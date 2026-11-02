<section class="policy-page" style="background: #f8f9fa; padding: 40px 0 60px 0;">
    <div class="container">
        <!-- Breadcrumb -->
        <ol class="breadcrumb" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.03); margin-bottom: 25px;">
            <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
            <li><a href="#">Hỗ trợ khách hàng</a></li>
            <li class="active">Hướng dẫn thanh toán</li>
        </ol>

        <div class="row">
            <!-- Sidebar hỗ trợ -->
            <div class="col-md-3 col-sm-4">
                <div class="card-shadow" style="background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 25px;">
                    <h4 style="font-size: 16px; font-weight: 700; margin-top: 0; padding-bottom: 12px; border-bottom: 2px solid #d70018; color: #222;">
                        <i class="fa fa-life-ring" style="color: #d70018;"></i> HỖ TRỢ KHÁCH HÀNG
                    </h4>
                    <ul class="list-unstyled" style="margin: 0; padding: 0;">
                        <li style="padding: 10px 0; border-bottom: 1px dashed #eee;">
                            <a href="<?php echo base_url('huong-dan-thanh-toan'); ?>" style="color: #d70018; font-weight: 600;">
                                <i class="fa fa-chevron-right" style="font-size: 11px;"></i> Hướng dẫn thanh toán
                            </a>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px dashed #eee;">
                            <a href="<?php echo base_url('huong-dan-dat-hang'); ?>" style="color: #555;">
                                <i class="fa fa-chevron-right" style="font-size: 11px;"></i> Hướng dẫn đặt hàng
                            </a>
                        </li>
                        <li style="padding: 10px 0; border-bottom: 1px dashed #eee;">
                            <a href="<?php echo base_url('dieu-khoan-dich-vu'); ?>" style="color: #555;">
                                <i class="fa fa-chevron-right" style="font-size: 11px;"></i> Điều khoản dịch vụ
                            </a>
                        </li>
                        <li style="padding: 10px 0;">
                            <a href="<?php echo base_url('chinh-sach-bao-mat'); ?>" style="color: #555;">
                                <i class="fa fa-chevron-right" style="font-size: 11px;"></i> Chính sách bảo mật
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="card-shadow text-center" style="background: linear-gradient(135deg, #d70018 0%, #b30014 100%); color: #fff; border-radius: 12px; padding: 25px 15px; box-shadow: 0 4px 15px rgba(215, 0, 24, 0.25);">
                    <i class="fa fa-phone" style="font-size: 32px; margin-bottom: 10px; color: #fff;"></i>
                    <h5 style="margin: 0 0 6px 0; font-weight: 700; color: #fff; font-size: 16px;">Cần hỗ trợ thanh toán?</h5>
                    <p style="font-size: 12px; color: rgba(255, 255, 255, 0.9); margin-bottom: 14px; line-height: 1.4;">Đội ngũ CSKH luôn sẵn sàng 24/7</p>
                    <a href="tel:0794358619" style="display: inline-block; background: #ffffff !important; color: #d70018 !important; border-radius: 24px; font-weight: 800; font-size: 14px; padding: 8px 22px; text-decoration: none; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15); transition: transform 0.2s ease;">
                        <i class="fa fa-phone-alt" style="margin-right: 5px;"></i> 0794.358.619
                    </a>
                </div>
            </div>

            <!-- Nội dung chính -->
            <div class="col-md-9 col-sm-8">
                <div class="card-shadow" style="background: #fff; border-radius: 10px; padding: 35px 30px;">
                    <h1 style="font-size: 24px; font-weight: 700; color: #222; margin-top: 0; padding-bottom: 15px; border-bottom: 1px solid #eee;">
                        <i class="fa fa-credit-card" style="color: #d70018;"></i> Hướng Dẫn Các Phương Thức Thanh Toán Tại NDN Mobile
                    </h1>
                    <p style="color: #666; font-size: 14px; margin-top: 15px;">
                        Nhằm mang lại trải nghiệm mua sắm tiện lợi, nhanh chóng và an toàn tuyệt đối, <strong>NDN Mobile</strong> hỗ trợ đa dạng các hình thức thanh toán linh hoạt:
                    </p>

                    <!-- Cách 1: Quét mã QR VietQR -->
                    <div style="background: #fdf6f6; border-left: 4px solid #d70018; padding: 20px; border-radius: 0 8px 8px 0; margin: 25px 0;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #d70018; margin-top: 0;">
                            <i class="fa fa-qrcode"></i> 1. Thanh toán chuyển khoản tự động qua VietQR (Khuyên dùng)
                        </h3>
                        <p style="color: #444; line-height: 1.6; margin-bottom: 10px;">
                            Hệ thống tích hợp cổng thanh toán <strong>VietQR chuẩn Vietcombank</strong> tự động nhận diện và xử lý đơn hàng trong tích tắc:
                        </p>
                        <ul style="padding-left: 20px; color: #555; line-height: 1.7;">
                            <li>Khi đặt hàng chọn phương thức <strong>"Chuyển khoản VietQR"</strong>.</li>
                            <li>Hệ thống sẽ hiển thị mã QR động chứa sẵn <strong>Số tiền chính xác</strong> và <strong>Mã đơn hàng (Memo)</strong>.</li>
                            <li>Khách hàng mở bất kỳ ứng dụng ngân hàng nào (Vietcombank, MB Bank, Techcombank, VPBank,...) hoặc ví điện tử để quét mã và xác nhận chuyển tiền.</li>
                            <li>Giao dịch hoàn toàn miễn phí và đơn hàng được tự động kích hoạt ngay lập tức.</li>
                        </ul>
                    </div>

                    <!-- Cách 2: COD -->
                    <div style="background: #f8f9fa; border-left: 4px solid #006837; padding: 20px; border-radius: 0 8px 8px 0; margin: 25px 0;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #006837; margin-top: 0;">
                            <i class="fa fa-truck"></i> 2. Thanh toán tiền mặt khi nhận hàng (COD)
                        </h3>
                        <p style="color: #444; line-height: 1.6; margin-bottom: 10px;">
                            Khách hàng hoàn toàn yên tâm khi mua sắm tại NDN Mobile:
                        </p>
                        <ul style="padding-left: 20px; color: #555; line-height: 1.7;">
                            <li>Nhân viên giao hàng sẽ liên hệ trước khi phát hàng.</li>
                            <li>Khách hàng được quyền đồng kiểm, kiểm tra tem niêm phong và ngoại quan máy trước khi thanh toán.</li>
                            <li>Thanh toán trực tiếp bằng tiền mặt cho shipper và nhận biên lai giao dịch.</li>
                        </ul>
                    </div>

                    <!-- Cách 3: Thẻ quốc tế Visa / MasterCard / JCB -->
                    <div style="background: #f4f8fb; border-left: 4px solid #0056b3; padding: 20px; border-radius: 0 8px 8px 0; margin: 25px 0;">
                        <h3 style="font-size: 18px; font-weight: 700; color: #0056b3; margin-top: 0;">
                            <i class="fa fa-globe"></i> 3. Thanh toán bằng Thẻ Quốc Tế & Thẻ Tín Dụng
                        </h3>
                        <p style="color: #444; line-height: 1.6;">
                            Hỗ trợ tất cả các thẻ phát hành bởi ngân hàng nội địa và quốc tế: <strong>Visa, MasterCard, JCB</strong> thông qua cổng kết nối bảo mật đạt chuẩn quốc tế PCI-DSS.
                        </p>
                    </div>

                    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #eee;">
                        <h4 style="font-size: 16px; font-weight: 700; color: #222;">Thông tin tài khoản thụ hưởng chính thức:</h4>
                        <div style="background: #fdfdfd; border: 1px solid #e2e8f0; border-radius: 8px; padding: 15px; margin-top: 10px;">
                            <p style="margin: 4px 0;"><strong>Ngân hàng:</strong> Vietcombank (Ngân hàng TMCP Ngoại thương Việt Nam)</p>
                            <p style="margin: 4px 0;"><strong>Số tài khoản:</strong> <span style="color: #d70018; font-weight: 700; font-size: 16px;">1915403967</span></p>
                            <p style="margin: 4px 0;"><strong>Chủ tài khoản:</strong> PHAM BA NAM</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
