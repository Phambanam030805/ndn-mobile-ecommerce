<?php echo form_open_multipart('admin/configuration/update/'); ?>
<div class="content-wrapper">
	<form action="<?php echo base_url() ?>admin/configuration/update.html" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
		<section class="content-header">
			<h1><i class="glyphicon glyphicon-text-background"></i> Hệ Thống</h1>
			<div class="breadcrumb">
				<button type="submit" class="btn btn-ndn">
					<span class="glyphicon glyphicon-floppy-save"></span> Lưu
				</button>
			</div>
		</section>

		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<div class="box" id="view">
						<div class="box-body">
							<div class="col-md-9">
								<?php echo validation_errors(); ?>

								<div class="form-group">
									<label>Mail SMTP <span class="maudo">(*)</span></label>
									<input type="email" class="form-control" name="mail_smtp" placeholder="Mail cấu hình" value="<?php echo $row['mail_smtp'] ?>">
								</div>

								<div class="form-group">
									<label>Password Mail SMTP</label>
									<input type="password" class="form-control" name="mail_smtp_password" placeholder="Password Mail cấu hình" value="<?php echo $row['mail_smtp_password'] ?>">
								</div>

								<div class="form-group">
									<label>Mail Admin</label>
									<input type="text" class="form-control" name="mail_noreply" placeholder="Mail nhận thông tin đơn hàng" value="<?php echo $row['mail_noreply'] ?>">
								</div>

								<div class="form-group">
									<label>Price Ship <span class="maudo">(*)</span></label>
									<input type="number" class="form-control" name="priceShip" placeholder="Giá ship" value="<?php echo $row['priceShip'] ?>">
								</div>

								<div class="form-group">
									<label>Title <span class="maudo">(*)</span></label>
									<input type="text" class="form-control" name="title" placeholder="Tiêu đề website" value="<?php echo $row['title'] ?>">
								</div>

								<div class="form-group">
									<label>Description <span class="maudo">(*)</span></label>
									<input type="text" class="form-control" name="description" placeholder="Mô tả website" value="<?php echo $row['description'] ?>">
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
					</div><!-- /.box -->
				</div>
			</div>
		</section>
	</form>
</div>

<!-- 🌈 STYLE MODERN FORM DASHBOARD -->
<style>
/* Khung chứa form (Box) */
.box {
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    border-top: none;
    padding: 20px;
    background: #fff;
}

/* Các ô nhập liệu (Input) */
.form-group label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 8px;
    font-size: 14px;
}
.form-control {
    border-radius: 8px;
    border: 1px solid #ced4da;
    padding: 10px 15px;
    height: auto;
    font-size: 14px;
    color: #333;
    transition: all 0.3s ease;
    box-shadow: none;
}
.form-control:focus {
    border-color: #0984e3;
    box-shadow: 0 0 0 4px rgba(9, 132, 227, 0.15);
    background-color: #fff;
}

/* Nút Lưu (Primary Button) */
.btn-ndn {
    background: linear-gradient(135deg, #d70018, #ff4757) !important;
    border: none !important;
    color: #fff !important;
    font-weight: 600;
    padding: 8px 24px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(215, 0, 24, 0.3);
    transition: all 0.3s ease;
    font-size: 14px;
}
.btn-ndn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(215, 0, 24, 0.4);
}

/* ⚠️ Dấu sao đỏ (Bắt buộc) */
.maudo {
    color: #d63031 !important;
    font-weight: bold;
    margin-left: 2px;
}
</style>
