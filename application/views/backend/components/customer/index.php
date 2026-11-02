<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-users text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Quản lý khách hàng
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Danh sách tài khoản thành viên & người mua hàng</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/customer/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Mkhachhang->customer_trash_count(); ?></b>)
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

                <!-- Toolbar: Tìm kiếm -->
                <div class="filter-card-wrapper">
                    <form action="<?php echo base_url('admin/customer'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm tên khách hàng, username, email, số điện thoại..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/customer'); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>

                            <?php if(!empty($search)): ?>
                                <a href="<?php echo base_url('admin/customer'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> khách hàng
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Customer Table Card -->
                <div class="box box-solid box-modern-customer">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-customer-table">
                                <thead>
                                    <tr>
                                        <th style="width: 55px;" class="text-center">STT</th>
                                        <th style="min-width: 220px;">Khách hàng</th>
                                        <th style="min-width: 170px;">Thông tin liên hệ</th>
                                        <th style="width: 140px;" class="text-center">Đơn hàng</th>
                                        <th style="min-width: 150px;">Tổng chi tiêu</th>
                                        <th style="width: 150px;">Ngày tham gia</th>
                                        <th style="width: 120px;" class="text-center">Trạng thái</th>
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
                                    <?php foreach ($list as $row): 
                                        $fullname = !empty($row['fullname']) ? $row['fullname'] : 'Khách vãng lai';
                                        $first_char = mb_substr($fullname, 0, 1, 'UTF-8');

                                        // Thống kê đơn hàng và chi tiêu của khách này
                                        $this->db->select('COUNT(id) as total_orders, SUM(money) as total_spent');
                                        $this->db->where('customer_id', $row['id']);
                                        $this->db->where('trash', 1);
                                        $order_stat = $this->db->get('orders')->row_array();
                                        $total_orders = !empty($order_stat['total_orders']) ? (int)$order_stat['total_orders'] : 0;
                                        $total_spent  = !empty($order_stat['total_spent']) ? (int)$order_stat['total_spent'] : 0;
                                    ?>
                                        <tr class="customer-item-row">
                                            <td class="text-center">
                                                <span class="customer-id-badge"><?php echo $stt++; ?></span>
                                            </td>

                                            <td>
                                                <div class="customer-profile-cell">
                                                    <div class="customer-avatar-box">
                                                        <?php echo mb_strtoupper($first_char, 'UTF-8'); ?>
                                                    </div>
                                                    <div class="customer-name-wrap">
                                                        <a href="<?php echo base_url('admin/customer/update/' . $row['id']); ?>" class="customer-fullname" title="Bấm xem hồ sơ khách hàng">
                                                            <?php echo htmlspecialchars($fullname); ?>
                                                        </a>
                                                        <?php if(!empty($row['username'])): ?>
                                                            <span class="customer-username">
                                                                <i class="fa fa-user-o"></i> <?php echo htmlspecialchars($row['username']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="customer-contact-list">
                                                    <?php if(!empty($row['phone'])): ?>
                                                        <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>" class="contact-phone-link" title="Bấm để gọi điện">
                                                            <i class="fa fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if(!empty($row['email'])): ?>
                                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="contact-email-link" title="Bấm để gửi email">
                                                            <i class="fa fa-envelope-o"></i> <?php echo htmlspecialchars($row['email']); ?>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted"><i class="fa fa-ban"></i> Chưa có email</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/orders?search=' . urlencode($row['phone'] ? $row['phone'] : $fullname)); ?>" 
                                                   class="orders-count-badge <?php echo ($total_orders > 0) ? 'has-orders' : 'zero-orders'; ?>" 
                                                   title="Bấm để xem lịch sử đơn hàng của khách">
                                                    <i class="fa fa-shopping-bag"></i> 
                                                    <span><b><?php echo $total_orders; ?></b> đơn</span>
                                                    <i class="fa fa-arrow-right view-arrow"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <?php if($total_spent > 0): ?>
                                                    <span class="spent-badge">
                                                        <?php echo number_format($total_spent); ?>₫
                                                    </span>
                                                <?php else: ?>
                                                    <span class="spent-zero">0₫</span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa fa-calendar-o"></i> 
                                                    <?php echo !empty($row['created_at']) ? date('d/m/Y', strtotime($row['created_at'])) : '--'; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="status-badge <?php echo ($row['status'] == 1) ? 'status-active' : 'status-locked'; ?>">
                                                    <?php if($row['status'] == 1): ?>
                                                        <i class="fa fa-check-circle"></i> Hoạt động
                                                    <?php else: ?>
                                                        <i class="fa fa-lock"></i> Đang khóa
                                                    <?php endif; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <!-- Xem/Sửa -->
                                                    <a href="<?php echo base_url('admin/customer/update/' . $row['id']); ?>" 
                                                       class="btn-action-pill btn-action-view" 
                                                       title="Xem và chỉnh sửa hồ sơ">
                                                        <i class="fa fa-pencil"></i> Sửa
                                                    </a>

                                                    <!-- Xóa -->
                                                    <a href="<?php echo base_url('admin/customer/trash/' . $row['id']); ?>" 
                                                       onclick="return confirm('Chuyển khách hàng [<?php echo htmlspecialchars(addslashes($fullname)); ?>] vào thùng rác?');" 
                                                       class="btn-action-pill btn-action-trash" 
                                                       title="Xóa vào thùng rác">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="empty-customer-state">
                                                <i class="fa fa-user-times empty-icon"></i>
                                                <h4>Không tìm thấy khách hàng nào!</h4>
                                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bấm làm mới.</p>
                                                <?php if(!empty($search)): ?>
                                                    <a href="<?php echo base_url('admin/customer'); ?>" class="btn btn-modern-filter btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả khách hàng
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
                            <div class="customer-pagination-footer">
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

<!-- 🎨 MODERN LUXURY CUSTOMER ADMIN STYLES -->
<style>
/* Header Action Buttons */
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
    min-width: 320px;
    max-width: 440px;
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

/* Customer Box Container */
.box-modern-customer {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Customer Table */
.modern-customer-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-customer-table thead th {
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
}
.modern-customer-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.customer-item-row:hover td {
    background-color: #fbfcfe;
}

/* ID Badge */
.customer-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Profile Cell */
.customer-profile-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}
.customer-avatar-box {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 15px;
    flex-shrink: 0;
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.customer-name-wrap {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.customer-fullname {
    font-size: 14.5px;
    font-weight: 600;
    color: #1e293b !important;
    text-decoration: none;
    transition: color 0.2s ease;
}
.customer-fullname:hover {
    color: #d70018 !important;
}
.customer-username {
    font-size: 11.5px;
    color: #94a3b8;
    font-family: monospace;
}

/* Contact List */
.customer-contact-list {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.contact-phone-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #16a34a !important;
    text-decoration: none;
}
.contact-phone-link:hover {
    text-decoration: underline !important;
}
.contact-email-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    color: #64748b !important;
    text-decoration: none;
}
.contact-email-link:hover {
    color: #2563eb !important;
}

/* Order Count Badge */
.orders-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12.5px;
    text-decoration: none !important;
    transition: all 0.25s ease;
}
.orders-count-badge.has-orders {
    background: #ecfeff;
    color: #0891b2;
    border: 1px solid #a5f3fc;
}
.orders-count-badge.has-orders:hover {
    background: #0891b2;
    color: #ffffff;
    box-shadow: 0 3px 10px rgba(8, 145, 178, 0.25);
    transform: translateY(-1px);
}
.orders-count-badge.has-orders:hover .view-arrow {
    transform: translateX(3px);
}
.orders-count-badge.zero-orders {
    background: #f8fafc;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
}
.view-arrow {
    font-size: 10px;
    transition: transform 0.2s ease;
}

/* Spent Badge */
.spent-badge {
    font-size: 14px;
    font-weight: 700;
    color: #d70018;
}
.spent-zero {
    font-size: 13px;
    color: #94a3b8;
}

/* Date Badge */
.date-badge {
    font-size: 12.5px;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.status-active {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}
.status-locked {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

/* Action Group */
.action-btn-group {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}
.btn-action-pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 6px 12px;
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
.btn-action-trash {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.btn-action-trash:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 3px 8px rgba(220, 38, 38, 0.25);
}

/* Empty State */
.empty-customer-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-customer-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.customer-pagination-footer {
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
