<section id="product-search" class="collection-page search-results-page">
    <div class="container" style="margin-top: 30px;">
        <div class="row">
            <div class="col-md-12">
                <div class="product-main-wrapper card-shadow">
                    <div class="collection-header search-header">
                        <div class="search-info">
                            <h1 class="collection-title">Kết quả tìm kiếm</h1>
                            <p class="search-summary">
                                Tìm thấy <strong><?php echo $count; ?></strong> kết quả cho từ khóa: 
                                <span class="search-keyword">"<?php echo htmlspecialchars($key); ?>"</span>
                            </p>
                        </div>
                    </div>

                    <div id="list-product" class="mt-4">
                        <div class="row">
                            <?php if(count($list)==0): ?>
                                <div class="col-md-12 text-center py-5 no-results">
                                    <div class="no-results-icon"><i class="fa fa-search-minus fa-4x"></i></div>
                                    <h3>Rất tiếc, chúng tôi không tìm thấy sản phẩm nào!</h3>
                                    <p>Vui lòng kiểm tra lại từ khóa hoặc thử tìm kiếm khác.</p>
                                    <a href="<?php echo base_url('san-pham'); ?>" class="btn btn-danger btn-modern mt-3">Xem tất cả sản phẩm</a>
                                </div>
                            <?php else : ?>
                                <?php foreach ($list as $sp) :?>
                                    <div class="col-md-3 col-sm-6 col-xs-6">
                                        <div class="product-lt product-card-modern">
                                            <div class="lt-product-group-image">
                                                <a href="<?php echo base_url($sp['alias']); ?>" title="<?php echo $sp['name'] ?>" >
                                                    <img class="img-p" src="<?php echo base_url('public/images/products/'.$sp['avatar']); ?>" alt="">
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
                        <?php if(count($list) > 0): ?>
                        <div class="text-center mt-4">
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