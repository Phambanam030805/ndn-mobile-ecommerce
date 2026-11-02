<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-truck text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Quản lý nhà cung cấp
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Đối tác phân phối & đại lý nguồn hàng</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <?php if($user['role'] == 1): ?>
                <a class="btn btn-modern-add" href="<?php echo base_url('admin/producer/insert'); ?>" role="button">
                    <i class="fa fa-plus-circle"></i> Thêm nhà cung cấp
                </a>
            <?php endif; ?>
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/producer/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Mnhacungcap->producer_trash_count(); ?></b>)
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
                    <form action="<?php echo base_url('admin/producer'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm tên nhà cung cấp, mã code..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/producer'); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>

                            <?php if(!empty($search)): ?>
                                <a href="<?php echo base_url('admin/producer'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> nhà cung cấp
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Producer Table Card -->
                <div class="box box-solid box-modern-producer">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-producer-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;" class="text-center">STT</th>
                                        <th style="width: 140px;">Mã đối tác</th>
                                        <th style="min-width: 240px;">Tên nhà cung cấp</th>
                                        <th style="width: 170px;">Ngày tạo</th>
                                        <th style="width: 130px;" class="text-center">Trạng thái</th>
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
                                    <?php foreach ($list as $row): ?>
                                        <tr class="producer-item-row">
                                            <td class="text-center">
                                                <span class="producer-id-badge"><?php echo $stt++; ?></span>
                                            </td>

                                            <td>
                                                <span class="code-pill">
                                                    <i class="fa fa-barcode"></i> <?php echo htmlspecialchars($row['code']); ?>
                                                </span>
                                            </td>

                                            <td>
                                                <div class="producer-name-cell">
                                                    <div class="producer-avatar-icon">
                                                        <i class="fa fa-building-o"></i>
                                                    </div>
                                                    <div class="producer-info-wrap">
                                                        <a href="<?php echo base_url('admin/producer/update/' . $row['id']); ?>" class="producer-name-link" title="Bấm để chỉnh sửa">
                                                            <?php echo htmlspecialchars($row['name']); ?>
                                                        </a>
                                                        <?php if(!empty($row['keyword'])): ?>
                                                            <span class="producer-tags" title="Từ khóa lĩnh vực">
                                                                <i class="fa fa-tags"></i> <?php echo htmlspecialchars($row['keyword']); ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa fa-calendar-o"></i> 
                                                    <?php echo !empty($row['created_at']) ? date('d/m/Y H:i', strtotime($row['created_at'])) : '--'; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/producer/status/' . $row['id']); ?>" 
                                                   class="status-toggle-badge <?php echo ($row['status'] == 1) ? 'is-active' : 'is-hidden'; ?>"
                                                   title="Bấm để chuyển đổi trạng thái hợp tác">
                                                    <?php if($row['status'] == 1): ?>
                                                        <i class="fa fa-check-circle"></i> Đang hợp tác
                                                    <?php else: ?>
                                                        <i class="fa fa-pause-circle"></i> Tạm ngưng
                                                    <?php endif; ?>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <?php if($user['role'] == 1): ?>
                                                        <a href="<?php echo base_url('admin/producer/update/' . $row['id']); ?>" 
                                                           class="btn-action-pill btn-action-edit" 
                                                           title="Chỉnh sửa thông tin">
                                                            <i class="fa fa-pencil"></i> Sửa
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="<?php echo base_url('admin/producer/trash/' . $row['id']); ?>" 
                                                       onclick="return confirm('Chuyển nhà cung cấp [<?php echo htmlspecialchars(addslashes($row['name'])); ?>] vào thùng rác?');" 
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
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-producer-state">
                                                <i class="fa fa-truck empty-icon"></i>
                                                <h4>Không tìm thấy nhà cung cấp nào!</h4>
                                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bấm làm mới.</p>
                                                <?php if(!empty($search)): ?>
                                                    <a href="<?php echo base_url('admin/producer'); ?>" class="btn btn-modern-add btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả nhà cung cấp
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
                            <div class="producer-pagination-footer">
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

<!-- 🎨 MODERN LUXURY PRODUCER ADMIN STYLES -->
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

/* Producer Box Container */
.box-modern-producer {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Producer Table */
.modern-producer-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-producer-table thead th {
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
.modern-producer-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.producer-item-row:hover td {
    background-color: #fbfcfe;
}

/* ID Badge */
.producer-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Code Pill */
.code-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #475569;
    font-family: monospace;
    font-weight: 700;
    font-size: 12px;
    padding: 4px 10px;
    border-radius: 6px;
}

/* Name Cell */
.producer-name-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}
.producer-avatar-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}
.producer-info-wrap {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.producer-name-link {
    font-size: 15px;
    font-weight: 600;
    color: #1e293b !important;
    text-decoration: none;
    transition: color 0.2s ease;
}
.producer-name-link:hover {
    color: #d70018 !important;
}
.producer-tags {
    font-size: 11.5px;
    color: #94a3b8;
}

/* Date Badge */
.date-badge {
    font-size: 12.5px;
    color: #64748b;
    display: inline-flex;
    align-items: center;
    gap: 6px;
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
.empty-producer-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-producer-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.producer-pagination-footer {
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
