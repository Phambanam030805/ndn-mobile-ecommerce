<div class="container" style="padding: 40px 15px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 65px; height: 65px; background: #fff3f3; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                        <i class="fas fa-shield-alt" style="font-size: 28px; color: #d70018;"></i>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 700; color: #333; margin: 0 0 8px;">Nhập mã OTP</h3>
                    <p style="color: #777; font-size: 14px; margin: 0;">
                        Mã OTP đã gửi đến: <strong style="color: #333;"><?php echo isset($email_hint) ? $email_hint : ''; ?></strong>
                    </p>
                    <p style="color: #e74c3c; font-size: 12px; margin-top: 5px;"><i class="fas fa-clock"></i> Mã có hiệu lực trong 15 phút</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" style="border-radius: 6px; font-size: 14px;">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <form action="<?php echo base_url('nhap-otp'); ?>" method="post" accept-charset="UTF-8">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    
                    <div class="form-group" style="margin-bottom: 20px; text-align: center;">
                        <label style="font-weight: 600; color: #555; font-size: 14px; display: block; margin-bottom: 12px;">
                            Mã OTP 6 chữ số
                        </label>
                        <input type="text" name="otp" required maxlength="6" pattern="[0-9]{6}"
                               class="form-control" id="otp-input"
                               placeholder="_ _ _ _ _ _"
                               style="border-radius: 8px; border: 2.5px solid #ddd; padding: 15px; font-size: 28px; font-weight: 700; height: auto; text-align: center; letter-spacing: 12px; color: #d70018; width: 100%; max-width: 250px; margin: 0 auto;">
                    </div>

                    <button type="submit" class="btn btn-block"
                            style="background: #d70018; color: #fff; border: none; border-radius: 6px; padding: 12px; font-size: 15px; font-weight: 600; margin-top: 5px;">
                        <i class="fas fa-check-circle"></i> Xác nhận OTP
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px; font-size: 13px;">
                    <a href="<?php echo base_url('quen-mat-khau'); ?>" style="color: #888;">
                        <i class="fas fa-redo"></i> Gửi lại mã OTP
                    </a>
                    &nbsp;|&nbsp;
                    <a href="<?php echo base_url('dang-nhap'); ?>" style="color: #d70018;">
                        <i class="fas fa-arrow-left"></i> Đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Tự động focus và chỉ nhận số
document.getElementById('otp-input').focus();
document.getElementById('otp-input').addEventListener('input', function() {
    this.value = this.value.replace(/[^0-9]/g, '');
});
</script>
