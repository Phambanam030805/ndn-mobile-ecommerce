<div class="content-wrapper">
    <form action="<?php echo base_url('admin/useradmin/update/'.$row['id']); ?>" enctype="multipart/form-data" method="POST" accept-charset="utf-8">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
        <section class="content-header">
            <div class="header-left">
                <h1>
                    <i class="fa fa-user-circle text-red" style="font-size: 20px; vertical-align: -2px; margin-right: 6px;"></i> Hồ sơ Quản trị viên
                    <small>Quản lý thông tin cá nhân, ảnh đại diện & đổi mật khẩu quản trị</small>
                </h1>
            </div>
            <div class="header-right">
                <button type="submit" class="btn btn-save-admin">
                    <i class="fa fa-floppy-o"></i> <span>Lưu thay đổi</span>
                </button>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Flash Messages -->
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-modern">
                    <i class="fa fa-check-circle"></i>
                    <span><?php echo $this->session->flashdata('success'); ?></span>
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
                <!-- CỘT TRÁI: AVATAR CARD & SUMMARY -->
                <div class="col-lg-4 col-md-5">
                    <div class="profile-sidebar-card">
                        <div class="avatar-upload-wrapper">
                            <?php 
                                $avatar = !empty($row['img']) && file_exists(FCPATH . 'public/images/admin/' . $row['img']) 
                                    ? base_url('public/images/admin/' . $row['img']) 
                                    : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
                            ?>
                            <div class="avatar-preview-box">
                                <img id="avatar_preview" src="<?php echo $avatar; ?>" alt="Avatar" class="avatar-img-circle">
                                <label for="avatar_input" class="btn-change-avatar" title="Thay đổi ảnh đại diện">
                                    <i class="fa fa-camera"></i>
                                </label>
                                <input type="file" id="avatar_input" name="image" accept="image/*" style="display: none;">
                            </div>
                        </div>

                        <div class="profile-identity">
                            <h3 class="profile-name"><?php echo htmlspecialchars($row['fullname']); ?></h3>
                            <div class="profile-role-badge">
                                <i class="fa fa-shield"></i> Quản trị viên cấp cao (ADMIN)
                            </div>
                            <div class="profile-meta-item">
                                <span class="meta-label">Tên đăng nhập:</span>
                                <span class="meta-val"><b><?php echo htmlspecialchars($row['username']); ?></b></span>
                            </div>
                            <div class="profile-meta-item">
                                <span class="meta-label">Ngày khởi tạo:</span>
                                <span class="meta-val"><?php echo date('d/m/Y - H:i', strtotime($row['created_at'])); ?></span>
                            </div>
                            <div class="profile-meta-item">
                                <span class="meta-label">Trạng thái:</span>
                                <span class="badge-status-active"><i class="fa fa-check-circle"></i> Đang kích hoạt</span>
                            </div>
                        </div>

                        <div class="security-tip-box">
                            <i class="fa fa-lock text-red"></i>
                            <div>
                                <b>Bảo mật tài khoản:</b> Khuyên dùng mật khẩu dài từ 8 ký tự gồm chữ, số và ký tự đặc biệt để bảo vệ tài khoản quản trị NDN Mobile.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI: FORM CHỈNH SỬA THÔNG TIN & ĐỔI MẬT KHẨU -->
                <div class="col-lg-8 col-md-7">
                    <!-- KHỐI 1: THÔNG TIN CÁ NHÂN -->
                    <div class="profile-main-card">
                        <div class="card-header">
                            <div class="card-icon blue">
                                <i class="fa fa-id-card-o"></i>
                            </div>
                            <div class="card-title-group">
                                <h3 class="card-title">Thông tin Quản trị viên</h3>
                                <p class="card-desc">Cập nhật họ tên, địa chỉ email, số điện thoại và nơi ở</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Họ và tên <span class="required">*</span></label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-user input-icon"></i>
                                            <input type="text" class="form-control modern-input" name="fullname" 
                                                   value="<?php echo htmlspecialchars($row['fullname']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Tên đăng nhập</label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-at input-icon"></i>
                                            <input type="text" class="form-control modern-input" value="<?php echo htmlspecialchars($row['username']); ?>" disabled readonly style="background: #f8fafc; color: #64748b; cursor: not-allowed;">
                                        </div>
                                        <span class="fg-hint">Tên đăng nhập cố định của hệ thống</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Địa chỉ Email <span class="required">*</span></label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-envelope-o input-icon"></i>
                                            <input type="email" class="form-control modern-input" name="email" 
                                                   value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Số điện thoại <span class="required">*</span></label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-phone input-icon"></i>
                                            <input type="text" class="form-control modern-input" name="phone" 
                                                   value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-8">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Địa chỉ</label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-map-marker input-icon"></i>
                                            <input type="text" class="form-control modern-input" name="address" 
                                                   value="<?php echo htmlspecialchars($row['address']); ?>" placeholder="Địa chỉ thường trú">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Giới tính</label>
                                        <select name="gender" class="form-control modern-select">
                                            <option value="1" <?php echo ($row['gender'] == 1) ? 'selected' : ''; ?>>Nam</option>
                                            <option value="0" <?php echo ($row['gender'] == 0) ? 'selected' : ''; ?>>Nữ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- KHỐI 2: ĐỔI MẬT KHẨU -->
                    <div class="profile-main-card" style="margin-top: 20px;">
                        <div class="card-header">
                            <div class="card-icon red">
                                <i class="fa fa-key"></i>
                            </div>
                            <div class="card-title-group">
                                <h3 class="card-title">Đổi mật khẩu Quản trị</h3>
                                <p class="card-desc">Để trống ô bên dưới nếu bạn không muốn thay đổi mật khẩu hiện tại</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group modern-fg" style="margin-bottom: 0;">
                                <label class="fg-label">Mật khẩu mới (Tùy chọn)</label>
                                <div class="input-with-icon has-action-btn">
                                    <i class="fa fa-lock input-icon"></i>
                                    <input type="password" id="new_admin_pwd" class="form-control modern-input" name="password" 
                                           placeholder="Nhập mật khẩu mới nếu muốn đổi (từ 5 đến 32 ký tự)">
                                    <button type="button" class="btn-toggle-pwd" id="toggle_admin_pwd" title="Ẩn/Hiện mật khẩu">
                                        <i class="fa fa-eye" id="admin_pwd_icon"></i>
                                    </button>
                                </div>
                                <span class="fg-hint"><i class="fa fa-info-circle"></i> Chỉ điền khi cần đổi mật khẩu đăng nhập Admin mới.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</div>

<!-- SCRIPT PREVIEW AVATAR & TOGGLE PASSWORD -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Preview ảnh đại diện khi chọn file
    const avatarInput = document.getElementById('avatar_input');
    const avatarPreview = document.getElementById('avatar_preview');

    if (avatarInput && avatarPreview) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    avatarPreview.src = evt.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // 2. Toggle ẩn hiện mật khẩu mới
    const toggleBtn = document.getElementById('toggle_admin_pwd');
    const pwdInput = document.getElementById('new_admin_pwd');
    const pwdIcon = document.getElementById('admin_pwd_icon');

    if (toggleBtn && pwdInput) {
        toggleBtn.addEventListener('click', function() {
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                pwdIcon.classList.remove('fa-eye');
                pwdIcon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                pwdIcon.classList.remove('fa-eye-slash');
                pwdIcon.classList.add('fa-eye');
            }
        });
    }
});
</script>

<!-- CSS CAO CẤP PROFILE ADMIN -->
<style>
/* Layout Header */
.content-header {
    background: #ffffff !important;
    border-bottom: 1px solid #e2e8f0 !important;
    box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05) !important;
    height: 60px !important;
    padding: 0 24px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
}
.header-left h1 {
    margin: 0 !important;
    font-size: 18px !important;
    font-weight: 700 !important;
    color: #1e293b !important;
    display: flex !important;
    align-items: baseline !important;
    gap: 10px !important;
    line-height: 1.2 !important;
}
.header-left h1 small {
    display: inline-block !important;
    font-size: 13px !important;
    color: #64748b !important;
    font-weight: 400 !important;
}

/* Nút Lưu màu đỏ thương hiệu */
.btn-save-admin {
    background: linear-gradient(135deg, #d70018 0%, #b80014 100%);
    color: #fff !important;
    border: none;
    padding: 10px 24px;
    font-size: 14px;
    font-weight: 600;
    border-radius: 8px;
    box-shadow: 0 4px 14px rgba(215, 0, 24, 0.35);
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.25s ease;
    cursor: pointer;
}
.btn-save-admin:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45);
    color: #fff !important;
}

/* Cột Trái Profile Card */
.profile-sidebar-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #eef2f5;
    padding: 30px 24px;
    text-align: center;
    margin-bottom: 25px;
}
.avatar-upload-wrapper {
    margin-bottom: 20px;
}
.avatar-preview-box {
    position: relative;
    width: 130px;
    height: 130px;
    margin: 0 auto;
}
.avatar-img-circle {
    width: 130px;
    height: 130px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #fff;
    box-shadow: 0 6px 18px rgba(0,0,0,0.12);
}
.btn-change-avatar {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #d70018;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 3px 8px rgba(215,0,24,0.4);
    transition: all 0.2s ease;
}
.btn-change-avatar:hover {
    transform: scale(1.1);
    background: #b80014;
}

.profile-identity {
    margin-bottom: 22px;
    border-bottom: 1px dashed #e2e8f0;
    padding-bottom: 20px;
}
.profile-name {
    margin: 0 0 8px;
    font-size: 20px;
    font-weight: 700;
    color: #1e293b;
}
.profile-role-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fee2e2;
    color: #dc2626;
    font-size: 12.5px;
    font-weight: 600;
    padding: 5px 14px;
    border-radius: 20px;
    margin-bottom: 18px;
}
.profile-meta-item {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    padding: 7px 0;
    color: #64748b;
    border-bottom: 1px solid #f8fafc;
}
.profile-meta-item .meta-val {
    color: #334155;
}
.badge-status-active {
    color: #16a34a;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.security-tip-box {
    background: #fef2f2;
    border-radius: 8px;
    padding: 12px 14px;
    font-size: 12px;
    color: #991b1b;
    text-align: left;
    display: flex;
    gap: 10px;
    line-height: 1.5;
}

/* Thẻ Form Chính */
.profile-main-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #eef2f5;
    overflow: hidden;
}
.card-header {
    padding: 18px 22px;
    border-bottom: 1px solid #f1f5f9;
    background: #fafbfc;
    display: flex;
    align-items: center;
    gap: 14px;
}
.card-icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.card-icon.blue {
    background: #e6f4ff;
    color: #0969da;
}
.card-icon.red {
    background: #ffebe9;
    color: #d70018;
}
.card-title-group {
    flex: 1;
}
.card-title {
    margin: 0;
    font-size: 16px;
    font-weight: 700;
    color: #1f2937;
}
.card-desc {
    margin: 3px 0 0;
    font-size: 12.5px;
    color: #6b7280;
}
.card-body {
    padding: 24px;
}

/* Form inputs */
.modern-fg {
    margin-bottom: 20px;
}
.fg-label {
    display: block;
    font-size: 13.5px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 7px;
}
.fg-label .required {
    color: #e53e3e;
    font-weight: 700;
}
.fg-hint {
    display: block;
    font-size: 12px;
    color: #8c9ba5;
    margin-top: 5px;
}

.input-with-icon {
    position: relative;
    display: flex;
    align-items: center;
}
.input-icon {
    position: absolute;
    left: 14px;
    color: #94a3b8;
    font-size: 15px;
    pointer-events: none;
    z-index: 2;
}
.modern-input, .modern-select {
    width: 100%;
    padding: 10px 14px 10px 40px !important;
    border-radius: 8px !important;
    border: 1px solid #d1d5db !important;
    font-size: 14px;
    color: #1f2937;
    background: #fff;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    height: 42px;
}
.modern-select {
    padding-left: 14px !important;
}
.modern-input:focus, .modern-select:focus {
    border-color: #d70018 !important;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12) !important;
    outline: none;
}

/* Nút ẩn hiện Password */
.has-action-btn .modern-input {
    padding-right: 42px !important;
}
.btn-toggle-pwd {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #64748b;
    padding: 6px 10px;
    cursor: pointer;
    border-radius: 6px;
    transition: color 0.2s;
    outline: none;
    z-index: 3;
}
.btn-toggle-pwd:hover {
    color: #d70018;
}

/* Flash alerts */
.alert-modern {
    border-radius: 10px;
    border: none;
    padding: 14px 18px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
}
.alert-modern.alert-success {
    background: #e8f8f0;
    color: #1e7e34;
    border-left: 4px solid #28a745;
}
.alert-modern.alert-danger {
    background: #fdf0f0;
    color: #c0392b;
    border-left: 4px solid #e74c3c;
}

@media (max-width: 768px) {
    .content-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 12px;
    }
    .header-right {
        width: 100%;
    }
    .btn-save-admin {
        width: 100%;
        justify-content: center;
    }
}
</style>