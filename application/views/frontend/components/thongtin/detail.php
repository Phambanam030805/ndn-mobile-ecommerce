<section id="content" class="account-luxury-page">
    <div class="container order-detail-page">
        <!-- Breadcrumb Hiện Đại -->
        <div class="breadcrumbs-modern mb-3" style="font-size: 13.5px; color: #64748b; margin-bottom: 25px;">
            <a href="<?php echo base_url(); ?>" style="color: #64748b; text-decoration: none;"><i class="fa fa-home"></i> Trang chủ</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <a href="<?php echo base_url('thong-tin-khach-hang'); ?>" style="color: #64748b; text-decoration: none;">Tài khoản</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <span style="color: #0f172a; font-weight: 700;">Đơn hàng #<?php echo $info['orderCode'] ?></span>
        </div>

        <!-- Header Card Đơn hàng -->
        <div class="order-detail-header-card" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
            <div>
                <span style="font-size: 12px; color: #cbd5e1; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700;">Chi tiết đơn đặt hàng</span>
                <h2 style="font-size: 22px; font-weight: 800; margin: 4px 0 0; color: #ffffff;">
                    #<?php echo $info['orderCode'] ?>
                </h2>
                <div style="font-size: 13px; color: #94a3b8; margin-top: 5px;">
                    <i class="far fa-clock"></i> Ngày đặt hàng: <?php echo date('d/m/Y - H:i', strtotime($info['order_date'])) ?>
                </div>
            </div>

            <div>
                <?php if($info['status'] == 1 || $info['status'] == 2): ?>
                    <span class="status-badge-luxury status-completed" style="font-size: 13.5px; padding: 7px 16px;">
                        <i class="fas fa-check-circle"></i> Đã giao thành công
                    </span>
                <?php elseif($info['status'] == 3 || $info['status'] == 4): ?>
                    <span class="status-badge-luxury status-cancelled" style="font-size: 13.5px; padding: 7px 16px;">
                        <i class="fas fa-ban"></i> Đơn hàng đã hủy
                    </span>
                <?php else: ?>
                    <span class="status-badge-luxury status-pending" style="font-size: 13.5px; padding: 7px 16px;">
                        <i class="fas fa-hourglass-half"></i> Đang chờ xử lý
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <div class="account-luxury-card" style="padding: 24px;">
            <!-- Tiêu đề danh sách sản phẩm -->
            <div style="font-size: 16px; font-weight: 800; color: #0f172a; margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-box-open" style="color: #d70018;"></i> DANH SÁCH SẢN PHẨM TRONG ĐƠN
            </div>

            <!-- Bảng sản phẩm -->
            <div class="table-responsive" style="margin-bottom: 30px;">
                <table class="table-luxury-orders">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th class="text-center">Màu sắc</th>
                            <th class="text-center">Dung lượng</th>
                            <th class="text-center">Đơn giá</th>
                            <th class="text-center">Số lượng</th>
                            <th class="text-right">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($row as $value) :?>
                            <tr>
                                <td>
                                    <a href="<?php echo base_url($value['alias']); ?>" class="font-weight-bold" style="color: #0f172a; text-decoration: none; font-weight: 700;">
                                        <?php echo $value['name'] ?>
                                    </a>
                                </td>
                                <td class="text-center"><span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-size: 12px;"><?php echo !empty($value['color']) ? $value['color'] : '-'; ?></span></td>
                                <td class="text-center"><span style="background: #f1f5f9; padding: 3px 8px; border-radius: 6px; font-size: 12px;"><?php echo !empty($value['capacity']) ? $value['capacity'] : '-'; ?></span></td>
                                <td class="text-center font-weight-bold" style="color: #334155;"><?php echo number_format($value['priceorder']) ?>₫</td>
                                <td class="text-center"><b style="font-size: 14px;"><?php echo $value['count'] ?></b></td>
                                <td class="text-right font-weight-bold" style="color: #d70018; font-size: 15px;"><?php echo number_format($value['priceorder'] * $value['count']) ?>₫</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="row">
                <!-- Thông tin người nhận -->
                <div class="col-md-7">
                    <div class="order-detail-box-luxury">
                        <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-map-marker-alt" style="color: #d70018;"></i> THÔNG TIN NHẬN HÀNG
                        </div>
                        <ul style="list-style: none; padding: 0; margin: 0; font-size: 13.5px; color: #334155; line-height: 2;">
                            <li><strong style="color: #64748b;">Người nhận:</strong> <b style="color: #0f172a;"><?php echo $info['fullname'] ?></b></li>
                            <li><strong style="color: #64748b;">Số điện thoại:</strong> <b style="color: #0f172a;"><?php echo $info['phone'] ?></b></li>
                            <li><strong style="color: #64748b;">Địa chỉ giao:</strong> <?php echo $info['address'] ?>, <?php echo $this->Mquanhuyen->district_name($info['district']); ?>, <?php echo $this->Mtinhthanh->province_name($info['province']);?></li>
                            <li><strong style="color: #64748b;">Phương thức:</strong> 
                                <?php echo ($info['payment_method'] == 1) ? '<span style="color: #0284c7; font-weight: 700;"><i class="fas fa-qrcode"></i> Chuyển khoản VietQR</span>' : '<span style="font-weight: 600;">Thanh toán khi nhận hàng (COD)</span>'; ?>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tổng kết tiền -->
                <div class="col-md-5">
                    <div class="order-detail-box-luxury" style="background: #f8fafc;">
                        <div style="font-size: 15px; font-weight: 800; color: #0f172a; margin-bottom: 14px; display: flex; align-items: center; gap: 8px;">
                            <i class="fas fa-receipt" style="color: #d70018;"></i> TỔNG KẾT THANH TOÁN
                        </div>
                        <?php  
                            $priceShip = $info['price_ship'];
                            $subtotal = $info['money'] - $info['price_ship'] + ($info['coupon_amount'] ?? 0);
                        ?>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px; color: #64748b;">
                            <span>Tiền hàng:</span>
                            <span style="font-weight: 700; color: #0f172a;"><?php echo number_format($subtotal) ?>₫</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px; color: #64748b;">
                            <span>Phí vận chuyển:</span>
                            <span style="font-weight: 700; color: #0f172a;"><?php echo number_format($priceShip) ?>₫</span>
                        </div>
                        <?php if($info['coupon'] != 0): ?>
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 13.5px; color: #16a34a;">
                                <span>Giảm giá (Voucher):</span>
                                <span style="font-weight: 700;">-<?php echo number_format($info['coupon_amount']) ?>₫</span>
                            </div>
                        <?php endif; ?>
                        
                        <div style="border-top: 2px dashed #cbd5e1; margin: 12px 0 10px; padding-top: 10px; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-weight: 800; font-size: 15px; color: #0f172a;">TỔNG CỘNG:</span>
                            <span style="font-size: 20px; font-weight: 800; color: #d70018;"><?php echo number_format($info['money']) ?>₫</span>
                        </div>

                        <!-- Nút tiếp tục thanh toán VietQR nếu chưa thanh toán -->
                        <?php if($info['payment_method'] == 1 && $info['status'] == 0): ?>
                            <div style="margin-top: 15px;">
                                <a href="<?php echo base_url('giohang/payment_qr/' . $info['orderCode']); ?>" 
                                   class="btn btn-block btn-success" 
                                   style="background: #006837; border-color: #006837; font-weight: 800; padding: 12px; font-size: 14px; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="fas fa-qrcode"></i> Quét mã VietQR thanh toán
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="text-center" style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #f1f5f9;">
                <a href="<?php echo base_url('thong-tin-khach-hang'); ?>" class="btn-account-action btn-account-pwd" style="display: inline-flex; width: auto; padding: 8px 24px; border-radius: 20px;">
                    <i class="fas fa-arrow-left"></i> Quay lại lịch sử đơn hàng
                </a>
            </div>
        </div>
    </div>
</section>