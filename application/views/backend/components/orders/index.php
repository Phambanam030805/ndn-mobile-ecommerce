<div class="content-wrapper">
	<section class="content-header">
		<h1><i class="glyphicon glyphicon-list-alt"></i> Danh sách đơn hàng</h1>
		<div class="breadcrumb">
			<a class="btn btn-primary btn-sm" href="<?php echo base_url()?>admin/orders/recyclebin" role="button">
				<span class="glyphicon glyphicon-trash"></span> Đơn hàng đã lưu (<?php $total=$this->Mdonhang->orders_trash_count(); echo $total; ?>)
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
									<table class="table table-hover modern-admin-table" style="font-size: 0.9em;">
										<thead>
											<tr>
												<th class="text-center" style="width:20px">Code</th>
												<th>Khách hàng</th>
												<th>Điện thoại</th>
												<th>Tổng tiền</th>
												<th>Ngày tạo hóa đơn</th>
												<th class="text-center">Trạng thái</th>
												<th class="text-center">Thanh toán</th>
												<th class="text-center" colspan="2">Xử lý đơn</th>
												<th class="text-center" colspan="2">Thao tác</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($list as $val):
												$cid = isset($val['customerid']) ? $val['customerid'] : (isset($val['customer_id']) ? $val['customer_id'] : 0);
												$name = $this->Mkhachhang->customer_detail($cid);
											?>
												<tr>
													<td class="text-center"><?php echo $val['orderCode'] ?></td>
													<td><?php echo $val['fullname']; ?></td>
													<td><?php echo $val['phone']; ?></td>
													<td><?php echo number_format($val['money']); ?>₫</td>
													<td><?php echo $val['order_date']; ?></td>
													<td style="text-align: center;">
														<?php
															switch ($val['status']) {
																case '0': echo '<span class="label label-warning">Đang chờ duyệt</span>'; break;
																case '1': echo '<span class="label label-primary">Đang giao hàng</span>'; break;
																case '2': echo '<span class="label label-success">Đã giao</span>'; break;
																case '3': echo '<span class="label label-default">Khách hàng đã hủy</span>'; break;
																case '4': echo '<span class="label label-danger">Nhân viên đã hủy</span>'; break;
															}
														?>
													</td>
													<td style="text-align: center;">
														<?php
															if($val['payment_method'] == 0) echo '<span class="label label-info">COD</span>';
															else echo '<span class="label label-success">Online</span>';
														?>
													</td>
													<td style="text-align: center;">
														<?php if($val['status']==1):?>
															<a class="btn btn-modern-approve btn-xs" href="<?php echo base_url() ?>admin/orders/status/<?php echo $val['id'] ?>" onclick="return confirm('Xác nhận đơn hàng đã giao và thanh toán thành công ?')" role="button">
																<i class="fa fa-thumbs-o-up"></i> Xác nhận thanh toán
															</a>
														<?php elseif($val['status']==0):?>
															<a class="btn btn-modern-approve btn-xs" href="<?php echo base_url() ?>admin/orders/status/<?php echo $val['id'] ?>" onclick="return confirm('Xác nhận gói hàng và chuẩn bị giao hàng ?')" role="button">
																<i class="fa fa-check-square-o"></i> Duyệt đơn đặt hàng
															</a>
														<?php endif; ?>
													</td>
													<td style="text-align: center;">
														<?php if($val['status']==0 || $val['status']==1): ?>
															<a class="btn btn-modern-cancel btn-xs" href="<?php echo base_url() ?>admin/orders/cancelorder/<?php echo $val['id'] ?>" onclick="return confirm('Xác nhận hủy đơn hàng này ?')" role="button">
																<i class="fa fa-times-circle"></i> Hủy đơn
															</a>
														<?php endif; ?>
													</td>
													<td class="text-center">
														<a class="btn btn-modern-view btn-xs" href="<?php echo base_url() ?>admin/orders/detail/<?php echo $val['id'] ?>" role="button">
															<span class="glyphicon glyphicon-eye-open"></span> Xem
														</a>
														<a class="btn btn-modern-save btn-xs" href="<?php echo base_url() ?>admin/orders/trash/<?php echo $val['id'] ?>" onclick="return confirm('Xác nhận lưu đơn hàng này ?')" role="button">
															<i class="fa fa-save"></i> Lưu đơn
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
.modern-admin-table thead th {
    background: #f4f6f9; color: #495057; font-weight: 600; text-transform: uppercase;
    font-size: 12px; padding: 12px; border-bottom: 2px solid #e9ecef; white-space: nowrap;
}
.modern-admin-table tbody td {
    vertical-align: middle !important; padding: 12px; border-top: 1px solid #f0f2f5; color: #333;
}
.modern-admin-table tbody tr:hover { background-color: #f8f9fa; }

/* Các loại Nút Bấm Đơn Hàng */
.btn-modern-approve, .btn-modern-cancel, .btn-modern-view, .btn-modern-save {
    padding: 6px 10px; border-radius: 6px; font-weight: 600; font-size: 11px;
    transition: all 0.3s ease; border: none; display: inline-block; margin-bottom: 2px;
}
/* Duyệt / Thanh toán (Xanh lá) */
.btn-modern-approve { background-color: #e3fbf4; color: #00b894; }
.btn-modern-approve:hover { background-color: #00b894; color: #fff; box-shadow: 0 4px 10px rgba(0, 184, 148, 0.3); }

/* Hủy đơn (Đỏ) */
.btn-modern-cancel { background-color: #ffeaea; color: #d63031; }
.btn-modern-cancel:hover { background-color: #d63031; color: #fff; box-shadow: 0 4px 10px rgba(214, 48, 49, 0.3); }

/* Xem (Xanh lam) */
.btn-modern-view { background-color: #e8f4fd; color: #0984e3; }
.btn-modern-view:hover { background-color: #0984e3; color: #fff; box-shadow: 0 4px 10px rgba(9, 132, 227, 0.3); }

/* Lưu đơn (Xám) */
.btn-modern-save { background-color: #f1f2f6; color: #2f3640; }
.btn-modern-save:hover { background-color: #2f3640; color: #fff; box-shadow: 0 4px 10px rgba(47, 54, 64, 0.3); }

/* Nút Thùng rác trên cùng */
.content-header .btn-primary {
    background: linear-gradient(135deg, #d70018, #ff4757); border: none; border-radius: 6px;
    padding: 8px 16px; box-shadow: 0 4px 15px rgba(215, 0, 24, 0.3); font-weight: 600; transition: all 0.3s ease;
}
.content-header .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(215, 0, 24, 0.4); }

/* Label trạng thái */
.label { padding: 5px 8px; border-radius: 4px; font-weight: 600; font-size: 11px; }
.label-warning { background-color: #fdcb6e !important; color: #2d3436; }
.label-primary { background-color: #74b9ff !important; color: #fff; }
.label-success { background-color: #00b894 !important; }
.label-danger { background-color: #d63031 !important; }
.label-info { background-color: #0984e3 !important; }
.label-default { background-color: #b2bec3 !important; color: #2d3436; }

/* Phân trang */
.pagination > li > a, .pagination > li > span { border-radius: 4px; margin: 0 3px; color: #d70018; border: none; background: #f4f6f9; font-weight: 600; }
.pagination > .active > a, .pagination > .active > span { background: #d70018 !important; color: #fff !important; box-shadow: 0 4px 10px rgba(215, 0, 24, 0.2); }
</style>
