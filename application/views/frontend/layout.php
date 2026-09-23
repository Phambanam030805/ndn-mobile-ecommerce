<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        <?php 
            if(isset($title)) echo $title;
            else echo "NDN Mobile - Điện thoại, Linh kiện chính hãng";
        ?>
    </title>

    <link rel="icon" type="image/x-icon" href="<?php echo base_url('public/images/cart2.png'); ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url('public/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS giao diện -->
    <link href="<?php echo base_url('public/css/lte.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/owl.carousel.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/AdminLTE.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/style-jc.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/menu-tab.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/style.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/jquery.bxslider.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/flexslider.css'); ?>" rel="stylesheet">

    <!-- jQuery (PHẢI TRƯỚC bootstrap.js) -->
    <script src="<?php echo base_url('public/js/jquery-2.2.3.min.js'); ?>"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>

<body>

<div class="thetop"></div>

<!-- Facebook SDK -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
    if (d.getElementById(id)) return;
    var js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8";
    d.getElementsByTagName(s)[0].parentNode.insertBefore(js, null);
}(document, 'script', 'facebook-jssdk'));
</script>

<!-- TOPBAR -->
<?php $this->load->view('frontend/modules/topbar'); ?>

<!-- LOGO + SEARCH -->
<?php $this->load->view('frontend/modules/logo-search'); ?>

<!-- MENU -->
<section id="menu-slider">
    <?php $this->load->view('frontend/modules/panel-left'); ?>
</section>

<!-- CONTENT -->
<?php
if (isset($com, $view)) {
    $this->load->view('frontend/components/'.$com.'/'.$view);
} else {
    $this->load->view('frontend/components/Error404/index');
}
?>

<!-- FOOTER -->
<?php $this->load->view('frontend/modules/footer'); ?>

<!-- JS (bootstrap phải sau jQuery) -->
<script src="<?php echo base_url('public/js/bootstrap.js'); ?>"></script>

<!-- Các JS khác -->
<script src="<?php echo base_url('public/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('public/js/owl.carousel.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery.jcarousel.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jcarousel.connected-carousels.js'); ?>"></script>
<script src="<?php echo base_url('public/js/scroll.js'); ?>"></script>
<script src="<?php echo base_url('public/js/search-quick.js'); ?>"></script>
<script src="<?php echo base_url('public/js/custom-owl.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery.flexslider.js'); ?>"></script>

<!-- Scroll to top -->
<div class="scrolltop">
    <div class="scroll icon">
        <i class="fa fa-angle-up fa-4x"></i>
    </div>
</div>


<!-- ✅ KÍCH HOẠT TỰ ĐỘNG TRƯỢT (BANNER & SẢN PHẨM) -->
<script>
$(document).ready(function() {
    // Banner chính (Owl 2)
    if ($('.owl-carousel-slider').length) {
        $('.owl-carousel-slider').owlCarousel({
            loop: false,
            margin: 15,
            nav: false,
            dots: false,
            responsive: {
                0: { items: 1 },
                480: { items: 2 },
                768: { items: 3 },
                1024: { items: 4 },
                1366: { items: 5 }
            }
        });
    }

    // Danh sách sản phẩm (Owl 2)
    if ($('.owl-carousel-product').length) {
        $('.owl-carousel-product').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            dots: false,
            responsive: {
                0: { items: 1 },
                480: { items: 2 },
                768: { items: 3 },
                992: { items: 4 },
                1200: { items: 5 }
            }
        });
    }
});
</script>
<script>
$(window).load(function() {
    if ($('.flexslider').length) {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    }
});
</script>

</body>
</html>
