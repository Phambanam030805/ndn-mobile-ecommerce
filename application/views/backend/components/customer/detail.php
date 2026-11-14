<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-circle text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Hồ sơ khách hàng
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Chi tiết tài khoản & lịch sử mua hàng của <b><?php echo htmlspecialchars($row['fullname']); ?></b></small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" form="customer-status-form" class="btn btn-modern-save">
                <i class="fa fa-check"></i> Lưu trạng thái
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/customer'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Flash Notification -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-modern alert-toast-fixed">
                        <i class="fa fa-check-circle" style="font-size: 20px; color: #10b981;"></i>
                        <span style="font-weight: 500; font-size: 14px; color: #065f46;"><?php echo $this->session->flashdata('success'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-left: auto;">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-modern alert-toast-fixed">
                        <i class="fa fa-exclamation-triangle" style="font-size: 20px; color: #ef4444;"></i>
                        <span style="font-weight: 500; font-size: 14px; color: #991b1b;"><?php echo $this->session->flashdata('error'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-left: auto;">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- 4 KPI SUMMARY CARDS -->
                <div class="row kpi-cards-row">
                    <!-- Tổng chi tiêu -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="kpi-card card-spent">
                            <div class="kpi-icon-wrap icon-spent">
                                <i class="fa fa-line-chart"></i>
                            </div>
                            <div class="kpi-body">
                                <span class="kpi-label">Tổng chi tiêu</span>
                                <h3 class="kpi-value text-red"><?php echo number_format($stat['total_spent']); ?>₫</h3>
                                <span class="kpi-subtext">Đã tích lũy tại cửa hàng</span>
                            </div>
                        </div>
                    </div>

                    <!-- Tổng đơn hàng -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="kpi-card card-orders">
                            <div class="kpi-icon-wrap icon-orders">
                                <i class="fa fa-shopping-bag"></i>
                            </div>
                            <div class="kpi-body">
                                <span class="kpi-label">Tổng số đơn hàng</span>
                                <h3 class="kpi-value text-blue"><?php echo (int)$stat['total_orders']; ?> <small>đơn</small></h3>
                                <span class="kpi-subtext"><?php echo (int)$stat['completed_orders']; ?> thành công / <?php echo (int)$stat['canceled_orders']; ?> đã hủy</span>
                            </div>
                        </div>
                    </div>

                    <!-- Phân hạng thành viên -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="kpi-card card-rank <?php echo $stat['rank_class']; ?>">
                            <div class="kpi-icon-wrap icon-rank">
                                <i class="fa fa-diamond"></i>
                            </div>
                            <div class="kpi-body">
                                <span class="kpi-label">Phân hạng thành viên</span>
                                <h3 class="kpi-value kpi-rank-title"><?php echo $stat['rank_badge']; ?></h3>
                                <span class="kpi-subtext"><?php echo $stat['rank_title']; ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- Trạng thái tài khoản -->
                    <div class="col-lg-3 col-sm-6">
                        <div class="kpi-card card-status">
                            <div class="kpi-icon-wrap icon-status <?php echo ($row['status'] == 1) ? 'status-active' : 'status-locked'; ?>">
                                <i class="fa <?php echo ($row['status'] == 1) ? 'fa-check-circle' : 'fa-lock'; ?>"></i>
                            </div>
                            <div class="kpi-body">
                                <span class="kpi-label">Trạng thái tài khoản</span>
                                <h3 class="kpi-value <?php echo ($row['status'] == 1) ? 'text-green' : 'text-red'; ?>">
                                    <?php echo ($row['status'] == 1) ? 'Đang hoạt động' : 'Đang tạm khóa'; ?>
                                </h3>
                                <span class="kpi-subtext"><?php echo ($row['status'] == 1) ? 'Cho phép mua sắm' : 'Bị chặn đăng nhập'; ?></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top: 15px;">
                    <!-- Cột Trái: Thông tin cá nhân (Read-only) -->
                    <div class="col-lg-7 col-md-7">
                        <div class="modern-card profile-details-card">
                            <div class="card-header-clean">
                                <h3>
                                    <i class="fa fa-id-card-o text-muted"></i> Thông tin khách hàng
                                </h3>
                                <span class="badge-privacy-tag">
                                    <i class="fa fa-shield"></i> Quyền riêng tư (Read-Only)
                                </span>
                            </div>
                            <div class="card-body-clean">
                                
                                <!-- Privacy policy note -->
                                <div class="privacy-note-box">
                                    <i class="fa fa-info-circle note-icon"></i>
                                    <div class="note-content">
                                        <b>Chính sách bảo vệ dữ liệu cá nhân:</b>
                                        Thông tin liên hệ do khách hàng tự đăng ký và quản lý tại trang cá nhân ngoài website. Quản trị viên không thể chỉnh sửa để bảo toàn tính toàn vẹn dữ liệu, quyền riêng tư và tránh xung đột bảo mật khi đăng nhập.
                                    </div>
                                </div>

                                <div class="profile-info-grid">
                                    <!-- Họ và tên -->
                                    <div class="profile-info-item">
                                        <div class="info-label">
                                            <i class="fa fa-user-circle-o"></i> Họ và tên khách hàng
                                        </div>
                                        <div class="info-value text-bold text-dark">
                                            <?php echo htmlspecialchars($row['fullname']); ?>
                                        </div>
                                    </div>

                                    <!-- Tên đăng nhập -->
                                    <div class="profile-info-item">
                                        <div class="info-label">
                                            <i class="fa fa-user-o"></i> Tên tài khoản (Username)
                                        </div>
                                        <div class="info-value">
                                            <span class="user-pill-tag">
                                                <i class="fa fa-at"></i> <?php echo htmlspecialchars(!empty($row['username']) ? $row['username'] : 'khach_vang_lai'); ?>
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Số điện thoại -->
                                    <div class="profile-info-item">
                                        <div class="info-label">
                                            <i class="fa fa-phone"></i> Số điện thoại liên hệ
                                        </div>
                                        <div class="info-value">
                                            <?php if(!empty($row['phone'])): ?>
                                                <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>" class="contact-value-link" title="Bấm để gọi khách">
                                                    <i class="fa fa-phone-square text-green"></i> <b><?php echo htmlspecialchars($row['phone']); ?></b>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted"><i class="fa fa-ban"></i> Chưa cập nhật</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="profile-info-item">
                                        <div class="info-label">
                                            <i class="fa fa-envelope-o"></i> Địa chỉ Email
                                        </div>
                                        <div class="info-value">
                                            <?php if(!empty($row['email'])): ?>
                                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="contact-value-link" title="Bấm để gửi email">
                                                    <i class="fa fa-envelope text-blue"></i> <?php echo htmlspecialchars($row['email']); ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted"><i class="fa fa-ban"></i> Chưa cập nhật</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <!-- Giới tính -->
                                    <div class="profile-info-item">
                                        <div class="info-label">
                                            <i class="fa fa-venus-mars"></i> Giới tính
                                        </div>
                                        <div class="info-value">
                                            <?php 
                                                if(isset($row['gender'])) {
                                                    echo ($row['gender'] == 1) ? '<span class="gender-tag gender-male"><i class="fa fa-mars"></i> Nam</span>' : '<span class="gender-tag gender-female"><i class="fa fa-venus"></i> Nữ</span>';
                                                } else {
                                                    echo '<span class="text-muted">Chưa xác định</span>';
                                                }
                                            ?>
                                        </div>
                                    </div>

                                    <!-- Ngày tham gia -->
                                    <div class="profile-info-item">
                                        <div class="info-label">
                                            <i class="fa fa-calendar-check-o"></i> Thời gian đăng ký
                                        </div>
                                        <div class="info-value text-muted">
                                            <i class="fa fa-clock-o"></i> <?php echo !empty($row['created_at']) ? date('d/m/Y H:i:s', strtotime($row['created_at'])) : 'Không xác định'; ?>
                                        </div>
                                    </div>

                                    <!-- Địa chỉ nhận hàng -->
                                    <?php 
                                        $last_address = !empty($row['address']) ? $row['address'] : (!empty($orders[0]['address']) ? $orders[0]['address'] : '');
                                    ?>
                                    <div class="profile-info-item full-span">
                                        <div class="info-label">
                                            <i class="fa fa-map-marker"></i> Địa chỉ giao hàng mặc định / Đơn gần nhất
                                        </div>
                                        <div class="info-value text-dark">
                                            <?php if(!empty($last_address)): ?>
                                                <i class="fa fa-location-arrow text-red" style="margin-right: 4px;"></i> <?php echo htmlspecialchars($last_address); ?>
                                            <?php else: ?>
                                                <span class="text-muted"><i class="fa fa-map-signs"></i> Chưa có địa chỉ giao hàng</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Cột Phải: Quyền Quản trị duy nhất - Trạng thái & Bảo mật -->
                    <div class="col-lg-5 col-md-5">
                        <div class="modern-card profile-security-card">
                            <div class="card-header-clean">
                                <h3>
                                    <i class="fa fa-shield text-muted"></i> Quản lý trạng thái tài khoản
                                </h3>
                            </div>
                            <div class="card-body-clean">
                                
                                <!-- Avatar Box -->
                                <div class="customer-avatar-hero">
                                    <div class="avatar-hero-circle">
                                        <?php echo !empty($row['fullname']) ? mb_strtoupper(mb_substr($row['fullname'], 0, 1, 'UTF-8')) : 'U'; ?>
                                    </div>
                                    <div class="avatar-hero-details">
                                        <h4 class="avatar-fullname"><?php echo htmlspecialchars($row['fullname']); ?></h4>
                                        <span class="avatar-role-tag">Tài khoản khách hàng #<?php echo $row['id']; ?></span>
                                        <div class="avatar-badges">
                                            <span class="badge-rank-hero <?php echo $stat['rank_class']; ?>">
                                                <?php echo $stat['rank_badge']; ?>
                                            </span>
                                            <span class="badge-status-hero <?php echo ($row['status'] == 1) ? 'hero-active' : 'hero-locked'; ?>">
                                                <i class="fa <?php echo ($row['status'] == 1) ? 'fa-check-circle' : 'fa-lock'; ?>"></i>
                                                <?php echo ($row['status'] == 1) ? 'Hoạt động' : 'Tạm khóa'; ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <hr style="margin: 20px 0; border-top: 1px dashed #e2e8f0;">

                                <!-- Form quản trị trạng thái tài khoản duy nhất -->
                                <?php echo form_open('admin/customer/detail/'.$row['id'], ['id' => 'customer-status-form']); ?>
                                    <div class="form-group-custom">
                                        <label class="form-label-custom">
                                            <i class="fa fa-power-off"></i> Quyền truy cập & Đặt hàng của khách:
                                        </label>
                                        <div class="select-wrapper">
                                            <select name="status" class="form-control-custom select-custom">
                                                <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>
                                                    ● Đang hoạt động (Cho phép đăng nhập & mua hàng)
                                                </option>
                                                <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>
                                                    ○ Tạm khóa tài khoản (Chặn đăng nhập website)
                                                </option>
                                            </select>
                                            <i class="fa fa-chevron-down select-arrow"></i>
                                        </div>
                                        <span class="field-hint">
                                            <i class="fa fa-warning text-warning"></i> Khi khóa tài khoản, người dùng sẽ không thể đăng nhập hoặc tạo đơn mới trên website.
                                        </span>
                                    </div>

                                    <button type="submit" class="btn btn-modern-save-block">
                                        <i class="fa fa-check-circle"></i> Cập nhật trạng thái tài khoản
                                    </button>
                                <?php echo form_close(); ?>

                                <div class="account-metric-list">
                                    <div class="metric-row">
                                        <span class="metric-title"><i class="fa fa-shopping-cart text-muted"></i> Đơn hàng hoàn tất:</span>
                                        <span class="metric-val text-green text-bold"><?php echo (int)$stat['completed_orders']; ?> đơn</span>
                                    </div>
                                    <div class="metric-row">
                                        <span class="metric-title"><i class="fa fa-truck text-muted"></i> Đơn đang giao:</span>
                                        <span class="metric-val text-blue text-bold"><?php echo (int)$stat['delivering_orders']; ?> đơn</span>
                                    </div>
                                    <div class="metric-row">
                                        <span class="metric-title"><i class="fa fa-clock-o text-muted"></i> Đơn chờ duyệt:</span>
                                        <span class="metric-val text-warning text-bold"><?php echo (int)$stat['pending_orders']; ?> đơn</span>
                                    </div>
                                    <div class="metric-row">
                                        <span class="metric-title"><i class="fa fa-times-circle text-muted"></i> Đơn đã hủy:</span>
                                        <span class="metric-val text-red text-bold"><?php echo (int)$stat['canceled_orders']; ?> đơn</span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- LỊCH SỬ ĐƠN HÀNG CỦA KHÁCH HÀNG -->
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12">
                        <div class="modern-card orders-history-card">
                            <div class="card-header-clean" style="justify-content: space-between;">
                                <h3>
                                    <i class="fa fa-history text-red"></i> Lịch sử đơn hàng đã đặt
                                    <span class="orders-count-badge"><?php echo count($orders); ?> đơn</span>
                                </h3>
                                <a href="<?php echo base_url('admin/orders?search=' . urlencode($row['phone'] ? $row['phone'] : $row['fullname'])); ?>" class="btn btn-sm btn-outline-custom">
                                    <i class="fa fa-external-link"></i> Mở quản lý đơn hàng
                                </a>
                            </div>

                            <div class="card-body-clean" style="padding: 0;">
                                <div class="table-responsive">
                                    <table class="table modern-orders-table">
                                        <thead>
                                            <tr>
                                                <th style="width: 50px;" class="text-center">STT</th>
                                                <th style="width: 140px;">Mã đơn hàng</th>
                                                <th style="min-width: 150px;">Thời gian đặt</th>
                                                <th style="min-width: 150px;">Tổng tiền</th>
                                                <th style="min-width: 140px;">Hình thức TT</th>
                                                <th style="min-width: 130px;" class="text-center">Trạng thái đơn</th>
                                                <th style="min-width: 110px;" class="text-center">Kho hồ sơ</th>
                                                <th style="width: 120px;" class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php if(!empty($orders)): ?>
                                            <?php $stt = 1; foreach ($orders as $ord): ?>
                                                <tr class="order-item-row">
                                                    <td class="text-center">
                                                        <span class="order-stt-badge"><?php echo $stt++; ?></span>
                                                    </td>
                                                    <td>
                                                        <a href="<?php echo base_url('admin/orders/detail/' . $ord['id']); ?>" class="order-code-link" title="Bấm xem chi tiết đơn hàng">
                                                            <b>#<?php echo htmlspecialchars($ord['orderCode']); ?></b>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <span class="date-badge">
                                                            <i class="fa fa-clock-o text-muted"></i> <?php echo !empty($ord['order_date']) ? date('d/m/Y H:i', strtotime($ord['order_date'])) : '--'; ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="order-money-pill">
                                                            <?php echo number_format($ord['money']); ?>₫
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if($ord['payment_method'] == 1): ?>
                                                            <span class="badge-payment badge-online"><i class="fa fa-credit-card"></i> Online</span>
                                                        <?php else: ?>
                                                            <span class="badge-payment badge-cod"><i class="fa fa-truck"></i> COD</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php
                                                            switch ($ord['status']) {
                                                                case '0':
                                                                    echo '<span class="status-order-pill status-pending"><i class="fa fa-hourglass-half"></i> Chờ duyệt</span>';
                                                                    break;
                                                                case '1':
                                                                    echo '<span class="status-order-pill status-shipping"><i class="fa fa-truck"></i> Đang giao</span>';
                                                                    break;
                                                                case '2':
                                                                    echo '<span class="status-order-pill status-delivered"><i class="fa fa-check-circle"></i> Đã giao</span>';
                                                                    break;
                                                                case '3':
                                                                    echo '<span class="status-order-pill status-cancelled"><i class="fa fa-user-times"></i> Khách hủy</span>';
                                                                    break;
                                                                case '4':
                                                                    echo '<span class="status-order-pill status-cancelled"><i class="fa fa-ban"></i> Đã hủy</span>';
                                                                    break;
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if(isset($ord['is_archive']) && $ord['is_archive'] == 1): ?>
                                                            <span class="badge-archive-tag"><i class="fa fa-archive"></i> Đã lưu trữ</span>
                                                        <?php else: ?>
                                                            <span class="badge-active-tag"><i class="fa fa-folder-open-o"></i> Đơn chính</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="<?php echo base_url('admin/orders/detail/' . $ord['id']); ?>" class="btn-action-view-order" title="Xem chi tiết đơn này">
                                                            <i class="fa fa-eye"></i> Xem đơn
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-5">
                                                    <div class="empty-orders-state">
                                                        <i class="fa fa-shopping-bag empty-icon"></i>
                                                        <h4>Khách hàng chưa phát sinh đơn hàng nào!</h4>
                                                        <p class="text-muted">Khi khách hàng đặt hàng qua website hoặc hotline, các đơn hàng sẽ được thống kê tự động tại đây.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- STYLES LUXURY CUSTOMER DETAIL -->
<style>
/* Background & Typography */
.content-wrapper {
    background-color: #f8fafc !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
}

/* Header Action Buttons */
.btn-modern-save {
    background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
    color: #ffffff !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    box-shadow: 0 3px 10px rgba(215, 0, 24, 0.25);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    cursor: pointer;
}
.btn-modern-save:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(215, 0, 24, 0.35);
}

.btn-modern-back {
    background: #ffffff;
    color: #475569 !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.03);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-modern-back:hover {
    background: #f1f5f9;
    color: #1e293b !important;
    border-color: #cbd5e1;
    transform: translateY(-1px);
}

/* KPI Summary Cards */
.kpi-cards-row {
    margin-bottom: 5px;
}
.kpi-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #edf2f7;
    padding: 16px 18px;
    display: flex;
    align-items: center;
    gap: 16px;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
    margin-bottom: 15px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.kpi-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
}
.kpi-icon-wrap {
    width: 52px;
    height: 52px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.icon-spent {
    background: #fef2f2;
    color: #dc2626;
}
.icon-orders {
    background: #eff6ff;
    color: #2563eb;
}
.icon-rank {
    background: #fefce8;
    color: #ca8a04;
}
.icon-status.status-active {
    background: #ecfdf5;
    color: #10b981;
}
.icon-status.status-locked {
    background: #fef2f2;
    color: #ef4444;
}
.kpi-body {
    display: flex;
    flex-direction: column;
    min-width: 0;
}
.kpi-label {
    font-size: 12px;
    color: #64748b;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
.kpi-value {
    font-size: 20px;
    font-weight: 800;
    margin: 3px 0 2px;
    letter-spacing: -0.5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.kpi-value small {
    font-size: 13px;
    font-weight: 500;
    color: #64748b;
}
.kpi-subtext {
    font-size: 11px;
    color: #94a3b8;
}

/* Card Structures */
.modern-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 3px 12px rgba(0, 0, 0, 0.03);
    overflow: hidden;
    height: 100%;
}
.card-header-clean {
    padding: 16px 20px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card-header-clean h3 {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 8px;
}
.card-body-clean {
    padding: 20px;
}

/* Privacy Note Box */
.privacy-note-box {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    padding: 12px 16px;
    display: flex;
    gap: 12px;
    align-items: flex-start;
    margin-bottom: 20px;
}
.privacy-note-box .note-icon {
    font-size: 18px;
    color: #16a34a;
    margin-top: 2px;
}
.privacy-note-box .note-content {
    font-size: 12.5px;
    color: #166534;
    line-height: 1.5;
}
.badge-privacy-tag {
    background: #f8fafc;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
}

/* Profile Info Grid */
.profile-info-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}
.profile-info-item {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 10px;
    padding: 12px 14px;
}
.profile-info-item.full-span {
    grid-column: span 2;
}
.info-label {
    font-size: 11.5px;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 4px;
    display: flex;
    align-items: center;
    gap: 5px;
}
.info-value {
    font-size: 14px;
    color: #1e293b;
}
.user-pill-tag {
    background: #e2e8f0;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
}
.contact-value-link {
    color: #0f172a;
    font-weight: 600;
    text-decoration: none;
    transition: color 0.15s ease;
}
.contact-value-link:hover {
    color: #d70018;
    text-decoration: underline;
}
.gender-tag {
    font-size: 12px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.gender-male {
    background: #eff6ff;
    color: #1d4ed8;
}
.gender-female {
    background: #fdf2f8;
    color: #be185d;
}

/* Avatar Hero in Right Column */
.customer-avatar-hero {
    display: flex;
    align-items: center;
    gap: 16px;
}
.avatar-hero-circle {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
    color: #ffffff;
    font-size: 26px;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 12px rgba(215, 0, 24, 0.25);
    flex-shrink: 0;
}
.avatar-hero-details {
    min-width: 0;
}
.avatar-fullname {
    font-size: 18px;
    font-weight: 800;
    color: #0f172a;
    margin: 0 0 3px;
}
.avatar-role-tag {
    font-size: 12px;
    color: #64748b;
    display: block;
    margin-bottom: 6px;
}
.avatar-badges {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}
.badge-rank-hero {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
    background: #fefce8;
    color: #a16207;
    border: 1px solid #fef08a;
}
.badge-status-hero {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 8px;
    border-radius: 6px;
}
.hero-active {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}
.hero-locked {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

/* Status Form */
.form-group-custom {
    margin-bottom: 16px;
}
.form-label-custom {
    font-size: 13px;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.select-wrapper {
    position: relative;
}
.form-control-custom {
    width: 100%;
    height: 42px;
    padding: 8px 14px;
    font-size: 13.5px;
    border-radius: 8px;
    border: 1.5px solid #cbd5e1;
    background: #ffffff;
    color: #1e293b;
    font-weight: 500;
    transition: all 0.2s ease;
}
.form-control-custom:focus {
    border-color: #d70018;
    outline: none;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.1);
}
.select-custom {
    appearance: none;
    cursor: pointer;
    padding-right: 36px;
}
.select-arrow {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    pointer-events: none;
}
.field-hint {
    font-size: 11.5px;
    color: #64748b;
    margin-top: 5px;
    display: block;
    line-height: 1.4;
}

.btn-modern-save-block {
    width: 100%;
    background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
    color: #ffffff;
    font-weight: 700;
    font-size: 13.5px;
    padding: 10px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 12px rgba(215, 0, 24, 0.25);
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-modern-save-block:hover {
    background: linear-gradient(135deg, #b91c1c 0%, #991b1b 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(215, 0, 24, 0.35);
}

.account-metric-list {
    margin-top: 20px;
    background: #f8fafc;
    border-radius: 10px;
    padding: 12px 14px;
    border: 1px solid #edf2f7;
}
.metric-row {
    display: flex;
    justify-content: space-between;
    padding: 6px 0;
    border-bottom: 1px dashed #e2e8f0;
    font-size: 12.5px;
}
.metric-row:last-child {
    border-bottom: none;
}
.metric-title {
    color: #64748b;
}

/* Orders Table */
.orders-count-badge {
    background: #fef2f2;
    color: #d70018;
    font-size: 12px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 6px;
    margin-left: 6px;
}
.btn-outline-custom {
    border: 1px solid #cbd5e1;
    background: #ffffff;
    color: #475569;
    font-weight: 600;
    font-size: 12px;
    padding: 5px 12px;
    border-radius: 6px;
    transition: all 0.15s ease;
}
.btn-outline-custom:hover {
    background: #f1f5f9;
    color: #0f172a;
    border-color: #94a3b8;
}

.modern-orders-table {
    margin-bottom: 0;
}
.modern-orders-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    border-bottom: 1px solid #e2e8f0;
    padding: 12px 16px;
}
.modern-orders-table tbody td {
    padding: 14px 16px;
    vertical-align: middle;
    border-bottom: 1px solid #f1f5f9;
    font-size: 13px;
}
.order-item-row:hover {
    background-color: #fbfcfe;
}
.order-stt-badge {
    background: #f1f5f9;
    color: #64748b;
    font-weight: 700;
    font-size: 11px;
    padding: 4px 8px;
    border-radius: 6px;
}
.order-code-link {
    color: #d70018;
    text-decoration: none;
    font-size: 13.5px;
    font-family: monospace;
}
.order-code-link:hover {
    text-decoration: underline;
    color: #b91c1c;
}
.order-money-pill {
    font-weight: 700;
    color: #d70018;
    font-size: 13.5px;
}

/* Payment badges */
.badge-payment {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 600;
}
.badge-online {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.badge-cod {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}

/* Status pills */
.status-order-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
}
.status-pending {
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
}
.status-shipping {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}
.status-delivered {
    background: #ecfdf5;
    color: #047857;
    border: 1px solid #a7f3d0;
}
.status-cancelled {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

.badge-archive-tag {
    background: #fffbeb;
    color: #b45309;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
    border: 1px solid #fde68a;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}
.badge-active-tag {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.btn-action-view-order {
    background: #f8fafc;
    color: #2563eb;
    border: 1px solid #cbd5e1;
    font-size: 12px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 6px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.btn-action-view-order:hover {
    background: #2563eb;
    color: #ffffff;
    border-color: #2563eb;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
}

/* Empty Orders State */
.empty-orders-state {
    padding: 40px 20px;
}
.empty-orders-state .empty-icon {
    font-size: 48px;
    color: #cbd5e1;
    margin-bottom: 12px;
}
.empty-orders-state h4 {
    font-size: 16px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 6px;
}

/* Toast Fixed */
.alert-toast-fixed {
    position: fixed !important;
    top: 65px !important;
    right: 25px !important;
    z-index: 99999 !important;
    min-width: 330px !important;
    max-width: 480px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18) !important;
    border-left: 5px solid #10b981 !important;
    background: #ffffff !important;
    border-radius: 12px !important;
    padding: 14px 20px !important;
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
    animation: toastSlideIn 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
}
@keyframes toastSlideIn {
    from {
        transform: translateX(110%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}
</style>

<script>
$(document).ready(function() {
    if ($('.alert-toast-fixed').length) {
        setTimeout(function() {
            $('.alert-toast-fixed').fadeOut(600, function() {
                $(this).remove();
            });
        }, 4000);
    }
});
</script>
