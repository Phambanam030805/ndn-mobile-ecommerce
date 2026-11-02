<?php 
	$list = $this->Mdanhmuc->category_list();
	$cat_name = 'Chưa phân loại';
	foreach ($list as $r) {
		if ($r['id'] == $row['catid']) {
			$cat_name = $r['name'];
			break;
		}
	}
	$in_stock = $row['number'] - $row['number_buy'];
?>
<div class="content-wrapper" style="background: #f8fafc; min-height: 100vh; padding-bottom: 40px;">
	<section class="content-header" style="padding: 24px 30px 15px;">
		<div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
			<div>
				<h1 style="font-size: 24px; font-weight: 700; color: #0f172a; margin: 0; display: flex; align-items: center; gap: 10px;">
					<span style="display: inline-flex; width: 42px; height: 42px; border-radius: 12px; background: rgba(215, 0, 24, 0.1); color: #d70018; align-items: center; justify-content: center; font-size: 20px;">
						<i class="fa fa-cubes"></i>
					</span>
					Nhập kho hàng hóa
				</h1>
				<p style="margin: 4px 0 0; color: #64748b; font-size: 13px;">Bổ sung số lượng tồn kho cho sản phẩm trong hệ thống</p>
			</div>
			<div style="display: flex; gap: 10px;">
				<a href="<?php echo base_url('admin/product'); ?>" class="btn" style="background: #fff; border: 1px solid #e2e8f0; color: #64748b; font-weight: 600; padding: 9px 18px; border-radius: 10px; font-size: 13px; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
					<i class="fa fa-arrow-left"></i> Quay lại
				</a>
			</div>
		</div>
	</section>

	<!-- Main content -->
	<section class="content" style="padding: 10px 30px;">
		<?php echo form_open('admin/product/import/'.$row['id'], array('id' => 'importForm')); ?>
			<div class="row">
				<!-- Cột trái: Thẻ tóm tắt thông tin sản phẩm & Tồn kho -->
				<div class="col-md-5">
					<div style="background: #fff; border-radius: 16px; border: 1px solid #edf2f7; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden; margin-bottom: 24px;">
						<div style="padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 10px;">
							<div style="width: 8px; height: 8px; border-radius: 50%; background: #d70018;"></div>
							<h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px;">Sản phẩm áp dụng</h3>
						</div>
						<div style="padding: 24px; text-align: center;">
							<div style="width: 140px; height: 140px; margin: 0 auto 16px; border-radius: 16px; border: 1px solid #f1f5f9; background: #f8fafc; padding: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.03);">
								<?php if(!empty($row['avatar'])): ?>
									<img src="<?php echo base_url('public/images/products/'.$row['avatar']); ?>" alt="<?php echo htmlspecialchars($row['name']); ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
								<?php else: ?>
									<i class="fa fa-image" style="font-size: 40px; color: #cbd5e1;"></i>
								<?php endif; ?>
							</div>
							<h4 style="font-size: 17px; font-weight: 700; color: #0f172a; margin: 0 0 8px; line-height: 1.4;">
								<?php echo htmlspecialchars($row['name']); ?>
							</h4>
							<div style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; background: #f1f5f9; color: #475569; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 16px;">
								<i class="fa fa-folder-open-o"></i> <?php echo htmlspecialchars($cat_name); ?>
							</div>

							<div style="background: #f8fafc; border-radius: 12px; padding: 16px; text-align: left; border: 1px solid #f1f5f9;">
								<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
									<span style="font-size: 13px; color: #64748b;">Giá bán lẻ:</span>
									<span style="font-size: 14px; font-weight: 700; color: #d70018;">
										<?php echo number_format($row['price_sale'] > 0 ? $row['price_sale'] : $row['price']); ?> đ
									</span>
								</div>
								<div style="display: flex; justify-content: space-between; align-items: center;">
									<span style="font-size: 13px; color: #64748b;">Mã sản phẩm:</span>
									<span style="font-size: 13px; font-weight: 600; color: #334155;">#<?php echo $row['id']; ?></span>
								</div>
							</div>
						</div>
					</div>

					<!-- Thống kê tồn kho hiện tại -->
					<div style="background: #fff; border-radius: 16px; border: 1px solid #edf2f7; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
						<div style="padding: 16px 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; gap: 8px;">
							<i class="fa fa-bar-chart" style="color: #64748b;"></i>
							<h3 style="margin: 0; font-size: 14px; font-weight: 700; color: #1e293b;">Tình trạng kho hiện tại</h3>
						</div>
						<div style="padding: 20px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; text-align: center;">
							<div style="background: #f8fafc; border-radius: 12px; padding: 12px 8px; border: 1px solid #e2e8f0;">
								<span style="display: block; font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 4px; text-transform: uppercase;">Đã nhập</span>
								<strong style="font-size: 18px; color: #0284c7;"><?php echo number_format($row['number']); ?></strong>
							</div>
							<div style="background: #f8fafc; border-radius: 12px; padding: 12px 8px; border: 1px solid #e2e8f0;">
								<span style="display: block; font-size: 11px; font-weight: 600; color: #64748b; margin-bottom: 4px; text-transform: uppercase;">Đã bán</span>
								<strong style="font-size: 18px; color: #16a34a;"><?php echo number_format($row['number_buy']); ?></strong>
							</div>
							<div style="background: rgba(215, 0, 24, 0.05); border-radius: 12px; padding: 12px 8px; border: 1px solid rgba(215, 0, 24, 0.15);">
								<span style="display: block; font-size: 11px; font-weight: 700; color: #d70018; margin-bottom: 4px; text-transform: uppercase;">Còn tồn</span>
								<strong id="currentStockVal" style="font-size: 18px; color: #d70018;"><?php echo number_format($in_stock); ?></strong>
							</div>
						</div>
					</div>
				</div>

				<!-- Cột phải: Form nhập số lượng bổ sung -->
				<div class="col-md-7">
					<div style="background: #fff; border-radius: 16px; border: 1px solid #edf2f7; box-shadow: 0 4px 20px rgba(0,0,0,0.03); overflow: hidden;">
						<div style="padding: 20px; border-bottom: 1px solid #f1f5f9; display: flex; align-items: center; justify-content: space-between;">
							<div style="display: flex; align-items: center; gap: 10px;">
								<div style="width: 8px; height: 8px; border-radius: 50%; background: #0284c7;"></div>
								<h3 style="margin: 0; font-size: 15px; font-weight: 700; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px;">Thông tin phiếu nhập kho</h3>
							</div>
							<span style="font-size: 12px; color: #64748b; background: #f8fafc; padding: 4px 10px; border-radius: 20px; border: 1px solid #e2e8f0;">
								<i class="fa fa-calendar-check-o"></i> <?php echo date('d/m/Y'); ?>
							</span>
						</div>

						<div style="padding: 24px;">
							<?php if(validation_errors()): ?>
								<div style="background: #fef2f2; border: 1px solid #fee2e2; border-left: 4px solid #ef4444; border-radius: 10px; padding: 14px 16px; margin-bottom: 20px; color: #991b1b; font-size: 13px;">
									<?php echo validation_errors(); ?>
								</div>
							<?php endif; ?>

							<div class="form-group" style="margin-bottom: 24px;">
								<label style="font-size: 13px; font-weight: 600; color: #334155; margin-bottom: 8px; display: block;">
									Số lượng nhập thêm <span style="color: #ef4444;">*</span>
								</label>
								<div style="position: relative;">
									<input type="number" 
									       name="number" 
									       id="importQty"
									       min="1" 
									       max="100000" 
									       required 
									       placeholder="Nhập số lượng máy nhập thêm..." 
									       style="width: 100%; height: 50px; font-size: 16px; font-weight: 600; padding: 10px 16px 10px 48px; border: 2px solid #e2e8f0; border-radius: 12px; color: #0f172a; outline: none; transition: all 0.2s; background: #fff;"
									       onfocus="this.style.borderColor='#d70018'; this.style.boxShadow='0 0 0 3px rgba(215, 0, 24, 0.1)';"
									       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none';"
									       oninput="updateProjectedStock(this.value)">
									<span style="position: absolute; left: 16px; top: 15px; color: #94a3b8; font-size: 18px;">
										<i class="fa fa-plus-circle"></i>
									</span>
								</div>
								<small style="display: block; color: #64748b; font-size: 12px; margin-top: 6px;">
									<i class="fa fa-info-circle"></i> Số lượng nhập này sẽ được cộng dồn trực tiếp vào tổng số máy hiện có của hệ thống.
								</small>
							</div>

							<!-- Card xem trước tồn kho sau khi nhập -->
							<div style="background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border-radius: 14px; padding: 20px; border: 1px dashed #cbd5e1; margin-bottom: 28px;">
								<h4 style="font-size: 13px; font-weight: 700; color: #475569; text-transform: uppercase; margin: 0 0 14px; display: flex; align-items: center; gap: 8px;">
									<i class="fa fa-calculator" style="color: #d70018;"></i> Ước tính sau khi nhập
								</h4>
								<div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0; font-size: 13px; color: #64748b;">
									<span>Tổng số máy đã nhập mới:</span>
									<strong id="newTotalImport" style="color: #0f172a; font-weight: 700;"><?php echo number_format($row['number']); ?></strong>
								</div>
								<div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; font-size: 14px;">
									<span style="font-weight: 600; color: #334155;">Tồn kho sẵn sàng bán mới:</span>
									<strong id="newInStock" style="color: #d70018; font-size: 18px; font-weight: 800;"><?php echo number_format($in_stock); ?></strong>
								</div>
							</div>

							<!-- Nút bấm hành động -->
							<div style="display: flex; gap: 12px; justify-content: flex-end; align-items: center;">
								<a href="<?php echo base_url('admin/product'); ?>" class="btn" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 12px 24px; border-radius: 12px; font-size: 14px; border: none; text-decoration: none;">
									Hủy bỏ
								</a>
								<button type="submit" class="btn" style="background: #d70018; color: #fff; font-weight: 700; padding: 12px 28px; border-radius: 12px; font-size: 14px; border: none; display: inline-flex; align-items: center; gap: 10px; box-shadow: 0 4px 12px rgba(215, 0, 24, 0.25); cursor: pointer; transition: all 0.2s;">
									<i class="fa fa-check"></i> Xác nhận nhập kho
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php echo form_close(); ?>
	</section>
</div>

<script>
var baseImported = <?php echo (int)$row['number']; ?>;
var baseBought = <?php echo (int)$row['number_buy']; ?>;

function updateProjectedStock(val) {
	var qty = parseInt(val) || 0;
	if (qty < 0) qty = 0;
	var newTotal = baseImported + qty;
	var newStock = newTotal - baseBought;
	
	document.getElementById('newTotalImport').innerText = newTotal.toLocaleString('vi-VN');
	document.getElementById('newInStock').innerText = newStock.toLocaleString('vi-VN');
}
</script>