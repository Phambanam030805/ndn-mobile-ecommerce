<!-- KHỐI TỔNG HỢP 50 SẢN PHẨM PHÂN TRANG (10 SẢN PHẨM / TRANG) - ĐẶT ĐẦU TRANG -->
<section id="content" class="home-product-section" style="padding-top: 15px; margin-top: 10px;">
    <div id="danh-sach-san-pham" style="position: relative; top: -20px;"></div>
    <div class="container-fluid" style="max-width: 1320px; margin: 0 auto; padding: 0 15px;">
        <div class="home-section-header">
            <h2>
                <i class="fa fa-mobile"></i> Khám phá sản phẩm
            </h2>
            <div class="home-header-right">
                <span class="home-product-badge">
                    Trang <?= isset($current_page) ? $current_page : 1 ?> / 5 (Tổng <?= isset($total_products) ? $total_products : 50 ?> sản phẩm)
                </span>
            </div>
        </div>

        <!-- Lưới 10 sản phẩm chia đều (2 hàng x 5 cột) -->
        <div class="home-grid-row" style="display: flex; flex-wrap: wrap; margin: 0 -8px;">
            <?php 
            $products_to_show = isset($list_home_products) ? $list_home_products : [];
            if(empty($products_to_show)) {
                // Fallback nếu truy cập trực tiếp không qua controller
                $products_to_show = $this->Msanpham->product_sanpham(10, 0, 'id', 'asc');
            }
            if(!empty($products_to_show)):
                foreach ($products_to_show as $sp): ?>
                    <div class="home-grid-col" style="flex: 0 0 20%; max-width: 20%; padding: 8px; box-sizing: border-box;">
                        <div class="product-card-modern">
                            <div class="lt-product-group-image">
                                <a href="<?= base_url($sp['alias']) ?>" title="<?= htmlspecialchars($sp['name']) ?>">
                                    <img class="img-p" src="<?= base_url('public/images/products/'.$sp['avatar']) ?>" alt="<?= htmlspecialchars($sp['name']) ?>">
                                </a>
                                <?php if($sp['sale'] > 0): ?>
                                    <div class="giam-percent"><span>-<?= $sp['sale'] ?>%</span></div>
                                <?php endif; ?>
                            </div>
                            <div class="lt-product-group-info">
                                <a href="<?= base_url($sp['alias']) ?>" title="<?= htmlspecialchars($sp['name']) ?>">
                                    <h3 style="min-height: 38px; line-height: 19px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;"><?= $sp['name'] ?></h3>
                                </a>
                                <div class="price-box">
                                    <?php if ($sp['sale'] > 0): ?>
                                        <span class="price-new"><?= number_format($sp['price_sale']) ?>₫</span>
                                        <span class="price-old"><?= number_format($sp['price']) ?>₫</span>
                                    <?php else: ?>
                                        <span class="price-new"><?= number_format($sp['price']) ?>₫</span>
                                    <?php endif; ?>
                                </div>
                                <div class="product-buy-count" style="font-size: 11px; color: #888; margin-top: 5px; text-align: left;">
                                    <i class="fa fa-shopping-cart"></i> Đã bán: <?= $sp['number_buy'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            else: ?>
                <div class="col-md-12 text-center py-4">
                    <p>Chưa có sản phẩm nào để hiển thị.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cụm Phân Trang 1 - 2 - 3 - 4 - 5 -->
        <?php if(!empty($strphantrang)): ?>
            <div class="home-pagination-wrapper">
                <ul class="pagination-modern">
                    <?= $strphantrang ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ==========================================
     KHỐI 1: FLASH SALE GIÁ SỐC (LUXURY REDESIGN)
     ========================================== -->
<div class="container-fluid px-0" style="max-width: 1320px; margin: 0 auto; padding: 0 15px;">
    <div class="home-showcase-section flash-sale-wrap">
        <div class="showcase-header-bar">
            <div class="showcase-header-left">
                <span class="flash-badge-fire">
                    <i class="fas fa-bolt"></i> FLASH SALE
                </span>
                <h2 class="showcase-header-title">Khuyến mãi cực sốc hôm nay</h2>
                <div class="flash-countdown-box hidden-xs">
                    <i class="far fa-clock" style="color: #ef4444;"></i>
                    <span>Kết thúc sau: </span>
                    <span class="time-unit" id="fs-hours">08</span> :
                    <span class="time-unit" id="fs-mins">45</span> :
                    <span class="time-unit" id="fs-secs">30</span>
                </div>
            </div>
            <a href="<?= base_url('khuyen-mai') ?>" class="showcase-viewall-btn">
                Xem tất cả deal <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="owl-carousel owl-carousel-product owl-theme">
            <?php 
            $product_sale = $this->Msanpham->product_sale(10);
            if($product_sale) foreach ($product_sale as $row): 
                // Tính % tiến độ bán giả lập hấp dẫn dựa trên number_buy
                $sold_percent = min(95, max(25, round(($row['number_buy'] % 50 + 15) * 1.5)));
            ?>
                <div class="item">
                    <div class="carousel-card-luxury">
                        <!-- Floating Actions (Wishlist & So sánh) -->
                        <div class="card-actions-float">
                            <button type="button" class="btn-action-circle" title="Thêm vào yêu thích" onclick="toggleWishlist(<?= $row['id'] ?>)">
                                <i class="far fa-heart"></i>
                            </button>
                            <a href="<?= base_url('so-sanh/them/'.$row['id']) ?>" class="btn-action-circle" title="So sánh cấu hình">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                        </div>

                        <!-- Nhãn giảm giá -->
                        <?php if($row['sale'] > 0): ?>
                            <span class="product-sale-pill">
                                -<?= $row['sale'] ?>%
                            </span>
                        <?php endif; ?>

                        <!-- Ảnh sản phẩm -->
                        <div class="product-img-box" style="height: 180px; display: flex; align-items: center; justify-content: center; padding: 8px;">
                            <a href="<?= base_url($row['alias']) ?>" title="<?= htmlspecialchars($row['name']) ?>" style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                                <img src="<?= base_url('public/images/products/'.$row['avatar']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </a>
                        </div>

                        <!-- Tên sản phẩm -->
                        <a href="<?= base_url($row['alias']) ?>" title="<?= htmlspecialchars($row['name']) ?>" style="text-decoration: none;">
                            <h3 class="product-name" style="min-height: 38px; font-size: 14px; text-align: left; margin-bottom: 6px;"><?= $row['name'] ?></h3>
                        </a>

                        <!-- Giá sản phẩm -->
                        <div class="product-price-box" style="text-align: left; margin-bottom: 8px;">
                            <?php if ($row['sale'] > 0): ?>
                                <span class="price-current" style="font-size: 16px;"><?= number_format($row['price_sale']) ?>₫</span>
                                <span class="price-original"><?= number_format($row['price']) ?>₫</span>
                            <?php else: ?>
                                <span class="price-current" style="font-size: 16px;"><?= number_format($row['price']) ?>₫</span>
                            <?php endif; ?>
                        </div>

                        <!-- Thanh tiến trình đã bán hấp dẫn -->
                        <div class="flash-sold-progress">
                            <div class="flash-sold-bar">
                                <div class="flash-sold-fill" style="width: <?= $sold_percent ?>%;"></div>
                                <span class="flash-sold-text"><i class="fas fa-fire"></i> Đã bán <?= $row['number_buy'] ?> sp</span>
                            </div>
                        </div>

                        <!-- Nút mua ngay / xem chi tiết -->
                        <div class="product-footer-bar" style="padding-top: 8px;">
                            <span style="font-size: 11px; color: #10b981; font-weight: 700;">
                                <i class="fas fa-check-circle"></i> Sẵn hàng
                            </span>
                            <a href="<?= base_url($row['alias']) ?>" class="btn-view-detail" style="font-size: 12.5px;">
                                Săn ngay <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- ==========================================
     KHỐI 2: TOP SẢN PHẨM BÁN CHẠY (LUXURY REDESIGN)
     ========================================== -->
<div class="container-fluid px-0" style="max-width: 1320px; margin: 0 auto; padding: 0 15px;">
    <div class="home-showcase-section">
        <div class="showcase-header-bar">
            <div class="showcase-header-left">
                <span class="flash-badge-fire" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); box-shadow: 0 3px 10px rgba(245, 158, 11, 0.35);">
                    <i class="fas fa-crown"></i> HOT TREND
                </span>
                <h2 class="showcase-header-title">Top sản phẩm bán chạy nhất</h2>
            </div>
            <a href="<?= base_url('ban-chay') ?>" class="showcase-viewall-btn" style="color: #d97706; background: #fffbeb;">
                Xem tất cả <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="owl-carousel owl-carousel-product owl-theme">
            <?php 
            $product_selling = $this->Msanpham->product_selling(10);
            if($product_selling) foreach ($product_selling as $row): ?>
                <div class="item">
                    <div class="carousel-card-luxury">
                        <!-- Floating Actions (Wishlist & So sánh) -->
                        <div class="card-actions-float">
                            <button type="button" class="btn-action-circle" title="Thêm vào yêu thích" onclick="toggleWishlist(<?= $row['id'] ?>)">
                                <i class="far fa-heart"></i>
                            </button>
                            <a href="<?= base_url('so-sanh/them/'.$row['id']) ?>" class="btn-action-circle" title="So sánh cấu hình">
                                <i class="fas fa-exchange-alt"></i>
                            </a>
                        </div>

                        <!-- Nhãn giảm giá nếu có -->
                        <?php if($row['sale'] > 0): ?>
                            <span class="product-sale-pill">
                                -<?= $row['sale'] ?>%
                            </span>
                        <?php endif; ?>

                        <!-- Ảnh sản phẩm -->
                        <div class="product-img-box" style="height: 180px; display: flex; align-items: center; justify-content: center; padding: 8px;">
                            <a href="<?= base_url($row['alias']) ?>" title="<?= htmlspecialchars($row['name']) ?>" style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                                <img src="<?= base_url('public/images/products/'.$row['avatar']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" style="max-height: 100%; max-width: 100%; object-fit: contain;">
                            </a>
                        </div>

                        <!-- Tên sản phẩm -->
                        <a href="<?= base_url($row['alias']) ?>" title="<?= htmlspecialchars($row['name']) ?>" style="text-decoration: none;">
                            <h3 class="product-name" style="min-height: 38px; font-size: 14px; text-align: left; margin-bottom: 6px;"><?= $row['name'] ?></h3>
                        </a>

                        <!-- Giá sản phẩm -->
                        <div class="product-price-box" style="text-align: left; margin-bottom: 8px;">
                            <?php if ($row['sale'] > 0): ?>
                                <span class="price-current" style="font-size: 16px;"><?= number_format($row['price_sale']) ?>₫</span>
                                <span class="price-original"><?= number_format($row['price']) ?>₫</span>
                            <?php else: ?>
                                <span class="price-current" style="font-size: 16px;"><?= number_format($row['price']) ?>₫</span>
                            <?php endif; ?>
                        </div>

                        <!-- Thông tin số lượng bán chạy -->
                        <div style="font-size: 12px; color: #64748b; margin-top: 6px; margin-bottom: 8px; display: flex; align-items: center; gap: 6px;">
                            <i class="fas fa-shopping-bag" style="color: #f59e0b;"></i> Đã bán: <b style="color: #0f172a;"><?= number_format($row['number_buy']) ?> máy</b>
                        </div>

                        <!-- Footer thẻ -->
                        <div class="product-footer-bar" style="padding-top: 8px;">
                            <span style="font-size: 11px; color: #0284c7; font-weight: 700;">
                                <i class="fas fa-shipping-fast"></i> Giao siêu tốc
                            </span>
                            <a href="<?= base_url($row['alias']) ?>" class="btn-view-detail" style="font-size: 12.5px;">
                                Chi tiết <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
// Countdown Timer giả lập cho Flash Sale
(function() {
    function updateCountdown() {
        var now = new Date();
        var h = 23 - now.getHours();
        var m = 59 - now.getMinutes();
        var s = 59 - now.getSeconds();
        
        var hEl = document.getElementById('fs-hours');
        var mEl = document.getElementById('fs-mins');
        var sEl = document.getElementById('fs-secs');
        
        if (hEl) hEl.textContent = h < 10 ? '0' + h : h;
        if (mEl) mEl.textContent = m < 10 ? '0' + m : m;
        if (sEl) sEl.textContent = s < 10 ? '0' + s : s;
    }
    updateCountdown();
    setInterval(updateCountdown, 1000);
})();
</script>

<!-- ===== TIN TỨC CÔNG NGHỆ LUXURY REDESIGN ===== -->
<div class="home-blog">
    <div class="container-fluid" style="max-width: 1320px; margin: 0 auto; padding: 0 15px;">

        <!-- Header mục tin tức -->
        <div class="news-header-modern">
            <div class="news-header-left">
                <span class="news-badge">
                    <i class="fas fa-bolt"></i> Cập Nhật 24/7
                </span>
                <h2><i class="fas fa-newspaper"></i> Tin tức công nghệ</h2>
                <p>Khám phá xu hướng smartphone, đánh giá chi tiết và thủ thuật công nghệ mới nhất</p>
            </div>
            <div class="news-header-right hidden-xs">
                <a href="<?php echo base_url('tin-tuc'); ?>" class="news-view-all-btn">
                    Xem tất cả bài viết <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="row blog-content">
            <?php  
            $listBaiViet = $this->Mnoidung->content_list_home(3, 0);
            if(empty($listBaiViet)) {
                $listBaiViet = $this->Mnoidung->content_list_home(6, 'all');
            }
            if(!empty($listBaiViet)):
                $count = 0;
                foreach ($listBaiViet as $rowPost): 
                    $count++;
                    if ($count > 3) break; // Hiển thị 3 bài nổi bật nhất hàng đầu
                    
                    // Xử lý ảnh đại diện
                    $imgUrl = '';
                    if(!empty($rowPost['img'])) {
                        if(strpos($rowPost['img'], 'http://') === 0 || strpos($rowPost['img'], 'https://') === 0) {
                            $imgUrl = $rowPost['img'];
                        } else {
                            $imgUrl = base_url('public/images/posts/'.$rowPost['img']);
                        }
                    } else {
                        $imgUrl = base_url('public/images/posts/default.png');
                    }

                    // Xử lý ngày đăng
                    $postDate = !empty($rowPost['created_at']) ? date('d/m/Y', strtotime($rowPost['created_at'])) : date('d/m/Y');

                    // Xử lý đoạn tóm tắt
                    $excerpt = '';
                    if(!empty($rowPost['introtext'])) {
                        $excerpt = strip_tags($rowPost['introtext']);
                    } elseif(!empty($rowPost['fulltext'])) {
                        $excerpt = strip_tags($rowPost['fulltext']);
                    }
                    if(mb_strlen($excerpt) > 100) {
                        $excerpt = mb_substr($excerpt, 0, 100) . '...';
                    }
                    if(empty($excerpt)) {
                        $excerpt = 'Khám phá chi tiết đánh giá, thông số và những tính năng nổi bật được quan tâm nhất tại NDN Mobile.';
                    }
            ?>
            
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="news-card-luxury">
                        <a href="<?php echo base_url('tin-tuc/'.$rowPost['alias']); ?>" style="text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;">
                            <div class="news-img-wrapper">
                                <span class="news-category-tag"><i class="fas fa-mobile-alt"></i> Smartphone</span>
                                <img 
                                    src="<?php echo $imgUrl; ?>" 
                                    alt="<?php echo htmlspecialchars($rowPost['title']); ?>"
                                    onerror="this.src='<?php echo base_url('public/images/posts/default.png'); ?>';">
                            </div>
                            <div class="news-body">
                                <div>
                                    <div class="news-meta">
                                        <span><i class="far fa-calendar-alt"></i> <?php echo $postDate; ?></span>
                                        <span><i class="far fa-clock"></i> 3 phút đọc</span>
                                    </div>
                                    <h3 class="news-title" title="<?php echo htmlspecialchars($rowPost['title']); ?>">
                                        <?php echo $rowPost['title']; ?>
                                    </h3>
                                    <p class="news-excerpt">
                                        <?php echo $excerpt; ?>
                                    </p>
                                </div>
                                <div class="news-footer-line">
                                    <span class="read-more-text">
                                        Đọc tiếp <i class="fas fa-chevron-right"></i>
                                    </span>
                                    <span class="read-time"><i class="far fa-eye"></i> NDN News</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

            <?php 
                endforeach; 
            else: ?>
                <div class="col-md-12 text-center" style="padding: 30px;">
                    <p style="color: #888;">Đang cập nhật tin tức công nghệ mới nhất...</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="text-center visible-xs" style="margin-top: 15px;">
            <a href="<?php echo base_url('tin-tuc'); ?>" class="btn btn-default btn-block" style="border-radius: 8px; font-weight: 700; color: #d70018; border-color: #ffd2d6;">
                Xem tất cả bài viết <i class="fas fa-arrow-right"></i>
            </a>
        </div>

    </div>
</div>
<!-- ===== END TIN TỨC CÔNG NGHỆ ===== -->


<div class="adv">
    <section id="service-section" class="modern-services">
        <div class="container">
            <div class="row services-grid-4">
                <!-- 1. Miễn phí giao hàng -->
                <div class="col-md-3 col-sm-6 service-col">
                    <a href="<?php echo base_url('huong-dan-thanh-toan'); ?>" class="service-card-modern text-center" title="Xem chi tiết chính sách giao hàng">
                        <div class="service-icon-wrap" style="background: rgba(215, 0, 24, 0.08); color: #d70018;">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div class="service-content-modern">
                            <h4>Giao hàng hỏa tốc</h4>
                            <p>Miễn phí vận chuyển toàn quốc đơn từ 1.000.000đ</p>
                        </div>
                    </a>
                </div>

                <!-- 2. 100% Chính hãng -->
                <div class="col-md-3 col-sm-6 service-col">
                    <a href="<?php echo base_url('san-pham'); ?>" class="service-card-modern text-center" title="Khám phá điện thoại chính hãng">
                        <div class="service-icon-wrap" style="background: rgba(46, 204, 113, 0.1); color: #27ae60;">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="service-content-modern">
                            <h4>100% Chính hãng</h4>
                            <p>Bảo hành 12 - 24 tháng tại trung tâm hãng</p>
                        </div>
                    </a>
                </div>

                <!-- 3. Đổi mới trong 30 ngày -->
                <div class="col-md-3 col-sm-6 service-col">
                    <a href="javascript:void(0)" onclick="openAiChat('Chính sách bảo hành 1 đổi 1 trong 30 ngày như thế nào?')" class="service-card-modern text-center" title="Hỏi AI về quy trình 1 đổi 1 trong 30 ngày">
                        <div class="service-icon-wrap" style="background: rgba(52, 152, 219, 0.1); color: #2980b9;">
                            <i class="fas fa-sync-alt"></i>
                        </div>
                        <div class="service-content-modern">
                            <h4>1 Đổi 1 trong 30 ngày</h4>
                            <p>Lỗi nhà sản xuất là đổi mới ngay lập tức</p>
                        </div>
                    </a>
                </div>

                <!-- 4. Thanh toán & Trả góp 0% -->
                <div class="col-md-3 col-sm-6 service-col">
                    <a href="<?php echo base_url('huong-dan-thanh-toan'); ?>" class="service-card-modern text-center" title="Xem phương thức thanh toán VietQR & Trả góp">
                        <div class="service-icon-wrap" style="background: rgba(243, 156, 18, 0.1); color: #d35400;">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div class="service-content-modern">
                            <h4>VietQR & Trả góp 0%</h4>
                            <p>Quét mã xác nhận tức thì, duyệt CCCD 15 phút</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>

