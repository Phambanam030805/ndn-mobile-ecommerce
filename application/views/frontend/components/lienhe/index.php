<section id="contact-page" class="contact-luxury-page">
    <!-- Hero Header Hiện Đại -->
    <div class="contact-hero-luxury">
        <div class="container">
            <span class="contact-hero-badge">
                <i class="fas fa-headset"></i> Trung tâm chăm sóc & hỗ trợ khách hàng
            </span>
            <h1 class="contact-hero-title">Liên Hệ & Hỗ Trợ Kỹ Thuật</h1>
            <p class="contact-hero-desc">
                Đội ngũ chuyên viên NDN Mobile luôn sẵn sàng giải đáp mọi thắc mắc, tư vấn chọn máy và hỗ trợ bảo hành nhanh chóng, tận tình nhất.
            </p>
        </div>
    </div>

    <div class="container">
        <!-- Breadcrumb -->
        <div class="breadcrumbs-modern mb-4" style="font-size: 13.5px; color: #64748b; margin-bottom: 25px;">
            <a href="<?php echo base_url(); ?>" style="color: #64748b; text-decoration: none;"><i class="fa fa-home"></i> Trang chủ</a>
            <span style="margin: 0 8px; color: #cbd5e1;">/</span>
            <span style="color: #0f172a; font-weight: 700;">Liên hệ & Hỗ trợ</span>
        </div>

        <div class="row">
            <!-- Cột trái: Form Gửi lời nhắn / Hỗ trợ -->
            <div class="col-md-7 col-sm-12">
                <div class="contact-card-box">
                    <div class="contact-box-header">
                        <div class="header-icon">
                            <i class="far fa-envelope-open"></i>
                        </div>
                        <h3>Gửi Lời Nhắn Cho Chúng Tôi</h3>
                    </div>
                    
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger" style="border-radius: 10px; font-size: 13.5px;">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('lien-he', array('id' => 'contact-form', 'class' => 'contact-luxury-form')); ?>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Họ và tên <span class="req">*</span></label>
                                    <input name="fullname" type="text" class="contact-input-modern" placeholder="Ví dụ: Nguyễn Văn A" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group">
                                    <label>Số điện thoại <span class="req">*</span></label>
                                    <input name="phone" type="tel" class="contact-input-modern" placeholder="Ví dụ: 0912 345 678" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Địa chỉ Email <span class="req">*</span></label>
                            <input name="email" type="email" class="contact-input-modern" placeholder="Ví dụ: customer@gmail.com" required>
                        </div>

                        <div class="form-group">
                            <label>Chủ đề cần hỗ trợ <span class="req">*</span></label>
                            <input name="title" type="text" class="contact-input-modern" placeholder="Ví dụ: Tư vấn trả góp, Bảo hành máy..." required>
                        </div>

                        <div class="form-group">
                            <label>Nội dung chi tiết <span class="req">*</span></label>
                            <textarea name="content" class="contact-input-modern" rows="5" placeholder="Mô tả cụ thể yêu cầu hoặc thắc mắc của bạn..." required></textarea>
                        </div>

                        <div class="text-right" style="margin-top: 10px;">
                            <button type="submit" class="btn-contact-submit">
                                <i class="fas fa-paper-plane"></i> GỬI YÊU CẦU HỖ TRỢ
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Cột phải: Thông tin liên hệ & Kênh hỗ trợ trực tiếp -->
            <div class="col-md-5 col-sm-12">
                <div class="contact-card-box">
                    <div class="contact-box-header">
                        <div class="header-icon">
                            <i class="fas fa-store"></i>
                        </div>
                        <h3>Thông Tin Showroom</h3>
                    </div>

                    <ul class="contact-info-list">
                        <li>
                            <div class="info-icon-circle">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div class="info-content">
                                <strong>Địa chỉ cửa hàng:</strong>
                                <p>Tổ 6A, Phường Trung Sơn, Thành phố Tam Điệp, Tỉnh Ninh Bình</p>
                            </div>
                        </li>
                        <li>
                            <div class="info-icon-circle">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div class="info-content">
                                <strong>Đường dây nóng (Hotline):</strong>
                                <p>
                                    <a href="tel:0794358619" style="color: #d70018; font-weight: 700; text-decoration: none;">0794 358 619</a> • 
                                    <a href="tel:0362289521" style="color: #d70018; font-weight: 700; text-decoration: none;">0362 289 521</a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="info-icon-circle">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <strong>Hộp thư điện tử:</strong>
                                <p>
                                    <a href="mailto:phambanam385@gmail.com" onclick="openEmailModal(event, 'phambanam385@gmail.com')" style="color: inherit; text-decoration: none;">
                                        phambanam385@gmail.com
                                    </a>
                                </p>
                            </div>
                        </li>
                        <li>
                            <div class="info-icon-circle">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="info-content">
                                <strong>Thời gian phục vụ:</strong>
                                <p>08:00 – 21:30 (Mở cửa tất cả các ngày trong tuần, kể cả ngày lễ)</p>
                            </div>
                        </li>
                    </ul>

                    <!-- Kênh kết nối trực tiếp -->
                    <div class="contact-quick-channels">
                        <h4><i class="fas fa-bolt"></i> Kết nối nhanh với chuyên viên</h4>
                        <div class="channels-btn-grid">
                            <a href="tel:0794358619" class="btn-channel call">
                                <i class="fas fa-phone-volume"></i> Gọi Hotline
                            </a>
                            <a href="https://zalo.me/0794358619" target="_blank" rel="noopener noreferrer" class="btn-channel zalo">
                                <i class="fas fa-comment-dots"></i> Chat Zalo 24/7
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bản đồ Google Maps Chuẩn Trung Sơn - Ninh Bình -->
        <div class="row">
            <div class="col-md-12">
                <div class="contact-map-card">
                    <div class="map-header">
                        <h3><i class="fas fa-map-marked-alt"></i> Bản Đồ Chỉ Đường Đến Showroom</h3>
                        <span class="map-badge-location">
                            <i class="fas fa-location-arrow" style="color: #d70018;"></i> Phường Trung Sơn, Ninh Bình
                        </span>
                    </div>
                    <div style="position: relative; overflow: hidden; border-radius: 12px; box-shadow: inset 0 0 10px rgba(0,0,0,0.05);">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14949.774238515456!2d105.894676!3d20.145719!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31366551b9e8a7ef%3A0x9d54e4fb6e39281!2zVHJ1bmcgU8ahbiwgVHAuIFRhbSDEkGnhu4dwLCBOaW5oIELDrG5oLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1700000000000!5m2!1svi!2s" 
                            width="100%" 
                            height="420" 
                            style="border:0; display: block;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
