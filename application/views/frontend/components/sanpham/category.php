<section id="product-all" class="collection-page" style="background-color: #f8fafc; padding: 25px 0 50px 0;">
    <div class="container">
        <!-- Breadcrumb Hiện Đại -->
        <div class="breadcrumbs-modern mb-3" style="font-size: 13.5px; color: #64748b; margin-bottom: 20px;">
            <a href="<?php echo base_url(); ?>" style="color: #64748b; text-decoration: none;"><i class="fa fa-home"></i> Trang chủ</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <a href="<?php echo base_url('san-pham'); ?>" style="color: #64748b; text-decoration: none;">Sản phẩm</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <span style="color: #0f172a; font-weight: 700;"><?php echo htmlspecialchars($categoryname); ?></span>
        </div>

        <div class="row">
            <!-- Sidebar: Bộ lọc thông minh & hiện đại -->
            <aside class="col-md-3 col-sm-12">
                <!-- 1. Lọc theo thương hiệu nổi bật -->
                <div class="filter-sidebar-card">
                    <div class="filter-sidebar-header">
                        <i class="fa fa-mobile"></i> Thương hiệu
                    </div>
                    <ul class="filter-brand-pills">
                        <?php if(!empty($categories)): ?>
                            <?php foreach($categories as $cat): ?>
                                <li class="<?php echo (isset($current_cat_link) && $current_cat_link == $cat['link']) ? 'active' : ''; ?>">
                                    <a href="<?php echo base_url('san-pham/'.$cat['link']); ?>">
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- 2. Lọc theo mức giá -->
                <div class="filter-sidebar-card">
                    <div class="filter-sidebar-header">
                        <i class="fa fa-filter"></i> Khoảng giá
                    </div>
                    <ul class="filter-price-list">
                        <li class="<?php echo empty($current_price) ? 'active' : ''; ?>">
                            <a href="<?php echo base_url('san-pham/'.$this->uri->segment(2)); ?>">
                                <span>Tất cả mức giá</span>
                                <i class="fa <?php echo empty($current_price) ? 'fa-check-circle' : 'fa-circle-o'; ?>"></i>
                            </a>
                        </li>
                        <li class="<?php echo ($current_price == '0-5000000') ? 'active' : ''; ?>">
                            <a href="?price=0-5000000">
                                <span>Dưới 5 triệu</span>
                                <i class="fa <?php echo ($current_price == '0-5000000') ? 'fa-check-circle' : 'fa-circle-o'; ?>"></i>
                            </a>
                        </li>
                        <li class="<?php echo ($current_price == '5000000-10000000') ? 'active' : ''; ?>">
                            <a href="?price=5000000-10000000">
                                <span>5 - 10 triệu</span>
                                <i class="fa <?php echo ($current_price == '5000000-10000000') ? 'fa-check-circle' : 'fa-circle-o'; ?>"></i>
                            </a>
                        </li>
                        <li class="<?php echo ($current_price == '10000000-20000000') ? 'active' : ''; ?>">
                            <a href="?price=10000000-20000000">
                                <span>10 - 20 triệu</span>
                                <i class="fa <?php echo ($current_price == '10000000-20000000') ? 'fa-check-circle' : 'fa-circle-o'; ?>"></i>
                            </a>
                        </li>
                        <li class="<?php echo ($current_price == '20000000-500000000') ? 'active' : ''; ?>">
                            <a href="?price=20000000-500000000">
                                <span>Trên 20 triệu</span>
                                <i class="fa <?php echo ($current_price == '20000000-500000000') ? 'fa-check-circle' : 'fa-circle-o'; ?>"></i>
                            </a>
                        </li>
                    </ul>

                    <?php if(!empty($current_price)): ?>
                        <div style="text-align: center; margin-top: 15px;">
                            <a href="<?php echo base_url('san-pham/'.$this->uri->segment(2)); ?>" class="clear-filter-btn">
                                <i class="fa fa-times-circle"></i> Xóa bộ lọc giá
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 3. Cam kết dịch vụ NDN Mobile -->
                <div class="filter-sidebar-card hidden-xs" style="background: linear-gradient(135deg, #fff5f5, #ffffff); border-color: #fee2e2;">
                    <div style="font-weight: 700; color: #d70018; margin-bottom: 10px; font-size: 14px;">
                        <i class="fa fa-shield"></i> Cam kết NDN Mobile
                    </div>
                    <ul style="list-style: none; padding: 0; margin: 0; font-size: 12.5px; color: #475569; line-height: 1.8;">
                        <li><i class="fa fa-check text-success" style="color:#10b981; margin-right: 6px;"></i> 100% Chính hãng nguyên seal</li>
                        <li><i class="fa fa-check text-success" style="color:#10b981; margin-right: 6px;"></i> Bảo hành 12 tháng chính hãng</li>
                        <li><i class="fa fa-check text-success" style="color:#10b981; margin-right: 6px;"></i> 1 đổi 1 trong 30 ngày</li>
                        <li><i class="fa fa-check text-success" style="color:#10b981; margin-right: 6px;"></i> Giao hàng hỏa tốc 2 giờ</li>
                    </ul>
                </div>
            </aside>

            <!-- Nội dung chính: Danh sách sản phẩm -->
            <div class="col-md-9 col-sm-12">
                <div class="collection-main-card">
                    <!-- Header bộ sưu tập -->
                    <div class="collection-hero-header">
                        <h1>
                            <?php echo htmlspecialchars($categoryname); ?>
                            <span class="product-count-badge">
                                <?php echo isset($total) ? $total : count($list); ?> sản phẩm
                            </span>
                        </h1>
                        
                        <!-- Bộ chọn sắp xếp hiện đại -->
                        <div class="sort-container-modern">
                            <label class="hidden-xs">Ưu tiên xem: </label>
                            <select id="sortControl" class="sort-select-modern" onchange="sortby(this.value)">
                                <?php 
                                $data = $this->session->userdata('sortby-category');
                                $sort = $data ? $data[0].'-'.$data[1] : 'created_at-desc';
                                ?>
                                <option value="created_at-desc" <?php if($sort=='created_at-desc') echo 'selected'; ?>>Mới nhất</option>
                                <option value="number_buy-desc" <?php if($sort=='number_buy-desc') echo 'selected'; ?>>Bán chạy nhất</option>
                                <option value="price-asc" <?php if($sort=='price-asc') echo 'selected'; ?>>Giá thấp đến cao</option>
                                <option value="price-desc" <?php if($sort=='price-desc') echo 'selected'; ?>>Giá cao đến thấp</option>
                                <option value="name-asc" <?php if($sort=='name-asc') echo 'selected'; ?>>Tên A - Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Lưới danh sách sản phẩm -->
                    <div id="list-product">
                        <div class="row">
                            <?php if(count($list) == 0): ?>
                                <div class="col-md-12 text-center" style="padding: 60px 20px;">
                                    <div style="width: 80px; height: 80px; line-height: 80px; border-radius: 50%; background: #f1f5f9; margin: 0 auto 15px; color: #94a3b8; font-size: 32px;">
                                        <i class="fa fa-search"></i>
                                    </div>
                                    <h4 style="font-weight: 700; color: #334155;">Chưa có sản phẩm phù hợp</h4>
                                    <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Hãy thử điều chỉnh bộ lọc giá hoặc khám phá các thương hiệu khác.</p>
                                    <a href="<?php echo base_url('san-pham'); ?>" class="btn btn-danger" style="border-radius: 8px; font-weight: 700; padding: 9px 20px; background: #d70018; border-color: #d70018;">
                                        Xem tất cả sản phẩm
                                    </a>
                                </div>
                            <?php else : ?>
                                <?php foreach ($list as $sp) :?>
                                    <div class="col-md-4 col-sm-6 col-xs-6" style="margin-bottom: 25px;">
                                        <div class="product-card-luxury">
                                            <!-- Floating Actions (Wishlist & So sánh) -->
                                            <div class="card-actions-float">
                                                <button type="button" class="btn-action-circle" title="Thêm vào yêu thích" onclick="toggleWishlist(<?php echo $sp['id']; ?>)">
                                                    <i class="far fa-heart"></i>
                                                </button>
                                                <a href="<?php echo base_url('so-sanh/them/'.$sp['id']); ?>" class="btn-action-circle" title="So sánh cấu hình">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </a>
                                            </div>

                                            <!-- Nhãn giảm giá -->
                                            <?php if($sp['sale'] > 0) :?>
                                                <span class="product-sale-pill">
                                                    Giảm <?php echo $sp['sale']; ?>%
                                                </span>
                                            <?php endif; ?>

                                            <!-- Ảnh sản phẩm -->
                                            <div class="product-img-box">
                                                <a href="<?php echo base_url($sp['alias']); ?>" title="<?php echo htmlspecialchars($sp['name']); ?>" style="display:flex; align-items:center; justify-content:center; width:100%; height:100%;">
                                                    <img src="<?php echo base_url(); ?>public/images/products/<?php echo $sp['avatar']; ?>" alt="<?php echo htmlspecialchars($sp['name']); ?>" loading="lazy">
                                                </a>
                                            </div>

                                            <!-- Tiêu đề sản phẩm -->
                                            <a href="<?php echo base_url($sp['alias']); ?>" title="<?php echo htmlspecialchars($sp['name']); ?>" style="text-decoration: none;">
                                                <h3 class="product-name"><?php echo $sp['name']; ?></h3>
                                            </a>

                                            <!-- Khối giá -->
                                            <div class="product-price-box">
                                                <?php if($sp['sale'] > 0) :?>
                                                    <span class="price-current"><?php echo number_format($sp['price_sale']); ?>₫</span>
                                                    <span class="price-original"><?php echo number_format($sp['price']); ?>₫</span>
                                                <?php else: ?>
                                                    <span class="price-current"><?php echo number_format($sp['price']); ?>₫</span>
                                                <?php endif;?>
                                            </div>

                                            <!-- Footer thẻ: Đã bán & Xem chi tiết -->
                                            <div class="product-footer-bar">
                                                <span>
                                                    <i class="fa fa-shopping-cart" style="color: #94a3b8;"></i> Đã bán: <b><?php echo $sp['number_buy']; ?></b>
                                                </span>
                                                <a href="<?php echo base_url($sp['alias']); ?>" class="btn-view-detail">
                                                    Chi tiết <i class="fa fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Phân trang hiện đại -->
                        <?php if(!empty($strphantrang)): ?>
                            <div class="text-center mt-4" style="margin-top: 30px; border-top: 1px solid #f1f5f9; padding-top: 20px;">
                                <ul class="pagination-modern">
                                    <?php echo $strphantrang; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function sortby(option){
        var strurl = "<?php echo base_url('sanpham/category/'.$this->uri->segment(2)); ?>";
        jQuery.ajax({
            url: strurl,
            type: 'POST',
            dataType: 'json',
            data: {
                'sapxep-category': option,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            },
            success: function(data) {
                location.reload();
            }
        });
    }
</script>