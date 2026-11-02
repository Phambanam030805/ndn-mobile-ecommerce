<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-comments text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Quản lý Đánh giá & Bình luận
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Duyệt nhận xét, xếp hạng sao & phản hồi từ khách mua hàng</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/reviews/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Mreview->review_trash_count(); ?></b>)
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

                <!-- Toolbar: Tìm kiếm & Lọc số sao -->
                <div class="filter-card-wrapper">
                    <form action="<?php echo base_url('admin/reviews'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm tên khách hàng, email, nội dung bình luận..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/reviews' . ($star !== '' ? '?star='.$star : '')); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <div class="star-select-group">
                                <i class="fa fa-star filter-icon"></i>
                                <select name="star" class="form-control modern-select" onchange="this.form.submit()">
                                    <option value="">-- Tất cả số sao đánh giá --</option>
                                    <option value="5" <?php if(isset($star) && $star === '5') echo 'selected'; ?>>⭐⭐⭐⭐⭐ (5 sao)</option>
                                    <option value="4" <?php if(isset($star) && $star === '4') echo 'selected'; ?>>⭐⭐⭐⭐ (4 sao)</option>
                                    <option value="3" <?php if(isset($star) && $star === '3') echo 'selected'; ?>>⭐⭐⭐ (3 sao)</option>
                                    <option value="2" <?php if(isset($star) && $star === '2') echo 'selected'; ?>>⭐⭐ (2 sao)</option>
                                    <option value="1" <?php if(isset($star) && $star === '1') echo 'selected'; ?>>⭐ (1 sao)</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Lọc
                            </button>

                            <?php if(!empty($search) || $star !== ''): ?>
                                <a href="<?php echo base_url('admin/reviews'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> đánh giá
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Review Table Card -->
                <div class="box box-solid box-modern-review">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-review-table">
                                <thead>
                                    <tr>
                                        <th style="width: 55px;" class="text-center">STT</th>
                                        <th style="min-width: 200px;">Sản phẩm</th>
                                        <th style="min-width: 180px;">Khách hàng</th>
                                        <th style="width: 130px;" class="text-center">Xếp hạng</th>
                                        <th style="min-width: 240px;">Nội dung đánh giá</th>
                                        <th style="width: 150px;">Thời gian</th>
                                        <th style="width: 130px;" class="text-center">Trạng thái</th>
                                        <th style="width: 90px;" class="text-center">Thao tác</th>
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
                                        $product = $this->Msanpham->product_detail_id($row['link']);
                                        $stars = (int)$row['title'];
                                        if($stars < 1) $stars = 5;
                                        if($stars > 5) $stars = 5;

                                        $fullname = !empty($row['fullname']) ? $row['fullname'] : 'Khách hàng';
                                        $first_char = mb_substr($fullname, 0, 1, 'UTF-8');
                                    ?>
                                        <tr class="review-item-row">
                                            <td class="text-center">
                                                <span class="review-id-badge"><?php echo $stt++; ?></span>
                                            </td>

                                            <td>
                                                <div class="product-cell-wrap">
                                                    <?php if($product): ?>
                                                        <a href="<?php echo base_url('admin/product/update/' . $product['id']); ?>" class="product-name-link" title="<?php echo htmlspecialchars($product['name']); ?>">
                                                            <i class="fa fa-mobile-phone"></i> <?php echo htmlspecialchars($product['name']); ?>
                                                        </a>
                                                        <span class="product-sku">Mã SP: #<?php echo $product['id']; ?></span>
                                                    <?php else: ?>
                                                        <span class="product-deleted">
                                                            <i class="fa fa-info-circle"></i> Sản phẩm đã xóa (ID: <?php echo htmlspecialchars($row['link']); ?>)
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="reviewer-profile-cell">
                                                    <div class="reviewer-avatar">
                                                        <?php echo mb_strtoupper($first_char, 'UTF-8'); ?>
                                                    </div>
                                                    <div class="reviewer-info">
                                                        <span class="reviewer-name"><?php echo htmlspecialchars($fullname); ?></span>
                                                        <?php if(!empty($row['email'])): ?>
                                                            <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="reviewer-email">
                                                                <?php echo htmlspecialchars($row['email']); ?>
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <div class="stars-rating-wrap" title="<?php echo $stars; ?> sao">
                                                    <?php for($i=1; $i<=5; $i++): ?>
                                                        <?php if($i <= $stars): ?>
                                                            <i class="fa fa-star star-filled"></i>
                                                        <?php else: ?>
                                                            <i class="fa fa-star-o star-empty"></i>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                    <span class="star-number"><?php echo $stars; ?>.0</span>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="review-content-box">
                                                    <i class="fa fa-quote-left quote-icon"></i>
                                                    <span class="review-comment-text">
                                                        <?php 
                                                            // Bảo mật an toàn: Thoát toàn bộ ký tự XSS & mã script độc hại
                                                            $clean_content = strip_tags($row['content']);
                                                            echo htmlspecialchars($clean_content); 
                                                        ?>
                                                    </span>
                                                </div>
                                            </td>

                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa fa-clock-o"></i> 
                                                    <?php echo !empty($row['created_at']) ? date('d/m/Y H:i', strtotime($row['created_at'])) : '--'; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/reviews/status/' . $row['id']); ?>" 
                                                   class="status-toggle-badge <?php echo ($row['status'] == 1) ? 'is-active' : 'is-pending'; ?>"
                                                   title="Bấm để chuyển trạng thái duyệt / chờ duyệt">
                                                    <?php if($row['status'] == 1): ?>
                                                        <i class="fa fa-check-circle"></i> Đã duyệt
                                                    <?php else: ?>
                                                        <i class="fa fa-clock-o"></i> Chờ duyệt
                                                    <?php endif; ?>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/reviews/trash/' . $row['id']); ?>" 
                                                   onclick="return confirm('Chuyển đánh giá của [<?php echo htmlspecialchars(addslashes($fullname)); ?>] vào thùng rác?');" 
                                                   class="btn-action-pill btn-action-trash" 
                                                   title="Xóa đánh giá">
                                                    <i class="fa fa-trash"></i> Xóa
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <div class="empty-review-state">
                                                <i class="fa fa-comments-o empty-icon"></i>
                                                <h4>Không tìm thấy đánh giá nào!</h4>
                                                <p class="text-muted">Chưa có bình luận nào hoặc không khớp từ khóa tìm kiếm.</p>
                                                <?php if(!empty($search) || $star !== ''): ?>
                                                    <a href="<?php echo base_url('admin/reviews'); ?>" class="btn btn-modern-filter btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả đánh giá
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
                            <div class="review-pagination-footer">
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

<!-- 🎨 MODERN LUXURY REVIEWS ADMIN STYLES -->
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
    min-width: 300px;
    max-width: 420px;
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
.star-select-group {
    position: relative;
    min-width: 200px;
}
.filter-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #f59e0b;
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

/* Review Box Container */
.box-modern-review {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Review Table */
.modern-review-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-review-table thead th {
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
.modern-review-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.review-item-row:hover td {
    background-color: #fbfcfe;
}

/* ID Badge */
.review-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Product Link */
.product-cell-wrap {
    display: flex;
    flex-direction: column;
    gap: 3px;
}
.product-name-link {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b !important;
    text-decoration: none;
    transition: color 0.2s ease;
}
.product-name-link:hover {
    color: #d70018 !important;
}
.product-sku {
    font-size: 11.5px;
    color: #94a3b8;
    font-family: monospace;
}
.product-deleted {
    font-size: 12.5px;
    color: #94a3b8;
    font-style: italic;
}

/* Reviewer Profile */
.reviewer-profile-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}
.reviewer-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
    background: #fef3c7;
    color: #b45309;
    border: 1px solid #fde68a;
}
.reviewer-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.reviewer-name {
    font-size: 13.5px;
    font-weight: 600;
    color: #1e293b;
}
.reviewer-email {
    font-size: 12px;
    color: #64748b !important;
    text-decoration: none;
}
.reviewer-email:hover {
    color: #2563eb !important;
}

/* Star Rating */
.stars-rating-wrap {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    background: #fffbeb;
    padding: 4px 8px;
    border-radius: 20px;
    border: 1px solid #fef3c7;
}
.star-filled {
    color: #f59e0b;
    font-size: 13px;
}
.star-empty {
    color: #cbd5e1;
    font-size: 13px;
}
.star-number {
    font-size: 11.5px;
    font-weight: 700;
    color: #b45309;
    margin-left: 3px;
}

/* Comment Box */
.review-content-box {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    background: #f8fafc;
    border: 1px solid #f1f5f9;
    padding: 8px 12px;
    border-radius: 8px;
}
.quote-icon {
    font-size: 11px;
    color: #cbd5e1;
    margin-top: 3px;
}
.review-comment-text {
    font-size: 13px;
    color: #334155;
    line-height: 1.4;
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
.status-toggle-badge.is-pending {
    background: #fffbeb;
    color: #d97706;
    border: 1px solid #fde68a;
}
.status-toggle-badge.is-pending:hover {
    background: #d97706;
    color: #ffffff;
}

/* Action Button */
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
.empty-review-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-review-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.review-pagination-footer {
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