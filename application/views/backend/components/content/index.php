<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-newspaper-o text-red"></i> Quản lý bài viết 
            <small>Danh sách tin tức & bài đánh giá công nghệ</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <a class="btn btn-modern-sync" href="<?php echo base_url('admin/content/sync_news'); ?>" role="button" title="Kích hoạt tự động quét và cào thêm bài viết mới nhất">
                <i class="fa fa-refresh"></i> Quét & Cập nhật tin tự động ngay
            </a>
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/content/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Mnoidung->content_trash_count('news'); ?></b>)
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

                <div class="box box-solid box-modern-content">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <?php 
                                $cur_page = isset($current) ? $current : (isset($this->phantrang) ? $this->phantrang->PageCurrent() : 1);
                                $stt = ($cur_page - 1) * 10 + 1;
                            ?>
                            <table class="table modern-content-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;" class="text-center">STT</th>
                                        <th style="width: 120px;" class="text-center">Hình ảnh</th>
                                        <th>Tiêu đề bài viết</th>
                                        <th style="width: 150px;">Ngày đăng</th>
                                        <th style="width: 120px;" class="text-center">Trạng thái</th>
                                        <th style="width: 140px;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($list)): ?>
                                    <?php foreach ($list as $row):
                                        // Xử lý link ảnh an toàn (URL báo mạng hoặc File cục bộ)
                                        $imgSrc = '';
                                        if (!empty($row['img'])) {
                                            if (strpos($row['img'], 'http://') === 0 || strpos($row['img'], 'https://') === 0) {
                                                $imgSrc = $row['img'];
                                            } else {
                                                $imgSrc = base_url('public/images/posts/' . $row['img']);
                                            }
                                        } else {
                                            $imgSrc = base_url('public/images/posts/default.png');
                                        }

                                        // Xử lý hiển thị tiêu đề giải mã HTML entities
                                        $cleanTitle = html_entity_decode($row['title'], ENT_QUOTES, 'UTF-8');
                                    ?>
                                        <tr>
                                            <td class="text-center" style="font-weight: 600; color: #64748b;">
                                                <?php echo $stt++; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="thumb-container">
                                                    <img src="<?php echo $imgSrc; ?>" 
                                                         alt="<?php echo htmlspecialchars($cleanTitle); ?>" 
                                                         class="modern-news-thumb"
                                                         onerror="this.onerror=null; this.src='<?php echo base_url('public/images/posts/default.png'); ?>';">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="article-title-wrap">
                                                    <a href="<?php echo base_url('admin/content/update/'.$row['id']); ?>" class="article-title-link" title="<?php echo htmlspecialchars($cleanTitle); ?>">
                                                        <?php echo $cleanTitle; ?>
                                                    </a>
                                                    <?php if(!empty($row['alias'])): ?>
                                                        <div class="article-slug">
                                                            <i class="fa fa-link"></i> <?php echo $row['alias']; ?>
                                                            <a href="<?php echo base_url('tin-tuc/'.$row['alias']); ?>" target="_blank" class="view-external-link" title="Xem trên website">
                                                                <i class="fa fa-external-link"></i>
                                                            </a>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-date">
                                                    <i class="fa fa-clock-o text-muted"></i> 
                                                    <?php echo !empty($row['created_at']) ? date('d/m/Y H:i', strtotime($row['created_at'])) : '---'; ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/content/status/'.$row['id']); ?>" 
                                                   class="status-toggle-link" 
                                                   title="<?php echo ($row['status'] == 1) ? 'Bấm để tắt hiển thị' : 'Bấm để hiển thị bài viết'; ?>">
                                                    <?php if($row['status'] == 1): ?>
                                                        <span class="badge-status-modern active">
                                                            <i class="fa fa-check-circle"></i> Hiển thị
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge-status-modern hidden-status">
                                                            <i class="fa fa-eye-slash"></i> Ẩn bài
                                                        </span>
                                                    <?php endif; ?>
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <a class="btn-action-edit" href="<?php echo base_url('admin/content/update/'.$row['id']); ?>" title="Chỉnh sửa bài viết">
                                                        <i class="fa fa-pencil"></i> Sửa
                                                    </a>
                                                    <a class="btn-action-delete" href="<?php echo base_url('admin/content/trash/'.$row['id']); ?>" onclick="return confirm('Bạn có chắc chắn muốn chuyển bài viết này vào thùng rác?');" title="Chuyển vào thùng rác">
                                                        <i class="fa fa-trash"></i> Xóa
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted" style="padding: 40px 0;">
                                            <i class="fa fa-newspaper-o" style="font-size: 36px; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                            Chưa có bài viết nào trong danh sách.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Phân trang hiện đại -->
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

<!-- 🎨 STYLE HIỆN ĐẠI DÀNH RIÊNG CHO TRANG TIN TỨC ADMIN -->
<style>
    /* Top Header Buttons */
    .btn-modern-sync {
        background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%) !important;
        color: #ffffff !important;
        padding: 8px 16px !important;
        border-radius: 10px !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(2, 132, 199, 0.3) !important;
        transition: all 0.25s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 7px !important;
        text-decoration: none !important;
    }
    .btn-modern-sync:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(2, 132, 199, 0.45) !important;
        color: #ffffff !important;
    }
    .btn-modern-sync i {
        transition: transform 0.4s ease;
    }
    .btn-modern-sync:hover i {
        transform: rotate(180deg);
    }

    .btn-modern-trash {
        background: #f1f5f9 !important;
        color: #475569 !important;
        padding: 8px 14px !important;
        border-radius: 10px !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        border: 1px solid #cbd5e1 !important;
        transition: all 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        margin-left: 8px !important;
    }
    .btn-modern-trash:hover {
        background: #e2e8f0 !important;
        color: #0f172a !important;
    }

    /* Box Wrapper */
    .box-modern-content {
        border-radius: 16px !important;
        border: 1px solid #e2e8f0 !important;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05) !important;
        overflow: hidden !important;
        background: #ffffff !important;
        margin-top: 15px !important;
    }

    /* Modern Table */
    .modern-content-table {
        width: 100%;
        margin-bottom: 0 !important;
        border-collapse: separate;
        border-spacing: 0;
    }
    .modern-content-table thead th {
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
    .modern-content-table tbody td {
        padding: 14px 16px !important;
        vertical-align: middle !important;
        border-top: 1px solid #f1f5f9 !important;
        font-size: 13.5px !important;
    }
    .modern-content-table tbody tr:hover td {
        background-color: #fafbfc !important;
    }

    /* Thumbnail Bài Viết (Khắc phục hoàn toàn ảnh vỡ / tỷ lệ sai) */
    .thumb-container {
        width: 100px;
        height: 64px;
        border-radius: 10px;
        overflow: hidden;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
    }
    .modern-news-thumb {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.3s ease;
    }
    .thumb-container:hover .modern-news-thumb {
        transform: scale(1.08);
    }

    /* Tiêu đề bài viết */
    .article-title-wrap {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .article-title-link {
        color: #0f172a !important;
        font-weight: 700 !important;
        font-size: 14px !important;
        text-decoration: none !important;
        line-height: 1.4 !important;
        transition: color 0.2s ease !important;
    }
    .article-title-link:hover {
        color: #d70018 !important;
    }
    .article-slug {
        font-size: 12px;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .view-external-link {
        color: #0284c7;
        margin-left: 4px;
        font-size: 11px;
    }
    .view-external-link:hover {
        color: #0369a1;
    }

    .text-date {
        font-size: 12.5px;
        color: #475569;
        font-weight: 500;
        white-space: nowrap;
    }

    /* Badge Trạng Thái */
    .status-toggle-link {
        text-decoration: none !important;
    }
    .badge-status-modern {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .badge-status-modern.active {
        background: #d1fae5;
        color: #047857;
    }
    .badge-status-modern.active:hover {
        background: #a7f3d0;
    }
    .badge-status-modern.hidden-status {
        background: #fee2e2;
        color: #b91c1c;
    }
    .badge-status-modern.hidden-status:hover {
        background: #fecaca;
    }

    /* Nhóm nút thao tác Sửa / Xóa */
    .action-btn-group {
        display: inline-flex;
        gap: 6px;
    }
    .btn-action-edit {
        background: #e0f2fe;
        color: #0369a1 !important;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-action-edit:hover {
        background: #0284c7;
        color: #ffffff !important;
        box-shadow: 0 3px 8px rgba(2, 132, 199, 0.3);
    }
    .btn-action-delete {
        background: #fee2e2;
        color: #b91c1c !important;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12.5px;
        font-weight: 600;
        text-decoration: none !important;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .btn-action-delete:hover {
        background: #dc2626;
        color: #ffffff !important;
        box-shadow: 0 3px 8px rgba(220, 38, 38, 0.3);
    }

    /* Alert Modern */
    .alert-modern {
        border-radius: 12px !important;
        border: none !important;
        font-size: 13.5px !important;
        font-weight: 500 !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        padding: 12px 18px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05) !important;
    }

    /* Phân trang */
    .pagination-footer {
        padding: 16px 20px;
        text-align: center;
        background: #f8fafc;
        border-top: 1px solid #f1f5f9;
    }
    .pagination-modern {
        margin: 0 !important;
    }
    .pagination-modern > li > a, 
    .pagination-modern > li > span {
        border-radius: 8px !important;
        margin: 0 4px !important;
        border: 1px solid #e2e8f0 !important;
        color: #334155 !important;
        font-weight: 600 !important;
        font-size: 13px !important;
        padding: 6px 12px !important;
    }
    .pagination-modern > .active > a, 
    .pagination-modern > .active > span {
        background: #d70018 !important;
        border-color: #d70018 !important;
        color: #ffffff !important;
        box-shadow: 0 3px 8px rgba(215, 0, 24, 0.3) !important;
    }
</style>
