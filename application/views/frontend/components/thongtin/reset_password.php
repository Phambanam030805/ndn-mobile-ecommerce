<div class="auth-page-luxury" style="padding: 40px 0 70px 0; background: #f8fafc;">
    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumbs-modern mb-3" style="font-size: 13.5px; color: #64748b; margin-bottom: 25px;">
            <a href="<?php echo base_url(); ?>" style="color: #64748b; text-decoration: none;"><i class="fa fa-home"></i> Trang chủ</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <a href="<?php echo base_url('thong-tin-khach-hang'); ?>" style="color: #64748b; text-decoration: none;">Tài khoản</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <span style="color: #0f172a; font-weight: 700;">Đổi mật khẩu</span>
        </div>

        <div style="display: flex; justify-content: center;">
            <div class="auth-card-luxury login-box" style="background: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.06); padding: 40px; width: 100%; max-width: 520px; border: 1px solid #eef2f6;">
                <div class="auth-header-luxury text-center" style="margin-bottom: 28px;">
                    <div style="width: 64px; height: 64px; line-height: 64px; border-radius: 50%; background: #fee2e2; color: #d70018; font-size: 26px; margin: 0 auto 14px; text-align: center;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="auth-title" style="font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 6px;">ĐỔI MẬT KHẨU</h2>
                    <p class="auth-subtitle" style="font-size: 13px; color: #64748b; margin: 0;">Bảo vệ tài khoản với mật khẩu tối thiểu 6 ký tự</p>
                </div>

                <?php if(isset($successpassword)): ?>
                    <div class="alert alert-success" style="border-radius: 10px; font-size: 13.5px; font-weight: 600;">
                        <i class="fas fa-check-circle"></i> <?php echo $successpassword; ?>
                    </div>
                <?php endif; ?>

                <form action="" accept-charset="UTF-8" id="reset_password_form" method="post">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    
                    <!-- Mật khẩu hiện tại -->
                    <div class="auth-form-group" style="margin-bottom: 18px;">
                        <label class="auth-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Mật khẩu hiện tại: <span style="color: #ef4444;">*</span></label>
                        <div class="auth-input-wrapper" style="position: relative;">
                            <i class="fas fa-lock auth-input-icon" style="position: absolute; left: 14px; top: 14px; color: #94a3b8; font-size: 14px;"></i>
                            <input type="password" id="password_old" name="password_old" class="auth-input has-toggle" placeholder="Nhập mật khẩu hiện tại" style="width: 100%; padding: 11px 40px 11px 38px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; box-sizing: border-box;">
                            <i class="far fa-eye auth-toggle-pwd" onclick="togglePassVisibility('password_old', this)" style="position: absolute; right: 14px; top: 14px; color: #94a3b8; cursor: pointer; font-size: 14px;"></i>
                        </div>
                        <div class="auth-error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px;"><?php echo form_error('password_old')?></div>
                    </div>

                    <!-- Mật khẩu mới -->
                    <div class="auth-form-group" style="margin-bottom: 18px;">
                        <label class="auth-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Mật khẩu mới: <span style="color: #ef4444;">*</span></label>
                        <div class="auth-input-wrapper" style="position: relative;">
                            <i class="fas fa-key auth-input-icon" style="position: absolute; left: 14px; top: 14px; color: #94a3b8; font-size: 14px;"></i>
                            <input type="password" id="password_new" name="password" class="auth-input has-toggle" placeholder="Nhập mật khẩu mới (tối thiểu 6 ký tự)" style="width: 100%; padding: 11px 40px 11px 38px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; box-sizing: border-box;">
                            <i class="far fa-eye auth-toggle-pwd" onclick="togglePassVisibility('password_new', this)" style="position: absolute; right: 14px; top: 14px; color: #94a3b8; cursor: pointer; font-size: 14px;"></i>
                        </div>
                        <div class="auth-error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px;"><?php echo form_error('password')?></div>
                    </div>

                    <!-- Nhập lại mật khẩu mới -->
                    <div class="auth-form-group" style="margin-bottom: 24px;">
                        <label class="auth-label" style="font-size: 13px; font-weight: 700; color: #334155; margin-bottom: 6px; display: block;">Nhập lại mật khẩu mới: <span style="color: #ef4444;">*</span></label>
                        <div class="auth-input-wrapper" style="position: relative;">
                            <i class="fas fa-check-double auth-input-icon" style="position: absolute; left: 14px; top: 14px; color: #94a3b8; font-size: 14px;"></i>
                            <input type="password" id="re_password" name="re_password" class="auth-input has-toggle" placeholder="Xác nhận lại mật khẩu mới" style="width: 100%; padding: 11px 40px 11px 38px; border: 1px solid #cbd5e1; border-radius: 10px; font-size: 14px; box-sizing: border-box;">
                            <i class="far fa-eye auth-toggle-pwd" onclick="togglePassVisibility('re_password', this)" style="position: absolute; right: 14px; top: 14px; color: #94a3b8; cursor: pointer; font-size: 14px;"></i>
                        </div>
                        <div class="auth-error-msg" style="color: #ef4444; font-size: 12px; margin-top: 4px;"><?php echo form_error('re_password')?></div>
                    </div>

                    <button type="submit" class="btn-auth-submit" style="width: 100%; padding: 13px; background: #d70018; color: #fff; border: none; border-radius: 12px; font-weight: 800; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; cursor: pointer; box-shadow: 0 4px 15px rgba(215, 0, 24, 0.3);">
                        <i class="fas fa-save"></i> CẬP NHẬT MẬT KHẨU
                    </button>

                    <div style="text-align: center; margin-top: 18px;">
                        <a href="<?php echo base_url('thong-tin-khach-hang'); ?>" style="color: #64748b; font-size: 13px; text-decoration: none; font-weight: 600;">
                            <i class="fas fa-arrow-left"></i> Quay lại thông tin tài khoản
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function togglePassVisibility(inputId, icon) {
    var input = document.getElementById(inputId);
    if (input) {
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            input.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    }
}
</script>