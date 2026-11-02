<section id="content" class="account-luxury-page">
    <div class="container">
        <!-- Breadcrumb Hiện Đại -->
        <div class="breadcrumbs-modern mb-3" style="font-size: 13.5px; color: #64748b; margin-bottom: 25px;">
            <a href="<?php echo base_url(); ?>" style="color: #64748b; text-decoration: none;"><i class="fa fa-home"></i> Trang chủ</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <span style="color: #0f172a; font-weight: 700;">Trung tâm tài khoản</span>
        </div>

        <div class="row">
            <!-- Sidebar: Profile VIP Card -->
            <aside class="col-md-4 col-sm-12">
                <div class="account-luxury-card account-profile-card">
                    <!-- Header Profile VIP -->
                    <div class="account-profile-header">
                        <div class="account-avatar-wrapper">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h3 class="account-user-name"><?php echo htmlspecialchars($info['fullname']); ?></h3>
                        <div class="account-member-badge">
                            <i class="fas fa-crown"></i> NDN VIP MEMBER
                        </div>
                    </div>

                    <!-- Body Thông tin tài khoản -->
                    <div class="account-profile-body">
                        <ul class="account-info-list">
                            <li class="account-info-item">
                                <span class="account-info-icon"><i class="fas fa-id-card"></i></span>
                                <div class="account-info-content">
                                    <span class="account-info-label">Tên tài khoản</span>
                                    <span class="account-info-val">@<?php echo htmlspecialchars($info['username']); ?></span>
                                </div>
                            </li>
                            <li class="account-info-item">
                                <span class="account-info-icon"><i class="fas fa-envelope"></i></span>
                                <div class="account-info-content">
                                    <span class="account-info-label">Địa chỉ Email</span>
                                    <span class="account-info-val"><?php echo htmlspecialchars($info['email']); ?></span>
                                </div>
                            </li>
                            <li class="account-info-item">
                                <span class="account-info-icon"><i class="fas fa-phone-alt"></i></span>
                                <div class="account-info-content">
                                    <span class="account-info-label">Số điện thoại</span>
                                    <span class="account-info-val"><?php echo htmlspecialchars($info['phone']); ?></span>
                                </div>
                            </li>
                        </ul>

                        <!-- Các nút thao tác tài khoản -->
                        <div style="margin-bottom: 15px;">
                            <a href="<?php echo base_url('reset_password'); ?>" class="btn-account-action btn-account-pwd">
                                <i class="fas fa-key"></i> Đổi mật khẩu bảo mật
                            </a>
                            <a href="<?php echo base_url('dang-xuat'); ?>" class="btn-account-action btn-account-logout" onclick="return confirm('Bạn có chắc chắn muốn đăng xuất?')">
                                <i class="fas fa-sign-out-alt"></i> Đăng xuất tài khoản
                            </a>
                        </div>

                        <!-- Khối Quà tặng / Voucher độc quyền -->
                        <div class="account-coupon-box">
                            <div class="account-coupon-title">
                                <i class="fas fa-gift" style="color: #ef4444;"></i> Voucher của bạn:
                            </div>
                            <?php 
                                $my_vouchers = $this->db->where('customer_id', $info['id'])
                                                        ->where('status', 1)
                                                        ->where('number_used < limit_number')
                                                        ->get('coupons')->result_array();
                                if(!empty($my_vouchers)):
                                    foreach($my_vouchers as $v):
                            ?>
                                <div class="luxury-coupon-ticket">
                                    <div class="coupon-ticket-desc"><?php echo htmlspecialchars($v['description']); ?></div>
                                    <div class="coupon-ticket-code-row">
                                        <span class="coupon-code-text" id="coupon-val-<?php echo $v['id']; ?>"><?php echo htmlspecialchars($v['code']); ?></span>
                                        <button type="button" class="btn-copy-coupon" onclick="copyCouponCode('<?php echo $v['code']; ?>')">
                                            <i class="far fa-copy"></i> Sao chép
                                        </button>
                                    </div>
                                    <div style="font-size: 10.5px; color: #94a3b8; margin-top: 6px; display: flex; align-items: center; gap: 4px;">
                                        <i class="far fa-clock"></i> HSD: <?php echo date('d/m/Y', strtotime($v['expiration_date'])); ?>
                                    </div>
                                </div>
                            <?php 
                                    endforeach;
                                else:
                            ?>
                                <div style="text-align: center; padding: 15px 10px; background: #f8fafc; border-radius: 10px; color: #94a3b8; font-size: 12.5px;">
                                    <i class="far fa-folder-open" style="font-size: 20px; margin-bottom: 5px; display: block;"></i>
                                    Bạn chưa có mã giảm giá khả dụng.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main: Thống kê & Bảng Lịch sử đơn hàng -->
            <div class="col-md-8 col-sm-12">
                <!-- 3 Thẻ KPI Thống Kê Tổng Quan Nhanh -->
                <?php 
                    $stats = isset($order_stats) ? $order_stats : [
                        'total_orders' => 0,
                        'processing' => 0,
                        'completed' => 0,
                        'total_spent' => 0
                    ];
                ?>
                <div class="account-kpi-row">
                    <div class="account-kpi-card">
                        <div class="account-kpi-icon kpi-icon-blue">
                            <i class="fas fa-shopping-bag"></i>
                        </div>
                        <div>
                            <div class="account-kpi-val"><?php echo $stats['total_orders']; ?></div>
                            <div class="account-kpi-label">Tổng đơn đã đặt</div>
                        </div>
                    </div>

                    <div class="account-kpi-card">
                        <div class="account-kpi-icon kpi-icon-orange">
                            <i class="fas fa-shipping-fast"></i>
                        </div>
                        <div>
                            <div class="account-kpi-val"><?php echo $stats['processing']; ?></div>
                            <div class="account-kpi-label">Đang giao / Chờ duyệt</div>
                        </div>
                    </div>

                    <div class="account-kpi-card">
                        <div class="account-kpi-icon kpi-icon-green">
                            <i class="fas fa-wallet"></i>
                        </div>
                        <div>
                            <div class="account-kpi-val"><?php echo number_format($stats['total_spent']); ?>₫</div>
                            <div class="account-kpi-label">Chi tiêu tích lũy</div>
                        </div>
                    </div>
                </div>

                <!-- Đơn hàng chưa duyệt (Nếu có) -->
                <?php 
                    $pending_orders = $this->Mthongtinkhach->order_listorder_customerid_not($info['id']);
                    if(!empty($pending_orders)): 
                ?>
                <div class="account-luxury-card account-orders-card" style="border-left: 4px solid #f59e0b;">
                    <div class="account-orders-header">
                        <h4 style="color: #b45309;"><i class="far fa-clock"></i> Đơn hàng đang chờ xử lý</h4>
                        <span class="badge" style="background: #fef3c7; color: #b45309; font-weight: 700;"><?php echo count($pending_orders); ?> đơn</span>
                    </div>
                    <div class="table-responsive">
                        <table class="table-luxury-orders">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Thời gian</th>
                                    <th class="text-center">Tổng thanh toán</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-right">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($pending_orders as $value): ?>
                                    <tr>
                                        <td>
                                            <span class="order-code-pill">#<?php echo $value['orderCode']; ?></span>
                                        </td>
                                        <td>
                                            <div class="order-date-text">
                                                <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y H:i', strtotime($value['order_date'])); ?>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-price-luxury"><?php echo number_format($value['money']); ?>₫</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge-luxury status-pending">
                                                <i class="fas fa-hourglass-half"></i> Chờ duyệt
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="<?php echo base_url('account/orders/'.$value['id']); ?>" class="btn-view-order-luxury" title="Xem chi tiết đơn hàng">
                                                <i class="far fa-eye"></i> Xem
                                            </a>
                                            <a href="<?php echo base_url('thongtin/update/'.$value['id']); ?>" 
                                               class="btn-cancel-order-luxury" 
                                               onclick="return confirm('Bạn có chắc chắn muốn hủy đơn hàng #<?php echo $value['orderCode']; ?> không?')"
                                               title="Hủy đơn hàng">
                                                <i class="fas fa-times"></i> Hủy
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Toàn bộ Lịch sử đơn hàng -->
                <div class="account-luxury-card account-orders-card">
                    <div class="account-orders-header">
                        <h4><i class="fas fa-history" style="color: #d70018;"></i> Lịch sử tất cả đơn hàng</h4>
                    </div>

                    <?php 
                        $history_orders = $this->Mthongtinkhach->order_listorder_customerid($info['id']);
                        if(!empty($history_orders)): 
                    ?>
                        <div class="table-responsive">
                            <table class="table-luxury-orders">
                                <thead>
                                    <tr>
                                        <th>Mã đơn</th>
                                        <th>Ngày đặt</th>
                                        <th class="text-center">Tổng tiền</th>
                                        <th class="text-center">Trạng thái</th>
                                        <th class="text-right">Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($history_orders as $value): ?>
                                        <tr>
                                            <td>
                                                <span class="order-code-pill">#<?php echo $value['orderCode']; ?></span>
                                            </td>
                                            <td>
                                                <div class="order-date-text">
                                                    <i class="far fa-calendar-alt"></i> <?php echo date('d/m/Y H:i', strtotime($value['order_date'])); ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="order-price-luxury"><?php echo number_format($value['money']); ?>₫</span>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                switch ($value['status']) {
                                                    case '0':
                                                        echo '<span class="status-badge-luxury status-pending"><i class="fas fa-hourglass-half"></i> Chờ duyệt</span>';
                                                        break;
                                                    case '1':
                                                        echo '<span class="status-badge-luxury status-shipping"><i class="fas fa-truck"></i> Đang giao</span>';
                                                        break;
                                                    case '2':
                                                        echo '<span class="status-badge-luxury status-completed"><i class="fas fa-check-circle"></i> Đã giao</span>';
                                                        break;
                                                    case '3':
                                                        echo '<span class="status-badge-luxury status-cancelled"><i class="fas fa-user-times"></i> Khách đã hủy</span>';
                                                        break;
                                                    case '4':
                                                        echo '<span class="status-badge-luxury status-cancelled"><i class="fas fa-ban"></i> Hệ thống hủy</span>';
                                                        break;
                                                }
                                                ?>
                                            </td>
                                            <td class="text-right">
                                                <a href="<?php echo base_url('account/orders/'.$value['id']); ?>" class="btn-view-order-luxury">
                                                    <i class="far fa-eye"></i> Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div style="text-align: center; padding: 50px 20px;">
                            <div style="width: 70px; height: 70px; line-height: 70px; border-radius: 50%; background: #f8fafc; margin: 0 auto 15px; color: #94a3b8; font-size: 28px;">
                                <i class="fas fa-receipt"></i>
                            </div>
                            <h5 style="font-weight: 700; color: #334155;">Chưa có lịch sử đơn hàng nào</h5>
                            <p style="color: #64748b; font-size: 13.5px; margin-bottom: 20px;">Hãy dạo một vòng và chọn chiếc smartphone ưng ý cho mình nhé!</p>
                            <a href="<?php echo base_url('san-pham'); ?>" class="btn btn-danger" style="border-radius: 20px; font-weight: 700; padding: 8px 24px; background: #d70018; border-color: #d70018;">
                                Khám phá sản phẩm
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Toast thông báo Copy Voucher -->
<div id="voucher-toast">
    <i class="fas fa-check-circle" style="color: #10b981;"></i>
    <span>Đã sao chép mã giảm giá vào bộ nhớ tạm!</span>
</div>

<script>
function copyCouponCode(code) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(code).then(showToast);
    } else {
        var textArea = document.createElement("textarea");
        textArea.value = code;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showToast();
        } catch (err) {}
        document.body.removeChild(textArea);
    }
}

function showToast() {
    var toast = document.getElementById("voucher-toast");
    if(toast) {
        toast.classList.add("show");
        setTimeout(function() {
            toast.classList.remove("show");
        }, 2500);
    }
}
</script>
