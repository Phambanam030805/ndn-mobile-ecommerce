<div class="content-wrapper">
	<section class="content-header">
		<h1><i class="glyphicon glyphicon-user"></i> Danh sách khách hàng</h1>
		<div class="breadcrumb">
			<a class="btn btn-primary btn-sm" href="<?php echo base_url()?>admin/customer/recyclebin" role="button">
				<span class="glyphicon glyphicon-trash"></span> Thùng rác (<?php $total=$this->Mkhachhang->customer_trash_count(); echo $total; ?>)
			</a>
		</div>
	</section>

	<section class="content">
		<div class="row">
			<div class="col-md-12">
				<div class="box" id="view">
					<div class="box-header with-border">
						<div class="box-body">
							
							<?php if($this->session->flashdata('success')):?>
								<div class="row">
									<div class="alert alert-success">
										<?php echo $this->session->flashdata('success'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									</div>
								</div>
							<?php endif;?>
							
							<?php if($this->session->flashdata('error')):?>
								<div class="row">
									<div class="alert alert-error">
										<?php echo $this->session->flashdata('error'); ?>
										<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									</div>
								</div>
							<?php endif;?>

							<div class="row" style='padding:0px; margin:0px;'>
								<div class="table-responsive">
									<table class="table table-hover modern-admin-table">
										<thead>
											<tr>
												<th class="text-center">ID</th>
												<th>Tên khách hàng</th>
												<th>Email</th>
												<th>Điện thoại</th>
												<th class="text-center" colspan="2">Thao tác</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($list as $row):?>
												<tr>
													<td class="text-center"><?php echo $row['id'] ?></td>
													<td><?php echo $row['fullname'] ?></td>
													<td>
														<?php 
															if($row['email']){
																echo $row['email'];
															}else{
																echo '<span class="label label-default">Khách vãng lai</span>';
															}
														?>
													</td>
													<td><?php echo $row['phone'] ?></td>
													<td class="text-center">
														<a class="btn btn-modern-view btn-xs" href="<?php echo base_url() ?>admin/customer/update/<?php echo $row['id'] ?>" role="button">
															<span class="glyphicon glyphicon-eye-open"></span> Xem
														</a>
													</td>
													<td class="text-center">
														<a class="btn btn-modern-delete btn-xs" href="<?php echo base_url() ?>admin/customer/trash/<?php echo $row['id'] ?>" onclick="return confirm('Xác nhận xóa thông tin khách hàng này ?')" role="button">
															<span class="glyphicon glyphicon-trash"></span> Xóa
														</a>
													</td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>

								<div class="row">
									<div class="col-md-12 text-center">
										<ul class="pagination">
											<?php echo $strphantrang ?>
										</ul>
									</div>
								</div>

							</div>
						</div><!-- ./box-body -->
					</div><!-- /.box -->
				</div>
			</div>
		</div>
	</section>
</div>

<!-- 🌈 STYLE MODERN DASHBOARD -->
<style>
/* Bảng dữ liệu hiện đại */
.box { border-radius: 12px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border-top: none; }
.modern-admin-table { border-collapse: separate; border-spacing: 0; width: 100%; }
.modern-admin-table thead th { background: #f4f6f9; color: #495057; font-weight: 600; text-transform: uppercase; font-size: 13px; padding: 15px; border-bottom: 2px solid #e9ecef; }
.modern-admin-table tbody td { vertical-align: middle !important; padding: 15px; border-top: 1px solid #f0f2f5; color: #333; }
.modern-admin-table tbody tr:hover { background-color: #f8f9fa; }

/* Nút bấm (Xem / Xóa) */
.btn-modern-view, .btn-modern-delete { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; transition: all 0.3s ease; border: none; display: inline-block; }
.btn-modern-view { background-color: #e8f4fd; color: #0984e3; }
.btn-modern-view:hover { background-color: #0984e3; color: #fff; box-shadow: 0 4px 10px rgba(9, 132, 227, 0.3); }
.btn-modern-delete { background-color: #ffeaea; color: #d63031; }
.btn-modern-delete:hover { background-color: #d63031; color: #fff; box-shadow: 0 4px 10px rgba(214, 48, 49, 0.3); }

/* Nút Thùng rác */
.content-header .btn-primary { background: linear-gradient(135deg, #d70018, #ff4757); border: none; border-radius: 6px; padding: 8px 16px; box-shadow: 0 4px 15px rgba(215, 0, 24, 0.3); font-weight: 600; transition: all 0.3s ease; }
.content-header .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(215, 0, 24, 0.4); }

/* Nhãn khách vãng lai */
.label-default { background-color: #e2e3e5 !important; color: #383d41 !important; padding: 5px 10px; border-radius: 4px; font-weight: 500; }

/* Phân trang */
.pagination > li > a, .pagination > li > span { border-radius: 4px; margin: 0 3px; color: #d70018; border: none; background: #f4f6f9; font-weight: 600; }
.pagination > .active > a, .pagination > .active > span { background: #d70018 !important; color: #fff !important; box-shadow: 0 4px 10px rgba(215, 0, 24, 0.2); }
</style>
