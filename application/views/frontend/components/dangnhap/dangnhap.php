<section class="auth-page-luxury">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="auth-card-luxury login-box">
                    <!-- Header -->
                    <div class="auth-header">
                        <div class="auth-logo-badge">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h1 class="auth-title">Đăng Nhập</h1>
                        <p class="auth-subtitle">Chào mừng bạn quay trở lại với NDN Mobile</p>
                    </div>

                    <!-- Switch Tabs: Đăng nhập / Đăng ký -->
                    <div class="auth-switch-tabs">
                        <a href="<?php echo base_url('dang-nhap'); ?>" class="auth-switch-tab active">
                            <i class="fas fa-sign-in-alt"></i> Đăng nhập
                        </a>
                        <a href="<?php echo base_url('dang-ky'); ?>" class="auth-switch-tab">
                            <i class="fas fa-user-plus"></i> Đăng ký
                        </a>
                    </div>

                    <!-- Thông báo Flashdata -->
                    <?php if($this->session->flashdata('success')): ?>
                        <div class="alert alert-success" style="border-radius: 10px; font-size: 13.5px;">
                            <i class="fas fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if($this->session->flashdata('error')): ?>
                        <div class="alert alert-warning" style="border-radius: 10px; font-size: 13.5px;">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger" style="border-radius: 10px; font-size: 13.5px;">
                            <i class="fas fa-times-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Form Đăng Nhập -->
                    <?php echo form_open('dang-nhap', array('id' => 'customer_login', 'accept-charset' => 'UTF-8')); ?>
                        
                        <!-- Tên đăng nhập -->
                        <div class="auth-form-group">
                            <label class="auth-label">Tài khoản hoặc Email <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <input type="text" id="login-form-username" name="username" class="auth-input" placeholder="Nhập tên đăng nhập của bạn" required autofocus>
                                <i class="fas fa-user auth-input-icon"></i>
                            </div>
                            <div class="auth-error-msg"><?php echo form_error('username'); ?></div>
                        </div>

                        <!-- Mật khẩu -->
                        <div class="auth-form-group">
                            <label class="auth-label">Mật khẩu <span class="req">*</span></label>
                            <div class="auth-input-wrap">
                                <input type="password" id="login-form-password" name="password" class="auth-input has-toggle" placeholder="Nhập mật khẩu" required>
                                <i class="fas fa-key auth-input-icon"></i>
                                <button type="button" class="auth-toggle-pwd" onclick="togglePasswordVisibility('login-form-password', this)" title="Ẩn/Hiện mật khẩu">
                                    <i class="far fa-eye"></i>
                                </button>
                            </div>
                            <div class="auth-error-msg"><?php echo form_error('password'); ?></div>
                        </div>

                        <!-- Quên mật khẩu link -->
                        <div class="auth-action-row">
                            <label style="font-size: 13px; color: #64748b; margin: 0; font-weight: normal; cursor: pointer;">
                                <input type="checkbox" name="remember" style="margin-right: 5px;"> Ghi nhớ đăng nhập
                            </label>
                            <a href="<?php echo base_url('quen-mat-khau'); ?>" class="auth-forgot-link">
                                Quên mật khẩu?
                            </a>
                        </div>

                        <!-- Nút Đăng Nhập -->
                        <button type="submit" class="btn-auth-submit" id="login-form-submit" name="login-form-submit" value="login">
                            <i class="fas fa-sign-in-alt"></i> ĐĂNG NHẬP NGAY
                        </button>

                    <?php echo form_close(); ?>

                    <!-- Footer Link -->
                    <div class="auth-footer-text">
                        Chưa có tài khoản? <a href="<?php echo base_url('dang-ky'); ?>">Đăng ký tài khoản mới</a>
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