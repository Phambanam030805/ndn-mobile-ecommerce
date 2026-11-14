<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-mobile text-red" style="font-size: 26px; vertical-align: middle; margin-right: 6px;"></i> Quản lý sản phẩm
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Danh sách điện thoại & thiết bị di động</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0;">
            <?php if($user['role'] == 1): ?>
                <a class="btn btn-modern-add" href="<?php echo base_url('admin/product/insert'); ?>" role="button">
                    <i class="fa fa-plus-circle"></i> Thêm sản phẩm
                </a>
            <?php endif; ?>
            <a class="btn btn-modern-trash" href="<?php echo base_url('admin/product/recyclebin'); ?>" role="button">
                <i class="fa fa-trash-o"></i> Thùng rác (<b><?php echo (int)$this->Msanpham->product_trash_count(); ?></b>)
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

                <!-- Toolbar: Tìm kiếm & Bộ lọc -->
                <div class="filter-card-wrapper">
                    <form action="<?php echo base_url('admin/product'); ?>" method="GET" class="filter-form">
                        <div class="filter-left">
                            <div class="search-input-group">
                                <i class="fa fa-search search-icon"></i>
                                <input type="text" name="search" value="<?php echo htmlspecialchars(isset($search) ? $search : ''); ?>" placeholder="Tìm kiếm theo tên sản phẩm, mã ID..." class="form-control modern-search-input">
                                <?php if(!empty($search)): ?>
                                    <a href="<?php echo base_url('admin/product' . (!empty($catid) ? '?catid='.$catid : '')); ?>" class="clear-search" title="Xóa tìm kiếm">&times;</a>
                                <?php endif; ?>
                            </div>

                            <div class="category-select-group">
                                <i class="fa fa-filter filter-icon"></i>
                                <select name="catid" class="form-control modern-select" onchange="this.form.submit()">
                                    <option value="">-- Tất cả danh mục hãng --</option>
                                    <?php if(!empty($categories)): ?>
                                        <?php foreach($categories as $c): ?>
                                            <?php if($c['id'] == 3 || mb_strtolower(trim($c['name'])) === 'điện thoại') continue; ?>
                                            <option value="<?php echo $c['id']; ?>" <?php if(isset($catid) && $catid == $c['id']) echo 'selected'; ?>>
                                                <?php echo htmlspecialchars($c['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-modern-filter">
                                <i class="fa fa-search"></i> Lọc
                            </button>

                            <?php if(!empty($search) || !empty($catid)): ?>
                                <a href="<?php echo base_url('admin/product'); ?>" class="btn btn-modern-reset" title="Đặt lại bộ lọc">
                                    <i class="fa fa-refresh"></i> Làm mới
                                </a>
                            <?php endif; ?>
                        </div>

                        <div class="filter-right">
                            <span class="total-badge">
                                Tổng cộng: <b><?php echo isset($total) ? (int)$total : count($list); ?></b> sản phẩm
                            </span>
                        </div>
                    </form>
                </div>

                <!-- Product Table Card -->
                <div class="box box-solid box-modern-product">
                    <div class="box-body" style="padding: 0;">
                        <div class="table-responsive">
                            <table class="table modern-product-table">
                                <thead>
                                    <tr>
                                        <th style="width: 55px;" class="text-center">STT</th>
                                        <th style="width: 80px;" class="text-center">Hình ảnh</th>
                                        <th style="min-width: 220px;">Tên sản phẩm</th>
                                        <th style="min-width: 150px;">Giá bán</th>
                                        <th style="width: 100px;" class="text-center">Kho hàng</th>
                                        <th style="width: 90px;" class="text-center">Đã bán</th>
                                        <th style="width: 130px;">Hãng / Danh mục</th>
                                        <th style="width: 110px;" class="text-center">Trạng thái</th>
                                        <th style="width: 160px;" class="text-center">Thao tác</th>
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
                                        // Tính tồn kho
                                        $tonkho = (int)$row['number'] - (int)$row['number_buy'];
                                        if($tonkho < 0) $tonkho = 0;

                                        // Lấy tên danh mục
                                        $namecat = $this->Mdanhmuc->category_name($row['catid']);
                                        if(empty($namecat)) $namecat = 'Chưa phân loại';

                                        // Xử lý ảnh đại diện
                                        $avatar = !empty($row['avatar']) ? $row['avatar'] : '';
                                        $imgUrl = '';
                                        if (strpos($avatar, 'http://') === 0 || strpos($avatar, 'https://') === 0) {
                                            $imgUrl = $avatar;
                                        } elseif (!empty($avatar)) {
                                            $imgUrl = base_url('public/images/products/' . $avatar);
                                        } else {
                                            $imgUrl = base_url('public/images/icon-logo.png');
                                        }
                                    ?>
                                        <tr class="product-item-row">
                                            <td class="text-center">
                                                <span class="product-id-badge"><?php echo $stt++; ?></span>
                                            </td>
                                            
                                            <td class="text-center">
                                                <div class="product-thumb-container">
                                                    <img src="<?php echo $imgUrl; ?>" 
                                                         alt="<?php echo htmlspecialchars($row['name']); ?>" 
                                                         class="product-thumb-img"
                                                         onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=NDN+Phone';">
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <div class="product-title-wrap">
                                                    <a href="<?php echo base_url('admin/product/update/'.$row['id']); ?>" class="product-title-link" title="<?php echo htmlspecialchars($row['name']); ?>">
                                                        <?php echo htmlspecialchars($row['name']); ?>
                                                    </a>
                                                    <div class="product-meta-sub">
                                                        <?php if(!empty($row['color'])): ?>
                                                            <span class="meta-tag"><i class="fa fa-paint-brush"></i> <?php echo htmlspecialchars($row['color']); ?></span>
                                                        <?php endif; ?>
                                                        <?php if(!empty($row['capacity'])): ?>
                                                            <span class="meta-tag"><i class="fa fa-hdd-o"></i> <?php echo htmlspecialchars($row['capacity']); ?></span>
                                                        <?php endif; ?>
                                                        <span class="meta-code">SKU: NDN-<?php echo str_pad($row['id'], 4, '0', STR_PAD_LEFT); ?></span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td>
                                                <div class="product-price-box">
                                                    <?php if($row['price_sale'] > 0 && $row['price_sale'] < $row['price']): ?>
                                                        <div class="price-current"><?php echo number_format($row['price_sale']); ?>₫</div>
                                                        <div class="price-original">
                                                            <del><?php echo number_format($row['price']); ?>₫</del>
                                                            <?php 
                                                                $percent = round((($row['price'] - $row['price_sale']) / $row['price']) * 100);
                                                            ?>
                                                            <span class="sale-badge">-<?php echo $percent; ?>%</span>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="price-current"><?php echo number_format($row['price']); ?>₫</div>
                                                        <span class="price-regular-label">Giá niêm yết</span>
                                                    <?php endif; ?>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <?php if($tonkho <= 0): ?>
                                                    <span class="stock-badge stock-empty" title="Sản phẩm đã hết hàng">
                                                        <i class="fa fa-times-circle"></i> Hết hàng (0)
                                                    </span>
                                                <?php elseif($tonkho <= 5): ?>
                                                    <span class="stock-badge stock-warning" title="Sắp hết hàng trong kho!">
                                                        <i class="fa fa-warning"></i> Còn <?php echo $tonkho; ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="stock-badge stock-good" title="Tồn kho dồi dào">
                                                        <i class="fa fa-check"></i> <?php echo $tonkho; ?>
                                                    </span>
                                                <?php endif; ?>
                                            </td>

                                            <td class="text-center">
                                                <span class="sold-badge" title="Đã bán <?php echo (int)$row['number_buy']; ?> chiếc">
                                                    <i class="fa fa-shopping-bag"></i> <?php echo (int)$row['number_buy']; ?>
                                                </span>
                                            </td>

                                            <td>
                                                <span class="category-pill">
                                                    <i class="fa fa-tag"></i> <?php echo htmlspecialchars($namecat); ?>
                                                </span>
                                            </td>

                                            <td class="text-center">
                                                <a href="<?php echo base_url('admin/product/status/' . $row['id']); ?>" 
                                                   class="status-toggle-badge <?php echo ($row['status'] == 1) ? 'is-active' : 'is-hidden'; ?>"
                                                   title="Bấm để bật / tắt trạng thái hiển thị">
                                                    <?php if($row['status'] == 1): ?>
                                                        <i class="fa fa-check-circle"></i> Hiển thị
                                                    <?php else: ?>
                                                        <i class="fa fa-eye-slash"></i> Tạm ẩn
                                                    <?php endif; ?>
                                                </a>
                                            </td>

                                            <td class="text-center">
                                                <div class="action-btn-group">
                                                    <?php if($user['role'] == 1): ?>
                                                        <!-- Nhập hàng -->
                                                        <a href="<?php echo base_url('admin/product/import/'.$row['id']); ?>" 
                                                           class="btn-action-pill btn-action-import" 
                                                           title="Nhập thêm hàng vào kho">
                                                            <i class="fa fa-download"></i> Nhập
                                                        </a>

                                                        <!-- Sửa -->
                                                        <a href="<?php echo base_url('admin/product/update/'.$row['id']); ?>" 
                                                           class="btn-action-pill btn-action-edit" 
                                                           title="Chỉnh sửa thông tin">
                                                            <i class="fa fa-pencil"></i> Sửa
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-muted"><i class="fa fa-lock"></i> Khóa</span>
                                                    <?php endif; ?>

                                                    <!-- Xóa -->
                                                    <a href="<?php echo base_url('admin/product/trash/'.$row['id']); ?>" 
                                                       onclick="return confirm('Chuyển sản phẩm [<?php echo htmlspecialchars(addslashes($row['name'])); ?>] vào thùng rác?');" 
                                                       class="btn-action-pill btn-action-trash" 
                                                       title="Xóa vào thùng rác">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center py-5">
                                            <div class="empty-product-state">
                                                <i class="fa fa-inbox empty-icon"></i>
                                                <h4>Không tìm thấy sản phẩm nào!</h4>
                                                <p class="text-muted">Thử thay đổi từ khóa tìm kiếm hoặc chọn danh mục khác.</p>
                                                <?php if(!empty($search) || !empty($catid)): ?>
                                                    <a href="<?php echo base_url('admin/product'); ?>" class="btn btn-modern-add btn-sm" style="display:inline-block; margin-top:10px;">
                                                        <i class="fa fa-arrow-left"></i> Xem tất cả sản phẩm
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
                            <div class="product-pagination-footer">
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

<!-- 🎨 MODERN LUXURY PRODUCT ADMIN STYLES -->
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
.category-select-group {
    position: relative;
    min-width: 200px;
}
.filter-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
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

/* Product Box Container */
.box-modern-product {
    background: #ffffff;
    border-radius: 14px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
    margin-bottom: 30px;
}

/* Modern Product Table */
.modern-product-table {
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
}
.modern-product-table thead th {
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
.modern-product-table tbody td {
    padding: 14px 16px;
    vertical-align: middle !important;
    border-top: 1px solid #f1f5f9;
    color: #334155;
    font-size: 13.5px;
    transition: background-color 0.15s ease;
}
.product-item-row:hover td {
    background-color: #fbfcfe;
}

/* ID Badge */
.product-id-badge {
    display: inline-block;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
}

/* Thumbnail */
.product-thumb-container {
    width: 58px;
    height: 58px;
    border-radius: 10px;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.product-thumb-container:hover {
    transform: scale(1.08);
    box-shadow: 0 6px 14px rgba(0,0,0,0.12);
}
.product-thumb-img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 4px;
}

/* Title & Meta */
.product-title-wrap {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.product-title-link {
    font-size: 14.5px;
    font-weight: 600;
    color: #1e293b !important;
    text-decoration: none;
    line-height: 1.4;
    transition: color 0.2s ease;
}
.product-title-link:hover {
    color: #d70018 !important;
}
.product-meta-sub {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 2px;
}
.meta-tag {
    font-size: 11px;
    font-weight: 500;
    background: #f1f5f9;
    color: #475569;
    padding: 2px 7px;
    border-radius: 4px;
}
.meta-tag i {
    font-size: 10px;
    color: #64748b;
}
.meta-code {
    font-size: 11px;
    color: #94a3b8;
    font-family: monospace;
}

/* Price Box */
.product-price-box {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.price-current {
    font-size: 14.5px;
    font-weight: 700;
    color: #d70018;
}
.price-original {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #94a3b8;
}
.sale-badge {
    background: #ffebeb;
    color: #d70018;
    font-size: 10.5px;
    font-weight: 700;
    padding: 1px 5px;
    border-radius: 4px;
}
.price-regular-label {
    font-size: 11px;
    color: #94a3b8;
}

/* Stock Badges */
.stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}
.stock-good {
    background: #e6f9f0;
    color: #059669;
    border: 1px solid #bbf7d0;
}
.stock-warning {
    background: #fffbeb;
    color: #d97706;
    border: 1px solid #fde68a;
}
.stock-empty {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

/* Sold Badge */
.sold-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 12.5px;
    font-weight: 600;
    color: #3b82f6;
    background: #eff6ff;
    padding: 4px 10px;
    border-radius: 20px;
    border: 1px solid #dbeafe;
}

/* Category Pill */
.category-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    color: #334155;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
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
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
    border: none;
}
.btn-action-import {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}
.btn-action-import:hover {
    background: #16a34a;
    color: #fff;
    box-shadow: 0 3px 8px rgba(22, 163, 74, 0.25);
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
    padding: 6px 9px;
}
.btn-action-trash:hover {
    background: #dc2626;
    color: #fff;
    box-shadow: 0 3px 8px rgba(220, 38, 38, 0.25);
}

/* Empty State */
.empty-product-state {
    padding: 50px 20px;
}
.empty-icon {
    font-size: 54px;
    color: #cbd5e1;
    margin-bottom: 15px;
}
.empty-product-state h4 {
    font-weight: 700;
    color: #334155;
    margin-bottom: 8px;
}

/* Pagination */
.product-pagination-footer {
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
