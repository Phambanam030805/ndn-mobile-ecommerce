<?php echo form_open_multipart('admin/producer/update/'.$row['id']); ?>
<div class="content-wrapper">
	<form action="<?php echo base_url() ?>admin/producer/update.html" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
		<section class="content-header">
			<h1><i class="glyphicon glyphicon-text-background"></i> Cập nhật nhà cung cấp</h1>
			<div class="breadcrumb">
				<button type = "submit" class="btn btn-primary btn-sm">
					<span class="glyphicon glyphicon-floppy-save"></span>
					Lưu[Cập nhật]
				</button>
				<a class="btn btn-primary btn-sm" href="admin/producer" role="button">
					<span class="glyphicon glyphicon-remove do_nos"></span> Thoát
				</a>
			</div>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="row">
						<!-- Cột bên trái: Form cập nhật -->
						<div class="col-md-8">
							<div class="box box-primary">
								<div class="box-body">
									<?php echo validation_errors(); ?>
									<div class="form-group">
										<label>Tên nhà cung cấp <span class="maudo">(*)</span></label>
										<input type="text" class="form-control" name="name" placeholder="Tên nhà cung cấp" value="<?php echo $row['name'] ?>">
										<div class="error" style="color: red"><?php echo form_error('name')?></div>
									</div>
									<div class="form-group">
										<label>Mã code <span class="maudo">(*)</span></label>
										<input type="text" class="form-control" name="code" placeholder="Mã code" disabled value="<?php echo $row['code'] ?>">
										<div class="error" style="color: red"><?php echo form_error('code')?></div>
									</div>
									<div class="form-group">
										<label>Từ khóa <span class="maudo">(*)</span></label>
										<input type="text" class="form-control" name="keyword" placeholder="Từ khóa" value="<?php echo isset($row['keyword']) ? $row['keyword'] : '' ?>">
										<span style="font-style: italic; line-height: 32px;">Chú ý: Mỗi từ khóa phân cách bởi một dấu ",". Ví dụ: dienthoai, laptop</span>
										<div class="error" style="color: red"><?php echo form_error('keyword')?></div>
									</div>
									<div class="form-group">
										<label>Trạng thái</label>
										<select name="status" class="form-control">
											<option value="1" <?php if($row['status'] == 1) {echo 'selected';}?> >Đang hoạt động</option>
											<option value="0" <?php if($row['status'] == 0) {echo 'selected';}?> >Ngừng hoạt động</option>
										</select>
									</div>
								</div>
							</div>
						</div>

						<!-- Cột bên phải: Panel Tin tức công nghệ -->
						<div class="col-md-4">
							<div class="box box-solid box-warning">
								<div class="box-header with-border">
									<h3 class="box-title"><i class="fa fa-newspaper-o"></i> Tin tức công nghệ</h3>
								</div>
								<div class="box-body">
									<img src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=500&q=80" class="img-responsive img-thumbnail" alt="Tech News" style="width:100%; margin-bottom:15px;">
									<p><strong>Xu hướng di động 2026:</strong> Trí tuệ nhân tạo (AI) đang dần trở thành tiêu chuẩn trên các dòng điện thoại mới nhất từ các đối tác lớn.</p>
									<p style="font-size: 0.9em; color: #777;"><i>* Hãy cập nhật từ khóa chính xác để cải thiện kết quả tìm kiếm sản phẩm của nhà cung cấp này.</i></p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</section>
	</form>
<!-- /.content -->
</div><!-- /.content-wrapper -->