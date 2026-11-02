<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<section id="product-detail" class="product-detail-page">
    <div class="container">
        <?php if($row):?>
            <!-- BREADCRUMBS HIỆN ĐẠI -->
            <nav aria-label="breadcrumb" class="modern-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url('san-pham/'.$this->Mdanhmuc->category_link($row['catid'])); ?>"><?php echo $name; ?></a></li>
                    <li class="breadcrumb-item active" aria-current="page"><?php echo html_escape($row['name']); ?></li>
                </ol>
            </nav>

            <!-- KHỐI HEADER SẢN PHẨM & ĐÁNH GIÁ NHANH -->
            <div class="product-header-top mb-3">
                <div class="row align-items-center">
                    <div class="col-md-8 col-sm-12">
                        <h1 class="product-main-name" id="pdp-title"><?php echo html_escape($row['name']); ?></h1>
                        <div class="product-meta-sub">
                            <span class="meta-rating">
                                <span class="stars-gold">
                                    <?php 
                                    $top_avg = isset($review_breakdown['avg']) ? round($review_breakdown['avg']) : 5;
                                    for($i=1; $i<=5; $i++) echo $i <= $top_avg ? '<i class="fa fa-star"></i>' : '<i class="far fa-star"></i>';
                                    ?>
                                </span>
                                <a href="#pdp-reviews" class="meta-review-link">(<?php echo isset($review_breakdown['total']) ? (int)$review_breakdown['total'] : 0; ?> đánh giá)</a>
                            </span>
                            <span class="meta-sep">|</span>
                            <span class="meta-brand">Thương hiệu: <strong><?php echo !empty($producer['name']) ? html_escape($producer['name']) : 'Chính hãng'; ?></strong></span>
                            <span class="meta-sep">|</span>
                            <span class="meta-sold">Đã bán: <strong id="pdp-sold"><?php echo (int)$row['number_buy']; ?></strong></span>
                            <span class="meta-sep">|</span>
                            <span class="meta-sku">Mã SKU: <strong id="pdp-sku">SKU-<?php echo $row['id']; ?></strong></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 text-right hidden-xs">
                        <div class="pdp-top-actions">
                            <button type="button" class="btn btn-outline-wishlist" onclick="toggleWishlist(<?php echo $row['id']; ?>)">
                                <i class="fa fa-heart" id="wishlist-icon-<?php echo $row['id']; ?>"></i> <span id="wishlist-text-<?php echo $row['id']; ?>">Yêu thích</span>
                            </button>
                            <a href="<?php echo base_url('so-sanh/them/' . $row['id']); ?>" class="btn btn-outline-compare">
                                <i class="fa fa-exchange-alt"></i> So sánh
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- MAIN PRODUCT CONTAINER -->
            <div class="product-view-container card-shadow">
                <div class="row">
                    <!-- CỘT TRÁI: GALLERY ẢNH TƯƠNG TÁC CAO CẤP & LIGHTBOX -->
                    <div class="col-md-6 col-sm-12">
                        <div class="product-gallery-modern">
                            <!-- Khung ảnh chính với Lens Zoom -->
                            <div class="main-image-viewport" id="mainImageContainer">
                                <?php
                                $first_img = !empty($row['avatar']) ? $row['avatar'] : '';
                                if (empty($first_img) && !empty($row['img'])) {
                                    $gallery_arr = explode('#', $row['img']);
                                    $first_img = trim($gallery_arr[0]);
                                }
                                $main_img_url = base_url('public/images/products/' . $first_img);
                                ?>
                                <img id="pdp-main-image" src="<?php echo $main_img_url; ?>" alt="<?php echo html_escape($row['name']); ?>" class="img-responsive main-display-img" data-zoom-image="<?php echo $main_img_url; ?>">
                                <div class="badge-discount-float" id="pdp-sale-badge" style="<?php echo ($row['price_sale'] > 0 && $row['sale'] > 0) ? '' : 'display:none;'; ?>">
                                    -<?php echo (int)$row['sale']; ?>%
                                </div>
                                <button type="button" class="btn-expand-lightbox" onclick="openLightbox()" title="Xem ảnh phóng to toàn màn hình">
                                    <i class="fa fa-expand"></i> Phóng to
                                </button>
                            </div>

                            <!-- Carousel Thumbnail trượt ngang mượt mà -->
                            <div class="thumbnail-strip-wrapper mt-3">
                                <div class="thumbnail-strip" id="thumbnailStrip">
                                    <?php
                                    $all_images = [];
                                    if(!empty($row['avatar'])) $all_images[] = $row['avatar'];
                                    if(!empty($row['img'])) {
                                        foreach(explode('#', $row['img']) as $img_item){
                                            $img_item = trim($img_item);
                                            if($img_item !== '') $all_images[] = $img_item;
                                        }
                                    }
                                    $all_images = array_values(array_unique($all_images));
                                    foreach($all_images as $idx => $img_name):
                                        $thumb_url = base_url('public/images/products/' . $img_name);
                                    ?>
                                        <div class="thumb-item <?php echo $idx == 0 ? 'active' : ''; ?>" onclick="changeMainImage('<?php echo $thumb_url; ?>', this)">
                                            <img src="<?php echo $thumb_url; ?>" alt="Thumbnail <?php echo $idx + 1; ?>">
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Chính sách cam kết nhanh bên dưới ảnh -->
                            <div class="gallery-commitments mt-4">
                                <div class="row text-center">
                                    <div class="col-xs-4 commit-box">
                                        <i class="fa fa-shield-alt text-danger"></i>
                                        <span>100% Chính Hãng</span>
                                    </div>
                                    <div class="col-xs-4 commit-box">
                                        <i class="fa fa-shipping-fast text-danger"></i>
                                        <span>Giao Siêu Tốc 2H</span>
                                    </div>
                                    <div class="col-xs-4 commit-box">
                                        <i class="fa fa-sync-alt text-danger"></i>
                                        <span>Lỗi 1 Đổi 1 30 Ngày</span>
                                    </div>
                                </div>
                            </div>

                            <!-- KHỐI QUÀ TẶNG & KHUYẾN MÃI ĐẶC QUYỀN (CHUYỂN SANG DƯỚI ẢNH ĐỂ CÂN BẰNG CHIỀU CAO) -->
                            <div class="pdp-promotions-box mt-3">
                                <div class="promo-header">
                                    <i class="fa fa-gift text-danger"></i>
                                    <strong>KHUYẾN MÃI ĐẶC QUYỀN NDN MOBILE</strong>
                                </div>
                                <div class="promo-body">
                                    <ul class="promo-checklist">
                                        <li><i class="fa fa-check-circle text-success"></i> <span>Tặng Voucher giảm giá trực tiếp trị giá <strong>500.000₫</strong> khi lên đời máy mới.</span></li>
                                        <li><i class="fa fa-check-circle text-success"></i> <span>Giảm thêm tới <strong>1.000.000₫</strong> khi thanh toán qua VNPay-QR / MoMo.</span></li>
                                        <li><i class="fa fa-check-circle text-success"></i> <span>Thu cũ đổi mới: Trợ giá thêm tới <strong>2.000.000₫</strong>.</span></li>
                                        <li><i class="fa fa-check-circle text-success"></i> <span>Miễn phí dán cường lực cao cấp trọn đời tại chuỗi cửa hàng.</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CỘT PHẢI: THÔNG TIN SẢN PHẨM, BIẾN THỂ & HÀNH ĐỘNG MUA SẮM -->
                    <div class="col-md-6 col-sm-12">
                        <div class="product-view-info">
                            <!-- KHỐI GIÁ VÀ TÌNH TRẠNG KHO -->
                            <div class="pdp-pricing-card">
                                <div class="price-row align-items-baseline">
                                    <span class="pdp-price-current" id="pdp-price-current">
                                        <?php echo render_price($row['price_sale'] > 0 ? $row['price_sale'] : $row['price']); ?>
                                    </span>
                                    <span class="pdp-price-old-wrap" id="pdp-price-old-wrap" style="<?php echo ($row['price_sale'] > 0 && $row['price'] > $row['price_sale']) ? '' : 'display:none;'; ?>">
                                        <del class="pdp-price-old" id="pdp-price-old"><?php echo number_format($row['price']); ?>₫</del>
                                    </span>
                                    <span class="pdp-stock-badge" id="pdp-stock-badge">
                                        <?php 
                                        $stock_qty = (int)$row['number'] - (int)$row['number_buy'];
                                        if($stock_qty > 0 && $row['status'] == 1):
                                        ?>
                                            <span class="badge-stock in-stock"><i class="fa fa-check-circle"></i> Còn hàng (<?php echo $stock_qty; ?> máy)</span>
                                        <?php else: ?>
                                            <span class="badge-stock out-of-stock"><i class="fa fa-times-circle"></i> Tạm hết hàng</span>
                                        <?php endif; ?>
                                    </span>
                                </div>
                                <div class="vat-note text-muted"><i class="fa fa-info-circle"></i> Giá đã bao gồm thuế VAT & Bảo hành chính hãng 12 tháng.</div>
                            </div>

                            <!-- MÔ TẢ NGẮN SẢN PHẨM -->
                            <?php if(!empty($row['sortDesc'])): ?>
                                <div class="pdp-short-desc mt-3">
                                    <p><?php echo nl2br(html_escape($row['sortDesc'])); ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- KHỐI CHỌN BIẾN THỂ: DUNG LƯỢNG (CAPACITY) -->
                            <div class="pdp-variants-wrapper mt-4">
                                <?php 
                                // Nếu có danh sách các SKU cùng series trong database
                                if(isset($variants) && count($variants) > 1): 
                                ?>
                                    <div class="variant-group mb-4">
                                        <div class="variant-title">
                                            <span>Chọn phiên bản bộ nhớ:</span>
                                            <strong class="text-danger ml-2" id="current-variant-name"><?php echo html_escape($row['name']); ?></strong>
                                        </div>
                                        <div class="variant-grid" id="sku-capacity-grid">
                                            <?php foreach($variants as $v_item): 
                                                $is_cur = ($v_item['id'] == $row['id']);
                                                $v_price = $v_item['price_sale'] > 0 ? $v_item['price_sale'] : $v_item['price'];
                                                // Trích xuất label ngắn (ví dụ 256GB, 512GB, 1TB)
                                                preg_match('/\b(128GB|256GB|512GB|1TB|2TB)\b/i', $v_item['name'], $m_cap);
                                                $cap_label = !empty($m_cap[0]) ? $m_cap[0] : $v_item['name'];
                                            ?>
                                                <button type="button" 
                                                        class="btn-variant-chip <?php echo $is_cur ? 'active' : ''; ?>"
                                                        data-id="<?php echo $v_item['id']; ?>"
                                                        data-alias="<?php echo $v_item['alias']; ?>"
                                                        onclick="switchSkuVariant(this, <?php echo $v_item['id']; ?>, '<?php echo base_url($v_item['alias']); ?>')">
                                                    <span class="chip-title"><?php echo $cap_label; ?></span>
                                                    <span class="chip-price"><?php echo number_format($v_price / 1000000, 1); ?> tr</span>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php elseif(!empty($row['capacity'])): ?>
                                    <div class="variant-group mb-4">
                                        <div class="variant-title">
                                            <span>Dung lượng bộ nhớ:</span>
                                            <strong class="text-danger ml-2" id="current-capacity-text"></strong>
                                        </div>
                                        <div class="variant-grid" id="capacity-options">
                                            <?php 
                                            $caps = explode(',', $row['capacity']); 
                                            foreach($caps as $index => $cap): $cap = trim($cap); 
                                            ?>
                                                <button type="button" class="btn-variant-chip <?php echo $index == 0 ? 'active' : ''; ?>" 
                                                        onclick="selectCapacitySimple(this, '<?php echo html_escape($cap); ?>')">
                                                    <span class="chip-title"><?php echo html_escape($cap); ?></span>
                                                </button>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- KHỐI CHỌN MÀU SẮC (COLOR SWATCHES) -->
                                <?php if(!empty($row['color'])): ?>
                                    <div class="variant-group mb-4">
                                        <div class="variant-title">
                                            <span>Màu sắc:</span>
                                            <strong class="text-danger ml-2" id="current-color-text"></strong>
                                        </div>
                                        <div class="color-swatches-grid" id="color-options">
                                            <?php 
                                            $cols = explode(',', $row['color']); 
                                            function get_pdp_color_hex($color_name) {
                                                $map = [
                                                    'Titan Tự Nhiên' => '#bebebe', 'Titan Sa Mạc' => '#C9B197', 'Titan Trắng' => '#f8f9fa', 'Titan Đen' => '#2c2c2c',
                                                    'Titan Xám' => '#808080', 'Titan' => '#7f8c8d', 
                                                    'Onyx' => '#1f1f1f', 'Midnight' => '#191970', 'Đen' => '#1a1a1a', 
                                                    'Trắng' => '#ffffff', 'Marble' => '#e8e8e8', 'Iceblue' => '#d4f1f4',
                                                    'Cobalt' => '#3b3a6d', 'Lilac' => '#c8a2c8', 'Tím' => '#8e44ad',
                                                    'Amber' => '#ffbf00', 'Vàng Starlight' => '#E7DED0', 'Vàng đồng' => '#EAE0D0', 'Vàng' => '#f39c12',
                                                    'Xanh dương đậm' => '#1B2631', 'Xanh dương nhạt' => '#AED6F1', 'Xanh dương' => '#2980b9', 'Navy' => '#000080',
                                                    'Ngọc Bích' => '#00a86b', 'Xanh' => '#27ae60', 'Đỏ' => '#e74c3c', 
                                                    'Rosé' => '#ff66cc', 'Hồng nhạt' => '#F7D1D1', 'Hồng' => '#e84393', 
                                                    'Bạc' => '#bdc3c7', 'Xám' => '#808080', 'Teal' => '#008080', 'Cam' => '#e67e22'
                                                ];
                                                foreach($map as $key => $hex) {
                                                    if(mb_stripos($color_name, $key) !== false) return $hex;
                                                }
                                                return '#95a5a6'; 
                                            }
                                            
                                            foreach($cols as $index => $col): 
                                                $col = trim($col); 
                                                $hex = get_pdp_color_hex($col);
                                            ?>
                                                <div class="color-swatch-item <?php echo $index == 0 ? 'active' : ''; ?>" 
                                                     data-color="<?php echo html_escape($col); ?>"
                                                     onclick="selectColorOption(this, '<?php echo html_escape($col); ?>', <?php echo $index; ?>)">
                                                    <span class="color-dot" style="background-color: <?php echo $hex; ?>; border: 1px solid <?php echo ($hex == '#ffffff' ? '#ccc' : $hex); ?>;"></span>
                                                    <span class="color-name"><?php echo html_escape($col); ?></span>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <!-- Hidden Inputs phục vụ Giỏ hàng & Form -->
                                <input type="hidden" id="selected_product_id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" id="selected_capacity" value="<?php 
                                    if(!empty($row['capacity'])){
                                        $c_arr = explode(',', $row['capacity']);
                                        echo trim($c_arr[0]);
                                    }
                                ?>">
                                <input type="hidden" id="selected_color" value="<?php 
                                    if(!empty($row['color'])){
                                        $col_arr = explode(',', $row['color']);
                                        echo trim($col_arr[0]);
                                    }
                                ?>">
                            </div>

                            <!-- BỘ NÚT HÀNH ĐỘNG MUA HÀNG CAO CẤP (ĐẨY LÊN NGAY SAU BIẾN THỂ) -->
                            <div class="pdp-cta-container mt-3">
                                <?php 
                                $is_buyable = ($stock_qty > 0 && $row['status'] == 1);
                                ?>
                                <div class="cta-buttons-row">
                                    <!-- Nút MUA NGAY (Direct Express Checkout) -->
                                    <button type="button" class="btn btn-buy-now" id="btnBuyNow" <?php echo !$is_buyable ? 'disabled' : ''; ?> onclick="handleBuyNow()">
                                        <div class="btn-cta-inner">
                                            <span class="btn-main-text"><i class="fa fa-bolt"></i> MUA NGAY</span>
                                            <span class="btn-sub-text">Giao hàng tận nơi hoặc nhận tại cửa hàng</span>
                                        </div>
                                    </button>

                                    <!-- Nút THÊM VÀO GIỎ (Asynchronous AJAX) -->
                                    <button type="button" class="btn btn-add-cart" id="btnAddCart" <?php echo !$is_buyable ? 'disabled' : ''; ?> onclick="handleAddToCart()">
                                        <div class="btn-cta-inner">
                                            <span class="btn-main-text"><i class="fa fa-cart-plus"></i> THÊM VÀO GIỎ</span>
                                            <span class="btn-sub-text">Tiếp tục mua sắm</span>
                                        </div>
                                    </button>
                                </div>

                                <!-- Nút Trả góp 0% -->
                                <div class="installment-row mt-3">
                                    <a href="<?php echo base_url('tra-gop'); ?>" class="btn btn-installment">
                                        <span class="inst-main-text"><i class="fa fa-credit-card"></i> TRẢ GÓP 0% QUA THẺ HOẶC CCCD</span>
                                        <span class="inst-sub-text">Duyệt hồ sơ nhanh chóng qua điện thoại trong 5 phút</span>
                                    </a>
                                </div>
                            </div>

                            <!-- Hotline tư vấn -->
                            <div class="hotline-box mt-3 text-center">
                                <i class="fa fa-phone-alt text-danger"></i> Gọi đặt mua: <strong class="text-danger">0794258819</strong> <span class="text-muted">(8:00 - 22:00 hàng ngày)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- THANH STICKY SUB-NAVIGATION CHO CHI TIẾT SẢN PHẨM -->
            <div class="pdp-sticky-subnav" id="pdpStickyNav">
                <div class="container">
                    <ul class="nav-sub-tabs">
                        <li class="active"><a href="#pdp-highlights">Đặc điểm nổi bật</a></li>
                        <li><a href="#pdp-specs">Thông số kỹ thuật</a></li>
                        <li><a href="#pdp-reviews">Đánh giá & Nhận xét (<?php echo isset($review_breakdown['total']) ? (int)$review_breakdown['total'] : 0; ?>)</a></li>
                        <li><a href="#pdp-related">Sản phẩm tương tự</a></li>
                    </ul>
                    <div class="sticky-nav-cta hidden-xs">
                        <span class="sticky-pname"><?php echo html_escape($row['name']); ?></span>
                        <span class="sticky-pprice text-danger font-weight-bold ml-2"><?php echo render_price($row['price_sale'] > 0 ? $row['price_sale'] : $row['price']); ?></span>
                        <button type="button" class="btn btn-danger btn-sm ml-3" onclick="handleBuyNow()"><i class="fa fa-bolt"></i> Mua ngay</button>
                    </div>
                </div>
            </div>

            <!-- NỘI DUNG CHI TIẾT & BẢNG THÔNG SỐ KỸ THUẬT -->
            <div class="row mt-4">
                <!-- CỘT TRÁI (8 CỘT): ĐẶC ĐIỂM NỔI BẬT & BÌNH LUẬN -->
                <div class="col-md-8 col-sm-12">
                    <!-- SECTION 1: ĐẶC ĐIỂM NỔI BẬT -->
                    <div id="pdp-highlights" class="pdp-section-card card-shadow mb-4">
                        <div class="section-card-header">
                            <h2><i class="fa fa-star text-warning"></i> Đặc điểm nổi bật của <?php echo html_escape($row['name']); ?></h2>
                        </div>
                        <div class="section-card-body content-collapsible" id="highlightsContent">
                            <div class="pdp-html-detail">
                                <?php echo $row['detail']; ?>
                            </div>
                            <div class="content-overlay-gradient" id="contentOverlay"></div>
                        </div>
                        <div class="text-center pb-3">
                            <button type="button" class="btn btn-outline-toggle-content" id="btnToggleHighlights" onclick="toggleHighlightsContent()">
                                <span>Xem thêm chi tiết</span> <i class="fa fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>

                    <!-- SECTION 2: BÌNH LUẬN FACEBOOK (TÙY CHỌN BỔ TRỢ) -->
                    <div class="pdp-section-card card-shadow mb-4">
                        <div class="section-card-header">
                            <h3><i class="fab fa-facebook text-primary"></i> Hỏi đáp cộng đồng</h3>
                        </div>
                        <div class="section-card-body">
                            <div class="fb-comments" data-href="<?php echo base_url($row['alias']); ?>" data-numposts="5" data-width="100%"></div>
                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI (4 CỘT): THÔNG SỐ KỸ THUẬT CHI TIẾT (COLLAPSIBLE TABLE) -->
                <div class="col-md-4 col-sm-12">
                    <div id="pdp-specs" class="pdp-section-card card-shadow mb-4 sticky-sidebar">
                        <div class="section-card-header">
                            <h3><i class="fa fa-cogs text-danger"></i> Thông số kỹ thuật</h3>
                        </div>
                        <div class="section-card-body p-0">
                            <table class="table table-striped table-specs-modern mb-0">
                                <tbody>
                                    <tr>
                                        <td class="spec-label">Màn hình</td>
                                        <td class="spec-val">6.9 inch, Super Retina XDR OLED, 120Hz ProMotion</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Camera sau</td>
                                        <td class="spec-val">Chính 48MP + Góc siêu rộng 48MP + Tele 48MP (Zoom 5x)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Camera trước</td>
                                        <td class="spec-val">12MP TrueDepth, Tự động lấy nét</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Vi xử lý (CPU)</td>
                                        <td class="spec-val">Apple A19 Pro (Tiến trình 2nm siêu tiết kiệm pin)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Bộ nhớ RAM</td>
                                        <td class="spec-val">12GB (Hỗ trợ Apple Intelligence toàn diện)</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Bộ nhớ trong</td>
                                        <td class="spec-val" id="spec-capacity-val"><?php echo !empty($row['capacity']) ? html_escape($row['capacity']) : '256GB / 512GB / 1TB'; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Dung lượng pin</td>
                                        <td class="spec-val">Xem video liên tục 33 giờ, sạc nhanh 50% trong 20 phút</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Cổng sạc & Kết nối</td>
                                        <td class="spec-val">USB-C (USB 3), Wi-Fi 7, Bluetooth 5.4, 5G</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Chất liệu khung viền</td>
                                        <td class="spec-val">Titanium Hàng Không Vũ Trụ Cấp 5</td>
                                    </tr>
                                    <tr>
                                        <td class="spec-label">Trọng lượng</td>
                                        <td class="spec-val">227g</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 text-center border-top">
                            <button type="button" class="btn btn-outline-danger btn-block btn-sm" onclick="openFullSpecsModal()">
                                <i class="fa fa-list"></i> Xem cấu hình chi tiết đầy đủ
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECTION 3: ĐÁNH GIÁ & RATING BREAKDOWN (INTERACTIVE CUSTOMER REVIEWS) -->
            <div id="pdp-reviews" class="pdp-reviews-section card-shadow mb-5">
                <div class="section-card-header">
                    <h2><i class="fa fa-comments text-danger"></i> Đánh giá & Nhận xét <?php echo html_escape($row['name']); ?></h2>
                </div>
                <div class="section-card-body">
                    <!-- Rating Summary Dashboard -->
                    <div class="rating-dashboard">
                        <div class="row align-items-center">
                            <!-- Cột Điểm trung bình -->
                            <div class="col-md-4 col-sm-12 text-center rating-score-col">
                                <div class="rating-big-number">
                                    <span id="avgRatingDisplay"><?php echo number_format($review_breakdown['avg'], 1); ?></span><span class="max-score">/5</span>
                                </div>
                                <div class="rating-big-stars">
                                    <?php 
                                    $score = round($review_breakdown['avg']);
                                    for($i=1; $i<=5; $i++) echo $i <= $score ? '<i class="fa fa-star text-warning"></i>' : '<i class="far fa-star text-warning"></i>';
                                    ?>
                                </div>
                                <div class="rating-total-count text-muted mt-2">
                                    Dựa trên <strong><?php echo $review_breakdown['total']; ?></strong> đánh giá thực tế từ khách hàng
                                </div>
                                <button type="button" class="btn btn-danger btn-write-review mt-3" onclick="toggleReviewForm()">
                                    <i class="fa fa-pencil-alt"></i> Viết đánh giá của bạn
                                </button>
                            </div>

                            <!-- Cột Tiến trình sao (Rating Breakdown Bars) -->
                            <div class="col-md-5 col-sm-12 rating-bars-col">
                                <?php for($s = 5; $s >= 1; $s--): 
                                    $cnt = isset($review_breakdown['stars'][$s]) ? $review_breakdown['stars'][$s] : 0;
                                    $pct = isset($review_breakdown['percentages'][$s]) ? $review_breakdown['percentages'][$s] : 0;
                                ?>
                                    <div class="star-bar-row">
                                        <div class="star-label">
                                            <span><?php echo $s; ?></span> <i class="fa fa-star text-warning"></i>
                                        </div>
                                        <div class="progress progress-rating-bar">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" style="width: <?php echo $pct; ?>%;" aria-valuenow="<?php echo $pct; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="star-count text-muted">
                                            <span><?php echo $cnt; ?> (<?php echo $pct; ?>%)</span>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            </div>

                            <!-- Cột Cam kết đánh giá khách quan -->
                            <div class="col-md-3 col-sm-12 rating-policy-col hidden-xs">
                                <div class="review-policy-card">
                                    <i class="fa fa-user-check text-success fa-2x mb-2"></i>
                                    <h6>Đánh giá xác thực</h6>
                                    <p>100% đánh giá đến từ khách hàng đã trải nghiệm sản phẩm tại chuỗi NDN Mobile.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FORM GỬI ĐÁNH GIÁ (SLIDE TOGGLE) -->
                    <div id="pdpReviewFormWrapper" class="review-form-wrapper" style="display: none;">
                        <h4 class="form-title"><i class="fa fa-edit text-danger"></i> Gửi nhận xét của bạn về sản phẩm</h4>
                        <form id="frmPdpReview" onsubmit="event.preventDefault(); submitPdpReview();">
                            <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                            
                            <!-- Hàng chọn sao -->
                            <div class="form-group text-center star-picker-group">
                                <label class="d-block mb-2 font-weight-bold">Bạn chấm sản phẩm này mấy sao?</label>
                                <div class="star-picker-box" id="starPicker">
                                    <i class="fa fa-star star-opt active" data-score="1" title="Rất tệ"></i>
                                    <i class="fa fa-star star-opt active" data-score="2" title="Tệ"></i>
                                    <i class="fa fa-star star-opt active" data-score="3" title="Bình thường"></i>
                                    <i class="fa fa-star star-opt active" data-score="4" title="Tốt"></i>
                                    <i class="fa fa-star star-opt active" data-score="5" title="Tuyệt vời"></i>
                                </div>
                                <input type="hidden" name="rating" id="review_score_input" value="5">
                                <div class="star-hint text-danger mt-1" id="starHintText">Tuyệt vời - Rất hài lòng</div>
                            </div>

                            <!-- Họ tên & Email -->
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Họ và tên <span class="text-danger">*</span></label>
                                    <input type="text" name="fullname" class="form-control" placeholder="Nhập họ và tên của bạn..." required 
                                           value="<?php echo $this->session->userdata('fullname') ? html_escape($this->session->userdata('fullname')) : ''; ?>">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email (Nhận thông báo khi được phản hồi)</label>
                                    <input type="email" name="email" class="form-control" placeholder="example@gmail.com" 
                                           value="<?php echo $this->session->userdata('email') ? html_escape($this->session->userdata('email')) : ''; ?>">
                                </div>
                            </div>

                            <!-- Nội dung nhận xét -->
                            <div class="form-group">
                                <label>Nội dung nhận xét <span class="text-danger">*</span></label>
                                <textarea name="content" class="form-control" rows="4" placeholder="Hãy chia sẻ trải nghiệm thực tế của bạn về hiệu năng, pin, camera... (Tối thiểu 10 ký tự)" required></textarea>
                            </div>

                            <div class="form-actions text-right">
                                <button type="button" class="btn btn-secondary mr-2" onclick="toggleReviewForm()">Đóng lại</button>
                                <button type="submit" class="btn btn-danger btn-submit-review" id="btnSubmitReview">
                                    <i class="fa fa-paper-plane"></i> Gửi đánh giá ngay
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- BỘ LỌC ĐÁNH GIÁ (FILTER TABS) -->
                    <div class="review-filter-tabs mt-4">
                        <span class="filter-title"><i class="fa fa-filter"></i> Lọc đánh giá:</span>
                        <button type="button" class="btn-filter-tag active" onclick="filterReviews('all', this)">Tất cả (<?php echo $review_breakdown['total']; ?>)</button>
                        <button type="button" class="btn-filter-tag" onclick="filterReviews(5, this)">5 Sao (<?php echo $review_breakdown['stars'][5]; ?>)</button>
                        <button type="button" class="btn-filter-tag" onclick="filterReviews(4, this)">4 Sao (<?php echo $review_breakdown['stars'][4]; ?>)</button>
                        <button type="button" class="btn-filter-tag" onclick="filterReviews(3, this)">3 Sao (<?php echo $review_breakdown['stars'][3]; ?>)</button>
                        <button type="button" class="btn-filter-tag" onclick="filterReviews(2, this)">2 Sao (<?php echo $review_breakdown['stars'][2]; ?>)</button>
                        <button type="button" class="btn-filter-tag" onclick="filterReviews(1, this)">1 Sao (<?php echo $review_breakdown['stars'][1]; ?>)</button>
                    </div>

                    <!-- DANH SÁCH REVIEW KHÁCH HÀNG -->
                    <div class="pdp-reviews-feed mt-4" id="reviewsFeed">
                        <?php if(isset($reviews) && count($reviews) > 0): ?>
                            <?php foreach($reviews as $rv): 
                                $r_star = (int)$rv['title'];
                            ?>
                                <div class="review-card-item" data-star="<?php echo $r_star; ?>">
                                    <div class="review-author-info">
                                        <div class="author-avatar-circle">
                                            <?php echo mb_substr(trim($rv['fullname']), 0, 1, 'UTF-8'); ?>
                                        </div>
                                        <div class="author-meta">
                                            <div class="author-name">
                                                <strong><?php echo html_escape($rv['fullname']); ?></strong>
                                                <span class="badge-verified"><i class="fa fa-check-circle"></i> Đã mua tại NDN Mobile</span>
                                            </div>
                                            <div class="review-date-stars">
                                                <span class="stars-gold mr-2">
                                                    <?php for($i=1; $i<=5; $i++) echo $i <= $r_star ? '<i class="fa fa-star"></i>' : '<i class="far fa-star"></i>'; ?>
                                                </span>
                                                <span class="review-time text-muted"><i class="far fa-clock"></i> <?php echo date('d/m/Y H:i', strtotime($rv['created_at'])); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="review-body-text mt-2">
                                        <p><?php echo nl2br(html_escape($rv['content'])); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="empty-reviews-box text-center py-5">
                                <i class="far fa-comments fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Chưa có đánh giá nào cho sản phẩm này</h5>
                                <p class="text-muted">Hãy là người đầu tiên trải nghiệm và chia sẻ nhận xét của bạn!</p>
                                <button type="button" class="btn btn-danger btn-sm mt-2" onclick="toggleReviewForm()">Viết đánh giá đầu tiên</button>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- SECTION 4: SẢN PHẨM CÙNG LOẠI LIÊN QUAN -->
            <div id="pdp-related" class="related-products-section card-shadow p-4 mb-5">
                <div class="section-card-header">
                    <h2><i class="fa fa-mobile-alt text-danger"></i> Sản phẩm tương tự cùng phân khúc</h2>
                </div>
                <?php $list_spcungloai = $this->Msanpham->product_cungloai($row['catid'], $row['id'], 4); ?>
                <div class="row mt-4">
                    <?php if(count($list_spcungloai) > 0): ?>
                        <?php foreach ($list_spcungloai as $sp) :?>
                            <div class="col-md-3 col-sm-6 col-xs-6">
                                <div class="product-lt product-card-modern">
                                    <div class="lt-product-group-image">
                                        <a href="<?php echo base_url($sp['alias']); ?>">
                                            <img class="img-p" src="<?php echo base_url('public/images/products/'.$sp['avatar']); ?>" alt="<?php echo html_escape($sp['name']); ?>">
                                        </a>
                                        <?php if($sp['sale'] > 0) :?>
                                            <div class="giam-percent"><span>-<?php echo $sp['sale'] ?>%</span></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="lt-product-group-info">
                                        <a href="<?php echo base_url($sp['alias']); ?>"><h3><?php echo html_escape($sp['name']); ?></h3></a>
                                        <div class="price-box">
                                            <?php if($sp['sale'] > 0) :?>
                                                <span class="price-new"><?php echo number_format($sp['price_sale']); ?>₫</span>
                                                <span class="price-old"><?php echo number_format($sp['price']); ?>₫</span>
                                            <?php else: ?>
                                                <span class="price-new"><?php echo number_format($sp['price']); ?>₫</span>
                                            <?php endif;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-md-12 text-center py-4">
                            <p class="text-muted">Đang cập nhật các dòng sản phẩm liên quan...</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- MODAL LIGHTBOX XEM ẢNH FULLSCREEN -->
            <div id="pdpLightboxModal" class="pdp-modal-lightbox">
                <div class="lightbox-backdrop" onclick="closeLightbox()"></div>
                <div class="lightbox-content-box">
                    <button type="button" class="lightbox-close-btn" onclick="closeLightbox()">&times;</button>
                    <img id="lightboxImage" src="<?php echo $main_img_url; ?>" alt="Lightbox Preview">
                    <div class="lightbox-thumbnails-bar" id="lightboxThumbs">
                        <?php foreach($all_images as $img_name): 
                            $l_thumb = base_url('public/images/products/' . $img_name);
                        ?>
                            <img src="<?php echo $l_thumb; ?>" onclick="switchLightboxImage('<?php echo $l_thumb; ?>')" alt="Thumb">
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- MODAL THÔNG SỐ KỸ THUẬT ĐẦY ĐỦ -->
            <div id="pdpSpecsModal" class="modal fade" tabindex="-1" role="dialog">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                        <div class="modal-header bg-danger text-white" style="background: #d70018; color: #fff; padding: 15px 20px;">
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 1;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title font-weight-bold" style="font-weight: 700;">
                                <i class="fa fa-info-circle"></i> Bảng thông số kỹ thuật chi tiết: <?php echo html_escape($row['name']); ?>
                            </h4>
                        </div>
                        <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="info"><th colspan="2">1. Màn hình & Hiển thị</th></tr>
                                    <tr><td width="35%">Công nghệ màn hình</td><td>LTPO Super Retina XDR OLED, 1 tỷ màu</td></tr>
                                    <tr><td>Kích thước màn hình</td><td>6.9 inch (Tỉ lệ hiển thị ~91.4%)</td></tr>
                                    <tr><td>Độ phân giải</td><td>2868 x 1320 pixels (~460 ppi)</td></tr>
                                    <tr><td>Tần số quét</td><td>120Hz ProMotion thích ứng</td></tr>
                                    <tr><td>Độ sáng tối đa</td><td>1000 nits (tiêu chuẩn), 1600 nits (HDR), 3000 nits (ngoài trời)</td></tr>
                                    
                                    <tr class="info"><th colspan="2">2. Camera & Quay phim</th></tr>
                                    <tr><td>Camera chính</td><td>48 MP, f/1.78, 24mm, sensor-shift OIS, Dual Pixel PDAF</td></tr>
                                    <tr><td>Camera góc siêu rộng</td><td>48 MP, f/2.2, 13mm, 120˚, Hybrid Focus Pixels</td></tr>
                                    <tr><td>Camera Telephoto</td><td>48 MP, f/2.8, 120mm (5x optical zoom), 3D sensor-shift OIS</td></tr>
                                    <tr><td>Tính năng quay phim</td><td>4K@120fps Dolby Vision HDR, ProRes, Log, Spatial Video</td></tr>
                                    
                                    <tr class="info"><th colspan="2">3. Vi xử lý & Bộ nhớ</th></tr>
                                    <tr><td>Hệ điều hành</td><td>iOS 18 (Cập nhật lâu dài)</td></tr>
                                    <tr><td>Chipset</td><td>Apple A19 Pro (Tiến trình 2nm)</td></tr>
                                    <tr><td>CPU / GPU</td><td>6 nhân CPU (2 hiệu năng + 4 tiết kiệm), 6 nhân GPU thế hệ mới</td></tr>
                                    <tr><td>Neural Engine</td><td>16 nhân thế hệ mới chuyên sâu Apple Intelligence</td></tr>
                                    <tr><td>RAM & ROM</td><td>12GB RAM | 256GB / 512GB / 1TB NVMe</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng cửa sổ</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TOAST NOTIFICATION THÊM GIỎ HÀNG THÀNH CÔNG -->
            <div id="pdpCartToast" class="pdp-cart-toast">
                <div class="toast-icon"><i class="fa fa-check-circle"></i></div>
                <div class="toast-body">
                    <strong class="toast-title">Thêm vào giỏ thành công!</strong>
                    <p class="toast-desc" id="toastItemDesc"></p>
                </div>
                <div class="toast-action">
                    <a href="<?php echo base_url('gio-hang'); ?>" class="btn-toast-view">Xem giỏ hàng</a>
                </div>
            </div>

            <!-- CẤU TRÚC SCHEMA.ORG PRODUCT JSON-LD CHO SEO GOOGLE -->
            <?php if(isset($schema_json_ld)): ?>
                <script type="application/ld+json">
                <?php echo $schema_json_ld; ?>
                </script>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</section>

<!-- PDP SCRIPT TOÀN DIỆN: VARIANT SWITCHING, AJAX CART, REVIEWS, LIGHTBOX -->
<script>
var CSRF_NAME = '<?php echo $this->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?php echo $this->security->get_csrf_hash(); ?>';
var BASE_URL  = '<?php echo base_url(); ?>';

/**
 * 1. Chuyển đổi SKU Biến thể (Dung lượng / Phiên bản) qua AJAX & Deep-linking
 */
function switchSkuVariant(btnElem, variantId, variantUrl) {
    jQuery('#sku-capacity-grid .btn-variant-chip').removeClass('active');
    jQuery(btnElem).addClass('active');

    // Cập nhật URL trình duyệt (HTML5 History API) mà không cần reload trang
    if (window.history && window.history.pushState) {
        window.history.pushState({ variantId: variantId }, '', variantUrl);
    }

    // Hiển thị trạng thái loading nhẹ
    jQuery('#pdp-price-current').css('opacity', '0.5');

    // Gửi request lấy thông số SKU mới
    jQuery.ajax({
        url: BASE_URL + 'sanpham/get_variant_ajax',
        type: 'GET',
        dataType: 'json',
        data: { id: variantId },
        success: function(res) {
            jQuery('#pdp-price-current').css('opacity', '1');
            if (res.status === 'success') {
                var d = res.data;

                // Cập nhật Hidden Product ID
                jQuery('#selected_product_id').val(d.id);

                // Cập nhật Tiêu đề và SKU
                jQuery('#pdp-title').text(d.name);
                jQuery('#current-variant-name').text(d.name);
                jQuery('#pdp-sku').text('SKU-' + d.id);
                document.title = d.name + ' - Giá Tốt | NDN Mobile';

                // Cập nhật Giá
                jQuery('#pdp-price-current').text(d.price_sale_formatted);
                if (d.has_sale) {
                    jQuery('#pdp-price-old').text(d.price_formatted);
                    jQuery('#pdp-price-old-wrap').show();
                    jQuery('#pdp-sale-badge').text('-' + d.sale_percent + '%').show();
                } else {
                    jQuery('#pdp-price-old-wrap').hide();
                    jQuery('#pdp-sale-badge').hide();
                }

                // Cập nhật Kho hàng
                if (d.is_in_stock) {
                    jQuery('#pdp-stock-badge').html('<span class="badge-stock in-stock"><i class="fa fa-check-circle"></i> ' + d.stock_text + '</span>');
                    jQuery('#btnBuyNow, #btnAddCart').prop('disabled', false);
                } else {
                    jQuery('#pdp-stock-badge').html('<span class="badge-stock out-of-stock"><i class="fa fa-times-circle"></i> ' + d.stock_text + '</span>');
                    jQuery('#btnBuyNow, #btnAddCart').prop('disabled', true);
                }

                // Cập nhật Gallery ảnh nếu SKU có ảnh riêng
                if (d.images && d.images.length > 0) {
                    changeMainImage(d.images[0].src, null);
                    renderThumbnailStrip(d.images);
                }
            }
        },
        error: function() {
            jQuery('#pdp-price-current').css('opacity', '1');
        }
    });
}

/**
 * 2. Chọn Dung lượng (Capacity) đơn lẻ
 */
function selectCapacitySimple(elem, capValue) {
    jQuery('#capacity-options .btn-variant-chip').removeClass('active');
    jQuery(elem).addClass('active');
    jQuery('#selected_capacity').val(capValue);
    jQuery('#current-capacity-text').text(capValue);
    jQuery('#spec-capacity-val').text(capValue);
}

/**
 * 3. Chọn Màu sắc (Color Swatches)
 */
function selectColorOption(elem, colorValue, index) {
    jQuery('#color-options .color-swatch-item').removeClass('active');
    jQuery(elem).addClass('active');
    jQuery('#selected_color').val(colorValue);
    jQuery('#current-color-text').text(colorValue);

    // Tự động nhảy thumbnail tương ứng nếu có
    var thumbs = jQuery('#thumbnailStrip .thumb-item');
    if (thumbs.length > index) {
        thumbs.eq(index).trigger('click');
    }
}

/**
 * 4. Gallery Ảnh & Lightbox
 */
function changeMainImage(imgUrl, thumbElem) {
    jQuery('#pdp-main-image').attr('src', imgUrl).attr('data-zoom-image', imgUrl);
    jQuery('#lightboxImage').attr('src', imgUrl);
    if (thumbElem) {
        jQuery('#thumbnailStrip .thumb-item').removeClass('active');
        jQuery(thumbElem).addClass('active');
    }
}

function renderThumbnailStrip(images) {
    var html = '';
    for (var i = 0; i < images.length; i++) {
        var act = (i === 0) ? 'active' : '';
        html += '<div class="thumb-item ' + act + '" onclick="changeMainImage(\'' + images[i].src + '\', this)">';
        html += '<img src="' + images[i].src + '" alt="Thumb ' + (i + 1) + '">';
        html += '</div>';
    }
    jQuery('#thumbnailStrip').html(html);
}

function openLightbox() {
    jQuery('#pdpLightboxModal').fadeIn(200);
}

function closeLightbox() {
    jQuery('#pdpLightboxModal').fadeOut(200);
}

function switchLightboxImage(src) {
    jQuery('#lightboxImage').attr('src', src);
}

function openFullSpecsModal() {
    jQuery('#pdpSpecsModal').modal('show');
}

/**
 * 5. Asynchronous Add to Cart & Buy Now
 */
function handleAddToCart() {
    var productId = jQuery('#selected_product_id').val();
    var color     = jQuery('#selected_color').val() || '';
    var capacity  = jQuery('#selected_capacity').val() || '';

    var btn = jQuery('#btnAddCart');
    var originalHtml = btn.html();
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang thêm...');

    var postData = {
        id: productId,
        color: color,
        capacity: capacity,
        quantity: 1
    };
    postData[CSRF_NAME] = CSRF_HASH;

    jQuery.ajax({
        url: BASE_URL + 'sanpham/addcart',
        type: 'POST',
        dataType: 'json',
        data: postData,
        success: function(res) {
            btn.prop('disabled', false).html(originalHtml);
            if (res.status === 'success') {
                // Cập nhật Header Giỏ Hàng
                jQuery('#cart-count').html(res.count);
                jQuery('#cart-total').html(res.total);

                // Hiển thị Toast Notification
                var desc = res.item.name;
                if (res.item.color) desc += ' - ' + res.item.color;
                if (res.item.capacity) desc += ' (' + res.item.capacity + ')';
                jQuery('#toastItemDesc').text(desc);
                showCartToast();
            } else {
                alert(res.message);
            }
        },
        error: function() {
            btn.prop('disabled', false).html(originalHtml);
            alert('Có lỗi xảy ra trong quá trình thêm giỏ hàng. Vui lòng thử lại!');
        }
    });
}

function handleBuyNow() {
    var productId = jQuery('#selected_product_id').val();
    var color     = jQuery('#selected_color').val() || '';
    var capacity  = jQuery('#selected_capacity').val() || '';

    // Tạo form ẩn để submit POST an toàn đến buynow endpoint
    var form = jQuery('<form method="POST" action="' + BASE_URL + 'sanpham/buynow"></form>');
    form.append('<input type="hidden" name="id" value="' + productId + '">');
    form.append('<input type="hidden" name="color" value="' + color + '">');
    form.append('<input type="hidden" name="capacity" value="' + capacity + '">');
    form.append('<input type="hidden" name="' + CSRF_NAME + '" value="' + CSRF_HASH + '">');
    jQuery('body').append(form);
    form.submit();
}

function showCartToast() {
    var toast = jQuery('#pdpCartToast');
    toast.addClass('show');
    setTimeout(function() {
        toast.removeClass('show');
    }, 4000);
}

/**
 * 6. Thu gọn / Mở rộng Đặc điểm nổi bật
 */
function toggleHighlightsContent() {
    var content = jQuery('#highlightsContent');
    var btn = jQuery('#btnToggleHighlights');
    var overlay = jQuery('#contentOverlay');

    if (content.hasClass('expanded')) {
        content.removeClass('expanded');
        overlay.show();
        btn.html('<span>Xem thêm chi tiết</span> <i class="fa fa-chevron-down"></i>');
        jQuery('html, body').animate({
            scrollTop: jQuery('#pdp-highlights').offset().top - 80
        }, 300);
    } else {
        content.addClass('expanded');
        overlay.hide();
        btn.html('<span>Thu gọn nội dung</span> <i class="fa fa-chevron-up"></i>');
    }
}

/**
 * 7. Rating, Reviews & Spam Protection
 */
function toggleReviewForm() {
    jQuery('#pdpReviewFormWrapper').slideToggle(300);
}

// Hover và Click chọn sao đánh giá
jQuery(document).on('click', '#starPicker .star-opt', function() {
    var score = jQuery(this).data('score');
    jQuery('#review_score_input').val(score);

    var hints = {
        1: 'Rất tệ - Không hài lòng chút nào',
        2: 'Tệ - Cần cải thiện nhiều',
        3: 'Bình thường - Tạm chấp nhận được',
        4: 'Tốt - Rất hài lòng',
        5: 'Tuyệt vời - Rất hài lòng'
    };
    jQuery('#starHintText').text(hints[score] || '');

    jQuery('#starPicker .star-opt').each(function() {
        var s = jQuery(this).data('score');
        if (s <= score) {
            jQuery(this).addClass('active');
        } else {
            jQuery(this).removeClass('active');
        }
    });
});

function submitPdpReview() {
    var form = jQuery('#frmPdpReview');
    var btn = jQuery('#btnSubmitReview');
    var originalHtml = btn.html();

    var fullname = jQuery.trim(form.find('input[name="fullname"]').val());
    var content  = jQuery.trim(form.find('textarea[name="content"]').val());
    var score    = jQuery('#review_score_input').val();

    if (!fullname || !content || !score) {
        alert('Vui lòng điền đầy đủ họ tên, nhận xét và chọn số sao đánh giá!');
        return;
    }

    if (content.length < 10) {
        alert('Nội dung nhận xét tối thiểu 10 ký tự!');
        return;
    }

    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Đang gửi...');

    var formData = form.serialize();
    formData += '&' + encodeURIComponent(CSRF_NAME) + '=' + encodeURIComponent(CSRF_HASH);

    jQuery.ajax({
        url: BASE_URL + 'sanpham/add_review',
        type: 'POST',
        dataType: 'json',
        data: formData,
        success: function(res) {
            btn.prop('disabled', false).html(originalHtml);
            alert(res.message);
            if (res.status === 'success') {
                form[0].reset();
                jQuery('#pdpReviewFormWrapper').slideUp();
            }
        },
        error: function() {
            btn.prop('disabled', false).html(originalHtml);
            alert('Lỗi hệ thống khi gửi nhận xét. Vui lòng thử lại sau!');
        }
    });
}

function filterReviews(star, btnElem) {
    jQuery('.review-filter-tabs .btn-filter-tag').removeClass('active');
    jQuery(btnElem).addClass('active');

    var items = jQuery('#reviewsFeed .review-card-item');
    if (star === 'all') {
        items.show();
    } else {
        items.each(function() {
            var itemStar = parseInt(jQuery(this).attr('data-star'), 10);
            if (itemStar === parseInt(star, 10)) {
                jQuery(this).show();
            } else {
                jQuery(this).hide();
            }
        });
    }
}

/**
 * 8. Sticky Navigation Sub-bar Smooth Scroll & Scrollspy
 */
jQuery(window).on('scroll', function() {
    var scrollPos = jQuery(window).scrollTop();
    var stickyNav = jQuery('#pdpStickyNav');
    var mainView = jQuery('.product-view-container');

    if (mainView.length) {
        var triggerPoint = mainView.offset().top + mainView.outerHeight() - 100;
        if (scrollPos > triggerPoint) {
            stickyNav.addClass('visible');
        } else {
            stickyNav.removeClass('visible');
        }
    }

    // Active state highlighting
    jQuery('#pdpStickyNav .nav-sub-tabs a').each(function() {
        var targetSec = jQuery(jQuery(this).attr('href'));
        if (targetSec.length) {
            var top = targetSec.offset().top - 120;
            var bottom = top + targetSec.outerHeight();
            if (scrollPos >= top && scrollPos <= bottom) {
                jQuery('#pdpStickyNav .nav-sub-tabs li').removeClass('active');
                jQuery(this).parent().addClass('active');
            }
        }
    });
});

jQuery(document).ready(function() {
    // Khởi tạo label mặc định
    var defaultCap = jQuery('#selected_capacity').val();
    var defaultCol = jQuery('#selected_color').val();
    if(defaultCap) jQuery('#current-capacity-text').text(defaultCap);
    if(defaultCol) jQuery('#current-color-text').text(defaultCol);

    // Smooth scroll cho các tab sticky nav
    jQuery('#pdpStickyNav .nav-sub-tabs a').on('click', function(e) {
        e.preventDefault();
        var target = jQuery(jQuery(this).attr('href'));
        if (target.length) {
            jQuery('html, body').animate({
                scrollTop: target.offset().top - 80
            }, 400);
        }
    });
});
</script>

<!-- MODERN PDP STYLESHEET (CLEAN RED & SLATE HIGH-END DESIGN) -->
<style>
/* Page Layout */
.product-detail-page {
    background: #f4f6f9;
    padding-top: 15px;
    padding-bottom: 50px;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    color: #2c3e50;
}
.modern-breadcrumb {
    margin-bottom: 15px;
}
.modern-breadcrumb .breadcrumb {
    background: transparent;
    padding: 0;
    font-size: 13px;
    margin-bottom: 10px;
}
.modern-breadcrumb .breadcrumb a {
    color: #666;
    text-decoration: none;
}
.modern-breadcrumb .breadcrumb a:hover {
    color: #d70018;
}

/* Header Top Card & Meta */
.product-header-top {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 20px;
    border: 1px solid #edf2f7;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    margin-bottom: 20px;
}
.product-header-top .product-main-name {
    font-size: 24px;
    font-weight: 800;
    color: #1a1a1a;
    margin: 0 0 6px 0;
    line-height: 1.3;
}
.product-meta-sub {
    font-size: 13px;
    color: #555;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
}
.stars-gold {
    color: #f39c12;
}
.meta-review-link {
    color: #2980b9;
    text-decoration: none;
    margin-left: 4px;
}
.meta-review-link:hover {
    text-decoration: underline;
}
.meta-sep {
    color: #ccc;
}
.btn-outline-wishlist, .btn-outline-compare {
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 20px;
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 600;
    color: #444;
    transition: all 0.2s ease;
    text-decoration: none;
    display: inline-block;
}
.btn-outline-wishlist:hover {
    border-color: #d70018;
    color: #d70018;
}
.btn-outline-compare:hover {
    border-color: #2980b9;
    color: #2980b9;
}

/* Card Shadow Container */
.card-shadow {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
}
.product-view-container {
    padding: 24px;
    margin-bottom: 25px;
}

/* Modern Gallery */
.product-gallery-modern {
    position: relative;
}
.main-image-viewport {
    position: relative;
    background: #fff;
    border: 1px solid #edf2f7;
    border-radius: 12px;
    padding: 20px;
    text-align: center;
    overflow: hidden;
    min-height: 380px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.main-display-img {
    max-height: 360px;
    width: auto;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.3s ease;
}
.main-image-viewport:hover .main-display-img {
    transform: scale(1.03);
}
.badge-discount-float {
    position: absolute;
    top: 14px;
    left: 14px;
    background: linear-gradient(135deg, #d70018 0%, #b30014 100%);
    color: #fff;
    font-size: 12px;
    font-weight: 800;
    padding: 4px 10px;
    border-radius: 6px;
    box-shadow: 0 2px 8px rgba(215, 0, 24, 0.35);
    z-index: 5;
    letter-spacing: 0.5px;
}
.btn-expand-lightbox {
    position: absolute;
    bottom: 12px;
    right: 12px;
    background: rgba(0,0,0,0.6);
    color: #fff;
    border: none;
    border-radius: 20px;
    padding: 5px 12px;
    font-size: 12px;
    cursor: pointer;
    transition: background 0.2s ease;
}
.btn-expand-lightbox:hover {
    background: rgba(0,0,0,0.85);
}

/* Thumbnail Strip */
.thumbnail-strip {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding: 6px 2px;
}
.thumbnail-strip::-webkit-scrollbar {
    height: 4px;
}
.thumbnail-strip::-webkit-scrollbar-thumb {
    background: #ddd;
    border-radius: 4px;
}
.thumb-item {
    flex: 0 0 65px;
    width: 65px;
    height: 65px;
    border: 2px solid #e0e0e0;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    padding: 4px;
    background: #fff;
    transition: all 0.2s ease;
}
.thumb-item:hover, .thumb-item.active {
    border-color: #d70018;
    box-shadow: 0 0 0 1px #d70018;
}
.thumb-item img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

/* Commitments */
.gallery-commitments {
    background: #fdfaf6;
    border: 1px dashed #f5c6cb;
    border-radius: 8px;
    padding: 12px 6px;
}
.commit-box {
    font-size: 12px;
    font-weight: 600;
}
.commit-box i {
    font-size: 16px;
    margin-right: 4px;
    display: inline-block;
}

/* Pricing Card */
.pdp-pricing-card {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 16px 20px;
    border-left: 4px solid #d70018;
    margin-bottom: 20px;
}
.price-row {
    display: flex;
    align-items: baseline;
    flex-wrap: wrap;
    gap: 12px;
}
.pdp-price-current {
    font-size: 30px;
    font-weight: 800;
    color: #d70018;
}
.pdp-price-old {
    font-size: 18px;
    color: #888;
    text-decoration: line-through;
}
.pdp-stock-badge .badge-stock {
    font-size: 13px;
    padding: 4px 10px;
    border-radius: 20px;
    font-weight: 600;
}
.badge-stock.in-stock {
    background: #e8f8f0;
    color: #27ae60;
}
.badge-stock.out-of-stock {
    background: #fbeae8;
    color: #e74c3c;
}
.vat-note {
    font-size: 12px;
    margin-top: 6px;
}

/* Short Description */
.pdp-short-desc {
    font-size: 14px;
    line-height: 1.6;
    color: #4a5568;
    background: #ffffff;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #edf2f7;
}

/* Variants */
.variant-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 8px;
}
.variant-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.btn-variant-chip {
    background: #fff;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    padding: 8px 14px;
    cursor: pointer;
    text-align: center;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-width: 90px;
}
.btn-variant-chip .chip-title {
    font-size: 13px;
    font-weight: 700;
    color: #333;
}
.btn-variant-chip .chip-price {
    font-size: 11px;
    color: #777;
    margin-top: 2px;
}
.btn-variant-chip:hover, .btn-variant-chip.active {
    border-color: #d70018;
    background: #fff5f5;
    box-shadow: 0 0 0 1px #d70018;
}
.btn-variant-chip.active .chip-title {
    color: #d70018;
}

/* Color Swatches Grid */
.color-swatches-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.color-swatch-item {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 6px 12px;
    border: 1px solid #d1d5db;
    border-radius: 20px;
    cursor: pointer;
    background: #fff;
    transition: all 0.2s ease;
}
.color-swatch-item .color-dot {
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: inline-block;
}
.color-swatch-item .color-name {
    font-size: 13px;
    font-weight: 600;
    color: #333;
}
.color-swatch-item:hover, .color-swatch-item.active {
    border-color: #d70018;
    background: #fff5f5;
    box-shadow: 0 0 0 1px #d70018;
}
.color-swatch-item.active .color-name {
    color: #d70018;
}

/* Promotions Box */
.pdp-promotions-box {
    border: 1px solid #fed7d7;
    background: #fffaf0;
    border-radius: 8px;
    overflow: hidden;
}
.promo-header {
    background: #feebc8;
    padding: 8px 14px;
    font-size: 13px;
    color: #c05621;
}
.promo-body {
    padding: 12px 14px;
}
.promo-checklist {
    list-style: none;
    padding: 0;
    margin: 0;
}
.promo-checklist li {
    font-size: 13px;
    margin-bottom: 6px;
    line-height: 1.5;
}
.promo-checklist li i {
    margin-right: 6px;
}

/* CTA Buttons Modern & Balanced */
.cta-buttons-row {
    display: flex !important;
    gap: 12px !important;
    align-items: stretch !important;
    margin-bottom: 0 !important;
}
.btn-buy-now, .btn-add-cart {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    height: 64px !important;
    min-height: 64px !important;
    max-height: 64px !important;
    padding: 8px 12px !important;
    border-radius: 10px !important;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1) !important;
    cursor: pointer !important;
    text-decoration: none !important;
    box-sizing: border-box !important;
    margin: 0 !important;
    vertical-align: middle !important;
}
.btn-cta-inner {
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    text-align: center !important;
}
.btn-buy-now {
    flex: 1.25 !important;
    width: auto !important;
    background: linear-gradient(135deg, #d70018 0%, #b30014 100%) !important;
    color: #ffffff !important;
    border: none !important;
    box-shadow: 0 4px 14px rgba(215, 0, 24, 0.28) !important;
}
.btn-buy-now:hover {
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 18px rgba(215, 0, 24, 0.4) !important;
    color: #ffffff !important;
}
.btn-buy-now:active {
    transform: translateY(0) !important;
}
.btn-buy-now .btn-main-text {
    color: #ffffff !important;
}
.btn-buy-now .btn-sub-text {
    color: rgba(255, 255, 255, 0.9) !important;
}
.btn-add-cart {
    flex: 1 !important;
    width: auto !important;
    background: #ffffff !important;
    border: 1.5px solid #d70018 !important;
    color: #d70018 !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
}
.btn-add-cart:hover {
    background: #fff5f5 !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 12px rgba(215, 0, 24, 0.15) !important;
    color: #b30014 !important;
    border-color: #b30014 !important;
}
.btn-add-cart:active {
    transform: translateY(0) !important;
}
.btn-add-cart .btn-main-text {
    color: #d70018 !important;
}
.btn-add-cart .btn-sub-text {
    color: #666666 !important;
}
.btn-main-text {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 6px !important;
    font-size: 14px !important;
    font-weight: 800 !important;
    letter-spacing: 0.3px !important;
    line-height: 1.25 !important;
    margin: 0 !important;
}
.btn-sub-text {
    display: block !important;
    font-size: 11px !important;
    font-weight: 400 !important;
    line-height: 1.3 !important;
    margin-top: 3px !important;
    margin-bottom: 0 !important;
}
.btn-installment {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background: #2b6cb0;
    color: #ffffff;
    border-radius: 10px;
    padding: 10px 14px;
    text-align: center;
    text-decoration: none;
    box-shadow: 0 2px 8px rgba(43, 108, 176, 0.2);
    transition: all 0.2s ease;
}
.btn-installment:hover {
    background: #23527c;
    color: #ffffff;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(43, 108, 176, 0.35);
}
.inst-main-text {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 700;
    line-height: 1.3;
}
.inst-sub-text {
    display: block;
    font-size: 11px;
    opacity: 0.9;
    margin-top: 2px;
}
.hotline-box {
    font-size: 13px;
    color: #4a5568;
    background: #f8fafc;
    border-radius: 8px;
    padding: 8px 12px;
    border: 1px solid #edf2f7;
}

/* Sticky Sub Navigation */
.pdp-sticky-subnav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: #fff;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    z-index: 1000;
    display: none;
    padding: 8px 0;
}
.pdp-sticky-subnav.visible {
    display: block;
    animation: slideDownNav 0.3s ease-out;
}
@keyframes slideDownNav {
    from { transform: translateY(-100%); }
    to { transform: translateY(0); }
}
.pdp-sticky-subnav .container {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.nav-sub-tabs {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 20px;
}
.nav-sub-tabs li a {
    color: #4a5568;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    padding: 8px 0;
    position: relative;
    display: block;
}
.nav-sub-tabs li.active a, .nav-sub-tabs li a:hover {
    color: #d70018;
}
.nav-sub-tabs li.active a:after {
    content: '';
    position: absolute;
    bottom: -8px;
    left: 0;
    right: 0;
    height: 3px;
    background: #d70018;
}

/* Sections */
.pdp-section-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
}
.section-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid #edf2f7;
}
.section-card-header h2, .section-card-header h3 {
    font-size: 18px;
    font-weight: 700;
    margin: 0;
    color: #1a202c;
}
.section-card-body {
    padding: 20px;
}

/* Collapsible Content */
.content-collapsible {
    position: relative;
    max-height: 480px;
    overflow: hidden;
    transition: max-height 0.4s ease;
}
.content-collapsible.expanded {
    max-height: none;
}
.content-overlay-gradient {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 120px;
    background: linear-gradient(to bottom, rgba(255,255,255,0) 0%, rgba(255,255,255,1) 100%);
    pointer-events: none;
}
.btn-outline-toggle-content {
    background: #fff;
    border: 1px solid #d70018;
    color: #d70018;
    border-radius: 20px;
    padding: 8px 24px;
    font-weight: 600;
    font-size: 13px;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-outline-toggle-content:hover {
    background: #d70018;
    color: #fff;
}

/* Specs Table */
.table-specs-modern {
    font-size: 13px;
}
.table-specs-modern tr td {
    padding: 10px 14px;
    border-top: 1px solid #f0f0f0;
}
.spec-label {
    width: 35%;
    color: #718096;
    font-weight: 600;
}
.spec-val {
    color: #2d3748;
    font-weight: 500;
}

/* Rating Dashboard */
.rating-dashboard {
    background: #f7fafc;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
}
.rating-big-number {
    font-size: 44px;
    font-weight: 800;
    color: #d70018;
    line-height: 1;
}
.max-score {
    font-size: 20px;
    color: #a0aec0;
}
.rating-big-stars {
    font-size: 18px;
    margin-top: 6px;
}
.star-bar-row {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
    font-size: 13px;
}
.star-label {
    width: 45px;
    text-align: right;
    font-weight: 600;
}
.progress-rating-bar {
    flex: 1;
    height: 8px;
    margin-bottom: 0;
    border-radius: 4px;
    background: #e2e8f0;
}
.progress-rating-bar .progress-bar-warning {
    background: #f6ad55;
}
.star-count {
    width: 80px;
    font-size: 12px;
}
.review-policy-card {
    text-align: center;
    background: #fff;
    padding: 16px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}
.review-policy-card h6 {
    font-weight: 700;
    margin: 4px 0;
}
.review-policy-card p {
    font-size: 12px;
    color: #718096;
    margin: 0;
}

/* Review Form */
.review-form-wrapper {
    background: #fffaf0;
    border: 1px solid #fbd38d;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 24px;
}
.star-picker-box .star-opt {
    font-size: 30px;
    color: #cbd5e0;
    cursor: pointer;
    margin: 0 4px;
    transition: color 0.15s ease;
}
.star-picker-box .star-opt.active {
    color: #f6ad55;
}

/* Review Filter */
.review-filter-tabs {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 8px;
    border-bottom: 1px solid #edf2f7;
    padding-bottom: 14px;
}
.filter-title {
    font-size: 13px;
    font-weight: 700;
    margin-right: 6px;
}
.btn-filter-tag {
    background: #edf2f7;
    border: none;
    border-radius: 20px;
    padding: 5px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #4a5568;
    cursor: pointer;
    transition: all 0.2s ease;
}
.btn-filter-tag:hover, .btn-filter-tag.active {
    background: #d70018;
    color: #fff;
}

/* Review Item */
.review-card-item {
    padding: 18px 0;
    border-bottom: 1px solid #edf2f7;
}
.review-author-info {
    display: flex;
    align-items: center;
    gap: 12px;
}
.author-avatar-circle {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    background: #e2e8f0;
    color: #4a5568;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
}
.badge-verified {
    font-size: 11px;
    color: #27ae60;
    background: #e8f8f0;
    padding: 2px 8px;
    border-radius: 12px;
    margin-left: 6px;
}
.review-body-text p {
    font-size: 14px;
    color: #2d3748;
    line-height: 1.6;
    margin: 8px 0 0 0;
}

/* Toast Cart */
.pdp-cart-toast {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: #2d3748;
    color: #fff;
    padding: 16px 20px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    display: flex;
    align-items: center;
    gap: 14px;
    z-index: 9999;
    transform: translateY(120%);
    opacity: 0;
    transition: all 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.pdp-cart-toast.show {
    transform: translateY(0);
    opacity: 1;
}
.toast-icon {
    font-size: 28px;
    color: #48bb78;
}
.toast-body {
    max-width: 260px;
}
.toast-title {
    font-size: 14px;
    display: block;
}
.toast-desc {
    font-size: 12px;
    color: #cbd5e0;
    margin: 2px 0 0 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.btn-toast-view {
    background: #d70018;
    color: #fff;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
}
.btn-toast-view:hover {
    background: #b30014;
    color: #fff;
}

/* Lightbox Modal */
.pdp-modal-lightbox {
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    z-index: 10000;
    display: none;
}
.lightbox-backdrop {
    position: absolute;
    top: 0; left: 0; right: 0; bottom: 0;
    background: rgba(0,0,0,0.85);
}
.lightbox-content-box {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    max-width: 90vw;
    max-height: 90vh;
    text-align: center;
}
.lightbox-content-box img {
    max-height: 70vh;
    max-width: 85vw;
    border-radius: 8px;
    background: #fff;
    padding: 10px;
}
.lightbox-close-btn {
    position: absolute;
    top: -40px;
    right: 0;
    color: #fff;
    font-size: 36px;
    background: transparent;
    border: none;
    cursor: pointer;
}
.lightbox-thumbnails-bar {
    display: flex;
    justify-content: center;
    gap: 8px;
    margin-top: 15px;
}
.lightbox-thumbnails-bar img {
    width: 50px;
    height: 50px;
    object-fit: contain;
    border-radius: 4px;
    cursor: pointer;
    border: 2px solid transparent;
}
.lightbox-thumbnails-bar img:hover {
    border-color: #d70018;
}

/* Responsive */
@media (max-width: 768px) {
    .pdp-pricing-card {
        padding: 12px;
    }
    .pdp-price-current {
        font-size: 24px;
    }
    .cta-buttons-row {
        flex-direction: column;
    }
    .pdp-sticky-subnav {
        display: none !important;
    }
    .pdp-cart-toast {
        left: 20px;
        right: 20px;
        bottom: 20px;
    }
}
</style>
