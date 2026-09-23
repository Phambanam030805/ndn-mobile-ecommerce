<section id="product-all" class="collection-page">
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <!-- Sidebar: Bộ lọc -->
            <aside class="col-md-3 col-sm-12">
                <!-- Lọc theo giá (UI) -->
                <div class="sidebar-box card-shadow mb-4">
                    <div class="sidebar-title">
                        <i class="fa fa-filter"></i> Lọc theo giá
                    </div>
                    <ul class="sidebar-list filter-price">
                        <li><a href="<?php echo base_url('san-pham/'.$this->uri->segment(2)); ?>"><i class="fa fa-circle-o"></i> Tất cả mức giá</a></li>
                        <li><a href="?price=0-5000000"><i class="fa fa-circle-o"></i> Dưới 5.000.000₫</a></li>
                        <li><a href="?price=5000000-10000000"><i class="fa fa-circle-o"></i> 5.000.000₫ - 10.000.000₫</a></li>
                        <li><a href="?price=10000000-20000000"><i class="fa fa-circle-o"></i> 10.000.000₫ - 20.000.000₫</a></li>
                        <li><a href="?price=20000000-500000000"><i class="fa fa-circle-o"></i> Trên 20.000.000₫</a></li>
                    </ul>
                </div>
            </aside>

            <!-- Nội dung chính: Danh sách sản phẩm -->
            <div class="col-md-9 col-sm-12">
                <div class="product-main-wrapper card-shadow">
                    <div class="collection-header">
                        <h1 class="collection-title"><?php echo $categoryname; ?></h1>
                        
                        <div class="sort-wrapper">
                            <label class="hidden-xs">Sắp xếp: </label>
                            <select id="sortControl" class="form-control-modern sort-select" onchange="sortby(this.value)">
                                <?php 
                                $data = $this->session->userdata('sortby-category');
                                $sort = $data ? $data[0].'-'.$data[1] : 'number_buy-desc';
                                ?>
                                <option value="number_buy-desc" <?php if($sort=='number_buy-desc') echo 'selected'; ?>>Bán chạy nhất</option>
                                <option value="price-asc" <?php if($sort=='price-asc') echo 'selected'; ?>>Giá tăng dần</option>
                                <option value="price-desc" <?php if($sort=='price-desc') echo 'selected'; ?>>Giá giảm dần</option>
                                <option value="name-asc" <?php if($sort=='name-asc') echo 'selected'; ?>>Tên A-Z</option>
                                <option value="created_at-desc" <?php if($sort=='created_at-desc') echo 'selected'; ?>>Hàng mới nhất</option>
                            </select>
                        </div>
                    </div>

                    <div id="list-product" class="mt-4">
                        <div class="row">
                            <?php if(count($list)==0): ?>
                                <div class="col-md-12 text-center py-5">
                                    <i class="fa fa-search fa-4x text-light mb-3"></i>
                                    <p>Danh mục hiện chưa có sản phẩm nào phù hợp!</p>
                                </div>
                            <?php else : ?>
                                <?php foreach ($list as $sp) :?>
                                    <div class="col-md-4 col-sm-6 col-xs-6">
                                        <div class="product-lt product-card-modern">
                                            <div class="lt-product-group-image">
                                                <a href="<?php echo base_url($sp['alias']); ?>" title="<?php echo $sp['name'] ?>" >
                                                    <img class="img-p" src="<?php echo base_url(); ?>public/images/products/<?php echo $sp['avatar'] ?>" alt="">
                                                </a>
                                                <?php if($sp['sale'] > 0) :?>
                                                    <div class="giam-percent">
                                                        <span>-<?php echo $sp['sale'] ?>%</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="lt-product-group-info">
                                                <a href="<?php echo base_url($sp['alias']); ?>" title="<?php echo $sp['name'] ?>">
                                                    <h3><?php echo $sp['name'] ?></h3>
                                                </a>
                                                <div class="price-box">
                                                    <?php if($sp['sale'] > 0) :?>
                                                        <span class="price-new"><?php echo number_format($sp['price_sale']); ?>₫</span>
                                                        <span class="price-old"><?php echo number_format($sp['price']); ?>₫</span>
                                                    <?php else: ?>
                                                        <span class="price-new"><?php echo number_format($sp['price']); ?>₫</span>
                                                    <?php endif;?>
                                                </div>
                                                <div class="product-buy-count" style="font-size: 12px; color: #777; margin-top: 5px; text-align: left;">
                                                    <i class="fa fa-shopping-cart"></i> Đã bán: <?php echo $sp['number_buy']; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- Phân trang -->
                        <div class="text-center mt-4">
                            <ul class="pagination-modern">
                                <?php echo $strphantrang; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function sortby(option){
        var strurl="<?php echo base_url('sanpham/category/'.$this->uri->segment(2));?>";
        jQuery.ajax({
            url: strurl,
            type: 'POST',
            dataType: 'json',
            data: {'sapxep-category': option, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function(data) {
                location.reload();
            }
        });
    }
</script>