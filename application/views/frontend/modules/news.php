<div class="widget-news-modern card-shadow">
    <div class="widget-header">
        <h3 class="widget-title"><i class="fa fa-newspaper-o text-danger"></i> BÀI VIẾT MỚI NHẤT</h3>
    </div>
    <div class="widget-content">
        <ul class="latest-news-list">
        <?php  
        $posts = $this->Mnoidung->content_get_news(5);
        foreach ($posts as $value) :?>
            <li class="news-item-modern">
                <div class="news-img">
                    <a href="<?php echo base_url(); ?>tin-tuc/<?php echo $value['alias'] ?>">
                        <img src="<?php echo base_url(); ?>public/images/posts/<?php echo $value['img']; ?>" alt="<?php echo $value['title']; ?>" onerror="this.src='<?php echo base_url(); ?>public/images/no-image.jpg';">
                    </a>
                </div>
                <div class="news-info">
                    <h4 class="news-title">
                        <a href="<?php echo base_url(); ?>tin-tuc/<?php echo $value['alias'] ?>"><?php echo $value['title']; ?></a>
                    </h4>
                </div>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
</div>