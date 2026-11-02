<div class="content-wrapper" style="min-height: 564px;">
    <?php
        $orderId = isset($id) ? $id : (isset($row['id']) ? $row['id'] : 0);
        $order = isset($row) ? $row : $this->Mdonhang->orders_detail($orderId);
        $customer = isset($customer) ? $customer : null;
        $data = isset($orderdetail) ? $orderdetail : $this->Mchitietdonhang->orderdetail_orderid($orderId);
    ?>
    <section class="content-header">
        <h1>
            <i class="fa fa-shopping-bag text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Chi tiết hóa đơn đơn hàng
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Đơn hàng <b>#<?php echo htmlspecialchars($order['orderCode']); ?></b></small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="button" class="btn btn-modern-print" onclick="window.print()">
                <i class="fa fa-print"></i> In đơn hàng
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/orders'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Hàng thông tin tóm tắt & Khách hàng -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="modern-card-info">
                            <div class="card-info-header">
                                <i class="fa fa-user-circle"></i> Thông tin người nhận
                            </div>
                            <div class="card-info-body">
                                <h4 class="recipient-name"><?php echo htmlspecialchars($order['fullname']); ?></h4>
                                <div class="info-line"><i class="fa fa-phone text-muted"></i> <b><?php echo htmlspecialchars($order['phone']); ?></b></div>
                                <div class="info-line">
                                    <i class="fa fa-map-marker text-muted"></i> 
                                    <?php 
                                        $addr_txt = htmlspecialchars($order['address']);
                                        if(!empty($order['district']) && isset($this->Mquanhuyen)) {
                                            $addr_txt .= ', ' . $this->Mquanhuyen->district_name($order['district']);
                                        }
                                        if(!empty($order['province']) && isset($this->Mtinhthanh)) {
                                            $addr_txt .= ', ' . $this->Mtinhthanh->province_name($order['province']);
                                        }
                                        echo $addr_txt;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="modern-card-info">
                            <div class="card-info-header">
                                <i class="fa fa-file-text-o"></i> Thông tin đơn hàng
                            </div>
                            <div class="card-info-body">
                                <div class="info-line"><span>Mã đơn:</span> <b class="order-code-text">#<?php echo htmlspecialchars($order['orderCode']); ?></b></div>
                                <div class="info-line"><span>Thời gian đặt:</span> <i><?php echo !empty($order['orderdate']) ? htmlspecialchars($order['orderdate']) : (!empty($order['order_date']) ? htmlspecialchars($order['order_date']) : ''); ?></i></div>
                                <div class="info-line"><span>Hình thức TT:</span> 
                                    <b>
                                        <?php if($order['payment_method'] == 0): ?>
                                            <span class="pay-pill-tag pay-cod">COD (Khi nhận hàng)</span>
                                        <?php else: ?>
                                            <span class="pay-pill-tag pay-online">ONLINE (Chuyển khoản / VietQR)</span>
                                        <?php endif; ?>
                                    </b>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="modern-card-info">
                            <div class="card-info-header">
                                <i class="fa fa-truck"></i> Tiến độ xử lý
                            </div>
                            <div class="card-info-body">
                                <div class="order-status-current">
                                    <?php
                                        $stt = $order['status'];
                                        if($stt == 0) echo '<span class="status-pill-badge stt-pending"><i class="fa fa-hourglass-start"></i> Đang chờ duyệt</span>';
                                        else if($stt == 1) echo '<span class="status-pill-badge stt-shipping"><i class="fa fa-truck"></i> Đang giao hàng</span>';
                                        else if($stt == 2) echo '<span class="status-pill-badge stt-completed"><i class="fa fa-check-circle"></i> Đã giao & Thanh toán</span>';
                                        else if($stt == 3) echo '<span class="status-pill-badge stt-cancelled"><i class="fa fa-ban"></i> Khách đã hủy</span>';
                                        else if($stt == 4) echo '<span class="status-pill-badge stt-cancelled"><i class="fa fa-times-circle"></i> Shop đã hủy</span>';
                                    ?>
                                </div>
                                <div class="status-action-box" style="margin-top: 12px;">
                                    <?php if($stt == 0): ?>
                                        <a href="<?php echo base_url('admin/orders/status/'.$order['id']); ?>" class="btn-quick-status btn-approve" onclick="return confirm('Xác nhận duyệt đơn hàng này?')">
                                            <i class="fa fa-check"></i> Duyệt đơn ngay
                                        </a>
                                    <?php elseif($stt == 1): ?>
                                        <a href="<?php echo base_url('admin/orders/status/'.$order['id']); ?>" class="btn-quick-status btn-deliver" onclick="return confirm('Xác nhận đã giao thành công và thu tiền?')">
                                            <i class="fa fa-thumbs-up"></i> Xác nhận đã giao
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bảng danh sách sản phẩm trong đơn -->
                <div class="modern-order-table-card">
                    <div class="card-header-styled">
                        <h3><i class="fa fa-list"></i> Danh sách mặt hàng (<?php echo count($data); ?> sản phẩm)</h3>
                    </div>
                    <div class="card-body-styled" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-items-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">STT</th>
                                        <th style="min-width: 260px;">Tên sản phẩm điện thoại</th>
                                        <th style="width: 120px;" class="text-center">Phiên bản màu</th>
                                        <th style="width: 120px;" class="text-center">Dung lượng</th>
                                        <th style="width: 100px;" class="text-center">Số lượng</th>
                                        <th style="width: 140px;" class="text-right">Đơn giá</th>
                                        <th style="width: 160px;" class="text-right">Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $stt_num = 0; $total_sub = 0;
                                    foreach ($data as $row) :
                                        $stt_num++;
                                        $product = $this->Msanpham->product_detail_id($row['product_id']);
                                        $price_line = $row['price'] * $row['count'];
                                        $total_sub += $price_line;
                                    ?>
                                    <tr>
                                        <td class="text-center"><span class="stt-badge"><?php echo $stt_num; ?></span></td>
                                        <td>
                                            <div class="prod-item-name">
                                                <b><?php echo isset($product['name']) ? htmlspecialchars($product['name']) : 'Sản phẩm không tồn tại'; ?></b>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="attr-pill"><?php echo !empty($row['color']) ? htmlspecialchars($row['color']) : '-'; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span class="attr-pill"><?php echo !empty($row['capacity']) ? htmlspecialchars($row['capacity']) : '-'; ?></span>
                                        </td>
                                        <td class="text-center">
                                            <b class="count-badge">x<?php echo $row['count']; ?></b>
                                        </td>
                                        <td class="text-right">
                                            <span><?php echo number_format($row['price']); ?>₫</span>
                                        </td>
                                        <td class="text-right">
                                            <b class="line-total-val"><?php echo number_format($price_line); ?>₫</b>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Bảng tính tổng tiền -->
                        <?php 
                            $price_ship = (float)$order['price_ship'];
                            $coupon = 0;
                            if($order['coupon'] != NULL) {
                                $coupon_detail = $this->db->where('id', $order['coupon'])->get('coupons')->row_array();
                                if($coupon_detail) {
                                    $coupon = (float)$coupon_detail['discount'];
                                }
                            }
                            $final_total = max(0, $total_sub + $price_ship - $coupon);
                        ?>
                        <div class="order-summary-box">
                            <div class="summary-line">
                                <span>Tiền hàng (Tạm tính):</span>
                                <b><?php echo number_format($total_sub); ?>₫</b>
                            </div>
                            <?php if($coupon > 0): ?>
                            <div class="summary-line line-discount">
                                <span>Voucher giảm giá:</span>
                                <b>-<?php echo number_format($coupon); ?>₫</b>
                            </div>
                            <?php endif; ?>
                            <div class="summary-line">
                                <span>Phí giao hàng:</span>
                                <b><?php echo ($price_ship > 0) ? number_format($price_ship).'₫' : 'Miễn phí'; ?></b>
                            </div>
                            <div class="summary-line line-total">
                                <span>Tổng tiền thanh toán:</span>
                                <b class="grand-total-val"><?php echo number_format($final_total); ?>₫</b>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<style>
    :root {
        --primary: #d70018;
        --primary-dark: #b91c1c;
        --border-color: #e2e8f0;
    }

    .content-wrapper {
        background-color: #f8fafc !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .content-header h1 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .btn-modern-print {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff !important;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-modern-print:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(215, 0, 24, 0.45);
    }

    .btn-modern-back {
        background: #ffffff;
        color: #475569 !important;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-modern-back:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a !important;
    }

    /* Modern Card Info */
    .modern-card-info {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .card-info-header {
        padding: 12px 18px;
        background: #fafbfc;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13.5px;
        font-weight: 700;
        color: #334155;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-info-header i {
        color: var(--primary);
    }
    .card-info-body {
        padding: 18px;
    }
    .recipient-name {
        margin: 0 0 8px;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .info-line {
        font-size: 13px;
        color: #475569;
        margin-bottom: 6px;
        line-height: 1.5;
    }
    .order-code-text {
        font-family: 'Consolas', 'Courier New', monospace;
        color: var(--primary);
        font-size: 14px;
    }

    .pay-pill-tag {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 6px;
    }
    .pay-cod {
        background: #f1f5f9;
        color: #475569;
    }
    .pay-online {
        background: #fdf2f8;
        color: #be185d;
    }

    /* Status Pills */
    .status-pill-badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
    }
    .stt-pending {
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }
    .stt-shipping {
        background: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }
    .stt-completed {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .stt-cancelled {
        background: #fef2f2;
        color: #dc2626;
        border: 1px solid #fee2e2;
    }

    .btn-quick-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-approve {
        background: #10b981;
        color: #ffffff !important;
    }
    .btn-approve:hover {
        background: #059669;
    }
    .btn-deliver {
        background: #2563eb;
        color: #ffffff !important;
    }
    .btn-deliver:hover {
        background: #1d4ed8;
    }

    /* Table Card */
    .modern-order-table-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .card-header-styled {
        padding: 14px 20px;
        background: #fafbfc;
        border-bottom: 1px solid #f1f5f9;
    }
    .card-header-styled h3 {
        font-size: 14.5px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-header-styled h3 i {
        color: var(--primary);
    }

    .modern-items-table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .modern-items-table thead tr th {
        background: #fafbfc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border-top: none;
        border-bottom: 1.5px solid #e2e8f0;
    }
    .modern-items-table tbody tr td {
        padding: 14px 16px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        font-size: 13.5px;
        color: #334155;
    }

    .stt-badge {
        font-size: 12px;
        color: #94a3b8;
        font-weight: 700;
    }
    .attr-pill {
        background: #f1f5f9;
        color: #475569;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
    }
    .count-badge {
        color: #1e293b;
        font-size: 14px;
    }
    .line-total-val {
        color: var(--primary);
        font-size: 14px;
    }

    /* Summary Box */
    .order-summary-box {
        background: #fafbfc;
        border-top: 1.5px solid #e2e8f0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 10px;
    }
    .summary-line {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 320px;
        font-size: 13.5px;
        color: #475569;
    }
    .summary-line.line-discount {
        color: #16a34a;
    }
    .summary-line.line-total {
        padding-top: 10px;
        border-top: 1px dashed #cbd5e1;
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }
    .grand-total-val {
        font-size: 20px;
        color: var(--primary);
    }

    @media print {
        .content-header, .breadcrumb, .btn-quick-status, .main-sidebar, .main-header, .main-footer {
            display: none !important;
        }
        .content-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
        }
    }
</style>