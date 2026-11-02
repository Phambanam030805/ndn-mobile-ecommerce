<?php echo form_open_multipart('admin/coupon/update/'.$row['id']); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-pencil-square-o text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Cập nhật mã giảm giá
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Chỉnh sửa thông số ưu đãi & hạn dùng của mã <b><?php echo htmlspecialchars($row['code']); ?></b></small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-check"></i> Lưu cập nhật
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/coupon'); ?>" role="button">
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
                    <!-- Cột trái: Thông tin mã giảm giá & giá trị -->
                    <div class="col-lg-7 col-md-7">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-tag"></i> Thông tin mã ưu đãi</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Mã giảm giá (Coupon Code) <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-custom font-code" name="code" value="<?php echo htmlspecialchars($row['code']); ?>" required style="text-transform: uppercase;">
                                    <span class="field-hint">Mã từ 5 đến 10 ký tự, viết liền không dấu.</span>
                                    <?php if(form_error('code')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('code'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Số tiền giảm giá (VNĐ) <span class="text-danger">*</span></label>
                                            <div class="input-unit-wrap">
                                                <input type="number" class="form-control-custom" name="discount" value="<?php echo (float)$row['discount']; ?>" required min="1000" step="1000">
                                                <span class="unit-badge">đ</span>
                                            </div>
                                            <?php if(form_error('discount')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('discount'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Đơn hàng tối thiểu (VNĐ) <span class="text-danger">*</span></label>
                                            <div class="input-unit-wrap">
                                                <input type="number" class="form-control-custom" name="payment_limit" value="<?php echo (float)$row['payment_limit']; ?>" required min="0" step="10000">
                                                <span class="unit-badge">đ</span>
                                            </div>
                                            <span class="field-hint">Áp dụng cho đơn hàng có tổng tiền từ mức này.</span>
                                            <?php if(form_error('payment_limit')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('payment_limit'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Mô tả chương trình ưu đãi</label>
                                    <textarea name="description" class="form-control-custom textarea-custom" rows="3" placeholder="Nhập tóm tắt ưu đãi hiển thị cho khách hàng..."><?php echo htmlspecialchars($row['description']); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Thống kê sử dụng & Hiệu lực -->
                    <div class="col-lg-5 col-md-5">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-pie-chart"></i> Lượt sử dụng & Hiệu lực</h3>
                            </div>
                            <div class="card-body-styled">
                                <?php 
                                    $limit_num = (int)$row['limit_number'];
                                    $used_num = (int)$row['number_used'];
                                    $remain_num = max(0, $limit_num - $used_num);
                                    $percent = ($limit_num > 0) ? min(100, round(($used_num / $limit_num) * 100)) : 0;
                                ?>
                                <div class="stats-preview-grid">
                                    <div class="stat-mini-box">
                                        <span class="stat-mini-title">Đã sử dụng</span>
                                        <b class="stat-mini-val text-primary"><?php echo $used_num; ?></b>
                                    </div>
                                    <div class="stat-mini-box">
                                        <span class="stat-mini-title">Còn lại</span>
                                        <b class="stat-mini-val text-success"><?php echo $remain_num; ?></b>
                                    </div>
                                </div>

                                <div class="usage-progress-bar-wrap">
                                    <div class="progress-info">
                                        <span>Tiến độ dùng mã:</span>
                                        <b><?php echo $used_num; ?> / <?php echo $limit_num; ?> lượt (<?php echo $percent; ?>%)</b>
                                    </div>
                                    <div class="progress-track">
                                        <div class="progress-fill" style="width: <?php echo $percent; ?>%;"></div>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Tổng số lượt giới hạn <span class="text-danger">*</span></label>
                                    <div class="input-unit-wrap">
                                        <input type="number" class="form-control-custom" name="limit_number" value="<?php echo $limit_num; ?>" required min="<?php echo $used_num; ?>">
                                        <span class="unit-badge"><i class="fa fa-users"></i></span>
                                    </div>
                                    <span class="field-hint">Số lượt tối đa cho phép nhập (phải >= số lượt đã dùng).</span>
                                    <?php if(form_error('limit_number')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('limit_number'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Ngày hết hạn sử dụng <span class="text-danger">*</span></label>
                                    <div class="input-unit-wrap">
                                        <input type="date" class="form-control-custom" name="expiration_date" value="<?php echo htmlspecialchars(substr($row['expiration_date'], 0, 10)); ?>" required>
                                    </div>
                                    <?php if(form_error('expiration_date')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('expiration_date'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Trạng thái phát hành</label>
                                    <div class="select-wrapper">
                                        <select name="status" class="form-control-custom select-custom">
                                            <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>● Có hiệu lực (Khách được áp dụng)</option>
                                            <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>○ Tạm khóa (Chưa cho khách dùng)</option>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
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

    /* Modern Buttons */
    .btn-modern-save {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff !important;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-modern-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(215, 0, 24, 0.45);
        color: #ffffff !important;
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
    .font-code {
        font-family: 'Consolas', 'Courier New', monospace;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .input-unit-wrap {
        position: relative;
    }
    .input-unit-wrap .form-control-custom {
        padding-right: 42px;
    }
    .unit-badge {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        pointer-events: none;
    }

    .textarea-custom {
        resize: vertical;
        min-height: 80px;
    }

    /* Stats mini box */
    .stats-preview-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 16px;
    }
    .stat-mini-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        flex-direction: column;
        gap: 4px;
    }
    .stat-mini-title {
        font-size: 11.5px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .stat-mini-val {
        font-size: 20px;
        font-weight: 800;
    }

    /* Progress bar */
    .usage-progress-bar-wrap {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        margin-bottom: 18px;
    }
    .progress-info {
        display: flex;
        justify-content: space-between;
        font-size: 12px;
        color: #475569;
        margin-bottom: 6px;
    }
    .progress-track {
        height: 8px;
        background: #e2e8f0;
        border-radius: 6px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
        border-radius: 6px;
        transition: width 0.3s ease;
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