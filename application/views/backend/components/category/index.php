<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-folder-open text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i> Quản lý loại sản phẩm
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Danh mục hãng điện thoại</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <?php if($user['role'] == 1): ?>
                <a class="btn btn-modern-add" href="<?php echo base_url('admin/category/insert'); ?>" role="button">
                    <i class="fa fa-plus-circle"></i> Thêm loại sản phẩm
                </a>
            <?php endif; ?>
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/category/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Mdanhmuc->category_trash_count(); ?></b>)
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Flash Messages: Hiển thị dạng Toast Notification nổi bật ở góc trên không bị che khuất -->
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

                <!-- Toolbar: Tìm kiếm -->
                <?php
                    $root_item = null;
                    $child_items = [];
                    if (!empty($list)) {
                        foreach ($list as $item) {
                            if ($item['id'] == 3 || ($item['parentid'] == 0 && $item['link'] == 'dien-thoai')) {
                                $root_item = $item;
                            } else {
                                $child_items[] = $item;
                            }
                        }
                    }
                ?>
                <div class="filter-card-wrapper">
                    <form action="<?php echo base_url('admin/category'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm tên danh mục, ID loại sản phẩm..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/category'); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Tìm kiếm
                            </button>

                            <?php if(!empty($search)): ?>
                                <a href="<?php echo base_url('admin/category'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo count($child_items); ?></b> thương hiệu con<?php echo (!empty($root_item)) ? ' (+1 gốc)' : ''; ?>
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Category Table Card -->
                <div class="box box-solid box-modern-category">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-category-table">
                                <thead>
                                    <tr>
                                        <th style="width: 75px;" class="text-center">STT</th>
                                        <th style="min-width: 220px;">Tên loại sản phẩm</th>
                                        <th style="width: 170px;" class="text-center">Số sản phẩm</th>
                                        <th style="min-width: 160px;">Danh mục cha</th>
                                        <th style="width: 170px;">Ngày tạo</th>
                                        <th style="width: 120px;" class="text-center">Trạng thái</th>
                                        <th style="width: 150px;" class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($root_item) || !empty($child_items)): ?>
                                    
                                    <!-- 1. HÀNG GHIM ĐẶC BIỆT: DANH MỤC GỐC HỆ THỐNG (ĐẦU TIÊN, KHÔNG ĐỂ SỐ THỨ TỰ) -->
                                    <?php if(!empty($root_item)): 
                                        $count_child = (int)$this->Mdanhmuc->category_count_parentid($root_item['id']);
                                    ?>
                                        <tr class="category-pinned-root-row">
                                            <td class="text-center">
                                                <span class="category-root-badge" title="Danh mục gốc hệ thống (Không dùng số thứ tự)">
                                                    <i class="fa fa-star"></i> GỐC
                                                </span>
                                            </td>

                                            <td>
                                                <div class="category-name-cell">
                                                    <span class="category-icon-box is-system-root-icon" title="Danh mục gốc cốt lõi hệ thống">
                                                        <i class="fa fa-shield"></i>
                                                    </span>
                                                    <div class="category-name-info">
                                                        <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap;">
                                                            <span class="category-title-static" style="font-size: 15.5px; font-weight: 700; color: #b45309;">
                                                                <?php echo htmlspecialchars($root_item['name']); ?>
                                                            </span>
                                                            <span class="badge-system-root-tag"><i class="fa fa-lock"></i> Danh mục gốc hệ thống</span>
                                                        </div>
                                                        <?php if(!empty($root_item['link'])): ?>
                                                            <span class="category-slug">slug: <?php echo htmlspecialchars($root_item['link']); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <span class="system-branches-badge" title="Cây danh mục gốc chứa <?php echo $count_child; ?> thương hiệu điện thoại con trực thuộc">
                                                    <i class="fa fa-sitemap"></i> <b><?php echo $count_child; ?></b> thương hiệu con
                                                </span>
                                            </td>

                                            <td>
                                                <span class="parent-badge parent-root-system">
                                                    <i class="fa fa-cube"></i> Cấp cao nhất
                                                </span>
                                            </td>

                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa fa-calendar-o"></i> 
                                                    <?php echo !empty($root_item['created_at']) ? date('d/m/Y H:i', strtotime($root_item['created_at'])) : '--'; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="status-system-fixed" title="Danh mục gốc luôn ở trạng thái hoạt động mặc định">
                                                    <i class="fa fa-check-circle"></i> Mặc định
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <span class="btn-action-system-locked" title="Danh mục gốc hệ thống được bảo vệ cố định (Không sửa / Không xóa)">
                                                    <i class="fa fa-lock"></i> Cố định
                                                </span>
                                            </td>
                                        </tr>

                                        <!-- DÒNG PHÂN CÁCH TIỂU MỤC TÁCH BIỆT RÕ RÀNG KHỎI CÁC DANH MỤC CON -->
                                        <tr class="category-section-divider-row">
                                            <td colspan="7">
                                                <div class="category-section-divider-content">
                                                    <div class="divider-left">
                                                        <i class="fa fa-level-down text-primary"></i>
                                                        <span>DANH SÁCH THƯƠNG HIỆU ĐIỆN THOẠI TRỰC THUỘC</span>
                                                        <span class="sub-counter-badge"><?php echo count($child_items); ?> thương hiệu con</span>
                                                    </div>
                                                    <div class="divider-right">
                                                        <small class="text-muted"><i class="fa fa-sort-numeric-asc"></i> Đánh số thứ tự độc lập từ 1</small>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <!-- 2. DANH SÁCH CÁC THƯƠNG HIỆU CON (ĐÁNH SỐ THỨ TỰ BẮT ĐẦU TỪ 1) -->
                                    <?php 
                                        $page_arr = explode('/', uri_string());
                                        $last_seg = end($page_arr);
                                        $cur_page = is_numeric($last_seg) ? (int)$last_seg : 1;
                                        $stt = ($cur_page - 1) * 20 + 1;
                                    ?>
                                    <?php foreach ($child_items as $row):
                                        $catid = $this->Mdanhmuc->category_parentid($row['id']);
                                        $parent_name = $this->Mdanhmuc->category_name_parent($catid);
                                        $count_prod = (int)$this->Msanpham->product_count_parentid($row['id']);
                                    ?>
                                        <tr class="category-item-row">
                                            <td class="text-center">
                                                <span class="category-id-badge"><?php echo $stt++; ?></span>
                                            </td>

                                            <td>
                                                <div class="category-name-cell">
                                                    <span class="category-icon-box is-child-icon">
                                                        <i class="fa fa-mobile"></i>
                                                    </span>
                                                    <div class="category-name-info">
                                                        <a href="<?php echo base_url('admin/category/update/' . $row['id']); ?>" class="category-title-link" title="Bấm để chỉnh sửa">
                                                            <?php echo htmlspecialchars($row['name']); ?>
                                                        </a>
                                                        <?php if(!empty($row['link'])): ?>
                                                            <span class="category-slug">slug: <?php echo htmlspecialchars($row['link']); ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/product?catid=' . $row['id']); ?>" 
                                                   class="product-count-badge <?php echo ($count_prod > 0) ? 'has-products' : 'zero-products'; ?>" 
                                                   title="Bấm để xem danh sách <?php echo $count_prod; ?> sản phẩm thuộc <?php echo htmlspecialchars($row['name']); ?>">
                                                    <i class="fa fa-cubes"></i> 
                                                    <span><b><?php echo $count_prod; ?></b> máy</span>
                                                    <i class="fa fa-arrow-right view-arrow"></i>
                                                </a>
                                            </td>

                                            <td>
                                                <span class="parent-badge parent-child">
                                                    <i class="fa fa-level-up fa-rotate-90"></i> <?php echo htmlspecialchars($parent_name); ?>
                                                </span>
                                            </td>

                                            <td>
                                                <span class="date-badge">
                                                    <i class="fa fa-calendar-o"></i> 
                                                    <?php echo !empty($row['created_at']) ? date('d/m/Y H:i', strtotime($row['created_at'])) : '--'; ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/category/status/' . $row['id']); ?>" 
                                                   class="status-toggle-badge <?php echo ($row['status'] == 1) ? 'is-active' : 'is-hidden'; ?>"
                                                   title="Bấm để chuyển đổi trạng thái hiển thị">
                                                    <?php if($row['status'] == 1): ?>
                                                        <i class="fa fa-check-circle"></i> Hoạt động
                                                    <?php else: ?>
                                                        <i class="fa fa-eye-slash"></i> Tạm ẩn
                                                    <?php endif; ?>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <?php if($user['role'] == 1): ?>
                                                        <a href="<?php echo base_url('admin/category/update/' . $row['id']); ?>" 
                                                           class="btn-action-pill btn-action-edit" 
                                                           title="Chỉnh sửa loại sản phẩm">
                                                            <i class="fa fa-pencil"></i> Sửa
                                                        </a>
                                                    <?php endif; ?>

                                                    <a href="<?php echo base_url('admin/category/trash/' . $row['id']); ?>" 
                                                       onclick="return confirm('Chuyển danh mục [<?php echo htmlspecialchars(addslashes($row['name'])); ?>] vào thùng rác?');" 
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
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-category-state">
                                                <i class="fa fa-folder-open-o empty-icon"></i>
                                                <h4>Không tìm thấy loại sản phẩm nào!</h4>
                                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc bấm làm mới.</p>
                                                <?php if(!empty($search)): ?>
                                                    <a href="<?php echo base_url('admin/category'); ?>" class="btn btn-modern-add btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả danh mục
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
                            <div class="category-pagination-footer">
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

<!-- 🎨 MODERN LUXURY CATEGORY ADMIN STYLES -->
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

/* Category Box Container */
.box-modern-category {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Category Table */
.modern-category-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-category-table thead th {
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
.modern-category-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.category-item-row:hover td {
    background-color: #fbfcfe;
}

/* ID Badge */
.category-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Name Cell */
.category-name-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}
.category-icon-box {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.category-icon-box.is-child-icon {
    background: #eff6ff;
    color: #2563eb;
    border: 1px solid #bfdbfe;
}
.category-icon-box.is-parent-icon {
    background: #fef3c7;
    color: #d97706;
    border: 1px solid #fde68a;
}
.category-name-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.category-title-link {
    font-size: 15px;
    font-weight: 600;
    color: #1e293b !important;
    text-decoration: none;
    transition: color 0.2s ease;
}
.category-title-link:hover {
    color: #d70018 !important;
}
.category-slug {
    font-size: 11px;
    color: #94a3b8;
    font-family: monospace;
}

/* Product Count Badge */
.product-count-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12.5px;
    text-decoration: none !important;
    transition: all 0.25s ease;
}
.product-count-badge.has-products {
    background: #ecfeff;
    color: #0891b2;
    border: 1px solid #a5f3fc;
}
.product-count-badge.has-products:hover {
    background: #0891b2;
    color: #ffffff;
    box-shadow: 0 3px 10px rgba(8, 145, 178, 0.25);
    transform: translateY(-1px);
}
.product-count-badge.has-products:hover .view-arrow {
    transform: translateX(3px);
}
.product-count-badge.zero-products {
    background: #f8fafc;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
}
.view-arrow {
    font-size: 10px;
    transition: transform 0.2s ease;
}

/* Parent Category Badges */
.parent-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 6px;
}
.parent-root {
    background: #fefce8;
    color: #b45309;
    border: 1px solid #fef08a;
}
.parent-child {
    background: #f1f5f9;
    color: #334155;
    border: 1px solid #e2e8f0;
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

/* System Root Category Highlight & Protection Styling */
.category-pinned-root-row td {
    background: #fffdf5 !important;
    border-bottom: 2px solid #fde68a !important;
    padding: 16px 16px !important;
    vertical-align: middle !important;
}
.category-pinned-root-row:hover td {
    background-color: #fefce8 !important;
}
.category-pinned-root-row td:first-child {
    border-left: 5px solid #f59e0b !important;
}

.category-root-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    color: #ffffff;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 800;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 6px rgba(217, 119, 6, 0.25);
    text-transform: uppercase;
}

.category-section-divider-row td {
    background: #f8fafc !important;
    padding: 10px 16px !important;
    border-top: 1px solid #e2e8f0 !important;
    border-bottom: 2px solid #e2e8f0 !important;
}
.category-section-divider-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.category-section-divider-content .divider-left {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    color: #334155;
    font-weight: 700;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.category-section-divider-content .sub-counter-badge {
    background: #e2e8f0;
    color: #475569;
    padding: 2px 8px;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 600;
    text-transform: none;
}
.category-section-divider-content .divider-right small {
    font-size: 11.5px;
    color: #64748b;
}

.category-item-row.is-system-root-row td {
    background-color: #fffdf5 !important;
}
.category-item-row.is-system-root-row:hover td {
    background-color: #fefce8 !important;
}
.category-item-row.is-system-root-row td:first-child {
    border-left: 4px solid #f59e0b;
}

.category-icon-box.is-system-root-icon {
    background: #fef3c7;
    color: #d97706;
    border: 1px solid #fde68a;
    box-shadow: 0 2px 6px rgba(217, 119, 6, 0.15);
}

.category-title-static {
    font-size: 15px;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: -0.2px;
}

.badge-system-root-tag {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    padding: 2px 8px;
    background: #fffbeb;
    color: #b45309;
    border: 1px solid #fde68a;
    border-radius: 4px;
    font-size: 10.5px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.system-branches-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    background: #fff7ed;
    color: #c2410c;
    border: 1px solid #ffedd5;
    border-radius: 20px;
    font-size: 12.5px;
    font-weight: 600;
    cursor: default;
}
.system-branches-badge b {
    color: #9a3412;
    font-weight: 700;
}

.parent-badge.parent-root-system {
    background: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
    font-weight: 700;
}

.status-system-fixed {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    background: #f1f5f9;
    color: #475569;
    border: 1px solid #cbd5e1;
    cursor: default;
    user-select: none;
}
.status-system-fixed i {
    color: #10b981;
}

.btn-action-system-locked {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    background: #f8fafc;
    color: #94a3b8;
    border: 1px solid #e2e8f0;
    cursor: not-allowed;
    user-select: none;
}

/* Empty State */
.empty-category-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-category-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.category-pagination-footer {
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

/* Toast Notification nổi bật ở góc trên không bị thanh cố định che khuất */
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
