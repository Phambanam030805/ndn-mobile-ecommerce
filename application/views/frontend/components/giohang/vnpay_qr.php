<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$bank_id       = '970436'; // BIN Vietcombank
$bank_name     = 'Vietcombank (Ngân hàng TMCP Ngoại thương Việt Nam)';
$account_no    = '1915403967';
$account_name  = 'PHAM BA NAM';
$amount        = (int)$order['money'];
$memo          = 'NDN ' . $order['orderCode'];

// Tạo URL mã VietQR chuẩn ngân hàng
$qr_url = "https://img.vietqr.io/image/{$bank_id}-{$account_no}-compact2.png?amount={$amount}&addInfo=" . urlencode($memo) . "&accountName=" . urlencode($account_name);
?>

<div class="container" style="padding: 40px 15px; max-width: 900px;">
    <div style="background: #fff; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; border: 1px solid #e9ecef;">
        
        <!-- Header Cổng Thanh Toán -->
        <div style="background: linear-gradient(135deg, #006837 0%, #004d26 100%); padding: 22px 30px; color: #fff; display: flex; align-items: center; justify-content: space-between;">
            <div style="display: flex; align-items: center; gap: 15px;">
                <div style="background: #fff; border-radius: 8px; padding: 6px 12px; font-weight: bold; color: #006837; font-size: 16px;">
                    <i class="fas fa-qrcode"></i> VietQR
                </div>
                <div>
                    <h3 style="margin: 0; font-size: 19px; font-weight: 700; color: #fff;">Cổng Thanh Toán Chuyển Khoản Trực Tuyến</h3>
                    <p style="margin: 3px 0 0; font-size: 13px; opacity: 0.9;">Đơn hàng #<strong><?php echo $order['orderCode']; ?></strong></p>
                </div>
            </div>
            <div style="text-align: right;" class="hidden-xs">
                <span style="font-size: 12px; opacity: 0.85; display: block;">Thời gian thanh toán còn lại:</span>
                <span id="countdown" style="font-size: 20px; font-weight: bold; color: #ffeb3b; font-family: monospace;">14:59</span>
            </div>
        </div>

        <div style="padding: 30px;">
            <div class="row">
                
                <!-- Cột Trái: Mã QR Quét Thật -->
                <div class="col-md-5 col-sm-12 text-center" style="border-right: 1px dashed #dee2e6; padding: 15px 25px;">
                    <div style="border: 2px solid #006837; border-radius: 12px; padding: 12px; display: inline-block; background: #fafafa; box-shadow: 0 4px 10px rgba(0,0,0,0.05);">
                        <img src="<?php echo $qr_url; ?>" alt="VietQR Vietcombank" style="width: 100%; max-width: 260px; height: auto; display: block; border-radius: 8px;">
                    </div>
                    
                    <p style="margin-top: 15px; font-size: 13px; color: #666;">
                        <i class="fas fa-camera" style="color: #006837;"></i> Mở ứng dụng <strong>Ngân hàng bất kỳ</strong> hoặc <strong>Ví điện tử</strong> để quét mã QR chuyển khoản tự động
                    </p>
                </div>

                <!-- Cột Phải: Thông tin Chuyển khoản Chi tiết -->
                <div class="col-md-7 col-sm-12" style="padding: 10px 25px;">
                    <h4 style="font-size: 16px; font-weight: 700; color: #333; margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #006837; padding-bottom: 8px;">
                        Thông tin chuyển khoản chính xác
                    </h4>

                    <div style="background: #f8f9fa; border-radius: 8px; padding: 15px 18px; margin-bottom: 20px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                            <span style="color: #666; font-size: 13px;">Ngân hàng thụ hưởng:</span>
                            <span style="font-weight: 700; color: #006837; font-size: 14px;"><?php echo $bank_name; ?></span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                            <span style="color: #666; font-size: 13px;">Chủ tài khoản:</span>
                            <span style="font-weight: 700; color: #333; font-size: 14px; text-transform: uppercase;"><?php echo $account_name; ?></span>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                            <span style="color: #666; font-size: 13px;">Số tài khoản:</span>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <strong style="font-size: 17px; color: #006837; letter-spacing: 1px;" id="copy-acc"><?php echo $account_no; ?></strong>
                                <button type="button" class="btn btn-xs btn-default" onclick="copyText('copy-acc')" title="Sao chép"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                            <span style="color: #666; font-size: 13px;">Số tiền cần thanh toán:</span>
                            <strong style="font-size: 19px; color: #d70018; font-weight: 800;"><?php echo number_format($amount); ?> VNĐ</strong>
                        </div>

                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="color: #666; font-size: 13px;">Nội dung chuyển khoản (bắt buộc):</span>
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <strong style="font-size: 15px; color: #d70018; background: #fff; padding: 3px 8px; border: 1px dashed #d70018; border-radius: 4px;" id="copy-memo"><?php echo $memo; ?></strong>
                                <button type="button" class="btn btn-xs btn-default" onclick="copyText('copy-memo')" title="Sao chép"><i class="fas fa-copy"></i></button>
                            </div>
                        </div>
                    </div>

                    <div style="background: #fff8e1; border-left: 4px solid #ffc107; padding: 12px 15px; border-radius: 4px; font-size: 13px; color: #856404; margin-bottom: 25px;">
                        <i class="fas fa-info-circle"></i> Vui lòng giữ nguyên <strong>Nội dung chuyển khoản</strong> để hệ thống tự động ghi nhận thanh toán nhanh nhất.
                    </div>

                    <!-- Nút Xác Nhận Đã Thanh Toán -->
                    <div style="display: flex; gap: 12px;">
                        <a href="<?php echo base_url('giohang/confirm_payment/' . $order['orderCode']); ?>" 
                           class="btn btn-success btn-lg" 
                           style="flex: 1; background: #006837; border-color: #006837; font-weight: 700; font-size: 15px; border-radius: 8px; padding: 12px;">
                            <i class="fas fa-check-circle"></i> Tôi đã chuyển khoản thành công
                        </a>
                        <a href="<?php echo base_url('thankyou'); ?>" 
                           class="btn btn-default btn-lg" 
                           style="font-size: 14px; border-radius: 8px; padding: 12px 20px;">
                            Để sau
                        </a>
                    </div>

                </div>

            </div>
        </div>

    </div>
</div>

<script>
// Đồng hồ đếm ngược 15 phút
var timeLeft = 15 * 60;
var countdownEl = document.getElementById('countdown');
var timer = setInterval(function() {
    var minutes = Math.floor(timeLeft / 60);
    var seconds = timeLeft % 60;
    if (seconds < 10) seconds = '0' + seconds;
    if (countdownEl) countdownEl.innerHTML = (minutes < 10 ? '0' + minutes : minutes) + ':' + seconds;
    timeLeft--;
    if (timeLeft < 0) {
        clearInterval(timer);
        if (countdownEl) countdownEl.innerHTML = "00:00";
    }
}, 1000);

// Copy text vào clipboard
function copyText(elementId) {
    var text = document.getElementById(elementId).innerText;
    navigator.clipboard.writeText(text).then(function() {
        alert('Đã sao chép: ' + text);
    });
}
</script>
