<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-ticket text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Quản lý mã giảm giá
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Chương trình ưu đãi voucher & coupon khuyến mãi</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <?php if($user['role'] == 1): ?>
                <a class="btn btn-modern-add" href="<?php echo base_url('admin/coupon/insert'); ?>" role="button">
                    <i class="fa fa-plus-circle"></i> Thêm mã giảm giá
                </a>
            <?php endif; ?>
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/coupon/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Mgiamgia->coupon_trash_count(); ?></b>)
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
                    <form action="<?php echo base_url('admin/coupon'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm kiếm theo mã coupon, mô tả ưu đãi..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/coupon'); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>

                            <?php if(!empty($search)): ?>
                                <a href="<?php echo base_url('admin/coupon'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> mã giảm giá
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Coupon Table Card -->
                <div class="box box-solid box-modern-coupon">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-coupon-table">
                                <thead>
                                    <tr>
                                        <th style="width: 55px;" class="text-center">STT</th>
                                        <th style="min-width: 170px;">Mã giảm giá</th>
                                        <th style="min-width: 130px;">Mức giảm</th>
                                        <th style="min-width: 150px;">Đơn tối thiểu</th>
                                        <th style="width: 150px;" class="text-center">Lượt sử dụng</th>
                                        <th style="width: 150px;">Hạn dùng</th>
                                        <th style="width: 120px;" class="text-center">Trạng thái</th>
                                        <th style="width: 150px;" class="text-center">Thao tác</th>
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
                                        $today_ts = strtotime(date('Y-m-d'));
                                        $exp_ts = !empty($row['expiration_date']) ? strtotime($row['expiration_date']) : 0;
                                        $is_expired = ($exp_ts > 0 && $exp_ts < $today_ts);

                                        $limit_num = (int)$row['limit_number'];
                                        $used_num = (int)$row['number_used'];
                                        $is_used_out = ($limit_num > 0 && $used_num >= $limit_num);
                                    ?>
                                        <tr class="coupon-item-row">
                                            <td class="text-center">
                                                <span class="coupon-id-badge"><?php echo $stt++; ?></span>
                                            </td>

                                            <td>
                                                <div class="coupon-code-wrap">
                                                    <span class="coupon-code-pill" onclick="navigator.clipboard.writeText('<?php echo htmlspecialchars($row['code']); ?>'); alert('Đã sao chép mã: <?php echo htmlspecialchars($row['code']); ?>');" title="Bấm để sao chép mã">
                                                        <i class="fa fa-ticket"></i> <?php echo htmlspecialchars($row['code']); ?>
                                                        <i class="fa fa-copy copy-icon"></i>
                                                    </span>
                                                    <?php if(!empty($row['description'])): ?>
                                                        <span class="coupon-desc-text" title="<?php echo htmlspecialchars($row['description']); ?>">
                                                            <?php echo htmlspecialchars($row['description']); ?>
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="discount-badge">
                                                    -<?php echo number_format($row['discount']); ?>₫
                                                </span>
                                            </td>

                                            <td>
                                                <?php if($row['payment_limit'] > 0): ?>
                                                    <span class="min-order-pill">
                                                        <i class="fa fa-shopping-cart"></i> Từ <?php echo number_format($row['payment_limit']); ?>₫
                                                    </span>
                                                <?php else: ?>
                                                    <span class="min-order-zero">
                                                        <i class="fa fa-check-circle-o"></i> Không giới hạn
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <?php if($row['orders'] == 1): ?>
                                                    <?php if($is_used_out): ?>
                                                        <span class="usage-badge usage-full" title="Đã hết lượt sử dụng">
                                                            <i class="fa fa-ban"></i> Đã hết (<?php echo $used_num; ?>/<?php echo $limit_num; ?>)
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="usage-badge usage-available" title="Đã dùng <?php echo $used_num; ?> trên tổng <?php echo $limit_num; ?> lượt">
                                                            <i class="fa fa-users"></i> <?php echo $used_num; ?> / <?php echo $limit_num; ?>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="usage-badge usage-auto" title="Mã cấp tự động cho từng khách">
                                                        <i class="fa fa-magic"></i> Tự động (<?php echo $used_num; ?>/<?php echo $limit_num; ?>)
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td>
                                                <?php if($is_expired): ?>
                                                    <span class="date-badge exp-out" title="Mã giảm giá đã quá hạn sử dụng">
                                                        <i class="fa fa-clock-o"></i> Đã hết hạn<br>
                                                        <small>(<?php echo date('d/m/Y', $exp_ts); ?>)</small>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="date-badge exp-valid" title="Hạn dùng đến ngày">
                                                        <i class="fa fa-calendar-check-o"></i> <?php echo date('d/m/Y', $exp_ts); ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/coupon/status/' . $row['id']); ?>" 
                                                   class="status-toggle-badge <?php echo ($row['status'] == 1 && !$is_expired) ? 'is-active' : 'is-hidden'; ?>"
                                                   title="Bấm để bật / tắt mã giảm giá">
                                                    <?php if($row['status'] == 1 && !$is_expired): ?>
                                                        <i class="fa fa-check-circle"></i> Hoạt động
                                                    <?php else: ?>
                                                        <i class="fa fa-pause-circle"></i> Tạm khóa
                                                    <?php endif; ?>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <?php if($user['role'] == 1): ?>
                                                        <a href="<?php echo base_url('admin/coupon/update/' . $row['id']); ?>" 
                                                           class="btn-action-pill btn-action-edit" 
                                                           title="Chỉnh sửa mã">
                                                            <i class="fa fa-pencil"></i> Sửa
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="<?php echo base_url('admin/coupon/trash/' . $row['id']); ?>" 
                                                       onclick="return confirm('Chuyển mã giảm giá [<?php echo htmlspecialchars(addslashes($row['code'])); ?>] vào thùng rác?');" 
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
                                            <div class="empty-coupon-state">
                                                <i class="fa fa-ticket empty-icon"></i>
                                                <h4>Không tìm thấy mã giảm giá nào!</h4>
                                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bấm làm mới.</p>
                                                <?php if(!empty($search)): ?>
                                                    <a href="<?php echo base_url('admin/coupon'); ?>" class="btn btn-modern-add btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả mã giảm giá
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
                            <div class="coupon-pagination-footer">
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

<!-- 🎨 MODERN LUXURY COUPON ADMIN STYLES -->
<style>
/* Header Action Buttons */
.btn-modern-add {
    background: linear-gradient(135deg, #d70018 0%, #b30013 100%);
    color: #fff !important;
    font-weight: 600;
    font-size: 13px;
    padding: 8px 18px;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(215, 0, 24, 0.25);
    border: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-right: 8px;
}
.btn-modern-add:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(215, 0, 24, 0.38);
    color: #fff !important;
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

/* Coupon Box Container */
.box-modern-coupon {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Coupon Table */
.modern-coupon-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-coupon-table thead th {
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
.modern-coupon-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.coupon-item-row:hover td {
    background-color: #fbfcfe;
}

/* ID Badge */
.coupon-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Coupon Code Pill */
.coupon-code-wrap {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.coupon-code-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fff1f2;
    border: 1px dashed #f43f5e;
    color: #e11d48;
    font-family: monospace;
    font-weight: 700;
    font-size: 13.5px;
    padding: 5px 12px;
    border-radius: 6px;
    cursor: pointer;
    width: fit-content;
    transition: all 0.2s ease;
}
.coupon-code-pill:hover {
    background: #e11d48;
    color: #ffffff;
    box-shadow: 0 3px 8px rgba(225, 29, 72, 0.25);
}
.coupon-code-pill:hover .copy-icon {
    opacity: 1;
}
.copy-icon {
    font-size: 11px;
    opacity: 0.6;
}
.coupon-desc-text {
    font-size: 11.5px;
    color: #94a3b8;
    max-width: 250px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Discount Badge */
.discount-badge {
    font-size: 14.5px;
    font-weight: 700;
    color: #d70018;
    background: #fff5f5;
    padding: 4px 10px;
    border-radius: 6px;
    border: 1px solid #fee2e2;
    display: inline-block;
}

/* Minimum Order Pill */
.min-order-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    color: #475569;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 4px 9px;
    border-radius: 6px;
}
.min-order-zero {
    font-size: 12px;
    color: #10b981;
    font-weight: 500;
}

/* Usage Badges */
.usage-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.usage-available {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.usage-full {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}
.usage-auto {
    background: #f5f3ff;
    color: #7c3aed;
    border: 1px solid #ddd6fe;
}

/* Date Badge */
.date-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
}
.exp-valid {
    color: #059669;
}
.exp-out {
    color: #dc2626;
}

/* Status Badge */
.status-toggle-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
}
.status-toggle-badge.is-active {
    background: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
}
.status-toggle-badge.is-active:hover {
    background: #059669;
    color: #ffffff;
}
.status-toggle-badge.is-hidden {
    background: #f1f5f9;
    color: #64748b;
    border: 1px solid #cbd5e1;
}
.status-toggle-badge.is-hidden:hover {
    background: #64748b;
    color: #ffffff;
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
.btn-action-edit {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.btn-action-edit:hover {
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
.empty-coupon-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-coupon-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.coupon-pagination-footer {
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
