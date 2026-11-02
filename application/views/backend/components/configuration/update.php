<div class="content-wrapper">
    <?php echo form_open('admin/configuration/update'); ?>
        <section class="content-header">
            <div class="header-left">
                <h1>
                    Cấu hình Hệ thống
                    <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Thiết lập thông tin thương hiệu, SEO, vận chuyển & SMTP Email</small>
                </h1>
            </div>
            <div class="header-right">
                <button type="submit" class="btn btn-save-config">
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
                <!-- CỘT TRÁI: THÔNG TIN CỬA HÀNG & SEO -->
                <div class="col-lg-7 col-md-12">
                    <div class="config-card">
                        <div class="card-header">
                            <div class="card-icon blue">
                                <i class="fa fa-globe"></i>
                            </div>
                            <div class="card-title-group">
                                <h3 class="card-title">Cửa hàng & Tối ưu SEO</h3>
                                <p class="card-desc">Thiết lập tiêu đề website, thông tin thương hiệu và hotline bán hàng</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group modern-fg">
                                <label class="fg-label">Tiêu đề Website (Site Title) <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa fa-header input-icon"></i>
                                    <input type="text" id="site_title" class="form-control modern-input" name="title" 
                                           placeholder="Ví dụ: NDN Mobile - Điện thoại & Phụ kiện chính hãng" 
                                           value="<?php echo htmlspecialchars(isset($row['title']) ? $row['title'] : ''); ?>" required>
                                </div>
                                <span class="fg-hint">Xuất hiện trên thanh tiêu đề trình duyệt và kết quả tìm kiếm Google.</span>
                            </div>

                            <div class="form-group modern-fg">
                                <label class="fg-label">Mô tả Website (Meta Description) <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa fa-align-left input-icon textarea-icon"></i>
                                    <textarea id="site_desc" class="form-control modern-textarea" name="description" rows="3" 
                                              placeholder="Nhập mô tả tóm tắt về NDN Mobile..." required><?php echo htmlspecialchars(isset($row['description']) ? $row['description'] : ''); ?></textarea>
                                </div>
                                <div class="char-counter">Khuyến nghị: 120 - 160 ký tự</div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Hotline tư vấn</label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-phone input-icon"></i>
                                            <input type="text" class="form-control modern-input" name="phone_hotline" 
                                                   placeholder="098.xxx.xxxx hoặc 1900.xxxx" 
                                                   value="<?php echo htmlspecialchars(isset($row['phone_hotline']) ? $row['phone_hotline'] : '098.345.6789'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group modern-fg">
                                        <label class="fg-label">Phí giao hàng mặc định <span class="required">*</span></label>
                                        <div class="input-with-icon">
                                            <i class="fa fa-truck input-icon"></i>
                                            <input type="number" id="price_ship" class="form-control modern-input" name="priceShip" 
                                                   placeholder="0" value="<?php echo (int)(isset($row['priceShip']) ? $row['priceShip'] : 0); ?>" required>
                                        </div>
                                        <div class="ship-preview" id="ship_preview">
                                            <?php 
                                            $ship = (int)(isset($row['priceShip']) ? $row['priceShip'] : 0);
                                            if($ship <= 0) {
                                                echo '<span class="badge-free"><i class="fa fa-gift"></i> Miễn phí giao hàng (FreeShip toàn quốc)</span>';
                                            } else {
                                                echo '<span class="badge-fee"><i class="fa fa-money"></i> Phí ship: ' . number_format($ship) . '₫</span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Google SERP Live Preview -->
                            <div class="google-preview-box">
                                <div class="google-preview-title"><i class="fa fa-google text-primary"></i> Xem trước hiển thị trên Google Search</div>
                                <div class="serp-wrapper">
                                    <div class="serp-url">https://ndnmobile.vn <i class="fa fa-angle-down"></i></div>
                                    <div class="serp-title" id="serp_title_preview"><?php echo htmlspecialchars(!empty($row['title']) ? $row['title'] : 'NDN Mobile'); ?></div>
                                    <div class="serp-desc" id="serp_desc_preview"><?php echo htmlspecialchars(!empty($row['description']) ? $row['description'] : 'Hệ thống bán lẻ điện thoại di động, phụ kiện chính hãng giá rẻ uy tín nhất.'); ?></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- CỘT PHẢI: EMAIL & SMTP GỬI THÔNG BÁO -->
                <div class="col-lg-5 col-md-12">
                    <div class="config-card">
                        <div class="card-header">
                            <div class="card-icon red">
                                <i class="fa fa-envelope-o"></i>
                            </div>
                            <div class="card-title-group">
                                <h3 class="card-title">Cấu hình Mail Server (SMTP)</h3>
                                <p class="card-desc">Gửi email xác nhận đơn hàng tự động cho khách & nhận thông báo đơn mới</p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-group modern-fg">
                                <label class="fg-label">Email gửi SMTP <span class="required">*</span></label>
                                <div class="input-with-icon">
                                    <i class="fa fa-at input-icon"></i>
                                    <input type="email" class="form-control modern-input" name="mail_smtp" 
                                           placeholder="vd: phambanam385@gmail.com" 
                                           value="<?php echo htmlspecialchars(isset($row['mail_smtp']) ? $row['mail_smtp'] : ''); ?>" required>
                                </div>
                                <span class="fg-hint">Tài khoản Gmail hoặc Google Workspace dùng để bắn email.</span>
                            </div>

                            <div class="form-group modern-fg">
                                <label class="fg-label">Mật khẩu ứng dụng SMTP (App Password)</label>
                                <div class="input-with-icon has-action-btn">
                                    <i class="fa fa-key input-icon"></i>
                                    <input type="password" id="smtp_pwd" class="form-control modern-input" name="mail_smtp_password" 
                                           placeholder="Mật khẩu 16 ký tự ứng dụng Google" 
                                           value="<?php echo htmlspecialchars(isset($row['mail_smtp_password']) ? $row['mail_smtp_password'] : ''); ?>">
                                    <button type="button" class="btn-toggle-pwd" id="toggle_pwd" title="Ẩn/Hiện mật khẩu">
                                        <i class="fa fa-eye" id="pwd_icon"></i>
                                    </button>
                                </div>
                                <span class="fg-hint">Không dùng mật khẩu đăng nhập Gmail thường. Hãy tạo Mật khẩu ứng dụng 16 ký tự trong bảo mật 2 lớp Google.</span>
                            </div>

                            <div class="form-group modern-fg">
                                <label class="fg-label">Email Admin nhận thông báo đơn mới</label>
                                <div class="input-with-icon">
                                    <i class="fa fa-bell-o input-icon"></i>
                                    <input type="email" class="form-control modern-input" name="mail_noreply" 
                                           placeholder="admin@ndnmobile.vn" 
                                           value="<?php echo htmlspecialchars(isset($row['mail_noreply']) ? $row['mail_noreply'] : ''); ?>">
                                </div>
                                <span class="fg-hint">Hệ thống sẽ gửi email báo ngay khi có khách đặt đơn hàng thành công.</span>
                            </div>

                            <!-- SMTP Helper Note -->
                            <div class="smtp-help-box">
                                <div class="help-header"><i class="fa fa-lightbulb-o"></i> Hướng dẫn kết nối Gmail SMTP:</div>
                                <ol class="help-steps">
                                    <li>Bật <b>Xác minh 2 bước</b> cho tài khoản Google của bạn.</li>
                                    <li>Truy cập <b>Bảo mật ➔ Mật khẩu ứng dụng (App Passwords)</b>.</li>
                                    <li>Chọn ứng dụng "Thư", tạo mã và dán mật khẩu 16 ký tự vào ô phía trên.</li>
                                </ol>
                            </div>

                            <!-- Bottom Action Button for Mobile / Small Screens -->
                            <div style="margin-top: 25px;">
                                <button type="submit" class="btn btn-save-config btn-block" style="padding: 12px;">
                                    <i class="fa fa-check"></i> Lưu tất cả cài đặt
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php echo form_close(); ?>
</div>

<!-- JAVASCRIPT HỖ TRỢ LIVE PREVIEW VÀ ẨN/HIỆN MẬT KHẨU -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // 1. Toggle mật khẩu SMTP
    const toggleBtn = document.getElementById('toggle_pwd');
    const pwdInput = document.getElementById('smtp_pwd');
    const pwdIcon = document.getElementById('pwd_icon');

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

    // 2. Google SERP Live Preview
    const siteTitle = document.getElementById('site_title');
    const siteDesc = document.getElementById('site_desc');
    const serpTitle = document.getElementById('serp_title_preview');
    const serpDesc = document.getElementById('serp_desc_preview');

    if (siteTitle && serpTitle) {
        siteTitle.addEventListener('input', function() {
            serpTitle.textContent = this.value.trim() || 'NDN Mobile - Điện thoại & Phụ kiện';
        });
    }

    if (siteDesc && serpDesc) {
        siteDesc.addEventListener('input', function() {
            serpDesc.textContent = this.value.trim() || 'Hệ thống bán lẻ điện thoại di động chính hãng uy tín giá tốt nhất.';
        });
    }

    // 3. Price Ship Live Badge
    const priceShipInput = document.getElementById('price_ship');
    const shipPreview = document.getElementById('ship_preview');

    if (priceShipInput && shipPreview) {
        priceShipInput.addEventListener('input', function() {
            const val = parseInt(this.value, 10) || 0;
            if (val <= 0) {
                shipPreview.innerHTML = '<span class="badge-free"><i class="fa fa-gift"></i> Miễn phí giao hàng (FreeShip toàn quốc)</span>';
            } else {
                shipPreview.innerHTML = '<span class="badge-fee"><i class="fa fa-money"></i> Phí ship: ' + val.toLocaleString('vi-VN') + '₫</span>';
            }
        });
    }
});
</script>

<!-- STYLESHEET CAO CẤP NDN MOBILE LUXURY -->
<style>
/* Layout Content Header */
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

/* Nút Lưu cấu hình màu đỏ thương hiệu */
.btn-save-config {
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
.btn-save-config:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45);
    color: #fff !important;
}

/* Flash Messages */
.alert-modern {
    border-radius: 10px;
    border: none;
    padding: 14px 18px;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.04);
}
.alert-modern .close {
    margin-left: auto;
    opacity: 0.7;
    outline: none;
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

/* Thẻ Card Cấu hình */
.config-card {
    background: #ffffff;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    border: 1px solid #eef2f5;
    margin-bottom: 25px;
    overflow: hidden;
    transition: all 0.25s ease;
}
.config-card:hover {
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.08);
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

/* Nhóm nhập liệu Hiện đại */
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
    line-height: 1.4;
}

/* Input with Icon */
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
.textarea-icon {
    top: 14px;
}
.modern-input, .modern-textarea {
    width: 100%;
    padding: 10px 14px 10px 40px !important;
    border-radius: 8px !important;
    border: 1px solid #d1d5db !important;
    font-size: 14px;
    color: #1f2937;
    background: #fff;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
}
.modern-input:focus, .modern-textarea:focus {
    border-color: #d70018 !important;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12) !important;
    outline: none;
}
.char-counter {
    text-align: right;
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 4px;
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

/* Ship preview badge */
.ship-preview {
    margin-top: 7px;
}
.badge-free {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #d4edda;
    color: #155724;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}
.badge-fee {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #e2e8f0;
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
}

/* Google SERP Live Preview Box */
.google-preview-box {
    margin-top: 25px;
    padding: 16px;
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 10px;
}
.google-preview-title {
    font-size: 13px;
    font-weight: 700;
    color: #475569;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.serp-wrapper {
    background: #ffffff;
    padding: 14px 18px;
    border-radius: 8px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    font-family: Arial, sans-serif;
}
.serp-url {
    font-size: 12px;
    color: #202124;
    margin-bottom: 3px;
}
.serp-title {
    font-size: 17px;
    font-weight: 500;
    color: #1a0dab;
    cursor: pointer;
    line-height: 1.3;
    margin-bottom: 4px;
    word-break: break-word;
}
.serp-desc {
    font-size: 13px;
    color: #4d5156;
    line-height: 1.45;
    word-break: break-word;
}

/* SMTP Helper Box */
.smtp-help-box {
    background: #fffbeb;
    border-left: 4px solid #f59e0b;
    border-radius: 8px;
    padding: 14px 16px;
    margin-top: 20px;
}
.help-header {
    font-size: 13px;
    font-weight: 700;
    color: #92400e;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.help-steps {
    margin: 0;
    padding-left: 18px;
    font-size: 12px;
    color: #78350f;
    line-height: 1.6;
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
    .btn-save-config {
        width: 100%;
        justify-content: center;
    }
}
</style>
