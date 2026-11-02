<?php echo form_open('admin/customer/update/'.$row['id']); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-user-circle text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Cập nhật hồ sơ khách hàng
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Chỉnh sửa thông tin tài khoản thành viên <b><?php echo htmlspecialchars($row['fullname']); ?></b></small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-check"></i> Lưu cập nhật
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/customer'); ?>" role="button">
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
                        <span>Vui lòng kiểm tra lại các trường thông tin bên dưới!</span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Cột trái: Thông tin cá nhân -->
                    <div class="col-lg-7 col-md-7">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-address-card-o"></i> Thông tin cá nhân</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Họ và tên khách hàng <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control-custom" name="fullname" value="<?php echo htmlspecialchars(set_value('fullname', $row['fullname'])); ?>" required placeholder="Ví dụ: Trần Đức Duy, Nguyễn Văn A...">
                                    <?php if(form_error('fullname')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('fullname'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Số điện thoại <span class="text-danger">*</span></label>
                                            <div class="input-icon-wrap">
                                                <i class="fa fa-phone input-icon"></i>
                                                <input type="text" class="form-control-custom with-icon" name="phone" value="<?php echo htmlspecialchars(set_value('phone', $row['phone'])); ?>" required placeholder="0386810238">
                                            </div>
                                            <?php if(form_error('phone')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('phone'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Địa chỉ Email <span class="text-danger">*</span></label>
                                            <div class="input-icon-wrap">
                                                <i class="fa fa-envelope-o input-icon"></i>
                                                <input type="email" class="form-control-custom with-icon" name="email" value="<?php echo htmlspecialchars(set_value('email', $row['email'])); ?>" required placeholder="khachhang@gmail.com">
                                            </div>
                                            <?php if(form_error('email')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('email'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-custom" style="margin-bottom: 0;">
                                    <label class="form-label-custom">Tên tài khoản (Username đăng nhập)</label>
                                    <input type="text" class="form-control-custom" value="<?php echo htmlspecialchars($row['username']); ?>" disabled style="background: #f8fafc; color: #64748b;">
                                    <span class="field-hint">Tên tài khoản được bảo mật và cố định, không thể thay đổi.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Trạng thái & Tổng quan tài khoản -->
                    <div class="col-lg-5 col-md-5">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-shield"></i> Trạng thái & Bảo mật</h3>
                            </div>
                            <div class="card-body-styled">
                                
                                <div class="customer-avatar-profile">
                                    <div class="avatar-circle-big">
                                        <?php echo !empty($row['fullname']) ? mb_strtoupper(mb_substr($row['fullname'], 0, 1, 'UTF-8')) : 'U'; ?>
                                    </div>
                                    <div class="avatar-profile-meta">
                                        <h4><?php echo htmlspecialchars($row['fullname']); ?></h4>
                                        <span class="meta-role">Thành viên Website (ID: #<?php echo $row['id']; ?>)</span>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Trạng thái tài khoản</label>
                                    <div class="select-wrapper">
                                        <select name="status" class="form-control-custom select-custom">
                                            <option value="1" <?php echo ($row['status'] == 1) ? 'selected' : ''; ?>>● Đang hoạt động (Cho phép đăng nhập & mua hàng)</option>
                                            <option value="0" <?php echo ($row['status'] == 0) ? 'selected' : ''; ?>>○ Tạm khóa tài khoản</option>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
                                    </div>
                                    <span class="field-hint">Khóa tài khoản sẽ chặn người dùng này đăng nhập trên website.</span>
                                </div>

                                <div class="account-dates-box">
                                    <div class="date-row">
                                        <span>Ngày đăng ký:</span>
                                        <b><?php echo htmlspecialchars(isset($row['created_at']) ? $row['created_at'] : 'Không rõ'); ?></b>
                                    </div>
                                    <?php 
                                        $this->db->where('customer_id', $row['id']);
                                        $order_cnt = $this->db->count_all_results('orders');
                                    ?>
                                    <div class="date-row" style="margin-top: 6px;">
                                        <span>Tổng số đơn hàng:</span>
                                        <b class="text-primary"><?php echo $order_cnt; ?> đơn hàng</b>
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

    .input-icon-wrap {
        position: relative;
    }
    .input-icon {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        color: #94a3b8;
    }
    .form-control-custom.with-icon {
        padding-left: 38px;
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

    /* Profile Box */
    .customer-avatar-profile {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 18px;
        border-bottom: 1px dashed #e2e8f0;
        margin-bottom: 18px;
    }
    .avatar-circle-big {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff;
        font-size: 22px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.25);
    }
    .avatar-profile-meta h4 {
        margin: 0 0 4px;
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
    }
    .meta-role {
        font-size: 12px;
        color: #64748b;
    }

    .account-dates-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 12px 14px;
        margin-top: 18px;
        font-size: 12.5px;
        color: #475569;
    }
    .date-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
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