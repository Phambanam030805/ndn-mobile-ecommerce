<div class="content-wrapper" style="min-height: 564px;">
	<section class="content-header">
		<h1><i class="glyphicon glyphicon-shopping-cart"></i> Chi tiết đơn hàng</h1>
		<div class="breadcrumb">
			<a class="btn btn-primary btn-sm" href="admin/orders" role="button">
				<span class="glyphicon glyphicon-trash"></span> Thoát
			</a>
		</div>
	</section>
	<section class="content">
		<!-- Info boxes -->
		<div class="row">
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<!--ND-->
						<div id="view">
							<form action="admin/orders/detail/<?php echo $id; ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">
								<?php

								$order = $this->Mdonhang->orders_detail($id);
								$cid = isset($order['customerid']) ? $order['customerid'] : (isset($order['customer_id']) ? $order['customer_id'] : 0);
								$customer = $this->Mkhachhang->customer_detail($cid);
								$data = $this->Mchitietdonhang->orderdetail_orderid($id);
								?>
								<h1 class="text-center" style="color: red;">CHI TIẾT ĐƠN HÀNG</h1>
								<h4>Tên khách hàng: <b><?php echo $order['fullname']; ?></b></h4>
								<h4>Điện thoại: <i><?php echo $order['phone']; ?></i></h4>
								<h4>Thời gian đặt hàng: <i><?php echo $order['order_date']; ?></i></h4>
								<h4>Địa chỉ: <?php echo $order['address']; ?>,
									<?php echo $this->Mquanhuyen->district_name($order['district']); ?>,
									<?php echo $this->Mtinhthanh->province_name($order['province']); ?>
								</h4>
								<h4>Mã đơn hàng: <b><?php echo $order['orderCode']; ?></b></h4>
								<h4>Hình thức thanh toán: 
									<b>
										<?php 
											if($order['payment_method'] == 0) echo 'Thanh toán khi nhận hàng (COD)';
											else echo 'Thanh toán Online (VNPay / Momo)';
										?>
									</b>
								</h4>
								<br />
								<div class="table-responsive">
									<table class="table table-hover table-bordered">
										<thead>
											<tr>
												<th class="text-center">STT</th>
												<th>Tên sản phẩm</th>
												<th class="text-center">Màu</th>
												<th class="text-center">Dung lượng</th>
												<th class="text-center" style="width:100px">Số lượng</th>
												<th style="width:120px">Giá bán</th>
												<th class="text-right" style="width:120px">Thành tiền</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$stt = 0; $total = 0;
											foreach ($data as $row) :
												$product = $this->Msanpham->product_detail_id($row['product_id']);												?>
												<tr>
													<td class="text-center"><?php $stt += 1; echo $stt; ?></td>
													<td><?php echo isset($product['name']) ? $product['name'] : 'Sản phẩm đã bị xóa hoặc không tồn tại'; ?></td>
													<td class="text-center"><?php echo !empty($row['color']) ? $row['color'] : '-'; ?></td>
													<td class="text-center"><?php echo !empty($row['capacity']) ? $row['capacity'] : '-'; ?></td>
													<td class="text-center"><?php echo $row['count']; ?></td>
													<td><?php echo number_format($row['price']); ?>₫</td>
													<td class="text-right">
														<?php 
														$price = $row['price'] * $row['count'];
														echo number_format($price);
														$total += $price;
														$price_ship= $order['price_ship'];
														$coupon = 0;
														if($order['coupon'] != NULL) {
															$coupon_detail = $this->db->where('id', $order['coupon'])->get('coupons')->row_array();
															if($coupon_detail) {
																$coupon = $coupon_detail['discount'];
															}
														}
														?>₫
													</td>
												</tr>
											<?php endforeach; ?>
											<tr>
												<td colspan="7" class="text-right" style="border: none; font-size: 1.1em;">Tổng cộng: <?php echo number_format($total); ?>₫</td>
											</tr>
											<?php 
											if($coupon != 0)
											{
												echo '<tr>
												<td colspan="7" class="text-right" style="border: none; font-size: 1.1em;">Voucher giảm giá : '.number_format($coupon).'₫</td>
											</tr>';
											}
											?>
											<tr>
												<td colspan="7" class="text-right" style="border: none; font-size: 0.9em;"><i>Phí vận chuyển: </i>
													<?php echo number_format($price_ship); ?>₫
												</td>
											</tr>
											<tr>
												<td colspan="7" class="text-right" style="border: none; color: red; font-size: 1.3em;">Thành tiền: <?php echo number_format($total+$price_ship-$coupon);?>₫</td>
											</tr>
											
											<tr>
												<td class="text-right" colspan="7">
													<a class="btn btn-primary btn-md" role="button" onclick="window.print()">
														<span class="glyphicon glyphicon-print"></span> In đơn hàng
													</a>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="row">
									<div class="col-md-12 text-right">
										<ul class="pagination">
										</ul>
									</div>
								</div>
							</form>                    
						</div>
						<!--/.ND-->
					</div>
				</div><!-- /.box -->
			</div><!-- /.col -->
		</div><!-- /.row -->
	</section><!-- /.content -->	      	
</div>