<section class="auth-page-luxury">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="auth-card-luxury register-box">
                    <!-- Header -->
                    <div class="auth-header">
                        <div class="auth-logo-badge">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h1 class="auth-title">Đăng Ký Tài Khoản</h1>
                        <p class="auth-subtitle">Trở thành thành viên NDN Mobile để nhận hàng ngàn ưu đãi</p>
                    </div>

                    <!-- Switch Tabs: Đăng nhập / Đăng ký -->
                    <div class="auth-switch-tabs">
                        <a href="<?php echo base_url('dang-nhap'); ?>" class="auth-switch-tab">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="<?php echo base_url('dang-ky'); ?>" class="auth-switch-tab active">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    </div>

                    <?php if(isset($success) && !empty($success)): ?>
                        <div class="alert alert-success" style="border-radius: 10px; font-size: 14px;">
                            <i class="fas fa-check-circle"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Đăng Ký 2 Cột Rộng Rãi -->
                    <?php echo form_open('dang-ky', array('id' => 'customer_register', 'accept-charset' => 'UTF-8')); ?>
                        <input name="FormType" type="hidden" value="customer_register">
                        <input name="utf8" type="hidden" value="true">

                        <div class="auth-form-grid-2">
                            <!-- Hàng 1: Tên đăng nhập & Họ tên -->
                            <div class="auth-col-6">
                                <div class="auth-form-group">
                                    <label class="auth-label">Tên đăng nhập <span class="req">*</span></label>
                                    <div class="auth-input-wrap">
                                        <input type="text" id="username" name="username" class="auth-input" placeholder="Tên tài khoản (viết liền)" value="<?php echo set_value('username'); ?>" required autofocus>
                                        <i class="fas fa-user auth-input-icon"></i>
                                    </div>
                                    <div class="auth-error-msg"><?php echo form_error('username'); ?></div>
                                </div>
                            </div>

                            <div class="auth-col-6">
                                <div class="auth-form-group">
                                    <label class="auth-label">Họ và tên <span class="req">*</span></label>
                                    <div class="auth-input-wrap">
                                        <input type="text" id="name" name="name" class="auth-input" placeholder="Họ và tên của bạn" value="<?php echo set_value('name'); ?>" required>
                                        <i class="fas fa-id-card auth-input-icon"></i>
                                    </div>
                                    <div class="auth-error-msg"><?php echo form_error('name'); ?></div>
                                </div>
                            </div>

                            <!-- Hàng 2: Email & Số điện thoại -->
                            <div class="auth-col-6">
                                <div class="auth-form-group">
                                    <label class="auth-label">Địa chỉ Email <span class="req">*</span></label>
                                    <div class="auth-input-wrap">
                                        <input type="email" id="email" name="email" class="auth-input" placeholder="email@example.com" value="<?php echo set_value('email'); ?>" required>
                                        <i class="fas fa-envelope auth-input-icon"></i>
                                    </div>
                                    <div class="auth-error-msg"><?php echo form_error('email'); ?></div>
                                </div>
                            </div>

                            <div class="auth-col-6">
                                <div class="auth-form-group">
                                    <label class="auth-label">Số điện thoại <span class="req">*</span></label>
                                    <div class="auth-input-wrap">
                                        <input type="tel" id="phone" name="phone" class="auth-input" placeholder="Số điện thoại nhận hàng" value="<?php echo set_value('phone'); ?>" required>
                                        <i class="fas fa-phone-alt auth-input-icon"></i>
                                    </div>
                                    <div class="auth-error-msg"><?php echo form_error('phone'); ?></div>
                                </div>
                            </div>

                            <!-- Hàng 3: Mật khẩu & Nhập lại mật khẩu -->
                            <div class="auth-col-6">
                                <div class="auth-form-group">
                                    <label class="auth-label">Mật khẩu <span class="req">*</span></label>
                                    <div class="auth-input-wrap">
                                        <input type="password" id="register-form-password" name="password" class="auth-input has-toggle" placeholder="Tối thiểu 6 ký tự" required>
                                        <i class="fas fa-lock auth-input-icon"></i>
                                        <button type="button" class="auth-toggle-pwd" onclick="togglePasswordVisibility('register-form-password', this)" title="Ẩn/Hiện">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="auth-error-msg"><?php echo form_error('password'); ?></div>
                                </div>
                            </div>

                            <div class="auth-col-6">
                                <div class="auth-form-group">
                                    <label class="auth-label">Xác nhận mật khẩu <span class="req">*</span></label>
                                    <div class="auth-input-wrap">
                                        <input type="password" id="register-form-repassword" name="re_password" class="auth-input has-toggle" placeholder="Nhập lại mật khẩu" required>
                                        <i class="fas fa-shield-alt auth-input-icon"></i>
                                        <button type="button" class="auth-toggle-pwd" onclick="togglePasswordVisibility('register-form-repassword', this)" title="Ẩn/Hiện">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="auth-error-msg"><?php echo form_error('re_password'); ?></div>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 10px;">
                            <button type="submit" class="btn-auth-submit" id="register-form-submit" name="register-form-submit">
                                <i class="fas fa-user-check"></i> ĐĂNG KÝ TÀI KHOẢN NGAY
                            </button>
                        </div>
                    <?php echo form_close(); ?>

                    <!-- Footer Link -->
                    <div class="auth-footer-text">
                        Đã có tài khoản thành viên? <a href="<?php echo base_url('dang-nhap'); ?>">Đăng nhập ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function togglePasswordVisibility(fieldId, btn) {
        var input = document.getElementById(fieldId);
        var icon = btn.querySelector('i');
        if (input.type === "password") {
            input.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
