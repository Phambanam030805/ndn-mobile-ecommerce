<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-archive" style="color: #d97706; font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Lưu trữ đơn hàng
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Hồ sơ các đơn hàng đã được cất giữ lưu trữ</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/orders'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Về danh sách đơn hàng
            </a>
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/orders/recyclebin'); ?>" role="button">
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
                    <div class="alert alert-modern alert-toast-fixed">
                        <i class="fa fa-check-circle" style="font-size: 24px; color: #10b981;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; font-size: 14px; margin-bottom: 2px; color: #065f46;">Thành công!</strong>
                            <span style="font-size: 13px; color: #047857;"><?php echo $this->session->flashdata('success'); ?></span>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #64748b; font-size: 20px; opacity: 0.8;">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-modern alert-toast-fixed" style="border-left-color: #ef4444 !important;">
                        <i class="fa fa-exclamation-triangle" style="font-size: 24px; color: #ef4444;"></i>
                        <div style="flex: 1;">
                            <strong style="display: block; font-size: 14px; margin-bottom: 2px; color: #991b1b;">Thông báo lỗi!</strong>
                            <span style="font-size: 13px; color: #b91c1c;"><?php echo $this->session->flashdata('error'); ?></span>
                        </div>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="color: #64748b; font-size: 20px; opacity: 0.8;">&times;</button>
                    </div>
                <?php endif; ?>

                <!-- Toolbar: Tìm kiếm & Lọc trạng thái trong kho lưu trữ -->
                <div class="filter-card-wrapper">
                    <form action="<?php echo base_url('admin/orders/archive'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm mã đơn (Code), tên khách hàng, SĐT trong kho..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/orders/archive' . ($status !== '' ? '?status='.$status : '')); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <div class="status-select-group">
                                <i class="fa fa-filter filter-icon"></i>
                                <select name="status" class="form-control modern-select" onchange="this.form.submit()">
                                    <option value="">-- Tất cả trạng thái --</option>
                                    <option value="2" <?php if(isset($status) && $status === '2') echo 'selected'; ?>>✅ Đã giao thành công</option>
                                    <option value="3" <?php if(isset($status) && $status === '3') echo 'selected'; ?>>❌ Khách hàng đã hủy</option>
                                    <option value="4" <?php if(isset($status) && $status === '4') echo 'selected'; ?>>⛔ Nhân viên đã hủy</option>
                                    <option value="0" <?php if(isset($status) && $status === '0') echo 'selected'; ?>>⏳ Đang chờ duyệt</option>
                                    <option value="1" <?php if(isset($status) && $status === '1') echo 'selected'; ?>>🚚 Đang giao hàng</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Lọc
                            </button>

                            <?php if(!empty($search) || $status !== ''): ?>
                                <a href="<?php echo base_url('admin/orders/archive'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Đang lưu trữ: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> đơn hàng
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Order Archive Table Card -->
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
                                        <th style="width: 200px;" class="text-center">Thao tác</th>
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
                                        <tr class="order-item-row archive-item-row">
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
                                                <div class="action-btn-group">
                                                    <!-- Xem chi tiết -->
                                                    <a href="<?php echo base_url('admin/orders/detail/' . $val['id']); ?>" 
                                                       class="btn-action-pill btn-action-view" 
                                                       title="Xem chi tiết đơn hàng">
                                                        <i class="fa fa-eye"></i> Xem
                                                    </a>

                                                    <!-- Bỏ lưu trữ (Đưa về danh sách chính) -->
                                                    <a href="<?php echo base_url('admin/orders/unarchive/' . $val['id']); ?>" 
                                                       onclick="return confirm('Bỏ lưu trữ đơn hàng #<?php echo htmlspecialchars($order_code); ?> và đưa về danh sách chính?');" 
                                                       class="btn-action-pill btn-action-unarchive" 
                                                       title="Bỏ lưu trữ (Khôi phục về bảng đơn chính)">
                                                        <i class="fa fa-undo"></i> Bỏ lưu
                                                    </a>

                                                    <!-- Xóa vào thùng rác -->
                                                    <a href="<?php echo base_url('admin/orders/trash/' . $val['id']); ?>" 
                                                       onclick="return confirm('Chuyển đơn hàng lưu trữ #<?php echo htmlspecialchars($order_code); ?> vào Thùng rác?');" 
                                                       class="btn-action-pill btn-action-trash" 
                                                       title="Xóa vào thùng rác">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-order-state">
                                                <i class="fa fa-archive empty-icon" style="color: #cbd5e1;"></i>
                                                <h4>Kho lưu trữ đơn hàng hiện đang trống!</h4>
                                                <p class="text-muted">Các đơn hàng sau khi hoàn tất có thể được chuyển vào đây để lưu trữ dài hạn.</p>
                                                <a href="<?php echo base_url('admin/orders'); ?>" class="btn btn-modern-filter btn-sm" style="display:inline-block; margin-top:10px;">
                                                    <i class="fa fa-arrow-left"></i> Về danh sách đơn hàng chính
                                                </a>
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

<!-- 🎨 MODERN LUXURY ORDERS ARCHIVE STYLES -->
<style>
/* Header Action Buttons */
.btn-modern-back {
    background: #ffffff;
    color: #334155 !important;
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
.btn-modern-back:hover {
    background: #f8fafc;
    border-color: #94a3b8;
    transform: translateY(-1px);
}

.btn-modern-trash {
    background: #ffffff;
    color: #e74c3c !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 16px;
    border-radius: 8px;
    border: 1px solid #fbd5d5;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    transition: all 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 6px;
}
.btn-modern-trash:hover {
    background: #fff5f5;
    border-color: #e74c3c;
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
    max-width: 380px;
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
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13.5px;
    height: 38px;
    box-shadow: none;
    transition: all 0.2s ease;
}
.modern-search-input:focus {
    border-color: #d97706;
    box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
}
.clear-search {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 18px;
    text-decoration: none;
}
.status-select-group {
    position: relative;
    min-width: 200px;
}
.filter-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 13px;
    pointer-events: none;
}
.modern-select {
    padding-left: 32px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    font-size: 13px;
    height: 38px;
    box-shadow: none;
    background-color: #fff;
    cursor: pointer;
}
.btn-modern-filter {
    background: #d97706;
    color: #fff !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 18px;
    border-radius: 8px;
    border: none;
    height: 38px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    box-shadow: 0 3px 10px rgba(217, 119, 6, 0.25);
    transition: all 0.2s ease;
}
.btn-modern-filter:hover {
    background: #b45309;
    transform: translateY(-1px);
}
.btn-modern-reset {
    background: #f1f5f9;
    color: #475569 !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 14px;
    border-radius: 8px;
    border: 1px solid #cbd5e1;
    height: 38px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
}
.total-badge {
    background: #fffbeb;
    border: 1px solid #fde68a;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 13px;
    color: #b45309;
}
.total-badge b {
    color: #92400e;
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
.modern-order-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-order-table thead th {
    background: #f8fafc;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 14px;
    border-top: none;
    border-bottom: 2px solid #e2e8f0;
    vertical-align: middle;
}
.modern-order-table tbody td {
    padding: 13px 14px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13px;
    transition: background-color 0.15s ease;
}
.order-item-row:hover td {
    background-color: #fbfcfe;
}

/* Order Badges */
.order-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}
.order-code-pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-family: monospace;
    font-weight: 700;
    font-size: 12.5px;
    color: #b45309;
    background: #fffbeb;
    border: 1px solid #fde68a;
    padding: 4px 10px;
    border-radius: 6px;
    text-decoration: none !important;
}
.order-customer-wrap {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.customer-fullname {
    font-weight: 600;
    color: #1e293b;
    font-size: 13.5px;
}
.customer-address {
    font-size: 11.5px;
    color: #94a3b8;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}
.order-phone-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #059669;
    font-weight: 600;
    font-size: 12.5px;
    text-decoration: none !important;
}
.order-money-badge {
    font-weight: 700;
    color: #d70018;
    font-size: 13.5px;
}
.date-badge {
    font-size: 12px;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Status Badges */
.status-order-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 600;
    white-space: nowrap;
}
.status-pending { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
.status-shipping { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.status-delivered { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; }
.status-cancelled-client { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
.status-cancelled-admin { background: #fdf4ff; color: #c026d3; border: 1px solid #f5d0fe; }

/* Payment Badges */
.payment-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
}
.payment-cod { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
.payment-online { background: #faf5ff; color: #9333ea; border: 1px solid #e9d5ff; }

/* Action Buttons */
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
}
.btn-action-unarchive {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}
.btn-action-unarchive:hover {
    background: #16a34a;
    color: #fff;
    box-shadow: 0 3px 8px rgba(22, 163, 74, 0.25);
}
.btn-action-trash {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
    padding: 6px 9px;
}
.btn-action-trash:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 3px 8px rgba(220, 38, 38, 0.25);
}

/* Empty State */
.empty-order-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
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
.modern-pagination > .active > a, 
.modern-pagination > .active > span {
    background: #d97706 !important;
    border-color: #d97706 !important;
    color: #fff !important;
    box-shadow: 0 3px 10px rgba(217, 119, 6, 0.25);
}

/* Toast Notification */
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
