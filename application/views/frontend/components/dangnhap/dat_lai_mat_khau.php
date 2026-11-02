<div class="container" style="padding: 40px 15px;">
    <div class="row">
        <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3">
            <div style="background: #fff; border: 1px solid #e0e0e0; border-radius: 10px; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                
                <div style="text-align: center; margin-bottom: 25px;">
                    <div style="width: 65px; height: 65px; background: #f0fff4; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 15px;">
                        <i class="fas fa-key" style="font-size: 28px; color: #27ae60;"></i>
                    </div>
                    <h3 style="font-size: 22px; font-weight: 700; color: #333; margin: 0 0 8px;">Đặt mật khẩu mới</h3>
                    <p style="color: #777; font-size: 14px; margin: 0;">OTP đã xác minh thành công ✅</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" style="border-radius: 6px;"><?php echo $error; ?></div>
                <?php endif; ?>

                <form action="<?php echo base_url('dat-lai-mat-khau'); ?>" method="post" accept-charset="UTF-8">
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                    
                    <div class="form-group" style="margin-bottom: 18px;">
                        <label style="font-weight: 600; color: #555; font-size: 14px;">
                            <i class="fas fa-lock" style="color: #d70018;"></i> Mật khẩu mới
                        </label>
                        <input type="password" name="password" required minlength="6"
                               class="form-control" placeholder="Tối thiểu 6 ký tự..."
                               style="border-radius: 6px; border: 1.5px solid #ddd; padding: 12px 15px; font-size: 14px; height: auto; margin-top: 6px;">
                        <div class="error" style="color:red; font-size: 13px;"><?php echo form_error('password'); ?></div>
                    </div>

                    <div class="form-group" style="margin-bottom: 22px;">
                        <label style="font-weight: 600; color: #555; font-size: 14px;">
                            <i class="fas fa-lock" style="color: #d70018;"></i> Nhập lại mật khẩu mới
                        </label>
                        <input type="password" name="re_password" required minlength="6"
                               class="form-control" placeholder="Nhập lại mật khẩu..."
                               style="border-radius: 6px; border: 1.5px solid #ddd; padding: 12px 15px; font-size: 14px; height: auto; margin-top: 6px;">
                        <div class="error" style="color:red; font-size: 13px;"><?php echo form_error('re_password'); ?></div>
                    </div>

                    <button type="submit" class="btn btn-block"
                            style="background: #27ae60; color: #fff; border: none; border-radius: 6px; padding: 12px; font-size: 15px; font-weight: 600;">
                        <i class="fas fa-save"></i> Lưu mật khẩu mới
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
