<!-- SLIDER FULL WIDTH -->
<section id="menu-slider">
    <div class="slider-main" style="width: 100% !important; float: none !important; margin: 0 auto !important;">
        <?php $this->load->view('frontend/modules/slider'); ?>
    </div>
</section>

<!-- SẢN PHẨM KHUYẾN MÃI HOT -->
<div class="container-fluid px-0" style="margin-top: 40px; margin-bottom: 20px;">
    <div class="section-title-modern text-center">
        <h2 style="text-transform: uppercase;">Sản phẩm khuyến mãi hot</h2>
        <div class="title-underline mx-auto" style="margin: 0 auto 30px auto;"></div>
    </div>
    
    <div class="container-fluid">
        <div class="owl-carousel owl-carousel-product owl-theme">
            <?php 
            $product_sale = $this->Msanpham->product_sale(10);
            if($product_sale) foreach ($product_sale as $row): ?>
                <div class="item" style="padding: 10px;">
                    <div class="product-card-modern">
                        <div class="lt-product-group-image">
                            <a href="<?= base_url($row['alias']) ?>">
                                <img class="img-p" src="<?= base_url('public/images/products/'.$row['avatar']) ?>">
                            </a>
                            <?php if($row['sale']>0): ?>
                                <div class="giam-percent"><span>-<?= $row['sale'] ?>%</span></div>
                            <?php endif; ?>
                        </div>
                        <div class="lt-product-group-info">
                            <a href="<?= base_url($row['alias']) ?>"><h3><?= $row['name'] ?></h3></a>
                            <div class="price-box">
                                <?php if ($row['sale'] > 0): ?>
                                    <span class="price-new"><?php echo number_format($row['price_sale']); ?>₫</span>
                                    <span class="price-old"><?php echo number_format($row['price']); ?>₫</span>
                                <?php else: ?>
                                    <span class="price-new"><?php echo number_format($row['price']); ?>₫</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-buy-count" style="font-size: 11px; color: #888; margin-top: 4px; text-align: left;">
                                <i class="fa fa-shopping-cart"></i> Đã bán: <?= $row['number_buy'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- SẢN PHẨM BÁN CHẠY -->
<div class="container-fluid px-0" style="margin-top: 40px; margin-bottom: 20px;">
    <div class="section-title-modern text-center">
        <h2 style="text-transform: uppercase;">Sản phẩm bán chạy</h2>
        <div class="title-underline mx-auto" style="margin: 0 auto 30px auto;"></div>
    </div>
    
    <div class="container-fluid">
        <div class="owl-carousel owl-carousel-product owl-theme">
            <?php 
            $product_sale = $this->Msanpham->product_selling(10);
            if($product_sale) foreach ($product_sale as $row): ?>
                <div class="item" style="padding: 10px;">
                    <div class="product-card-modern">
                        <div class="lt-product-group-image">
                            <a href="<?= base_url($row['alias']) ?>">
                                <img class="img-p" src="<?= base_url('public/images/products/'.$row['avatar']) ?>">
                            </a>
                            <?php if($row['sale']>0): ?>
                                <div class="giam-percent"><span>-<?= $row['sale'] ?>%</span></div>
                            <?php endif; ?>
                        </div>
                        <div class="lt-product-group-info">
                            <a href="<?= base_url($row['alias']) ?>"><h3><?= $row['name'] ?></h3></a>
                            <div class="price-box">
                                <?php if ($row['sale'] > 0): ?>
                                    <span class="price-new"><?php echo number_format($row['price_sale']); ?>₫</span>
                                    <span class="price-old"><?php echo number_format($row['price']); ?>₫</span>
                                <?php else: ?>
                                    <span class="price-new"><?php echo number_format($row['price']); ?>₫</span>
                                <?php endif; ?>
                            </div>
                            <div class="product-buy-count" style="font-size: 11px; color: #888; margin-top: 4px; text-align: left;">
                                <i class="fa fa-shopping-cart"></i> Đã bán: <?= $row['number_buy'] ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<div id="content">
    <div class="container-fluid">
        <?php 
        $listCategory=$this->Mdanhmuc->category_menu(0);
        foreach ($listCategory as $rowCategory):
            // row dien thoai
            $subCategory=$this->Mdanhmuc->category_menu($rowCategory['id']);
            // Id dien thoai
            $catId=$this->Mdanhmuc->category_id($rowCategory['link']);
            // list id dt ss, apple,...
            $listCatId=$this->Mdanhmuc->category_listcat($catId);
            // list dt ss, apple
            $listProducts=$this->Msanpham->product_home_limit($listCatId,10);
            if($listProducts && count($listProducts) > 0): ?>
                <div class="list-product">
                    <div class="list-header-z">
                        <h2><a href="<?php echo  $rowCategory['link']?>"><?php echo  $rowCategory['name']?> nổi bật</a></h2>
                        <ul class="sub-category">
                            <?php foreach ($subCategory as $rowSubCategory) :?>
                                <li>
                                    <a href="<?php echo base_url('san-pham/'.$rowSubCategory['link']); ?>" 
   title="<?php echo $rowSubCategory['name'] ?>" 
   class="ws-nw overflow ellipsis">
    <?php echo $rowSubCategory['name'] ?>
</a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="product-container">
                        <?php foreach ($listProducts as $sp) :?>
                            <div class="p-box-5">
                                <div class="product-lt">
                                    <div class="lt-product-group-image">
                                        <a href="<?php echo $sp['alias'] ?>" title="<?php echo $sp['name'] ?>" >
                                            <img class="img-p" src="<?php echo base_url() ?>public/images/products/<?php echo $sp['avatar'] ?>" alt="">
                                        </a>

                                        <?php if($sp['sale'] > 0) :?>
                                            <div class="giam-percent">
                                                <span class="text-giam-percent">Giảm <?php echo $sp['sale'] ?>%</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="lt-product-group-info">
                                        <a href="<?php echo $sp['alias'] ?>" title="<?php echo $sp['name'] ?>" style="text-align: left;">
                                            <h3><?php echo $sp['name'] ?></h3>
                                        </a>
                                        <div class="price-box">
                                            <?php if($sp['sale'] > 0) :?>

                                                <div class="price-box">
    <?php if ($sp['sale'] > 0): ?>
        <span class="price-new">
            <?php echo number_format($sp['price_sale']); ?>₫
        </span>
        <span class="price-old">
            <?php echo number_format($sp['price']); ?>₫
        </span>
    <?php else: ?>
        <span class="price-new">
            <?php echo number_format($sp['price']); ?>₫
        </span>
    <?php endif; ?>
</div>

                                                <?php else: ?>
                                                 <p class="old-price">
                                                    <span class="price" style="color: #fff"><?php echo(number_format($sp['price'])); ?>₫</span>
                                                </p>
                                                <p class="special-price">
                                                    <span class="price"><?php echo(number_format($sp['price'])); ?>₫</span>
                                                </p>
                                            <?php endif;?>
                                        </div>
                                        <div class="product-buy-count" style="font-size: 11px; color: #888; margin-bottom: 5px; text-align: left;">
                                            <i class="fa fa-shopping-cart"></i> Đã bán: <?= $sp['number_buy'] ?>
                                        </div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    </div>
                </div>
            <?php endif;?>
        <?php endforeach;?>
    </div>
</div>

<!-- ===== TIN TỨC CÔNG NGHỆ ===== -->
<div class="home-blog">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="sectin-title title title-blue">TIN TỨC CÔNG NGHỆ</h2>
            </div>
        </div>

        <div class="row blog-content">
            <?php  
            $listBaiViet = $this->Mnoidung->content_list_home(6, 'all');
            foreach ($listBaiViet as $rowPost): ?>
            
                <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="latest news-card">
                        <a href="tin-tuc/<?php echo $rowPost['alias'] ?>" class="news-link">
                            <div class="news-img-wrapper">
                                <img 
                                    src="<?php echo base_url() ?>public/images/posts/<?php echo $rowPost['img'] ?>" 
                                    alt="<?php echo $rowPost['title'] ?>"
                                    class="img-responsive">
                            </div>
                            <div class="news-info">
                                <h3 class="news-title"><?php echo $rowPost['title'] ?></h3>
                                <div class="news-divider"></div>
                            </div>
                        </a>
                    </div>
                </div>

            <?php endforeach; ?>
        </div>

    </div>
</div>
<!-- ===== END TIN TỨC ===== -->


<div class="adv">
    <section id="service-section" class="modern-services">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4">
                    <div class="service-card text-center">
                        <div class="service-icon-box">
                            <img src="<?php echo base_url('public/images/icon_142e7.png'); ?>" alt="Free Shipping">
                        </div>
                        <div class="service-content">
                            <h4>Miễn phí giao hàng</h4>
                            <p>Cho hóa đơn từ 5.000.000đ</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="service-card text-center">
                        <div class="service-icon-box">
                            <img src="<?php echo base_url('public/images/icon_242e7.png'); ?>" alt="Same Day Delivery">
                        </div>
                        <div class="service-content">
                            <h4>Giao hàng trong ngày</h4>
                            <p>Với tất cả đơn hàng nội thành</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-4">
                    <div class="service-card text-center">
                        <div class="service-icon-box">
                            <img src="<?php echo base_url('public/images/icon_342e7.png'); ?>" alt="Safe Products">
                        </div>
                        <div class="service-content">
                            <h4>Sản phẩm an toàn</h4>
                            <p>Cam kết chính hãng 100%</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
