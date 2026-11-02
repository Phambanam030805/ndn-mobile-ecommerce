<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller Chatbot AI Tư Vấn Thông Minh NDN Mobile
 * 
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 */
class Ai_chat extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Msanpham');
    }

    /**
     * Endpoint API nhận câu hỏi từ khách hàng và trả lời thông minh
     */
    public function ask() {
        // Trả về JSON
        header('Content-Type: application/json; charset=utf-8');

        $question = trim($this->input->post('question'));
        if (empty($question)) {
            echo json_encode([
                'status' => 'error',
                'reply'  => 'Chào bạn! Mình có thể giúp gì cho bạn về điện thoại, giá cả hay chính sách tại NDN Mobile?'
            ]);
            return;
        }

        $reply = $this->generate_smart_response($question);

        echo json_encode([
            'status' => 'success',
            'reply'  => $reply['text'],
            'products' => isset($reply['products']) ? $reply['products'] : [],
            'quick_suggestions' => isset($reply['quick_suggestions']) ? $reply['quick_suggestions'] : []
        ]);
    }

    /**
     * Hàm sinh câu trả lời thông minh dựa trên NLP từ khóa & database sản phẩm
     */
    private function generate_smart_response($q) {
        $q_lower = mb_strtolower($q, 'UTF-8');
        $q_no_accent = $this->remove_vietnamese_accents($q_lower);

        // 1. Chào hỏi
        if (preg_match('/\b(chao|hi|hello|alo|xin chao|hey|chao shop|ad oi|co ai khong)\b/i', $q_no_accent)) {
            return [
                'text' => "👋 **Dạ NDN Mobile xin chào Quý khách!**\n\nEm là **Trợ lý AI chuyên nghiệp của NDN Mobile**. Em có thể hỗ trợ anh/chị ngay lập tức:\n- 📱 **Tư vấn chọn mua điện thoại** (iPhone, Samsung, Xiaomi, OPPO, vivo... theo phân khúc giá).\n- 🔎 **Tra cứu cấu hình, giá bán & tình trạng còn hàng**.\n- 🛡️ **Tư vấn bảo hành 24/7 & đổi trả máy**.\n- 📦 **Kiểm tra cách đặt hàng & thanh toán VietQR / COD**.\n\nAnh/chị đang quan tâm đến dòng máy nào hay cần em hỗ trợ gì ạ?",
                'quick_suggestions' => [
                    'Tư vấn iPhone dưới 20 triệu',
                    'Điện thoại Samsung pin trâu chụp ảnh đẹp',
                    'Chính sách bảo hành 24/7 thế nào?',
                    'Có hỗ trợ trả góp không?'
                ]
            ];
        }

        // 2. Bảo hành & Hỗ trợ kỹ thuật 24/7
        if (preg_match('/\b(bao hanh|ky thuat|sua chua|doi tra|loi|hu|24\/7|bao hanh nhu the nao|chinh sach bao hanh)\b/i', $q_no_accent)) {
            return [
                'text' => "🛡️ **CHÍNH SÁCH BẢO HÀNH & HỖ TRỢ KỸ THUẬT 24/7 TẠI NDN MOBILE**:\n\n" .
                          "✅ **Bảo hành 12 - 24 tháng** chính hãng cho toàn bộ máy mới.\n" .
                          "✅ **1 đổi 1 trong 30 ngày đầu** nếu sản phẩm phát sinh lỗi từ nhà sản xuất (phần cứng, màn hình, nguồn...).\n" .
                          "✅ **Hỗ trợ phần mềm, nâng cấp iOS / Android, vệ sinh máy trọn đời MIỄN PHÍ**.\n" .
                          "✅ Hotline kỹ thuật trực 24/7: **0794.358.619** hoặc **0362.289.521**.\n\n" .
                          "Quý khách có thể mang máy đến trực tiếp cửa hàng hoặc gửi chuyển phát nhanh bảo hành an tâm tuyệt đối ạ!",
                'quick_suggestions' => [
                    'Địa chỉ bảo hành ở đâu?',
                    'Thời gian bảo hành mất bao lâu?',
                    'Cách kiểm tra máy chính hãng'
                ]
            ];
        }

        // 3. Địa chỉ shop & Hotline liên hệ
        if (preg_match('/\b(dia chi|o dau|shop o dau|cua hang|chi nhanh|hotline|so dien thoai|sdt|lien he|gio mo cua)\b/i', $q_no_accent)) {
            return [
                'text' => "📍 **HỆ THỐNG NDN MOBILE XIN THÔNG TIN ĐẾN ANH/CHỊ:**\n\n" .
                          "🏢 **Địa chỉ:** Đội 3, Thôn 6, Xã Mai Sơn, Huyện Yên Mô, Tỉnh Ninh Bình\n" .
                          "📞 **Hotline tư vấn & hỗ trợ:** **0794.358.619** - **0362.289.521**\n" .
                          "✉️ **Email tiếp nhận:** phambanam385@gmail.com\n" .
                          "⏰ **Giờ mở cửa:** 8:00 - 21:00 (Tất cả các ngày trong tuần, kể cả Thứ 7 & Chủ Nhật)\n\n" .
                          "Quý khách có thể ghé trực tiếp trải nghiệm máy hoặc đặt hàng giao hỏa tốc toàn quốc ạ!",
                'quick_suggestions' => [
                    'Giao hàng toàn quốc mất mấy ngày?',
                    'Phí ship bao nhiêu?',
                    'Xem điện thoại mới nhất'
                ]
            ];
        }

        // 4. Thanh toán & Trả góp
        if (preg_match('/\b(tra gop|thanh toan|vietqr|quet ma|chuyen khoan|cod|the tin dung|lai suat)\b/i', $q_no_accent)) {
            return [
                'text' => "💳 **PHƯƠNG THỨC THANH TOÁN & TRẢ GÓP TẠI NDN MOBILE:**\n\n" .
                          "1️⃣ **Trả góp 0% lãi suất**: Hỗ trợ qua thẻ tín dụng hoặc CCCD gắn chip (xét duyệt nhanh trong 15 phút, tỷ lệ đậu 99%).\n" .
                          "2️⃣ **Quét mã VietQR tự động**: Xác nhận thanh toán tức thì chuẩn bảo mật ngân hàng.\n" .
                          "3️⃣ **Ship COD toàn quốc**: Nhận hàng -> Kiểm tra máy kỹ lưỡng -> Mới phải thanh toán tiền cho shipper.\n" .
                          "4️⃣ **Thanh toán trực tiếp** tại cửa hàng bằng tiền mặt hoặc quẹt thẻ POS.",
                'quick_suggestions' => [
                    'Thủ tục trả góp cần những gì?',
                    'Tư vấn iPhone trả góp',
                    'Xem hướng dẫn đặt hàng'
                ]
            ];
        }

        // 5. Giao hàng / Vận chuyển
        if (preg_match('/\b(giao hang|ship|van chuyen|bao lau|nhan hang|phi ship)\b/i', $q_no_accent)) {
            return [
                'text' => "🚀 **CHÍNH SÁCH VẬN CHUYỂN & GIAO HÀNG:**\n\n" .
                          "🎁 **MIỄN PHÍ VẬN CHUYỂN TOÀN QUỐC** cho đơn hàng điện thoại từ 1.000.000đ trở lên.\n" .
                          "⏱️ **Thời gian giao:**\n" .
                          "- Nội tỉnh Ninh Bình & lân cận: Giao nhanh trong 2-4 giờ.\n" .
                          "- Các tỉnh thành khác (Hà Nội, TP.HCM, miền Trung, Tây Nam Bộ...): 1 - 3 ngày làm việc.\n" .
                          "📦 Toàn bộ kiện hàng đều được đóng gói chống sốc 3 lớp, dán tem niêm phong chống tráo hàng và cho phép đồng kiểm khi nhận!",
                'quick_suggestions' => [
                    'Có cho kiểm tra máy khi nhận không?',
                    'Hướng dẫn đặt hàng online',
                    'Tư vấn điện thoại bán chạy'
                ]
            ];
        }

        // 6. Nhận diện truy vấn giá hoặc hãng máy trong Database
        $brand_detected = null;
        $brand_search_term = null;
        $brands = [
            'Apple'   => ['iphone', 'ipad', 'apple'],
            'Samsung' => ['samsung', 'galaxy', 'z fold', 'z flip'],
            'Xiaomi'  => ['xiaomi', 'redmi', 'poco'],
            'OPPO'    => ['oppo', 'reno', 'find'],
            'Vivo'    => ['vivo', 'iqoo'],
            'Realme'  => ['realme'],
            'Asus'    => ['asus', 'rog phone'],
            'Sony'    => ['sony', 'xperia'],
            'Nokia'   => ['nokia'],
            'Huawei'  => ['huawei']
        ];

        foreach ($brands as $brand_key => $keywords) {
            foreach ($keywords as $kw) {
                if (strpos($q_no_accent, $kw) !== false) {
                    $brand_detected = $brand_key;
                    $brand_search_term = $kw; // VD: 'iphone' hoặc 'samsung'
                    break 2;
                }
            }
        }

        // Nhận diện phân khúc giá: dưới 5tr, dưới 10tr, 15tr, 20tr...
        $price_max = null;
        $price_min = null;
        if (preg_match('/(duoi|tam|khoang|<|nho hon)\s*(\d+)\s*(trieu|tr|m)/i', $q_no_accent, $matches)) {
            $num = (int)$matches[2];
            $price_max = $num * 1000000;
        } elseif (preg_match('/(tren|>|lon hon)\s*(\d+)\s*(trieu|tr|m)/i', $q_no_accent, $matches)) {
            $num = (int)$matches[2];
            $price_min = $num * 1000000;
        } elseif (preg_match('/tu\s*(\d+)\s*(den|-)\s*(\d+)\s*(trieu|tr|m)/i', $q_no_accent, $matches)) {
            $price_min = ((int)$matches[1]) * 1000000;
            $price_max = ((int)$matches[3]) * 1000000;
        }

        // Tìm kiếm sản phẩm tương thích trong DB
        $matched_products = $this->query_matched_products($q_no_accent, $brand_search_term, $price_min, $price_max);

        if (!empty($matched_products)) {
            $prod_list_text = "";
            $prod_cards = [];
            foreach ($matched_products as $p) {
                $price_display = number_format($p['price'], 0, ',', '.') . '₫';
                if (!empty($p['price_sale']) && $p['price_sale'] > 0 && $p['price_sale'] < $p['price']) {
                    $price_display = number_format($p['price_sale'], 0, ',', '.') . '₫ (Giảm từ ' . number_format($p['price'], 0, ',', '.') . '₫)';
                }
                $prod_list_text .= "• **{$p['name']}**: {$price_display}\n";
                $prod_cards[] = [
                    'id'    => $p['id'],
                    'name'  => $p['name'],
                    'alias' => $p['alias'],
                    'price' => number_format(!empty($p['price_sale']) ? $p['price_sale'] : $p['price'], 0, ',', '.') . '₫',
                    'avatar'=> base_url('public/images/products/' . $p['avatar']),
                    'url'   => base_url($p['alias'])
                ];
            }

            $prefix = "Dạ, theo yêu cầu của Quý khách, em tìm thấy các mẫu máy cực kỳ phù hợp và bán chạy nhất tại NDN Mobile:";
            if ($brand_detected) {
                $prefix = "Dạ, với thương hiệu **" . ucfirst($brand_detected) . "**, NDN Mobile đang sẵn các model hot nhất với giá ưu đãi đặc biệt:";
            }

            return [
                'text' => "📱 **{$prefix}**\n\n{$prod_list_text}\n💡 *Tất cả các sản phẩm trên đều có sẵn hàng, bảo hành chính hãng 12 tháng, 1 đổi 1 trong 30 ngày và tặng kèm đầy đủ sạc cáp, dán cường lực cao cấp!*",
                'products' => $prod_cards,
                'quick_suggestions' => [
                    'Xem chi tiết chính sách bảo hành',
                    'Có hỗ trợ trả góp 0% không?',
                    'So sánh cấu hình chi tiết'
                ]
            ];
        }

        // 7. Câu hỏi chung về website, cách đặt hàng, giỏ hàng
        if (preg_match('/\b(dat hang|mua hang|gio hang|thanh toan o dau|cach mua)\b/i', $q_no_accent)) {
            return [
                'text' => "🛒 **HƯỚNG DẪN MUA HÀNG NHANH TRÊN WEBSITE NDN MOBILE:**\n\n" .
                          "1️⃣ Chọn sản phẩm điện thoại ưng ý từ trang chủ hoặc mục tìm kiếm.\n" .
                          "2️⃣ Nhấn nút **'Thêm vào giỏ hàng'** hoặc **'Mua ngay'**.\n" .
                          "3️⃣ Vào biểu tượng Giỏ hàng góc trên bên phải, bấm **'Thanh toán'**.\n" .
                          "4️⃣ Điền Họ tên, Số điện thoại và Địa chỉ nhận hàng -> Chọn hình thức thanh toán (COD hoặc VietQR) -> Nhấn **'Hoàn tất đặt hàng'**.\n\n" .
                          "Hệ thống sẽ gửi email xác nhận và nhân viên sẽ liên hệ Quý khách xác nhận gửi hàng trong 10 phút!",
                'quick_suggestions' => [
                    'Kiểm tra tình trạng đơn hàng',
                    'Số điện thoại hỗ trợ',
                    'Xem các dòng iPhone giá tốt'
                ]
            ];
        }

        // 8. So sánh điện thoại
        if (preg_match('/\b(so sanh|nen mua|hay hon|khac gi|vs)\b/i', $q_no_accent)) {
            return [
                'text' => "⚖️ **TƯ VẤN SO SÁNH & LỰA CHỌN:**\n\n" .
                          "Để có đánh giá trực quan nhất, website NDN Mobile có tích hợp sẵn tính năng **'So sánh sản phẩm'** đối chiếu cấu hình, màn hình, chip, pin và giá cạnh tranh.\n\n" .
                          "📌 **Lời khuyên từ chuyên viên:**\n" .
                          "- Nếu anh/chị cần sự **mượt mà, quay video đỉnh cao, giữ giá lâu dài**: Hãy chọn dòng **iPhone**.\n" .
                          "- Nếu anh/chị thích **màn hình xuất sắc, bút S-Pen, zoom xa, đa nhiệm**: Hãy chọn dòng **Samsung Galaxy**.\n" .
                          "- Nếu cần **cấu hình khủng, pin trâu, sạc siêu nhanh trong tầm giá tiết kiệm**: Hãy chọn **Xiaomi / Realme**.\n\n" .
                          "Anh/chị có thể cho em biết 2 model cụ thể đang phân vân để em phân tích chi tiết nhé!",
                'quick_suggestions' => [
                    'So sánh iPhone 15 Pro Max và S24 Ultra',
                    'Tư vấn điện thoại chơi game tốt',
                    'Tư vấn điện thoại chụp ảnh đẹp'
                ]
            ];
        }

        // 9. Phản hồi thông minh mặc định (Chuyên viên hỗ trợ)
        return [
            'text' => "🤖 **Dạ em đã ghi nhận câu hỏi của Quý khách!**\n\n" .
                      "Tại NDN Mobile, chúng em chuyên cung cấp điện thoại chính hãng Apple iPhone, Samsung, Xiaomi, OPPO, vivo, realme... với giá tốt nhất thị trường.\n\n" .
                      "Để em tư vấn chuẩn xác nhất, anh/chị có thể nhắn cho em biết:\n" .
                      "1. Tầm giá mong muốn (ví dụ: dưới 10 triệu, 15 - 20 triệu)?\n" .
                      "2. Nhu cầu ưu tiên: Chụp ảnh, chơi game, pin trâu hay thiết kế thời trang?\n\n" .
                      "Hoặc gọi trực tiếp Hotline kỹ thuật 24/7: **0794.358.619** để được hỗ trợ tức thì!",
            'quick_suggestions' => [
                'Tư vấn điện thoại dưới 10 triệu',
                'Tư vấn iPhone chính hãng giá tốt',
                'Chính sách bảo hành 24/7',
                'Địa chỉ cửa hàng ở đâu?'
            ]
        ];
    }

    /**
     * Truy vấn sản phẩm liên quan từ CSDL
     */
    private function query_matched_products($q_no_accent, $brand, $price_min, $price_max) {
        $this->db->select('id, name, alias, price, price_sale, avatar');
        $this->db->from('products');
        $this->db->where('status', 1);
        $this->db->where('trash', 1);

        if ($price_min !== null) {
            $this->db->where('price >=', $price_min);
        }
        if ($price_max !== null) {
            $this->db->where('price <=', $price_max);
        }

        if ($brand !== null) {
            $this->db->like('name', $brand);
        } else {
            // Tách từ khóa quan trọng
            $words = explode(' ', $q_no_accent);
            $meaningful_words = [];
            foreach ($words as $w) {
                if (strlen($w) >= 3 && !in_array($w, ['dien', 'thoai', 'muon', 'can', 'mua', 'xem', 'shop', 'tu', 'van', 'co', 'nao', 'khong', 'duoi', 'tren', 'tam', 'khoang', 'trieu'])) {
                    $meaningful_words[] = $w;
                }
            }
            if (!empty($meaningful_words)) {
                $this->db->group_start();
                foreach ($meaningful_words as $w) {
                    $this->db->or_like('name', $w);
                }
                $this->db->group_end();
            } elseif ($price_min === null && $price_max === null) {
                // Không có cả từ khóa lẫn giá => không match sản phẩm bừa bãi
                return [];
            }
        }

        $this->db->order_by('price', 'desc');
        $this->db->limit(4);
        $res = $this->db->get()->result_array();

        // Nếu lọc giá không thấy mà có brand, lấy 4 máy của brand đó
        if (empty($res) && $brand !== null) {
            $this->db->select('id, name, alias, price, price_sale, avatar');
            $this->db->from('products');
            $this->db->where('status', 1);
            $this->db->where('trash', 1);
            $this->db->like('name', $brand);
            $this->db->order_by('price', 'asc');
            $this->db->limit(4);
            $res = $this->db->get()->result_array();
        }

        return $res;
    }

    /**
     * Bỏ dấu tiếng Việt phục vụ match từ khóa
     */
    private function remove_vietnamese_accents($str) {
        $unicode = [
            'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd'=>'đ',
            'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i'=>'í|ì|ỉ|ĩ|ị',
            'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
            'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D'=>'Đ',
            'E'=>'É|È|Ả|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I'=>'Í|Ì|Ỉ|Ĩ|Ị',
            'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        ];
        foreach($unicode as $nonAccent=>$accent) {
            $str = preg_replace("/($accent)/i", $nonAccent, $str);
        }
        return strtolower($str);
    }
}
