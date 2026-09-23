<section id="contact-page" class="contact-page">
    <div class="container" style="margin-top: 40px; margin-bottom: 50px;">
        <div class="row">
            <!-- Cột trái: Form Liên hệ -->
            <div class="col-md-7">
                <div class="contact-form-wrapper card-shadow">
                    <div class="section-header-modern">
                        <i class="fa fa-envelope-o"></i>
                        <h2>Gửi lời nhắn cho chúng tôi</h2>
                    </div>
                    
                    <?php if(validation_errors()): ?>
                        <div class="alert alert-danger">
                            <?php echo validation_errors(); ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open('lien-he', array('id' => 'contact-form', 'class' => 'modern-form')); ?>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Họ tên <span class="required">*</span></label>
                                    <input name="fullname" type="text" class="form-control-modern" placeholder="Họ tên của bạn" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email <span class="required">*</span></label>
                                    <input name="email" type="email" class="form-control-modern" placeholder="Email liên hệ" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Số điện thoại <span class="required">*</span></label>
                                    <input name="phone" type="text" class="form-control-modern" placeholder="SĐT của bạn" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tiêu đề <span class="required">*</span></label>
                            <input name="title" type="text" class="form-control-modern" placeholder="Vấn đề bạn cần hỗ trợ" required>
                        </div>
                        <div class="form-group">
                            <label>Lời nhắn <span class="required">*</span></label>
                            <textarea name="content" class="form-control-modern" rows="5" placeholder="Nhập nội dung lời nhắn tại đây..." required></textarea>
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-danger btn-lg btn-modern-submit">
                                GỬI NHẬN XÉT <i class="fa fa-paper-plane"></i>
                            </button>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>

            <!-- Cột phải: Thông tin liên hệ -->
            <div class="col-md-5">
                <div class="contact-info-wrapper card-shadow">
                    <div class="section-header-modern">
                        <i class="fa fa-map-marker"></i>
                        <h2>Thông tin liên hệ</h2>
                    </div>
                    <ul class="contact-details-list">
                        <li>
                            <div class="detail-icon"><i class="fas fa-home"></i></div>
                            <div class="detail-text">
                                <strong>Địa chỉ:</strong>
                                <p>Thôn 6 - Phường Trung Sơn - tỉnh Ninh Bình</p>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="detail-text">
                                <strong>Hotline:</strong>
                                <p>0794 358 619 - 0362 289 521</p>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon"><i class="fas fa-envelope"></i></div>
                            <div class="detail-text">
                                <strong>Email:</strong>
                                <p>namok030805@gmail.com</p>
                            </div>
                        </li>
                        <li>
                            <div class="detail-icon"><i class="fas fa-clock"></i></div>
                            <div class="detail-text">
                                <strong>Giờ làm việc:</strong>
                                <p>Tất cả các ngày trong tuần (08:00 - 21:00)</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bản đồ -->
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="map-wrapper card-shadow">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d955650.6961528348!2d105.26007606249999!3d20.669150519151252!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31366500025735e9%3A0x47720df6fd324dc7!2zTmjDoCBWxrDhu51uIEN1bmcgQ-G6pXAgxJDDoG8gUGhhaSBOZ-G7jWMgSHXDqg!5e0!3m2!1svi!2s!4v1778742552858!5m2!1svi!2s" width="100%" height="450" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>
