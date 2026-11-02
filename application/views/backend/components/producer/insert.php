<?php echo form_open('admin/producer/insert'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-building text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thêm nhà cung cấp mới
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Thiết lập thông tin đối tác, nhà phân phối thiết bị & phụ kiện</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-floppy-o"></i> Lưu nhà cung cấp
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/producer'); ?>" role="button">
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
                    <!-- Cột trái: Thông tin chính -->
                    <div class="col-md-8">
                        <div class="box box-solid box-modern-form">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-id-card-o text-primary"></i> Thông tin đối tác cung cấp</h3>
                            </div>
                            <div class="box-body" style="padding: 24px;">

                                <div class="form-group modern-fg">
                                    <label class="fg-label">Tên nhà cung cấp <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-building-o input-icon"></i>
                                        <input type="text" class="form-control modern-input" name="name" 
                                               placeholder="Ví dụ: Digiworld, Thế Giới Di Động, FPT Synnex..." 
                                               value="<?php echo set_value('name'); ?>" required>
                                    </div>
                                    <span class="fg-hint">Tên doanh nghiệp hoặc nhà phân phối chính thức của sản phẩm.</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group modern-fg">
                                            <label class="fg-label">Mã code đối tác <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-barcode input-icon"></i>
                                                <input type="text" class="form-control modern-input" name="code" 
                                                       placeholder="Ví dụ: DGW, FPT, TGDD..." 
                                                       value="<?php echo set_value('code'); ?>" required style="text-transform: uppercase;">
                                            </div>
                                            <span class="fg-hint">Mã viết tắt viết hoa, duy nhất để phân loại nhà cung cấp.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group modern-fg">
                                            <label class="fg-label">Từ khóa phân loại <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-tags input-icon"></i>
                                                <input type="text" class="form-control modern-input" name="keyword" 
                                                       placeholder="dienthoai, apple, samsung..." 
                                                       value="<?php echo set_value('keyword'); ?>" required>
                                            </div>
                                            <span class="fg-hint">Mỗi từ khóa phân cách bởi dấu phẩy ",".</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Trạng thái & Mẹo -->
                    <div class="col-md-4">
                        <div class="box box-solid box-modern-form">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-cog text-primary"></i> Trạng thái & Hiển thị</h3>
                            </div>
                            <div class="box-body" style="padding: 24px;">

                                <div class="form-group modern-fg">
                                    <label class="fg-label">Trạng thái hợp tác</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-toggle-on input-icon"></i>
                                        <select name="status" class="form-control modern-select">
                                            <option value="1" <?php echo set_select('status', '1', TRUE); ?>> Hoạt động (Xuất bản)</option>
                                            <option value="0" <?php echo set_select('status', '0'); ?>> Tạm ngưng (Chưa xuất bản)</option>
                                        </select>
                                    </div>
                                    <span class="fg-hint">Khi ngưng hoạt động, đối tác sẽ không xuất hiện khi tạo sản phẩm mới.</span>
                                </div>

                                <div class="info-help-card">
                                    <div class="help-title"><i class="fa fa-lightbulb-o"></i> Mẹo quản lý đối tác:</div>
                                    <p class="help-text">Mã đối tác (Code) sẽ được hệ thống dùng để tra cứu nhanh nguồn gốc lô hàng khi kiểm kê tồn kho và nhập hàng.</p>
                                </div>

                                <div style="margin-top: 20px;">
                                    <button type="submit" class="btn btn-modern-save btn-block" style="padding: 12px;">
                                        <i class="fa fa-check"></i> Hoàn tất thêm mới
                                    </button>
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

    /* Buttons */
    .btn-modern-save {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff !important;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-modern-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45);
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

    /* Card Form */
    .box-modern-form {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }
    .box-modern-form .box-header {
        background: #fafbfc;
        border-bottom: 1.5px solid #f1f5f9;
        padding: 16px 24px;
    }
    .box-modern-form .box-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Form Groups */
    .modern-fg {
        margin-bottom: 20px;
    }
    .fg-label {
        font-size: 13px;
        font-weight: 700 !important;
        color: #334155;
        margin-bottom: 7px;
        display: block;
    }
    .fg-label .required {
        color: #ef4444;
    }
    .input-with-icon {
        position: relative;
    }
    .input-with-icon .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 14px;
        pointer-events: none;
    }
    .modern-input, .modern-select {
        height: 44px;
        border-radius: 10px !important;
        border: 1.5px solid #cbd5e1 !important;
        padding-left: 40px !important;
        padding-right: 14px !important;
        font-size: 13.5px;
        color: #1e293b;
        background-color: #ffffff;
        box-shadow: none !important;
        transition: all 0.2s ease;
    }
    .modern-input:focus, .modern-select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12) !important;
    }
    .fg-hint {
        display: block;
        font-size: 12px;
        color: #64748b;
        margin-top: 5px;
    }

    /* Help Card */
    .info-help-card {
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 12px;
        padding: 14px 16px;
        margin-top: 15px;
    }
    .help-title {
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .help-text {
        font-size: 12px;
        color: #64748b;
        margin: 0;
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
        margin-bottom: 20px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    }
    .alert-danger.alert-modern {
        background-color: #fef2f2 !important;
        color: #991b1b !important;
        border-left: 4px solid #ef4444 !important;
    }
</style>