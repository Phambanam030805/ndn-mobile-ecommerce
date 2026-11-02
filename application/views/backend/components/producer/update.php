<?php echo form_open('admin/producer/update/'.$row['id']); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-building text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Cập nhật nhà cung cấp
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Chỉnh sửa thông tin đối tác <b><?php echo htmlspecialchars($row['name']); ?></b></small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-check"></i> Lưu cập nhật
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
                    <!-- Cột trái: Form thông tin -->
                    <div class="col-md-8">
                        <div class="box box-solid box-modern-form">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-pencil-square-o text-primary"></i> Chi tiết thông tin đối tác</h3>
                            </div>
                            <div class="box-body" style="padding: 24px;">

                                <div class="form-group modern-fg">
                                    <label class="fg-label">Tên nhà cung cấp <span class="required">*</span></label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-building-o input-icon"></i>
                                        <input type="text" class="form-control modern-input" name="name" 
                                               placeholder="Tên nhà cung cấp" 
                                               value="<?php echo htmlspecialchars(isset($row['name']) ? $row['name'] : ''); ?>" required>
                                    </div>
                                    <span class="fg-hint">Tên doanh nghiệp đối tác phân phối thiết bị.</span>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group modern-fg">
                                            <label class="fg-label">Mã code đối tác (Cố định)</label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-barcode input-icon"></i>
                                                <input type="text" class="form-control modern-input" name="code" 
                                                       value="<?php echo htmlspecialchars($row['code']); ?>" disabled style="background: #f1f5f9; cursor: not-allowed; font-weight: 700;">
                                            </div>
                                            <span class="fg-hint">Mã code đối tác đã định danh, không thể thay đổi.</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group modern-fg">
                                            <label class="fg-label">Từ khóa phân loại <span class="required">*</span></label>
                                            <div class="input-with-icon">
                                                <i class="fa fa-tags input-icon"></i>
                                                <input type="text" class="form-control modern-input" name="keyword" 
                                                       placeholder="dienthoai, apple, samsung..." 
                                                       value="<?php echo htmlspecialchars(isset($row['keyword']) ? $row['keyword'] : ''); ?>" required>
                                            </div>
                                            <span class="fg-hint">Mỗi từ khóa phân cách bởi dấu phẩy ",".</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Trạng thái & Thống kê -->
                    <div class="col-md-4">
                        <div class="box box-solid box-modern-form">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-info-circle text-primary"></i> Trạng thái & Hồ sơ</h3>
                            </div>
                            <div class="box-body" style="padding: 24px;">

                                <div class="form-group modern-fg">
                                    <label class="fg-label">Trạng thái hợp tác</label>
                                    <div class="input-with-icon">
                                        <i class="fa fa-toggle-on input-icon"></i>
                                        <select name="status" class="form-control modern-select">
                                            <option value="1" <?php if($row['status'] == 1) echo 'selected'; ?>> Hoạt động (Xuất bản)</option>
                                            <option value="0" <?php if($row['status'] == 0) echo 'selected'; ?>> Tạm ngưng (Chưa xuất bản)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="partner-meta-box">
                                    <div class="meta-item">
                                        <span class="meta-label"><i class="fa fa-calendar-o"></i> Ngày tạo đối tác:</span>
                                        <span class="meta-value"><?php echo !empty($row['created_at']) ? date('d/m/Y H:i', strtotime($row['created_at'])) : '---'; ?></span>
                                    </div>
                                    <div class="meta-item">
                                        <span class="meta-label"><i class="fa fa-clock-o"></i> Cập nhật gần nhất:</span>
                                        <span class="meta-value"><?php echo !empty($row['updated_at']) ? date('d/m/Y H:i', strtotime($row['updated_at'])) : 'Chưa cập nhật'; ?></span>
                                    </div>
                                </div>

                                <div style="margin-top: 24px;">
                                    <button type="submit" class="btn btn-modern-save btn-block" style="padding: 12px;">
                                        <i class="fa fa-check"></i> Lưu thay đổi
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

    /* Meta Info */
    .partner-meta-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px 16px;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .meta-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 12.5px;
    }
    .meta-label {
        color: #64748b;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .meta-value {
        color: #1e293b;
        font-weight: 600;
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