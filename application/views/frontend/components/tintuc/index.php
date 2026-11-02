<section id="content" class="news-list-page">
    <div class="container" style="max-width: 1200px;">
        <div class="row">
            <div class="col-md-12">
                <div class="news-main-card">
                    
                    <!-- Header trang tin tức sang trọng -->
                    <div class="news-page-hero-header">
                        <div>
                            <span class="badge-tech">
                                <i class="fas fa-satellite-dish"></i> BẢN TIN SMARTPHONE
                            </span>
                            <h1>Tin Tức & Đánh Giá Công Nghệ</h1>
                            <p>Cập nhật liên tục các thông tin công nghệ, thủ thuật di động và đánh giá smartphone mới nhất mỗi ngày</p>
                        </div>
                    </div>

                    <!-- Danh sách bài viết phong cách hiện đại -->
                    <div class="news-list-wrapper">
                        <?php if(empty($list)): ?>
                            <div class="text-center py-5" style="padding: 50px 0;">
                                <i class="far fa-newspaper fa-4x text-muted" style="color: #cbd5e1; margin-bottom: 15px;"></i>
                                <p style="color: #64748b; font-size: 15px;">Hiện chưa có bài viết nào trong chuyên mục này.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($list as $item) :
                                // Xử lý nguồn ảnh thông minh (link trực tiếp từ báo hoặc file local)
                                $imgSrc = '';
                                if (!empty($item['img'])) {
                                    if (strpos($item['img'], 'http://') === 0 || strpos($item['img'], 'https://') === 0) {
                                        $imgSrc = $item['img'];
                                    } else {
                                        $imgSrc = base_url('public/images/posts/' . $item['img']);
                                    }
                                } else {
                                    $imgSrc = base_url('public/images/no-image.jpg');
                                }

                                // Xử lý mô tả ngắn gọn gàng
                                $excerpt = '';
                                if (!empty($item['introtext'])) {
                                    $excerpt = strip_tags($item['introtext']);
                                } elseif (!empty($item['fulltext'])) {
                                    $excerpt = strip_tags($item['fulltext']);
                                }
                                if (mb_strlen($excerpt, 'UTF-8') > 130) {
                                    $excerpt = mb_substr($excerpt, 0, 130, 'UTF-8') . '...';
                                }
                                if (empty($excerpt)) {
                                    $excerpt = 'Khám phá chi tiết đánh giá, thông số và những tính năng nổi bật được quan tâm nhất tại NDN Mobile.';
                                }
                            ?>
                                <div class="news-list-item-luxury">
                                    <div class="row" style="width: 100%; margin: 0; align-items: center; display: flex; flex-wrap: wrap;">
                                        <!-- Hình ảnh bài viết -->
                                        <div class="col-md-4 col-sm-5 col-xs-12" style="padding: 0;">
                                            <a href="<?php echo base_url('tin-tuc/' . $item['alias']); ?>" class="news-item-img-link" style="display: block;">
                                                <div class="news-item-img-wrapper">
                                                    <span class="category-floating-badge"><i class="fas fa-mobile-alt"></i> Mobile</span>
                                                    <img src="<?php echo $imgSrc; ?>" 
                                                         alt="<?php echo htmlspecialchars($item['title']); ?>"
                                                         onerror="this.src='<?php echo base_url('public/images/no-image.jpg'); ?>';">
                                                </div>
                                            </a>
                                        </div>

                                        <!-- Nội dung bài viết -->
                                        <div class="col-md-8 col-sm-7 col-xs-12" style="padding: 0 10px 0 25px;">
                                            <div class="news-item-content">
                                                <div class="news-item-meta">
                                                    <span><i class="far fa-calendar-alt"></i> <?php echo date("d/m/Y", strtotime($item['created'])); ?></span>
                                                    <span><i class="far fa-user"></i> Ban biên tập NDN</span>
                                                    <span><i class="far fa-clock"></i> 3 phút đọc</span>
                                                </div>
                                                <a href="<?php echo base_url('tin-tuc/' . $item['alias']); ?>" style="text-decoration: none; color: inherit;">
                                                    <h2 class="news-item-title" title="<?php echo htmlspecialchars($item['title']); ?>"><?php echo $item['title']; ?></h2>
                                                </a>
                                                <div class="news-item-excerpt">
                                                    <?php echo $excerpt; ?>
                                                </div>
                                                <a href="<?php echo base_url('tin-tuc/' . $item['alias']); ?>" class="btn-readmore-luxury">
                                                    Đọc chi tiết <i class="fas fa-chevron-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Cụm Phân trang hiện đại -->
                    <?php if(!empty($strphantrang)): ?>
                        <div class="text-center" style="margin-top: 40px;">
                            <ul class="pagination-modern">
                                <?php echo $strphantrang; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>