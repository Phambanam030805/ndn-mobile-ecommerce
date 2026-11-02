<div class="container" style="padding: 40px 15px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                
                <!-- Header -->
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 65px; height: 65px; background: #fff3f3; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                        <i class="fas fa-lock" style="font-size: 28px; color: #d70018;"></i>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 700; color: #333; margin: 0 0 8px;">Quên mật khẩu?</h3>
                    <p style="color: #777; font-size: 14px; margin: 0;">Nhập email để nhận mã OTP khôi phục</p>
                </div>

                <!-- Thông báo lỗi -->
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" style="border-radius: 6px; font-size: 14px;">
                        <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
                    </div>
                <?php endif; ?>

                <!-- Form -->
                <form action="<?php echo base_url('quen-mat-khau'); ?>" method="post" accept-charset="UTF-8">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label style="font-weight: 600; color: #555; font-size: 14px;">
                            <i class="fas fa-envelope" style="color: #d70018;"></i> Địa chỉ email
                        </label>
                        <input type="email" name="email" required
                               class="form-control" 
                               placeholder="Nhập email đã đăng ký..."
                               style="border-radius: 6px; border: 1.5px solid #ddd; padding: 12px 15px; font-size: 14px; height: auto; margin-top: 6px;">
                    </div>

                    <button type="submit" class="btn btn-block"
                            style="background: #d70018; color: #fff; border: none; border-radius: 6px; padding: 12px; font-size: 15px; font-weight: 600; cursor: pointer; transition: all .2s;">
                        <i class="fas fa-paper-plane"></i> Gửi mã OTP
                    </button>
                </form>

                <div style="text-align: center; margin-top: 20px; font-size: 13px; color: #888;">
                    <a href="<?php echo base_url('dang-nhap'); ?>" style="color: #d70018;">
                        <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>