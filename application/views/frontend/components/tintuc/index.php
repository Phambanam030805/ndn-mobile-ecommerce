<section id="content" class="news-list-page">
    <div class="container">
        <!-- Banner đầu trang -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="news-banner-wrapper card-shadow">
                    <img src="<?php echo base_url(); ?>public/images/sp.png" class="img-responsive" alt="Banner Tin tức">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="news-container card-shadow">
                    
                    <div class="news-page-header">
                        <h1 class="news-page-title">Tin tức công nghệ</h1>
                        <div class="news-title-underline"></div>
                    </div>

                    <div class="news-list-wrapper">
                        <?php if(empty($list)): ?>
                            <div class="text-center py-5">
                                <i class="fa fa-newspaper-o fa-4x text-light mb-3"></i>
                                <p>Hiện chưa có bài viết nào trong chuyên mục này.</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($list as $item) :?>
                                <div class="news-list-item">
                                    <div class="row">
                                        <!-- Hình ảnh bài viết -->
                                        <div class="col-md-4 col-sm-5 col-xs-12">
                                            <a href="<?php echo $item['alias']; ?>" class="news-item-img-link">
                                                <div class="news-item-img-wrapper">
                                                    <img src="<?php echo base_url(); ?>public/images/posts/<?php echo $item['img']; ?>" 
                                                         class="img-responsive" 
                                                         alt="<?php echo $item['title']; ?>"
                                                         onerror="this.src='<?php echo base_url(); ?>public/images/no-image.jpg';">
                                                </div>
                                            </a>
                                        </div>

                                        <!-- Nội dung bài viết -->
                                        <div class="col-md-8 col-sm-7 col-xs-12">
                                            <div class="news-item-content">
                                                <div class="news-item-meta">
                                                    <span><i class="fa fa-calendar"></i> <?php echo date("d/m/Y", strtotime($item['created'])); ?></span>
                                                    <span class="ml-3"><i class="fa fa-user"></i> Admin</span>
                                                </div>
                                                <a href="<?php echo $item['alias']; ?>" class="news-item-title-link">
                                                    <h2 class="news-item-title"><?php echo $item['title']; ?></h2>
                                                </a>
                                                <div class="news-item-excerpt">
                                                    <?php echo strip_tags($item['introtext']); ?>
                                                </div>
                                                <a href="<?php echo $item['alias']; ?>" class="btn-readmore">
                                                    Đọc thêm <i class="fa fa-angle-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>

                    <!-- Phân trang -->
                    <div class="text-center mt-5">
                        <ul class="pagination-modern">
                            <?php echo $strphantrang; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>