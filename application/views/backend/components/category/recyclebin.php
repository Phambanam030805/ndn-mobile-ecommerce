<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-trash-o text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thùng rác danh mục sản phẩm
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Khôi phục hoặc xóa dọn dẹp các danh mục / hãng điện thoại đã tạm xóa</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/category'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại danh mục
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
                                        <th style="min-width: 220px;">Tên danh mục loại sản phẩm</th>
                                        <th style="width: 200px;">Đường dẫn (Slug / Link)</th>
                                        <th style="width: 170px;">Thời gian tạo</th>
                                        <th style="width: 150px;">Người thực hiện</th>
                                        <th style="width: 180px;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($list)): ?>
                                        <?php foreach ($list as $val): 
                                            $name = $this->Mnguoidung->user_name($val['created_by']);
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="category-id-badge">#<?php echo $val['id']; ?></span>
                                            </td>
                                            <td>
                                                <div class="category-title-wrap">
                                                    <span class="category-name-text"><?php echo htmlspecialchars($val['name']); ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="slug-pill">
                                                    <i class="fa fa-link"></i> <?php echo htmlspecialchars($val['link']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-date">
                                                    <i class="fa fa-clock-o text-muted"></i> 
                                                    <?php echo !empty($val['created_at']) ? date('d/m/Y H:i', strtotime($val['created_at'])) : '---'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="trash-uploader">
                                                    <i class="fa fa-user-circle-o text-muted"></i>
                                                    <span><?php echo !empty($name) ? htmlspecialchars($name) : 'Hệ thống'; ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <!-- Nút Khôi phục -->
                                                    <a class="btn-action-restore" href="<?php echo base_url('admin/category/restore/' . $val['id']); ?>" 
                                                       title="Khôi phục loại sản phẩm này trở lại hệ thống">
                                                        <i class="fa fa-undo"></i> Khôi phục
                                                    </a>

                                                    <!-- Nút Xóa vĩnh viễn -->
                                                    <?php if($user['role'] == 1): ?>
                                                        <a class="btn-action-destroy" href="<?php echo base_url('admin/category/delete/' . $val['id']); ?>" 
                                                           onclick="return confirm('CẢNH BÁO: Bạn có chắc chắn muốn XÓA VĨNH VIỄN loại sản phẩm [<?php echo htmlspecialchars(addslashes($val['name'])); ?>]? Thao tác này KHÔNG thể hoàn tác!');" 
                                                           title="Xóa vĩnh viễn">
                                                            <i class="fa fa-trash"></i> Xóa VV
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="badge-lock" title="Chỉ Quản trị viên cấp cao mới có quyền xóa vĩnh viễn">
                                                            <i class="fa fa-lock"></i> Khóa
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center" style="padding: 50px 20px;">
                                                <div class="empty-trash-box">
                                                    <div class="empty-trash-icon-wrap">
                                                        <i class="fa fa-trash-o"></i>
                                                    </div>
                                                    <h3 style="font-size: 18px; font-weight: 700; color: #1e293b; margin: 12px 0 6px;">Thùng rác trống</h3>
                                                    <p style="font-size: 13.5px; color: #64748b; margin-bottom: 16px;">Hiện tại không có danh mục loại sản phẩm nào bị tạm xóa.</p>
                                                    <a href="<?php echo base_url('admin/category'); ?>" class="btn-goto-product">
                                                        <i class="fa fa-folder-open"></i> Xem danh mục sản phẩm
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang -->
                        <?php if(!empty($strphantrang)): ?>
                            <div class="pagination-footer">
                                <ul class="pagination-modern">
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
    /* Nút Quay lại Header */
    .btn-modern-back {
        background: #ffffff !important;
        color: #334155 !important;
        padding: 8px 16px !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05) !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        text-decoration: none !important;
    }
    .btn-modern-back:hover {
        background: #f8fafc !important;
        color: var(--primary) !important;
        border-color: #94a3b8 !important;
        transform: translateX(-2px);
    }

    /* Box Thùng rác */
    .box-modern-trash {
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden !important;
        background: #ffffff !important;
        margin-top: 15px !important;
    }

    /* Bảng thùng rác */
    .modern-trash-table {
        width: 100%;
        margin-bottom: 0 !important;
        border-collapse: separate;
        border-spacing: 0;
    }
    .modern-trash-table thead th {
        background: #f8fafc !important;
        color: #475569 !important;
        font-weight: 700 !important;
        font-size: 12.5px !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        padding: 14px 16px !important;
        border-bottom: 1.5px solid #e2e8f0 !important;
        border-top: none !important;
    }
    .modern-trash-table tbody td {
        padding: 14px 16px !important;
        vertical-align: middle !important;
        border-top: 1px solid #f1f5f9 !important;
        font-size: 13.5px !important;
    }
    .modern-trash-table tbody tr:hover td {
        background-color: #fafbfc !important;
    }

    .category-id-badge {
        font-weight: 700;
        color: #64748b;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 12px;
    }
    .category-name-text {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
    }
    .slug-pill {
        font-size: 12px;
        color: #475569;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 3px 8px;
        border-radius: 6px;
        font-family: monospace;
    }
    .text-date {
        font-size: 12.5px;
        color: #64748b;
    }
    .trash-uploader {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        color: #475569;
    }

    /* Nhóm nút thao tác */
    .action-btn-group {
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-action-restore {
        background: #ecfdf5 !important;
        color: #059669 !important;
        border: 1px solid #a7f3d0 !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none !important;
    }
    .btn-action-restore:hover {
        background: #059669 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(5, 150, 105, 0.25);
        transform: translateY(-1px);
    }

    .btn-action-destroy {
        background: #fef2f2 !important;
        color: #dc2626 !important;
        border: 1px solid #fecaca !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        font-size: 12.5px !important;
        font-weight: 700 !important;
        transition: all 0.2s ease !important;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none !important;
    }
    .btn-action-destroy:hover {
        background: #dc2626 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
        transform: translateY(-1px);
    }

    .badge-lock {
        background: #f1f5f9;
        color: #94a3b8;
        padding: 5px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    /* Trạng thái thùng rác trống */
    .empty-trash-box {
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
    .btn-goto-product {
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
    .btn-goto-product:hover {
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