<div class="container" style="padding: 30px 15px;">
    <!-- Header -->
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 25px; border-bottom: 2px solid #2980b9; padding-bottom: 12px;">
        <h2 style="margin: 0; font-size: 22px; color: #333;">
            <i class="fas fa-balance-scale" style="color: #2980b9;"></i> So sánh sản phẩm
            <span style="background: #2980b9; color: #fff; font-size: 12px; padding: 2px 8px; border-radius: 20px; margin-left: 8px;"><?php echo $count; ?>/4</span>
        </h2>
        <div>
            <?php if($count > 0): ?>
            <button onclick="clearCompare()" class="btn btn-danger btn-sm" style="border-radius: 20px; margin-right: 8px;">
                <i class="fas fa-trash"></i> Xóa tất cả
            </button>
            <?php endif; ?>
            <a href="<?php echo base_url('san-pham'); ?>" class="btn btn-default btn-sm" style="border-radius: 20px;">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </a>
        </div>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('info')): ?>
        <div class="alert alert-info" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
            <i class="fas fa-info-circle"></i> <?php echo $this->session->flashdata('info'); ?>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger" style="border-radius: 8px; font-size: 14px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <?php if(empty($products)): ?>
    <!-- Trạng thái rỗng -->
    <div style="text-align: center; padding: 80px 20px;">
        <i class="fas fa-balance-scale" style="font-size: 70px; color: #e0e0e0; display: block; margin-bottom: 20px;"></i>
        <h4 style="color: #999; font-weight: 400;">Chưa có sản phẩm nào để so sánh</h4>
        <p style="color: #bbb; margin-bottom: 25px;">Thêm 2-4 sản phẩm để xem so sánh chi tiết thông số</p>
        <a href="<?php echo base_url('san-pham'); ?>" class="btn" style="background: #2980b9; color: #fff; border-radius: 25px; padding: 12px 30px; font-weight: 600;">
            <i class="fas fa-search"></i> Tìm sản phẩm
        </a>
    </div>
    <?php else: ?>

    <!-- Bảng so sánh -->
    <div style="overflow-x: auto;">
        <table class="table" style="min-width: 600px; border-collapse: separate; border-spacing: 0;">
            <thead>
                <tr style="background: #f8f9fa;">
                    <th style="width: 160px; padding: 12px 15px; color: #555; font-size: 13px; border: 1px solid #dee2e6;">Thông số</th>
                    <?php foreach($products as $p): ?>
                    <th style="text-align: center; padding: 12px; border: 1px solid #dee2e6; min-width: 180px;">
                        <div style="position: relative;">
                            <!-- Nút xóa -->
                            <button onclick="removeCompare(<?php echo $p['id']; ?>)"
                                    style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: #fff; border: none; border-radius: 50%; width: 22px; height: 22px; font-size: 11px; cursor: pointer; line-height: 22px; padding: 0;">×</button>
                            <!-- Ảnh -->
                            <img src="<?php echo base_url('public/images/products/' . $p['avatar']); ?>"
                                 alt="<?php echo htmlspecialchars($p['name']); ?>"
                                 style="width: 100%; max-width: 130px; height: 120px; object-fit: contain; display: block; margin: 0 auto 8px;">
                            <!-- Tên -->
                            <a href="<?php echo base_url($p['alias']); ?>" style="font-size: 13px; font-weight: 600; color: #333; text-decoration: none; display: block; line-height: 1.4;">
                                <?php echo htmlspecialchars($p['name']); ?>
                            </a>
                        </div>
                    </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <!-- Hàng: Giá -->
                <tr>
                    <td style="padding: 12px 15px; font-weight: 600; color: #555; font-size: 13px; background: #fff8f8; border: 1px solid #dee2e6;">
                        <i class="fas fa-tag" style="color: #d70018;"></i> Giá bán
                    </td>
                    <?php foreach($products as $p): ?>
                    <?php $price = ($p['price_sale'] > 0) ? $p['price_sale'] : $p['price']; ?>
                    <td style="text-align: center; padding: 12px; border: 1px solid #dee2e6;">
                        <strong style="font-size: 16px; color: #d70018;"><?php echo number_format($price); ?>đ</strong>
                        <?php if($p['price_sale'] > 0): ?>
                        <br><small style="color: #999; text-decoration: line-through;"><?php echo number_format($p['price']); ?>đ</small>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Hàng: Tồn kho -->
                <tr style="background: #fafafa;">
                    <td style="padding: 12px 15px; font-weight: 600; color: #555; font-size: 13px; border: 1px solid #dee2e6;">
                        <i class="fas fa-box" style="color: #27ae60;"></i> Còn hàng
                    </td>
                    <?php foreach($products as $p): ?>
                    <?php $stock = max(0, $p['number'] - $p['number_buy']); ?>
                    <td style="text-align: center; padding: 12px; border: 1px solid #dee2e6;">
                        <?php if($stock > 0): ?>
                            <span style="color: #27ae60; font-weight: 600;"><i class="fas fa-check-circle"></i> Còn <?php echo $stock; ?> sp</span>
                        <?php else: ?>
                            <span style="color: #e74c3c;"><i class="fas fa-times-circle"></i> Hết hàng</span>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Hàng: Đã bán -->
                <tr>
                    <td style="padding: 12px 15px; font-weight: 600; color: #555; font-size: 13px; background: #fff8f8; border: 1px solid #dee2e6;">
                        <i class="fas fa-fire" style="color: #ff6b35;"></i> Đã bán
                    </td>
                    <?php foreach($products as $p): ?>
                    <td style="text-align: center; padding: 12px; border: 1px solid #dee2e6;">
                        <?php echo number_format($p['number_buy']); ?> sản phẩm
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Hàng: Giảm giá -->
                <tr style="background: #fafafa;">
                    <td style="padding: 12px 15px; font-weight: 600; color: #555; font-size: 13px; border: 1px solid #dee2e6;">
                        <i class="fas fa-percent" style="color: #e74c3c;"></i> Giảm giá
                    </td>
                    <?php foreach($products as $p): ?>
                    <td style="text-align: center; padding: 12px; border: 1px solid #dee2e6;">
                        <?php if($p['sale'] > 0): ?>
                            <span style="background: #d70018; color: #fff; padding: 3px 10px; border-radius: 4px; font-weight: 700;">-<?php echo $p['sale']; ?>%</span>
                        <?php else: ?>
                            <span style="color: #bbb;">Không</span>
                        <?php endif; ?>
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Hàng: Mô tả ngắn -->
                <tr>
                    <td style="padding: 12px 15px; font-weight: 600; color: #555; font-size: 13px; background: #fff8f8; border: 1px solid #dee2e6;">
                        <i class="fas fa-info-circle" style="color: #2980b9;"></i> Mô tả
                    </td>
                    <?php foreach($products as $p): ?>
                    <td style="padding: 12px; border: 1px solid #dee2e6; font-size: 12px; color: #666; line-height: 1.5;">
                        <?php echo mb_substr(strip_tags($p['sortDesc']), 0, 150, 'UTF-8'); ?>...
                    </td>
                    <?php endforeach; ?>
                </tr>

                <!-- Hàng: Hành động -->
                <tr style="background: #f8f9fa;">
                    <td style="padding: 12px 15px; font-weight: 600; color: #555; font-size: 13px; border: 1px solid #dee2e6;">Thao tác</td>
                    <?php foreach($products as $p): ?>
                    <td style="text-align: center; padding: 12px; border: 1px solid #dee2e6;">
                        <a href="<?php echo base_url($p['alias']); ?>"
                           class="btn btn-sm btn-block"
                           style="background: #d70018; color: #fff; border-radius: 5px; font-size: 12px; margin-bottom: 5px;">
                            <i class="fas fa-shopping-cart"></i> Mua ngay
                        </a>
                        <a href="<?php echo base_url($p['alias']); ?>"
                           class="btn btn-sm btn-block btn-default"
                           style="border-radius: 5px; font-size: 12px;">
                            <i class="fas fa-eye"></i> Xem chi tiết
                        </a>
                    </td>
                    <?php endforeach; ?>
                </tr>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<script>
function removeCompare(productId) {
    $.ajax({
        url: base_url + 'so-sanh/xoa/' + productId,
        type: 'GET',
        success: function(res) { location.reload(); }
    });
}

function clearCompare() {
    if(!confirm('Xóa toàn bộ danh sách so sánh?')) return;
    $.ajax({
        url: base_url + 'so-sanh/xoa-tat-ca',
        type: 'GET',
        success: function(res) { location.reload(); }
    });
}
</script>
