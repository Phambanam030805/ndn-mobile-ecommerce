<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-shopping-cart text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Quản lý đơn hàng
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Theo dõi, xử lý và cập nhật tiến độ giao hàng</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-archive" href="<?php echo base_url('admin/orders/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o text-danger"></i> Thùng rác (<b><?php echo (int)$this->Mdonhang->orders_trash_count(); ?></b>)
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Flash Messages -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-modern">
                        <i class="fa fa-check-circle"></i>
                        <span><?php echo $this->session->flashdata('success'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-modern">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span><?php echo $this->session->flashdata('error'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Toolbar: Tìm kiếm & Lọc trạng thái -->
                <div class="filter-card-wrapper">
                    <form action="<?php echo base_url('admin/orders'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm mã đơn (Code), tên khách hàng, SĐT..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/orders' . ($status !== '' ? '?status='.$status : '')); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <div class="status-select-group">
                                <i class="fa fa-filter filter-icon"></i>
                                <select name="status" class="form-control modern-select" onchange="this.form.submit()">
                                    <option value="">-- Tất cả trạng thái đơn --</option>
                                    <option value="0" <?php if(isset($status) && $status === '0') echo 'selected'; ?>>⏳ Đang chờ duyệt</option>
                                    <option value="1" <?php if(isset($status) && $status === '1') echo 'selected'; ?>>🚚 Đang giao hàng</option>
                                    <option value="2" <?php if(isset($status) && $status === '2') echo 'selected'; ?>>✅ Đã giao thành công</option>
                                    <option value="3" <?php if(isset($status) && $status === '3') echo 'selected'; ?>>❌ Khách hàng đã hủy</option>
                                    <option value="4" <?php if(isset($status) && $status === '4') echo 'selected'; ?>>⛔ Nhân viên đã hủy</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Lọc
                            </button>

                            <?php if(!empty($search) || $status !== ''): ?>
                                <a href="<?php echo base_url('admin/orders'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> đơn hàng
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Order Table Card -->
                <div class="box box-solid box-modern-order">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-order-table">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;" class="text-center">STT</th>
                                        <th style="width: 130px;">Mã đơn (Code)</th>
                                        <th style="min-width: 180px;">Khách hàng</th>
                                        <th style="width: 140px;">Điện thoại</th>
                                        <th style="min-width: 140px;">Tổng thanh toán</th>
                                        <th style="width: 155px;">Thời gian đặt</th>
                                        <th style="width: 135px;" class="text-center">Trạng thái</th>
                                        <th style="width: 100px;" class="text-center">Hình thức</th>
                                        <th style="min-width: 200px;" class="text-center">Xử lý tiến độ</th>
                                        <th style="width: 140px;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($list)): ?>
                                    <?php 
                                        $page_arr = explode('/', uri_string());
                                        $last_seg = end($page_arr);
                                        $cur_page = is_numeric($last_seg) ? (int)$last_seg : 1;
                                        $stt = ($cur_page - 1) * 10 + 1;
                                    ?>
                                    <?php foreach ($list as $val): 
                                        $order_code = !empty($val['orderCode']) ? $val['orderCode'] : ('DH' . $val['id']);
                                    ?>
                                        <tr class="order-item-row">
                                            <td class="text-center">
                                                <span class="order-id-badge"><?php echo $stt++; ?></span>
                                            </td>
                                            <td>
                                                <a href="<?php echo base_url('admin/orders/detail/' . $val['id']); ?>" class="order-code-pill" title="Bấm xem chi tiết đơn hàng">
                                                    <i class="fa fa-hashtag"></i> <?php echo htmlspecialchars($order_code); ?>
                                                </a>
                                            </td>

                                            <td>
                                                <div class="order-customer-wrap">
                                                    <span class="customer-fullname"><?php echo htmlspecialchars($val['fullname']); ?></span>
                                                    <?php if(!empty($val['address'])): ?>
                                                        <span class="customer-address" title="<?php echo htmlspecialchars($val['address']); ?>">
                                                            <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars(mb_substr($val['address'], 0, 32, 'UTF-8')) . '...'; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td>
                                                <a href="tel:<?php echo htmlspecialchars($val['phone']); ?>" class="order-phone-link" title="Bấm để gọi khách hàng">
                                                    <i class="fa fa-phone"></i> <?php echo htmlspecialchars($val['phone']); ?>
                                                </a>
                                            </td>

                                            <td>
                                                <span class="order-money-badge">
                                                    <?php echo number_format($val['money']); ?>₫
                                                </span>
                                            </td>

                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa fa-clock-o"></i> 
                                                    <?php echo !empty($val['order_date']) ? date('d/m/Y H:i', strtotime($val['order_date'])) : '--'; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <?php
                                                    switch ($val['status']) {
                                                        case '0':
                                                            echo '<span class="status-order-badge status-pending"><i class="fa fa-hourglass-half"></i> Chờ duyệt</span>';
                                                            break;
                                                        case '1':
                                                            echo '<span class="status-order-badge status-shipping"><i class="fa fa-truck"></i> Đang giao</span>';
                                                            break;
                                                        case '2':
                                                            echo '<span class="status-order-badge status-delivered"><i class="fa fa-check-circle"></i> Đã giao</span>';
                                                            break;
                                                        case '3':
                                                            echo '<span class="status-order-badge status-cancelled-client"><i class="fa fa-user-times"></i> Khách hủy</span>';
                                                            break;
                                                        case '4':
                                                            echo '<span class="status-order-badge status-cancelled-admin"><i class="fa fa-ban"></i> Đã hủy</span>';
                                                            break;
                                                    }
                                                ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($val['payment_method'] == 0): ?>
                                                    <span class="payment-badge payment-cod" title="Thanh toán khi nhận hàng (COD)">
                                                        COD
                                                    </span>
                                                <?php else: ?>
                                                    <span class="payment-badge payment-online" title="Thanh toán trực tuyến (VNPAY/Chuyển khoản)">
                                                        <i class="fa fa-credit-card"></i> Online
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <div class="process-action-wrap">
                                                    <?php if($val['status'] == 0): ?>
                                                        <!-- Chờ duyệt -> Duyệt đơn -->
                                                        <a href="<?php echo base_url('admin/orders/status/' . $val['id']); ?>" 
                                                           class="btn-process-pill btn-process-approve" 
                                                           title="Duyệt đơn và chuyển sang trạng thái đang giao hàng">
                                                            <i class="fa fa-check-square-o"></i> Duyệt đơn
                                                        </a>
                                                        <a href="<?php echo base_url('admin/orders/cancelorder/' . $val['id']); ?>" 
                                                           onclick="return confirm('Xác nhận HỦY đơn hàng #<?php echo htmlspecialchars($order_code); ?>?');"
                                                           class="btn-process-pill btn-process-cancel" 
                                                           title="Hủy đơn hàng">
                                                            <i class="fa fa-times"></i> Hủy
                                                        </a>
                                                    <?php elseif($val['status'] == 1): ?>
                                                        <!-- Đang giao -> Xác nhận giao thành công -->
                                                        <a href="<?php echo base_url('admin/orders/status/' . $val['id']); ?>" 
                                                           class="btn-process-pill btn-process-complete" 
                                                           title="Xác nhận khách đã nhận hàng và hoàn tất thanh toán">
                                                            <i class="fa fa-thumbs-up"></i> Đã giao & Thu tiền
                                                        </a>
                                                        <a href="<?php echo base_url('admin/orders/cancelorder/' . $val['id']); ?>" 
                                                           onclick="return confirm('Xác nhận HỦY đơn hàng #<?php echo htmlspecialchars($order_code); ?>?');"
                                                           class="btn-process-pill btn-process-cancel" 
                                                           title="Hủy đơn hàng">
                                                            <i class="fa fa-times"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="process-done-tag">
                                                            <i class="fa fa-check"></i> Hoàn tất
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <!-- Xem chi tiết -->
                                                    <a href="<?php echo base_url('admin/orders/detail/' . $val['id']); ?>" 
                                                       class="btn-action-pill btn-action-view" 
                                                       title="Xem chi tiết đơn hàng & In hóa đơn">
                                                        <i class="fa fa-eye"></i> Xem
                                                    </a>

                                                    <!-- Lưu trữ / Chuyển vào thùng rác -->
                                                    <a href="<?php echo base_url('admin/orders/trash/' . $val['id']); ?>" 
                                                       onclick="return confirm('Chuyển đơn hàng #<?php echo htmlspecialchars($order_code); ?> vào danh sách đã lưu?');" 
                                                       class="btn-action-pill btn-action-archive" 
                                                       title="Lưu trữ đơn hàng">
                                                        <i class="fa fa-archive"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-order-state">
                                                <i class="fa fa-shopping-bag empty-icon"></i>
                                                <h4>Không tìm thấy đơn hàng nào!</h4>
                                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc lọc theo trạng thái khác.</p>
                                                <?php if(!empty($search) || $status !== ''): ?>
                                                    <a href="<?php echo base_url('admin/orders'); ?>" class="btn btn-modern-filter btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả đơn hàng
                                                    </a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Footer -->
                        <?php if(!empty($strphantrang)): ?>
                            <div class="order-pagination-footer">
                                <ul class="pagination modern-pagination">
                                    <?php echo $strphantrang; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<!-- 🎨 MODERN LUXURY ORDERS ADMIN STYLES -->
<style>
/* Header Action Buttons */
.btn-modern-archive {
    background: #ffffff;
    color: #475569 !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-modern-archive:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    transform: translateY(-1px);
}

/* Flash Alerts */
.alert-modern {
    border-radius: 10px;
    padding: 14px 20px;
    font-size: 14px;
    font-weight: 500;
    border: none;
    display: flex;
    align-items: center;
    gap: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.06);
    margin-bottom: 20px;
}
.alert-modern i {
    font-size: 20px;
}

/* Filter Card Toolbar */
.filter-card-wrapper {
    background: #ffffff;
    border-radius: 12px;
    padding: 16px 20px;
    margin-bottom: 20px;
    box-shadow: 0 3px 14px rgba(0,0,0,0.04);
    border: 1px solid #edf2f7;
}
.filter-form {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
}
.filter-left {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    flex: 1;
}
.search-input-group {
    position: relative;
    min-width: 280px;
    max-width: 360px;
    flex: 1;
}
.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 14px;
}
.modern-search-input {
    padding-left: 36px;
    padding-right: 32px;
    height: 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    transition: all 0.2s ease;
}
.modern-search-input:focus {
    border-color: #d70018;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12);
}
.clear-search {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 18px;
    color: #94a3b8;
    text-decoration: none !important;
}
.clear-search:hover {
    color: #e74c3c;
}
.status-select-group {
    position: relative;
    min-width: 220px;
}
.filter-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 13px;
    z-index: 2;
    pointer-events: none;
}
.modern-select {
    padding-left: 34px;
    height: 40px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    background-color: #fff;
    cursor: pointer;
    transition: all 0.2s ease;
}
.modern-select:focus {
    border-color: #d70018;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12);
}
.btn-modern-filter {
    background: #1e293b;
    color: #ffffff;
    height: 40px;
    padding: 0 16px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    border: none;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-modern-filter:hover {
    background: #0f172a;
    color: #fff;
}
.btn-modern-reset {
    background: #f1f5f9;
    color: #475569 !important;
    height: 40px;
    padding: 0 14px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 13px;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-modern-reset:hover {
    background: #e2e8f0;
    color: #1e293b !important;
}
.filter-right {
    display: flex;
    align-items: center;
}
.total-badge {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    color: #64748b;
}
.total-badge b {
    color: #d70018;
    font-weight: 700;
}

/* Order Box Container */
.box-modern-order {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Order Table */
.modern-order-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-order-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 16px;
    border-top: none;
    border-bottom: 2px solid #e2e8f0;
    vertical-align: middle;
    white-space: nowrap;
}
.modern-order-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.order-item-row:hover td {
    background-color: #fbfcfe;
}

/* Order STT Badge */
.order-id-badge {
    font-size: 11.5px;
    font-weight: 700;
    color: #64748b;
    background: #f1f5f9;
    padding: 3px 8px;
    border-radius: 6px;
    display: inline-block;
}

/* Order Code Pill */
.order-code-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-family: monospace;
    font-weight: 700;
    font-size: 13px;
    color: #0f172a !important;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    padding: 5px 10px;
    border-radius: 6px;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.order-code-pill:hover {
    background: #d70018;
    color: #ffffff !important;
    border-color: #d70018;
}

/* Customer Wrap */
.order-customer-wrap {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.customer-fullname {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
}
.customer-address {
    font-size: 11.5px;
    color: #94a3b8;
}

/* Phone Link */
.order-phone-link {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 13px;
    color: #059669 !important;
    font-weight: 600;
    text-decoration: none !important;
}
.order-phone-link:hover {
    text-decoration: underline !important;
}

/* Money Badge */
.order-money-badge {
    font-size: 14.5px;
    font-weight: 700;
    color: #d70018;
}

/* Date Badge */
.date-badge {
    font-size: 12.5px;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
}

/* Status Order Badges */
.status-order-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}
.status-pending {
    background: #fffbeb;
    color: #d97706;
    border: 1px solid #fde68a;
}
.status-shipping {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.status-delivered {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}
.status-cancelled-client {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #e2e8f0;
}
.status-cancelled-admin {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

/* Payment Method Badges */
.payment-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
}
.payment-cod {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
}
.payment-online {
    background: #fdf4ff;
    color: #a21caf;
    border: 1px solid #f0abfc;
}

/* Process Action Pills */
.process-action-wrap {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}
.btn-process-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: none;
}
.btn-process-approve {
    background: #10b981;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);
}
.btn-process-approve:hover {
    background: #059669;
    transform: translateY(-1px);
}
.btn-process-complete {
    background: #0ea5e9;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(14, 165, 233, 0.25);
}
.btn-process-complete:hover {
    background: #0284c7;
    transform: translateY(-1px);
}
.btn-process-cancel {
    background: #ffe4e6;
    color: #e11d48 !important;
    padding: 6px 9px;
}
.btn-process-cancel:hover {
    background: #e11d48;
    color: #fff !important;
}
.process-done-tag {
    font-size: 12px;
    color: #94a3b8;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

/* Action Group */
.action-btn-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    white-space: nowrap;
}
.btn-action-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 6px 11px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: none;
}
.btn-action-view {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.btn-action-view:hover {
    background: #2563eb;
    color: #fff;
    box-shadow: 0 3px 8px rgba(37, 99, 235, 0.25);
}
.btn-action-archive {
    background: #f8fafc;
    color: #64748b;
    border: 1px solid #cbd5e1;
    padding: 6px 9px;
}
.btn-action-archive:hover {
    background: #64748b;
    color: #fff;
    box-shadow: 0 3px 8px rgba(100, 116, 139, 0.25);
}

/* Empty State */
.empty-order-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-order-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.order-pagination-footer {
    padding: 16px 20px;
    border-top: 1px solid #f1f5f9;
    display: flex;
    justify-content: center;
    background: #fafbfc;
}
.modern-pagination {
    margin: 0;
}
.modern-pagination > li > a, 
.modern-pagination > li > span {
    border-radius: 8px !important;
    margin: 0 3px;
    border: 1px solid #e2e8f0;
    color: #334155;
    font-weight: 600;
    font-size: 13px;
    padding: 7px 14px;
    transition: all 0.2s ease;
}
.modern-pagination > li > a:hover {
    background-color: #f1f5f9;
    color: #d70018;
    border-color: #cbd5e1;
}
.modern-pagination > .active > a, 
.modern-pagination > .active > span {
    background: #d70018 !important;
    border-color: #d70018 !important;
    color: #fff !important;
    box-shadow: 0 3px 10px rgba(215, 0, 24, 0.25);
}
</style>
