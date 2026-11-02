<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-trash-o text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thùng rác nhà cung cấp
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Khôi phục hoặc xóa dọn dẹp các đối tác, nhà phân phối đã tạm xóa</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/producer'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách đối tác
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

                <div class="box box-solid box-modern-trash">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-trash-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;" class="text-center">STT</th>
                                        <th style="width: 130px;">Mã đối tác</th>
                                        <th style="min-width: 240px;">Tên nhà cung cấp</th>
                                        <th style="width: 170px;">Ngày tạo</th>
                                        <th style="width: 180px;" class="text-center">Thao tác</th>
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
                                        <?php foreach ($list as $val): ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="producer-id-badge"><?php echo $stt++; ?></span>
                                            </td>
                                            <td>
                                                <span class="code-pill">
                                                    <i class="fa fa-barcode"></i> <?php echo htmlspecialchars($val['code']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="producer-item-wrap">
                                                    <div class="producer-avatar-icon">
                                                        <i class="fa fa-building-o"></i>
                                                    </div>
                                                    <div>
                                                        <b class="producer-title-name"><?php echo htmlspecialchars($val['name']); ?></b>
                                                        <?php if(!empty($val['keyword'])): ?>
                                                            <div class="producer-keyword-sub"><?php echo htmlspecialchars($val['keyword']); ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="date-text">
                                                    <i class="fa fa-calendar-o"></i> <?php echo !empty($val['created_at']) ? date('d/m/Y H:i', strtotime($val['created_at'])) : '---'; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="trash-action-btns">
                                                    <a class="btn btn-action-restore" href="<?php echo base_url('admin/producer/restore/'.$val['id']); ?>" role="button" title="Khôi phục lại đối tác này">
                                                        <i class="fa fa-undo"></i> Khôi phục
                                                    </a>
                                                    <?php if($user['role'] == 1): ?>
                                                        <a class="btn btn-action-delete" href="<?php echo base_url('admin/producer/delete/'.$val['id']); ?>" role="button" title="Xóa vĩnh viễn" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn nhà cung cấp này? Thao tác không thể hoàn tác!')">
                                                            <i class="fa fa-trash"></i> Xóa VV
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="badge-no-perm"><i class="fa fa-lock"></i> Khóa</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center empty-trash-cell">
                                                <div class="empty-trash-content">
                                                    <div class="empty-trash-icon-wrap">
                                                        <i class="fa fa-trash-o"></i>
                                                    </div>
                                                    <h4 style="margin: 12px 0 6px; font-weight: 700; color: #475569;">Thùng rác đối tác hiện đang trống</h4>
                                                    <p style="color: #94a3b8; font-size: 13px; margin: 0 0 16px;">Không có nhà cung cấp nào bị tạm xóa.</p>
                                                    <a href="<?php echo base_url('admin/producer'); ?>" class="btn-goto-list">
                                                        <i class="fa fa-arrow-left"></i> Về danh sách đối tác
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <?php if(!empty($strphantrang)): ?>
                            <div class="pagination-footer">
                                <ul class="pagination pagination-modern">
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

    /* Box Modern Trash */
    .box-modern-trash {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-top: 10px;
    }

    /* Table Styles */
    .modern-trash-table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .modern-trash-table thead tr th {
        background: #fafbfc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        padding: 14px 16px;
        border-top: none;
        border-bottom: 1.5px solid #e2e8f0;
        vertical-align: middle;
    }
    .modern-trash-table tbody tr {
        transition: background-color 0.15s ease;
    }
    .modern-trash-table tbody tr:hover {
        background-color: #f8fafc;
    }
    .modern-trash-table tbody tr td {
        padding: 13px 16px;
        vertical-align: middle;
        border-top: 1px solid #f1f5f9;
        font-size: 13px;
        color: #334155;
    }

    .producer-id-badge {
        font-size: 11.5px;
        font-weight: 700;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .code-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-family: monospace;
        font-weight: 700;
        font-size: 12px;
        color: #0f172a;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 3px 8px;
        border-radius: 6px;
    }

    /* Producer Item Wrap */
    .producer-item-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .producer-avatar-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #eff6ff;
        color: #3b82f6;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        border: 1px solid #dbeafe;
    }
    .producer-title-name {
        color: #1e293b;
        font-size: 13.5px;
        display: block;
    }
    .producer-keyword-sub {
        font-size: 11.5px;
        color: #64748b;
        margin-top: 2px;
    }
    .date-text {
        font-size: 12px;
        color: #64748b;
    }

    /* Actions */
    .trash-action-btns {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }
    .btn-action-restore {
        background: #ecfdf5;
        color: #059669 !important;
        border: 1px solid #a7f3d0;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s ease;
    }
    .btn-action-restore:hover {
        background: #10b981;
        color: #ffffff !important;
        border-color: #10b981;
        transform: translateY(-1px);
    }

    .btn-action-delete {
        background: #fef2f2;
        color: #dc2626 !important;
        border: 1px solid #fee2e2;
        padding: 6px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s ease;
    }
    .btn-action-delete:hover {
        background: #dc2626;
        color: #ffffff !important;
        border-color: #dc2626;
        transform: translateY(-1px);
    }

    .badge-no-perm {
        font-size: 11px;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 4px 8px;
        border-radius: 6px;
    }

    /* Empty state */
    .empty-trash-cell {
        padding: 60px 20px !important;
    }
    .empty-trash-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .empty-trash-icon-wrap {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: #f8fafc;
        border: 2px dashed #cbd5e1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        color: #94a3b8;
    }
    .btn-goto-list {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff !important;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3);
        transition: all 0.2s ease;
    }
    .btn-goto-list:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45);
    }

    /* Phân trang */
    .pagination-footer {
        padding: 14px 20px;
        background: #fafbfc;
        border-top: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .pagination-modern {
        display: inline-flex;
        padding-left: 0;
        margin: 0;
        border-radius: 10px;
        gap: 4px;
    }
    .pagination-modern li {
        display: inline;
    }
    .pagination-modern li a,
    .pagination-modern li span {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 34px;
        height: 34px;
        padding: 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px !important;
        text-decoration: none;
        transition: all 0.2s ease;
    }
    .pagination-modern li.active span {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%) !important;
        color: #ffffff !important;
        border-color: #d70018 !important;
        box-shadow: 0 3px 8px rgba(215, 0, 24, 0.3);
    }
    .pagination-modern li a:hover {
        background-color: #f1f5f9;
        color: #d70018;
    }

    /* Alerts */
    .alert-modern {
        border-radius: 12px !important;
        padding: 12px 18px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        border: none !important;
        margin-bottom: 16px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    }
    .alert-success.alert-modern {
        background-color: #ecfdf5 !important;
        color: #065f46 !important;
        border-left: 4px solid #10b981 !important;
    }
    .alert-danger.alert-modern {
        background-color: #fef2f2 !important;
        color: #991b1b !important;
        border-left: 4px solid #ef4444 !important;
    }
</style>