<?php echo form_open_multipart('admin/coupon/insert'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-ticket text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Thêm mã giảm giá mới
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Thiết lập chương trình voucher ưu đãi & khuyến mãi</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <button type="submit" class="btn btn-modern-save">
                <i class="fa fa-check"></i> Lưu mã giảm giá
            </button>
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/coupon'); ?>" role="button">
                <i class="fa fa-times"></i> Hủy bỏ
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-modern">
                        <i class="fa fa-exclamation-triangle"></i>
                        <span><?php echo $this->session->flashdata('error'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Cột trái: Thông tin mã giảm giá & giá trị -->
                    <div class="col-lg-7 col-md-7">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-tag"></i> Thông tin mã ưu đãi</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Mã giảm giá (Coupon Code) <span class="text-danger">*</span></label>
                                    <div class="input-with-action">
                                        <input type="text" class="form-control-custom font-code" name="code" id="coupon_code" placeholder="Ví dụ: SALE50K, TET2026, NDNVIP..." value="<?php echo set_value('code'); ?>" required style="text-transform: uppercase;">
                                        <button type="button" class="btn-gen-code" onclick="generateRandomCode()" title="Tự động tạo mã ngẫu nhiên">
                                            <i class="fa fa-magic"></i> Tạo nhanh
                                        </button>
                                    </div>
                                    <span class="field-hint">Mã từ 5 đến 10 ký tự, viết liền không dấu (chữ cái và số).</span>
                                    <?php if(form_error('code')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('code'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Số tiền giảm giá (VNĐ) <span class="text-danger">*</span></label>
                                            <div class="input-unit-wrap">
                                                <input type="number" class="form-control-custom" name="discount" id="discount_val" placeholder="Ví dụ: 50000" value="<?php echo set_value('discount'); ?>" required min="1000" step="1000">
                                                <span class="unit-badge">đ</span>
                                            </div>
                                            <?php if(form_error('discount')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('discount'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group-custom">
                                            <label class="form-label-custom">Đơn hàng tối thiểu (VNĐ) <span class="text-danger">*</span></label>
                                            <div class="input-unit-wrap">
                                                <input type="number" class="form-control-custom" name="payment_limit" placeholder="Ví dụ: 200000" value="<?php echo set_value('payment_limit', 0); ?>" required min="0" step="10000">
                                                <span class="unit-badge">đ</span>
                                            </div>
                                            <span class="field-hint">Áp dụng cho đơn hàng có tổng tiền từ mức này trở lên.</span>
                                            <?php if(form_error('payment_limit')): ?>
                                                <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('payment_limit'); ?></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Mô tả chương trình ưu đãi</label>
                                    <textarea name="description" class="form-control-custom textarea-custom" rows="3" placeholder="Nhập tóm tắt ưu đãi hiển thị cho khách hàng (ví dụ: Giảm ngay 50.000đ cho đơn hàng phụ kiện từ 200.000đ)..."><?php echo set_value('description'); ?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Giới hạn & Hiệu lực -->
                    <div class="col-lg-5 col-md-5">
                        <div class="modern-form-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-sliders"></i> Giới hạn & Hiệu lực</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="form-group-custom">
                                    <label class="form-label-custom">Số lần giới hạn nhập (Lượt dùng) <span class="text-danger">*</span></label>
                                    <div class="input-unit-wrap">
                                        <input type="number" class="form-control-custom" name="limit_number" placeholder="Ví dụ: 100" value="<?php echo set_value('limit_number', 100); ?>" required min="1">
                                        <span class="unit-badge"><i class="fa fa-users"></i></span>
                                    </div>
                                    <span class="field-hint">Mã sẽ tự động khóa sau khi đạt đủ số lượt dùng này.</span>
                                    <?php if(form_error('limit_number')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('limit_number'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Ngày hết hạn sử dụng <span class="text-danger">*</span></label>
                                    <div class="input-unit-wrap">
                                        <input type="date" class="form-control-custom" name="expiration_date" value="<?php echo set_value('expiration_date', date('Y-m-d', strtotime('+30 days'))); ?>" required min="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                    <span class="field-hint">Sau 23:59:59 ngày này, mã sẽ hết hạn áp dụng.</span>
                                    <?php if(form_error('expiration_date')): ?>
                                        <div class="field-error-msg"><i class="fa fa-exclamation-circle"></i> <?php echo form_error('expiration_date'); ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group-custom">
                                    <label class="form-label-custom">Trạng thái phát hành</label>
                                    <div class="select-wrapper">
                                        <select name="status" class="form-control-custom select-custom">
                                            <option value="1" <?php echo set_select('status', '1', TRUE); ?>>● Có hiệu lực (Kích hoạt ngay)</option>
                                            <option value="0" <?php echo set_select('status', '0'); ?>>○ Tạm khóa (Chưa cho khách dùng)</option>
                                        </select>
                                        <i class="fa fa-chevron-down select-arrow"></i>
                                    </div>
                                </div>

                                <div class="tip-info-box">
                                    <div class="tip-icon"><i class="fa fa-lightbulb-o"></i></div>
                                    <div class="tip-content">
                                        <h4>Gợi ý cấu hình</h4>
                                        <p>Nên đặt tên mã gắn liền với các dịp lễ (như <b>SUMMER26</b>, <b>IPHONE16</b>) để người mua dễ nhớ và áp dụng khi thanh toán.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<?php echo form_close(); ?>

<script>
function generateRandomCode() {
    var prefix = "NDN";
    var chars = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
    var randomStr = "";
    for (var i = 0; i < 4; i++) {
        randomStr += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById("coupon_code").value = prefix + randomStr;
}
</script>

<style>
    :root {
        --primary: #d70018;
        --primary-dark: #b91c1c;
        --border-color: #e2e8f0;
    }

    .content-wrapper {
        background-color: #f8fafc !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    }

    .content-header h1 {
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    /* Modern Buttons */
    .btn-modern-save {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff !important;
        padding: 8px 18px;
        border-radius: 10px;
        font-size: 13.5px;
        font-weight: 700;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3);
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .btn-modern-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(215, 0, 24, 0.45);
        color: #ffffff !important;
    }

    .btn-modern-back {
        background: #ffffff;
        color: #475569 !important;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid #cbd5e1;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-modern-back:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a !important;
    }

    /* Modern Card Styles */
    .modern-form-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .card-header-styled {
        padding: 14px 20px;
        background: #fafbfc;
        border-bottom: 1px solid #f1f5f9;
    }
    .card-header-styled h3 {
        font-size: 14.5px;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .card-header-styled h3 i {
        color: var(--primary);
    }
    .card-body-styled {
        padding: 20px;
    }

    /* Form Fields */
    .form-group-custom {
        margin-bottom: 18px;
    }
    .form-label-custom {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
    }
    .form-control-custom {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1.5px solid #cbd5e1;
        font-size: 13.5px;
        color: #1e293b;
        background: #ffffff;
        outline: none;
        transition: all 0.2s ease;
    }
    .form-control-custom:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12);
    }
    .font-code {
        font-family: 'Consolas', 'Courier New', monospace;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .input-with-action {
        display: flex;
        gap: 8px;
    }
    .btn-gen-code {
        background: #f1f5f9;
        border: 1.5px solid #cbd5e1;
        border-radius: 10px;
        padding: 0 14px;
        font-size: 12.5px;
        font-weight: 700;
        color: #475569;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        white-space: nowrap;
        transition: all 0.2s ease;
    }
    .btn-gen-code:hover {
        background: #e2e8f0;
        color: #1e293b;
        border-color: #94a3b8;
    }

    .input-unit-wrap {
        position: relative;
    }
    .input-unit-wrap .form-control-custom {
        padding-right: 42px;
    }
    .unit-badge {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 13px;
        font-weight: 700;
        color: #94a3b8;
        pointer-events: none;
    }

    .textarea-custom {
        resize: vertical;
        min-height: 80px;
    }

    /* Select Dropdown */
    .select-wrapper {
        position: relative;
    }
    .select-custom {
        appearance: none;
        -webkit-appearance: none;
        cursor: pointer;
        padding-right: 32px;
    }
    .select-arrow {
        position: absolute;
        right: 14px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 11px;
        color: #94a3b8;
        pointer-events: none;
    }

    .field-hint {
        font-size: 11.5px;
        color: #94a3b8;
        margin-top: 5px;
        display: block;
    }

    .field-error-msg {
        font-size: 12px;
        color: #ef4444;
        font-weight: 600;
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    /* Tip Box */
    .tip-info-box {
        background: #fef2f2;
        border: 1px solid #fee2e2;
        border-radius: 14px;
        padding: 14px 16px;
        display: flex;
        gap: 12px;
        align-items: flex-start;
        margin-top: 20px;
    }
    .tip-icon {
        font-size: 20px;
        color: #ef4444;
        margin-top: 2px;
    }
    .tip-content h4 {
        margin: 0 0 4px;
        font-size: 13px;
        font-weight: 700;
        color: #991b1b;
    }
    .tip-content p {
        margin: 0;
        font-size: 12px;
        color: #b91c1c;
        line-height: 1.5;
    }

    /* Alerts */
    .alert-modern {
        border-radius: 12px !important;
        padding: 12px 18px !important;
        font-size: 13.5px !important;
        font-weight: 600 !important;
        display: flex !important;
        align-items: center !important;
        gap: 10px !important;
        border: none !important;
        margin-bottom: 16px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
    }
    .alert-danger.alert-modern {
        background-color: #fef2f2 !important;
        color: #991b1b !important;
        border-left: 4px solid #ef4444 !important;
    }
</style>
