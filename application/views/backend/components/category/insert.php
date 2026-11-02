<?php echo form_open_multipart('admin/category/insert'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-plus-circle text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thêm danh mục mới
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Thiết lập phân cấp hãng sản xuất & phân loại sản phẩm</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-check"></i> Lưu danh mục
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/category'); ?>" role="button">
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

                <div class="row">
                    <!-- Cột trái: Thông tin danh mục -->
                    <div class="col-lg-7 col-md-7">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-folder-open-o"></i> Thông tin danh mục</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Tên danh mục / Hãng sản xuất <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-custom" name="name" id="category_name" placeholder="Ví dụ: Apple (iPhone), Samsung Galaxy, Xiaomi..." value="<?php echo set_value('name'); ?>" required oninput="updateSlugPreview(this.value)">
                                    <?php if(form_error('name')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('name'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Đường dẫn tĩnh (Slug dự kiến)</label>
                                    <div class="slug-preview-box">
                                        <i class="fa fa-globe"></i>
                                        <span><?php echo base_url(); ?></span><b id="slug_preview" style="color: var(--primary);">danh-muc-moi</b>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Danh mục cha (Phân cấp bậc)</label>
                                    <div class="select-wrapper">
                                        <select name="parentid" class="form-control-custom select-custom">
                                            <option value="0">★ Là danh mục gốc (Cấp cao nhất)</option>
                                            <?php  
                                            $list = $this->Mdanhmuc->category_list();
                                            foreach ($list as $row) {
                                                echo "<option value='".$row['id']."'>-- Phụ thuộc: ".$row['name']."</option>";
                                            }
                                            ?>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
                                    </div>
                                    <span class="field-hint">Để nguyên "Là danh mục gốc" nếu đây là hãng chính (như Apple, Samsung...).</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Thứ tự & Trạng thái -->
                    <div class="col-lg-5 col-md-5">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-sliders"></i> Cấu hình hiển thị</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Vị trí sắp xếp hiển thị</label>
                                    <div class="select-wrapper">
                                        <select name="orders" class="form-control-custom select-custom">
                                            <option value="0">Ưu tiên đứng đầu tiên</option>
                                            <?php  
                                            foreach ($list as $row) {
                                                echo "<option value='".($row['orders']+1)."'>Sau: ".$row['name']."</option>";
                                            }
                                            ?>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
                                    </div>
                                    <span class="field-hint">Xác định vị trí xuất hiện trên thanh menu sản phẩm của website.</span>
                                </div>

                                <div class="form-group-custom" style="margin-bottom: 0;">
                                    <label class="form-label-custom">Trạng thái kinh doanh</label>
                                    <div class="select-wrapper">
                                        <select name="status" class="form-control-custom select-custom">
                                            <option value="1">Đang kinh doanh (Hiển thị ngay)</option>
                                            <option value="0">Tạm ngưng kinh doanh (Ẩn)</option>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Mẹo nhỏ -->
                        <div class="tip-info-box">
                            <div class="tip-icon"><i class="fa fa-lightbulb-o"></i></div>
                            <div class="tip-content">
                                <h4>Gợi ý quản trị:</h4>
                                <p>Sau khi tạo loại sản phẩm thành công, bạn có thể vào mục <b>"Sản phẩm"</b> để bắt đầu thêm máy thuộc danh mục này.</p>
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
    // Preview slug tự động chuyển tiếng Việt sang không dấu
    function updateSlugPreview(val) {
        if(!val) {
            document.getElementById('slug_preview').innerText = 'danh-muc-moi';
            return;
        }
        var str = val.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        str = str.replace(/[^a-z0-9 -]/g, '');
        str = str.replace(/\s+/g, '-');
        str = str.replace(/-+/g, '-');
        str = str.replace(/^-+|-+$/g, '');
        document.getElementById('slug_preview').innerText = str || 'danh-muc-moi';
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
        color: var(--primary);
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
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12);
    }

    /* Slug Preview */
    .slug-preview-box {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 12.5px;
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
        overflow-x: auto;
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

    .field-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 5px;
        display: block;
    }

    .field-error-msg {
        font-size: 12px;
        color: #ef4444;
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Tip Box */
    .tip-info-box {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
    }
    .tip-icon {
        font-size: 20px;
        color: #16a34a;
        margin-top: 2px;
    }
    .tip-content h4 {
        margin: 0 0 4px;
        font-size: 13px;
        font-weight: 700;
        color: #166534;
    }
    .tip-content p {
        margin: 0;
        font-size: 12px;
        color: #15803d;
        line-height: 1.5;
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
    .alert-danger.alert-modern {
        background-color: #fef2f2 !important;
        color: #991b1b !important;
        border-left: 4px solid #ef4444 !important;
    }
</style>