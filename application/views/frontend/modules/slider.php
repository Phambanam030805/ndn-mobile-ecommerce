<div class="container-fluid" style="margin-top: 20px; margin-bottom: 20px; padding-left: 20px; padding-right: 20px;">
    <div class="owl-carousel-slider owl-carousel owl-theme modern-grid-banners">
        <?php
        $list_banner = $this->Mnoidung->slider_list();
        if(!empty($list_banner) && is_array($list_banner)) foreach ($list_banner as $value) :
            $bannerImg = !empty($value['img']) && file_exists(FCPATH . 'public/images/banners/' . $value['img'])
                ? base_url('public/images/banners/' . $value['img'])
                : base_url('public/images/banners/default.png');
        ?>
            <div class="item">
                <div class="banner-grid-item">
                    <a href="<?php echo $value['link']; ?>">
                        <img src="<?php echo $bannerImg; ?>" alt="<?php echo $value['title']; ?>" class="banner-img">
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
.modern-grid-banners {
    padding: 0;
}

.banner-grid-item {
    width: 100%;
    height: 180px;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.banner-grid-item:hover {
    transform: translateY(-5px);
}

.banner-img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Dùng cover vì đây là các banner ngang chuẩn */
}

/* Đảm bảo container không bị tràn */
#menu-slider .container {
    max-width: 1200px;
    margin: 0 auto;
}
</style>
