<?php echo form_open_multipart('admin/product/update/'.$row['id']); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-pencil-square-o text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Cập nhật sản phẩm
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Chỉnh sửa thông số, giá bán & hình ảnh điện thoại: <b><?php echo htmlspecialchars($row['name']); ?></b></small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-floppy-o"></i> Lưu thay đổi
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/product'); ?>" role="button">
                <i class="fa fa-times"></i> Hủy bỏ
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-modern">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span><?php echo $this->session->flashdata('error'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if(validation_errors()): ?>
                    <div class="alert alert-danger alert-modern">
                        <i class="fa fa-exclamation-triangle"></i>
                        <div><?php echo validation_errors(); ?></div>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Cột trái (Thông tin chính & Mô tả) -->
                    <div class="col-lg-8 col-md-7">
                        <!-- Card 1: Thông tin cơ bản -->
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-info-circle"></i> Thông tin cơ bản</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Tên sản phẩm điện thoại <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-custom" name="name" id="product_name" placeholder="Ví dụ: iPhone 17 Pro Max 256GB..." value="<?php echo htmlspecialchars(set_value('name', $row['name'])); ?>" required>
                                    <?php if(form_error('name')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('name'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Hãng / Danh mục <span class="text-danger">*</span></label>
                                            <div class="select-wrapper">
                                                <select name="catid" class="form-control-custom select-custom" required>
                                                    <option value="">-- Chọn danh mục hãng --</option>
                                                    <?php if(!empty($listcat)): ?>
                                                        <?php foreach ($listcat as $r): ?>
                                                            <option value="<?php echo $r['id']; ?>" <?php echo ($r['id'] == $row['catid']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($r['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <i class="fa fa-chevron-down select-arrow"></i>
                                            </div>
                                            <?php if(form_error('catid')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('catid'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Nhà cung cấp phân phối <span class="text-danger">*</span></label>
                                            <div class="select-wrapper">
                                                <select name="producer" class="form-control-custom select-custom" required>
                                                    <option value="">-- Chọn nhà cung cấp --</option>
                                                    <?php if(!empty($listproducer)): ?>
                                                        <?php foreach ($listproducer as $r): ?>
                                                            <option value="<?php echo $r['id']; ?>" <?php echo ($r['id'] == $row['producer']) ? 'selected' : ''; ?>>
                                                                <?php echo htmlspecialchars($r['name']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>
                                                <i class="fa fa-chevron-down select-arrow"></i>
                                            </div>
                                            <?php if(form_error('producer')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('producer'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Mô tả ngắn (Hiển thị đầu trang sản phẩm & SEO)</label>
                                    <textarea name="sortDesc" class="form-control-custom" rows="3" placeholder="Tóm tắt điểm nổi bật: Chip xử lý, công nghệ camera, thời lượng pin..."><?php echo htmlspecialchars(set_value('sortDesc', $row['sortDesc'])); ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Nội dung chi tiết & Đánh giá cấu hình -->
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-file-text-o"></i> Bài viết đánh giá & Chi tiết cấu hình</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom" style="margin-bottom: 0;">
                                    <textarea name="detail" id="detail" class="form-control"><?php echo set_value('detail', $row['detail']); ?></textarea>
                                    <script>CKEDITOR.replace('detail');</script>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải (Thiết lập giá, Số lượng kho, Hình ảnh, Trạng thái) -->
                    <div class="col-lg-4 col-md-5">
                        
                        <!-- Card 3: Giá bán & Chiết khấu -->
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-tag"></i> Thiết lập giá & Kho hàng</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Giá niêm yết gốc (VNĐ) <span class="text-danger">*</span></label>
                                    <div class="input-currency-wrapper">
                                        <input name="price_root" id="price_root" class="form-control-custom price-input" type="number" value="<?php echo set_value('price_root', $row['price']); ?>" min="0" step="10000" required oninput="calcSalePrice()">
                                        <span class="currency-label">₫</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Khuyến mãi (%)</label>
                                            <div class="input-currency-wrapper">
                                                <input name="sale_of" id="sale_of" class="form-control-custom" type="number" value="<?php echo set_value('sale_of', $row['sale']); ?>" min="0" max="99" oninput="calcSaleFromPercent()">
                                                <span class="currency-label">%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Số lượng tồn kho</label>
                                            <input class="form-control-custom" type="text" value="<?php echo max(0, $row['number'] - $row['number_buy']); ?> máy" disabled style="background: #f8fafc; color: #10b981; font-weight: 700; cursor: not-allowed;">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Đã bán thực tế</label>
                                            <input class="form-control-custom" type="text" value="<?php echo (int)$row['number_buy']; ?> máy" disabled style="background: #f8fafc; color: #64748b; font-weight: 600; cursor: not-allowed;">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Tổng nhập kho</label>
                                            <input class="form-control-custom" type="text" value="<?php echo (int)$row['number']; ?> máy" disabled style="background: #f8fafc; color: #475569; font-weight: 600; cursor: not-allowed;">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Giá bán thực tế (Sau giảm) <span class="text-danger">*</span></label>
                                    <div class="input-currency-wrapper">
                                        <input name="price_buy" id="price_buy" class="form-control-custom price-input highlight-price" type="number" value="<?php echo set_value('price_buy', $row['price_sale']); ?>" min="0" step="10000" required oninput="calcPercentFromPrice()">
                                        <span class="currency-label">₫</span>
                                    </div>
                                    <?php if(form_error('price_buy')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('price_buy'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-custom" style="margin-bottom: 0;">
                                    <label class="form-label-custom">Trạng thái kinh doanh</label>
                                    <div class="select-wrapper">
                                        <select name="status" class="form-control-custom select-custom">
                                            <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>Đang kinh doanh (Mở bán)</option>
                                            <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>Tạm ngưng kinh doanh</option>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 4: Hình ảnh sản phẩm -->
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-picture-o"></i> Hình ảnh đại diện & Thư viện ảnh</h3>
                            </div>
                            <div class="card-body-styled">
                                <!-- Ảnh đại diện chính -->
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Ảnh đại diện chính</label>
                                    <div class="file-upload-zone" onclick="document.getElementById('avatar_input').click()">
                                        <input type="file" id="avatar_input" name="img" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                                        <div id="avatar_preview_box" class="avatar-preview-box">
                                            <?php if(!empty($row['avatar']) && file_exists(FCPATH . 'public/images/products/' . $row['avatar'])): ?>
                                                <img src="<?php echo base_url('public/images/products/' . $row['avatar']); ?>" style="max-height: 140px; max-width: 100%; object-fit: contain; border-radius: 8px; margin-bottom: 6px;">
                                                <span style="font-size: 11.5px; color: #2563eb; font-weight: 700;"><i class="fa fa-refresh"></i> Nhấp để thay đổi ảnh mới</span>
                                            <?php else: ?>
                                                <i class="fa fa-cloud-upload upload-icon"></i>
                                                <span class="upload-title">Chọn ảnh đại diện mới</span>
                                                <span class="upload-sub">Hỗ trợ JPG, PNG, WebP (Tỷ lệ 1:1 đẹp nhất)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bộ ảnh chi tiết -->
                                <div class="form-group-custom" style="margin-bottom: 0;">
                                    <label class="form-label-custom">Thư viện ảnh chi tiết (Nhiều ảnh)</label>
                                    <div class="file-upload-zone" onclick="document.getElementById('gallery_input').click()">
                                        <input type="file" id="gallery_input" name="image_list[]" multiple accept="image/*" style="display: none;" onchange="previewGallery(this)">
                                        <div class="avatar-preview-box">
                                            <i class="fa fa-images upload-icon" style="color: #0284c7;"></i>
                                            <span class="upload-title" id="gallery_status_text">Chọn nhiều ảnh chi tiết mới</span>
                                            <span class="upload-sub">Giữ phím Ctrl để chọn cùng lúc nhiều góc chụp</span>
                                        </div>
                                    </div>
                                    
                                    <!-- Xem trước ảnh chi tiết hiện tại hoặc ảnh vừa chọn -->
                                    <div id="gallery_thumbs_container" class="gallery-thumbs-row">
                                        <?php 
                                            if(!empty($row['img'])) {
                                                $arr_imgs = array_filter(explode('#', $row['img']));
                                                foreach($arr_imgs as $img_item) {
                                                    if(file_exists(FCPATH . 'public/images/products/' . $img_item)) {
                                                        echo '<div class="gallery-thumb-item" title="Ảnh chi tiết hiện tại">';
                                                        echo '<img src="' . base_url('public/images/products/' . $img_item) . '">';
                                                        echo '</div>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php echo form_close(); ?>

<script>
    // Tính giá sau giảm dựa theo phần trăm sale
    function calcSaleFromPercent() {
        var root = parseFloat(document.getElementById('price_root').value) || 0;
        var salePercent = parseFloat(document.getElementById('sale_of').value) || 0;
        if(salePercent > 0 && root > 0) {
            var salePrice = Math.round(root * (100 - salePercent) / 100);
            document.getElementById('price_buy').value = salePrice;
        } else {
            document.getElementById('price_buy').value = root;
        }
    }

    // Tính ngược lại phần trăm sale khi sửa giá bán trực tiếp
    function calcPercentFromPrice() {
        var root = parseFloat(document.getElementById('price_root').value) || 0;
        var salePrice = parseFloat(document.getElementById('price_buy').value) || 0;
        if(root > 0 && salePrice < root && salePrice > 0) {
            var percent = Math.round(((root - salePrice) / root) * 100);
            document.getElementById('sale_of').value = percent;
        } else {
            document.getElementById('sale_of').value = 0;
        }
    }

    function calcSalePrice() {
        calcSaleFromPercent();
    }

    // Xem trước ảnh đại diện khi thay đổi
    function previewAvatar(input) {
        var uploadZone = document.querySelector('.file-upload-zone');
        if (input.files && input.files[0]) {
            if (uploadZone) {
                uploadZone.style.borderColor = '#10b981';
                uploadZone.style.background = '#f0fdf4';
            }
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewBox = document.getElementById('avatar_preview_box');
                previewBox.innerHTML = '<img src="' + e.target.result + '" style="max-height: 140px; max-width: 100%; object-fit: contain; border-radius: 8px;">' +
                                       '<span style="font-size: 11.5px; color: #10b981; font-weight: 700; margin-top: 6px;"><i class="fa fa-check-circle"></i> Đã chọn ảnh mới: ' + input.files[0].name + '</span>';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Xem trước danh sách ảnh chi tiết khi thay đổi
    function previewGallery(input) {
        var container = document.getElementById('gallery_thumbs_container');
        container.innerHTML = '';
        if (input.files && input.files.length > 0) {
            document.getElementById('gallery_status_text').innerText = 'Đã chọn ' + input.files.length + ' ảnh mới';
            Array.from(input.files).forEach(file => {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var thumb = document.createElement('div');
                    thumb.className = 'gallery-thumb-item';
                    thumb.innerHTML = '<img src="' + e.target.result + '">';
                    container.appendChild(thumb);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>

<style>
    /* Nút Header */
    .btn-modern-save {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%) !important;
        color: #ffffff !important;
        padding: 8px 18px !important;
        border-radius: 10px !important;
        font-weight: 700 !important;
        font-size: 13px !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3) !important;
        transition: all 0.25s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        cursor: pointer;
    }
    .btn-modern-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45) !important;
    }

    .btn-modern-back {
        background: #ffffff !important;
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
        text-decoration: none !important;
    }
    .btn-modern-back:hover {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }

    /* Modern Card Styles */
    .modern-form-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .card-header-styled {
        padding: 14px 20px;
        background: #fafbfc;
        border-bottom: 1px solid #f1f5f9;
    }
    .card-header-styled h3 {
        font-size: 14.5px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-header-styled h3 i {
        color: #d70018;
    }
    .card-body-styled {
        padding: 20px;
    }

    /* Form Fields */
    .form-group-custom {
        margin-bottom: 18px;
    }
    .form-label-custom {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        font-size: 13.5px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus {
        border-color: #d70018;
        box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12);
    }

    /* Select Dropdown */
    .select-wrapper {
        position: relative;
    }
    .select-custom {
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        padding-right: 32px;
    }
    .select-arrow {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: #94a3b8;
        pointer-events: none;
    }

    /* Currency inputs */
    .input-currency-wrapper {
        position: relative;
    }
    .currency-label {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        pointer-events: none;
    }
    .price-input {
        padding-right: 30px;
        font-weight: 700;
        font-size: 14px;
    }
    .highlight-price {
        color: #d70018 !important;
        background: #fef2f2 !important;
        border-color: #fca5a5 !important;
    }

    /* File Upload Box */
    .file-upload-zone {
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #f8fafc;
        padding: 18px 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .file-upload-zone:hover {
        border-color: #d70018;
        background: #fef2f2;
    }
    .avatar-preview-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .upload-icon {
        font-size: 26px;
        color: #d70018;
        margin-bottom: 6px;
    }
    .upload-title {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }
    .upload-sub {
        font-size: 11px;
        color: #94a3b8;
        margin-top: 2px;
    }

    .gallery-thumbs-row {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 12px;
    }
    .gallery-thumb-item {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e2e8f0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        background: #ffffff;
    }
    .gallery-thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .field-error-msg {
        font-size: 12px;
        color: #dc2626;
        font-weight: 600;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>
