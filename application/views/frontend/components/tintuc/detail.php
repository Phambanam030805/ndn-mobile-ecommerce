<section id="content" style="padding: 30px 0 50px; background: #fafbfc;">
	<div class="container">
		<div class="row">
			<!-- CỘT TRÁI: BÀI VIẾT NỔI BẬT KHÁC -->
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<?php $this->load->view('frontend/modules/news'); ?> 
			</div>

			<!-- CỘT PHẢI: NỘI DUNG CHI TIẾT BÀI VIẾT -->
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 product-content" id="list-content">
				<div class="product-wrap" id="info-content" style="background: #fff; padding: 30px 35px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); border: 1px solid #eef0f3;">
					<article class="news-article-detail">
						<header class="entry-header" style="margin-bottom: 25px; border-bottom: 1px solid #eee; padding-bottom: 15px;">
							<div class="entry-tags" style="margin-bottom: 10px;">
								<span style="background: rgba(215, 0, 24, 0.08); color: #d70018; font-weight: 700; font-size: 11px; padding: 4px 12px; border-radius: 20px; text-transform: uppercase;">
									<i class="fas fa-mobile-alt"></i> Tin Công Nghệ NDN Mobile
								</span>
							</div>
							<h1 class="entry-title" style="font-size: 26px; font-weight: 800; color: #1a1a1a; line-height: 1.4; margin-top: 5px; margin-bottom: 12px;">
								<?php echo htmlspecialchars($row['title']); ?>
							</h1>
							<div class="entry-meta" style="color: #888; font-size: 13px; display: flex; gap: 15px; align-items: center;">
								<span><i class="far fa-calendar-alt" style="color: #d70018; margin-right: 5px;"></i> <?php echo date("d/m/Y H:i", strtotime($row['created_at'])); ?></span>
								<span><i class="far fa-user" style="color: #d70018; margin-right: 5px;"></i> Ban biên tập NDN Mobile</span>
							</div>
						</header>

						<?php if(!empty($row['introtext'])): ?>
							<div class="entry-intro" style="font-size: 16px; font-weight: 600; line-height: 1.6; color: #444; margin-bottom: 25px; background: #fdf6f6; border-left: 4px solid #d70018; padding: 12px 18px; border-radius: 4px;">
								<?php echo nl2br(strip_tags($row['introtext'])); ?>
							</div>
						<?php endif; ?>

						<div class="entry-content" style="font-size: 15.5px; line-height: 1.8; color: #333;">
							<?php echo $row['fulltext']; ?>
						</div>

						<footer class="entry-footer" style="margin-top: 40px; padding-top: 20px; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap;">
							<div style="font-size: 13px; color: #888;">
								<i class="fas fa-tags" style="color: #d70018;"></i> Từ khóa: <strong>Điện thoại, Smartphone, NDN Mobile, Công nghệ mới</strong>
							</div>
							<div>
								<a href="<?php echo base_url('tin-tuc'); ?>" class="btn btn-default" style="font-weight: 600; border-radius: 6px;">
									<i class="fas fa-arrow-left"></i> Quay lại danh sách tin
								</a>
							</div>
						</footer>
					</article>
				</div>
			</div>
		</div>
	</div>
</section>
