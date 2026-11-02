<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-trash-o text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thùng rác thư liên hệ
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Khôi phục hoặc dọn dẹp các thư liên hệ & góp ý đã tạm xóa</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/contact'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại hộp thư liên hệ
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
                                        <th style="width: 60px;" class="text-center">ID</th>
                                        <th style="min-width: 170px;">Khách hàng</th>
                                        <th style="width: 180px;">Email / Hotline</th>
                                        <th style="width: 200px;">Tiêu đề thư</th>
                                        <th style="min-width: 220px;">Nội dung trích dẫn</th>
                                        <th style="width: 170px;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($list)): ?>
                                        <?php foreach ($list as $row): ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="contact-id-badge">#<?php echo $row['id']; ?></span>
                                            </td>
                                            <td>
                                                <div class="user-info-block">
                                                    <span class="user-avatar-mini">
                                                        <?php echo !empty($row['fullname']) ? mb_strtoupper(mb_substr($row['fullname'], 0, 1, 'UTF-8')) : 'K'; ?>
                                                    </span>
                                                    <b class="user-fullname"><?php echo htmlspecialchars($row['fullname']); ?></b>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-methods">
                                                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="email-link">
                                                        <i class="fa fa-envelope-o"></i> <?php echo htmlspecialchars($row['email']); ?>
                                                    </a>
                                                    <?php if(!empty($row['phone'])): ?>
                                                        <span class="phone-text"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($row['phone']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-title-pill">
                                                    <i class="fa fa-comment-o"></i>
                                                    <b><?php echo htmlspecialchars($row['title']); ?></b>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="contact-excerpt-text" title="<?php echo htmlspecialchars($row['content']); ?>">
                                                    <?php echo htmlspecialchars(mb_substr($row['content'], 0, 80, 'UTF-8')) . (mb_strlen($row['content'], 'UTF-8') > 80 ? '...' : ''); ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="trash-action-btns">
                                                    <a class="btn btn-action-restore" href="<?php echo base_url('admin/contact/restore/'.$row['id']); ?>" role="button" title="Khôi phục lại thư này về hộp thư đến">
                                                        <i class="fa fa-undo"></i> Khôi phục
                                                    </a>
                                                    <?php if($user['role'] == 1): ?>
                                                        <a class="btn btn-action-delete" href="<?php echo base_url('admin/contact/delete/'.$row['id']); ?>" role="button" title="Xóa vĩnh viễn" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn thư liên hệ #<?php echo $row['id']; ?>? Thao tác không thể hoàn tác!')">
                                                            <i class="fa fa-trash"></i> Xóa VV
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted" style="font-size: 11px;"><i class="fa fa-lock"></i> Khóa</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center empty-trash-cell">
                                                <div class="empty-trash-content">
                                                    <div class="empty-trash-icon-wrap">
                                                        <i class="fa fa-trash-o"></i>
                                                    </div>
                                                    <h4 style="margin: 12px 0 6px; font-weight: 700; color: #475569;">Thùng rác thư hiện đang trống</h4>
                                                    <p style="color: #94a3b8; font-size: 13px; margin: 0 0 16px;">Không có thư liên hệ nào bị đưa vào thùng rác.</p>
                                                    <a href="<?php echo base_url('admin/contact'); ?>" class="btn-goto-list">
                                                        <i class="fa fa-arrow-left"></i> Về danh sách liên hệ
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

    .contact-id-badge {
        font-size: 11.5px;
        font-weight: 700;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
    }

    .user-info-block {
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .user-avatar-mini {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff;
        font-size: 12px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .user-fullname {
        color: #1e293b;
        font-size: 13.5px;
    }

    .contact-methods {
        display: flex;
        flex-direction: column;
        gap: 3px;
        font-size: 12px;
    }
    .email-link {
        color: var(--primary) !important;
        text-decoration: none !important;
        font-weight: 500;
    }
    .email-link:hover {
        text-decoration: underline !important;
    }
    .phone-text {
        color: #64748b;
    }

    .contact-title-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #1e293b;
        font-size: 13px;
    }
    .contact-title-pill i {
        color: #64748b;
    }

    .contact-excerpt-text {
        font-size: 12.5px;
        color: #64748b;
        line-height: 1.5;
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