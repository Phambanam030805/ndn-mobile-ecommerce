<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Service tự động lấy tin tức điện thoại từ RSS Feeds uy tín
 * (VnExpress Số Hóa, Thanh Niên Công Nghệ, Tuổi Trẻ Nhịp Sống Số)
 * Lọc chính xác các tin liên quan đến Smartphone / Điện thoại / Di động
 */
class Tech_news_crawler {

    protected $CI;

    // Danh sách nguồn RSS uy tín
    protected $feeds = [
        'https://vnexpress.net/rss/so-hoa.rss',
        'https://thanhnien.vn/rss/cong-nghe.rss',
        'https://tuoitre.vn/rss/nhip-song-so.rss'
    ];

    // Bộ từ khóa lọc chính xác chủ đề Điện thoại / Smartphone
    protected $keywords = [
        'iphone', 'apple', 'samsung', 'galaxy', 'xiaomi', 'oppo', 'pixel', 'vivo', 'realme',
        'điện thoại', 'smartphone', 'di động', 'snapdragon', 'ios', 'android', 'flagship',
        'camera phone', 'fold', 'flip', 'redmi', 'pro max', 'ultra'
    ];

    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->model('frontend/Mnoidung');
        $this->CI->load->library('alias');
    }

    /**
     * Tự động kiểm tra và cập nhật tin tức nếu chưa chạy hôm nay
     * Trả về số lượng bài viết mới được thêm
     */
    public function auto_crawl_daily($max_articles = 5) {
        $last_crawl_file = APPPATH . 'cache/last_news_crawl.txt';
        $today = date('Y-m-d');

        // Nếu hôm nay đã quét rồi thì bỏ qua để không tốn tài nguyên
        if (file_exists($last_crawl_file)) {
            $last_date = trim(@file_get_contents($last_crawl_file));
            if ($last_date === $today) {
                return 0; // Đã chạy hôm nay
            }
        }

        // Tiến hành cào tin mới
        $added = $this->crawl_latest_news($max_articles);

        // Ghi nhận mốc thời gian hoàn tất
        @file_put_contents($last_crawl_file, $today);

        return $added;
    }

    /**
     * Thu thập tin tức từ các nguồn RSS
     */
    public function crawl_latest_news($limit = 6) {
        $added_count = 0;

        foreach ($this->feeds as $feed_url) {
            if ($added_count >= $limit) {
                break;
            }

            $rss_content = $this->fetch_url($feed_url);
            if (!$rss_content) {
                continue;
            }

            // Tắt báo lỗi XML tạm thời khi parse
            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($rss_content, 'SimpleXMLElement', LIBXML_NOCDATA);
            libxml_clear_errors();

            if (!$xml || !isset($xml->channel->item)) {
                continue;
            }

            foreach ($xml->channel->item as $item) {
                if ($added_count >= $limit) {
                    break;
                }

                $title = trim((string)$item->title);
                $link  = trim((string)$item->link);
                $description_raw = (string)$item->description;

                // Kiểm tra xem bài viết có chứa từ khóa liên quan đến Điện thoại không
                if (!$this->is_phone_related($title, $description_raw)) {
                    continue;
                }

                // Tạo alias thân thiện
                $alias = $this->CI->alias->str_alias($title);

                // Kiểm tra trùng lặp trong CSDL
                if ($this->CI->Mnoidung->content_exists_by_title_or_alias($title, $alias)) {
                    continue;
                }

                // Trích xuất ảnh và mô tả sạch từ description HTML
                $img_url = $this->extract_image($item, $description_raw);
                $clean_intro = $this->clean_description($description_raw);

                // Nội dung tóm tắt & liên kết nguồn gốc
                $fulltext = '<p class="lead" style="font-size: 16px; line-height: 1.6; font-weight: 500; color: #333;">' . htmlspecialchars($clean_intro) . '</p>';
                if (!empty($img_url)) {
                    $fulltext .= '<p style="text-align: center; margin: 25px 0;"><img src="' . htmlspecialchars($img_url) . '" alt="' . htmlspecialchars($title) . '" style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"></p>';
                }
                $fulltext .= '<p style="line-height: 1.8; color: #444;">Bài viết được cập nhật tự động từ hệ thống tin tức công nghệ chính thống. Để xem toàn bộ bài viết gốc chi tiết, bạn đọc có thể truy cập tại: <a href="' . htmlspecialchars($link) . '" target="_blank" rel="nofollow noopener" style="color: #d70018; font-weight: 600; text-decoration: underline;">Xem bài viết gốc trên báo</a>.</p>';

                $post_data = [
                    'title'       => $title,
                    'alias'       => $alias,
                    'type'        => 'news',
                    'introtext'   => $clean_intro,
                    'fulltext'    => $fulltext,
                    'img'         => !empty($img_url) ? $img_url : 'default.png',
                    'created_at'  => date('Y-m-d H:i:s'),
                    'created_by'  => 1,
                    'updated_at'  => date('Y-m-d H:i:s'),
                    'modified_by' => 1,
                    'trash'       => 1,
                    'status'      => 1
                ];

                if ($this->CI->Mnoidung->content_insert($post_data)) {
                    $added_count++;
                }
            }
        }

        return $added_count;
    }

    /**
     * Kiểm tra nội dung có đúng chủ đề điện thoại
     */
    protected function is_phone_related($title, $desc) {
        $search_text = mb_strtolower($title . ' ' . $desc, 'UTF-8');
        foreach ($this->keywords as $kw) {
            if (mb_strpos($search_text, $kw) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Tải nội dung web bằng cURL an toàn
     */
    protected function fetch_url($url) {
        if (!function_exists('curl_init')) {
            return @file_get_contents($url);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 6);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) NDNMobileBot/1.0');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * Trích xuất link ảnh từ thẻ <enclosure> hoặc trong thẻ <img> của description
     */
    protected function extract_image($item, $desc) {
        // Cách 1: enclosure tag (thường có trên Tuổi Trẻ, Thanh Niên)
        if (isset($item->enclosure) && isset($item->enclosure['url'])) {
            return (string)$item->enclosure['url'];
        }

        // Cách 2: Tìm ảnh qua regex trong description
        if (preg_match('/<img[^>]+src=[\'"]([^\'"]+)[\'"]/i', $desc, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * Dọn dẹp HTML tags lấy text thuần túy làm tóm tắt
     */
    protected function clean_description($desc) {
        $text = preg_replace('/<a[^>]*>(.*?)<\/a>/is', '', $desc); // Xóa link
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/', ' ', $text);
        return trim($text);
    }
}
