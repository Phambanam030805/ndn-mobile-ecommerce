<section id="content">
    <div class="container order-detail-page" style="margin-top: 30px; margin-bottom: 50px;">
        <div class="card-shadow">
            <div class="card-header-modern">
                <i class="fa fa-file-text-o"></i>
                <h3>Chi tiết đơn hàng #<?php echo $info['orderCode'] ?></h3>
            </div>
            
            <div class="card-body-modern">
                <!-- Bảng sản phẩm -->
                <div class="table-responsive mb-5">
                    <table class="table table-modern">
                        <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th class="text-center">Màu</th>
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
                                            <a href="<?php echo $value['alias'] ?>" class="text-dark font-weight-bold">
                                                <?php echo $value['name'] ?>
                                            </a>
                                        </td>
                                        <td class="text-center"><?php echo !empty($value['color']) ? $value['color'] : '-'; ?></td>
                                        <td class="text-center"><?php echo !empty($value['capacity']) ? $value['capacity'] : '-'; ?></td>
                                        <td class="text-center"><?php echo number_format($value['priceorder']) ?>₫</td>
                                        <td class="text-center"><?php echo $value['count'] ?></td>
                                        <td class="text-right font-weight-bold"><?php echo number_format($value['priceorder'] * $value['count']) ?>₫</td>
                                    </tr>
                                <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <!-- Thông tin người nhận -->
                    <div class="col-md-7">
                        <div class="section-header">
                            <i class="fa fa-address-card"></i>
                            <h4>Thông tin nhận hàng</h4>
                        </div>
                        <div class="order-info-box">
                            <p><strong>Người nhận:</strong> <?php echo $info['fullname'] ?></p>
                            <p><strong>Số điện thoại:</strong> <?php echo $info['phone'] ?></p>
                            <p><strong>Thời gian đặt:</strong> <?php echo date('d/m/Y H:i', strtotime($info['order_date'])) ?></p>
                            <p><strong>Địa chỉ:</strong> <?php echo $info['address'] ?>, <?php echo $this->Mquanhuyen->district_name($info['district']); ?>, <?php echo $this->Mtinhthanh->province_name($info['province']);?></p>
                        </div>
                    </div>

                    <!-- Tổng kết tiền -->
                    <div class="col-md-5">
                        <div class="section-header">
                            <i class="fa fa-calculator"></i>
                            <h4>Tổng kết thanh toán</h4>
                        </div>
                        <div class="payment-summary">
                            <?php  
                                $priceShip = $info['price_ship'];
                                $subtotal = $info['money'] - $info['price_ship'] + ($info['coupon_amount'] ?? 0);
                            ?>
                            <div class="summary-line">
                                <span>Tiền hàng:</span>
                                <span><?php echo number_format($subtotal) ?>₫</span>
                            </div>
                            <div class="summary-line">
                                <span>Phí vận chuyển:</span>
                                <span><?php echo number_format($priceShip) ?>₫</span>
                            </div>
                            <?php if($info['coupon'] != 0): ?>
                                <div class="summary-line text-success">
                                    <span>Giảm giá (Voucher):</span>
                                    <span>-<?php echo number_format($info['coupon_amount']) ?>₫</span>
                                </div>
                            <?php endif; ?>
                            <hr>
                            <div class="summary-line total-line">
                                <span>Tổng cộng:</span>
                                <span class="text-danger"><?php echo number_format($info['money']) ?>₫</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5 text-center">
                    <a href="javascript:;" onclick="window.history.go(-1);" class="btn btn-default btn-modern">
                        <i class="fa fa-arrow-left"></i> Trở về trang trước
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.order-info-box p {
    margin-bottom: 10px;
    font-size: 14px;
    color: #555;
}
.payment-summary .summary-line {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    font-size: 14px;
}
.total-line {
    font-size: 18px !important;
    font-weight: bold;
}
</style>