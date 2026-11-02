<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-trash-o text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thùng rác đánh giá & bình luận
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Khôi phục hoặc xóa dọn dẹp các phản hồi, nhận xét sản phẩm đã tạm xóa</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/reviews'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại danh sách đánh giá
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
                                        <th style="min-width: 220px;">Sản phẩm điện thoại</th>
                                        <th style="width: 200px;">Khách hàng nhận xét</th>
                                        <th style="width: 140px;" class="text-center">Số sao vote</th>
                                        <th style="min-width: 240px;">Nội dung đánh giá</th>
                                        <th style="width: 170px;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(!empty($list)): ?>
                                        <?php foreach ($list as $row): 
                                            $product = $this->Msanpham->product_detail_id($row['link']);
                                            $stars = (int)$row['title'];
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <span class="review-id-badge">#<?php echo $row['id']; ?></span>
                                            </td>
                                            <td>
                                                <div class="product-item-wrap">
                                                    <?php if(!empty($product['avatar'])): ?>
                                                        <img src="<?php echo base_url('public/images/products/'.$product['avatar']); ?>" class="product-mini-thumb" alt="Product">
                                                    <?php else: ?>
                                                        <div class="product-mini-thumb no-img"><i class="fa fa-mobile"></i></div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <b class="product-name-title">
                                                            <?php echo $product ? htmlspecialchars($product['name']) : 'Sản phẩm đã bị xóa (ID: '.$row['link'].')'; ?>
                                                        </b>
                                                        <?php if($product): ?>
                                                            <div class="product-price-sub"><?php echo number_format($product['price']); ?>₫</div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="reviewer-info-wrap">
                                                    <span class="reviewer-avatar-mini">
                                                        <?php echo !empty($row['fullname']) ? mb_strtoupper(mb_substr($row['fullname'], 0, 1, 'UTF-8')) : 'K'; ?>
                                                    </span>
                                                    <div>
                                                        <b class="reviewer-name"><?php echo htmlspecialchars($row['fullname']); ?></b>
                                                        <div class="reviewer-email text-muted"><?php echo htmlspecialchars($row['email']); ?></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="star-rating-box">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                        <?php if($i <= $stars): ?>
                                                            <i class="fa fa-star star-filled"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-star-o star-empty"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                    <span class="star-count-text">(<?php echo $stars; ?>/5)</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="review-content-bubble">
                                                    <i class="fa fa-quote-left quote-icon"></i>
                                                    <span class="review-text"><?php echo htmlspecialchars($row['content']); ?></span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="trash-action-btns">
                                                    <a class="btn btn-action-restore" href="<?php echo base_url('admin/reviews/restore/'.$row['id']); ?>" role="button" title="Khôi phục lại đánh giá này">
                                                        <i class="fa fa-undo"></i> Khôi phục
                                                    </a>
                                                    <a class="btn btn-action-delete" href="<?php echo base_url('admin/reviews/delete/'.$row['id']); ?>" role="button" title="Xóa vĩnh viễn" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn đánh giá #<?php echo $row['id']; ?>? Thao tác không thể hoàn tác!')">
                                                        <i class="fa fa-trash"></i> Xóa VV
                                                    </a>
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
                                                    <h4 style="margin: 12px 0 6px; font-weight: 700; color: #475569;">Thùng rác đánh giá hiện đang trống</h4>
                                                    <p style="color: #94a3b8; font-size: 13px; margin: 0 0 16px;">Không có nhận xét hoặc bình luận nào bị đưa vào thùng rác.</p>
                                                    <a href="<?php echo base_url('admin/reviews'); ?>" class="btn-goto-list">
                                                        <i class="fa fa-arrow-left"></i> Về danh sách đánh giá
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

    .review-id-badge {
        font-size: 11.5px;
        font-weight: 700;
        color: #94a3b8;
        background: #f1f5f9;
        padding: 3px 8px;
        border-radius: 6px;
    }

    /* Product mini wrap */
    .product-item-wrap {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .product-mini-thumb {
        width: 44px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
    }
    .product-mini-thumb.no-img {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 20px;
    }
    .product-name-title {
        color: #1e293b;
        font-size: 13.5px;
        display: block;
        line-height: 1.4;
    }
    .product-price-sub {
        font-size: 12px;
        color: var(--primary);
        font-weight: 600;
        margin-top: 2px;
    }

    /* Reviewer */
    .reviewer-info-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .reviewer-avatar-mini {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: #ffffff;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .reviewer-name {
        color: #1e293b;
        font-size: 13.5px;
    }
    .reviewer-email {
        font-size: 11.5px;
        margin-top: 1px;
    }

    /* Star rating */
    .star-rating-box {
        display: inline-flex;
        align-items: center;
        gap: 3px;
    }
    .star-filled {
        color: #f59e0b;
        font-size: 13px;
    }
    .star-empty {
        color: #cbd5e1;
        font-size: 13px;
    }
    .star-count-text {
        font-size: 11.5px;
        font-weight: 700;
        color: #64748b;
        margin-left: 4px;
    }

    /* Content bubble */
    .review-content-bubble {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        display: flex;
        align-items: flex-start;
        gap: 8px;
        max-width: 360px;
    }
    .quote-icon {
        color: #94a3b8;
        font-size: 12px;
        margin-top: 3px;
    }
    .review-text {
        font-size: 12.5px;
        color: #334155;
        line-height: 1.5;
        word-break: break-word;
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