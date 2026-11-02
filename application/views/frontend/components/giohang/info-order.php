<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php  
if(!$this->session->userdata('cart')){
    redirect('gio-hang');
}
if(!$this->session->userdata('sessionKhachHang')){
    redirect('dang-nhap');
}
$user = $this->session->userdata('sessionKhachHang');
$cart = $this->session->userdata('cart');
$cart_info = $this->session->userdata('cart_info') ?? [];
?>

<!-- TIÊU CHUẨN THIẾT KẾ: MODERN TECH RETAIL CHECKOUT -->
<div class="checkout-modern-page" style="background: #F4F6F8; min-height: 85vh; padding: 25px 0 60px 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;">
    <div class="container" style="max-width: 1200px;">

        <!-- 1. BREADCRUMBS & 3-STEP PROGRESS INDICATOR -->
        <div class="checkout-step-progress card-shadow mb-4">
            <div class="row align-items-center">
                <div class="col-md-4 col-sm-12">
                    <ol class="breadcrumb mb-0" style="background: transparent; padding: 0; font-size: 13px;">
                        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-home"></i> Trang chủ</a></li>
                        <li><a href="<?php echo base_url('gio-hang'); ?>">Giỏ hàng</a></li>
                        <li class="active text-danger font-weight-bold">Thanh toán</li>
                    </ol>
                </div>
                <div class="col-md-8 col-sm-12">
                    <div class="step-indicator-wrapper">
                        <div class="step-node completed">
                            <span class="step-circle"><i class="fa fa-check"></i></span>
                            <span class="step-label">1. Giỏ hàng</span>
                        </div>
                        <div class="step-line active"></div>
                        <div class="step-node active">
                            <span class="step-circle">2</span>
                            <span class="step-label">2. Thông tin & Thanh toán</span>
                        </div>
                        <div class="step-line"></div>
                        <div class="step-node">
                            <span class="step-circle">3</span>
                            <span class="step-label">3. Hoàn tất đơn</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($stockError = $this->session->flashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade in card-shadow" role="alert" style="border-left: 4px solid #EF4444; background: #FEF2F2; color: #991B1B;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong><i class="fa fa-exclamation-triangle"></i> Thông báo:</strong> <?php echo html_escape($stockError); ?>
            </div>
        <?php endif; ?>

        <!-- 2. MAIN 2-COLUMN CHECKOUT GRID (65% LEFT / 35% RIGHT) -->
        <?php echo form_open('info-order', ['id' => 'checkoutMainForm', 'novalidate' => 'novalidate']); ?>
        <div class="row">
            
            <!-- CỘT TRÁI (65%): FORM GIAO HÀNG, KHUYẾN MÃI & PHƯƠNG THỨC THANH TOÁN -->
            <div class="col-md-8 col-sm-12">
                
                <!-- KHỐI 1: THÔNG TIN GIAO HÀNG (SHIPPING ADDRESS) -->
                <div class="checkout-card card-shadow mb-4">
                    <div class="card-header-clean">
                        <h3 class="card-title">
                            <span class="section-badge"><i class="fa fa-map-marker-alt"></i></span>
                            1. Địa chỉ nhận hàng
                        </h3>
                        <span class="header-note text-muted font-italic">(*) Thông tin bắt buộc</span>
                    </div>

                    <div class="card-body-clean">
                        <div class="row">
                            <!-- Họ tên người nhận -->
                            <div class="col-md-6 col-sm-12 form-group form-group-float">
                                <label class="float-label">Họ và tên người nhận <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa fa-user input-icon"></i>
                                    <input type="text" name="name" id="receiver_name" class="form-control modern-input" 
                                           placeholder="Ví dụ: Nguyễn Văn A" 
                                           value="<?php echo set_value('name', $user['fullname'] ?? ''); ?>" required>
                                </div>
                                <div class="field-error-msg" id="name_error"><?php echo form_error('name'); ?></div>
                            </div>

                            <!-- Số điện thoại nhận hàng -->
                            <div class="col-md-6 col-sm-12 form-group form-group-float">
                                <label class="float-label">Số điện thoại liên hệ <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa fa-phone-alt input-icon"></i>
                                    <input type="tel" name="phone" id="receiver_phone" class="form-control modern-input" 
                                           placeholder="Ví dụ: 0987654321" 
                                           value="<?php echo set_value('phone', $user['phone'] ?? ''); ?>" required>
                                </div>
                                <div class="field-error-msg" id="phone_error"><?php echo form_error('phone'); ?></div>
                            </div>
                        </div>

                        <!-- Email liên hệ nhận hóa đơn điện tử -->
                        <div class="row">
                            <div class="col-md-12 form-group form-group-float">
                                <label class="float-label">Email nhận biên lai & mã vận đơn <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa fa-envelope input-icon"></i>
                                    <input type="email" name="email" id="receiver_email" class="form-control modern-input" 
                                           placeholder="name@example.com" 
                                           value="<?php echo set_value('email', $user['email'] ?? ''); ?>" required>
                                </div>
                                <div class="field-error-msg" id="email_error"><?php echo form_error('email'); ?></div>
                            </div>
                        </div>

                        <!-- Địa chỉ hành chính 2 cấp (Tỉnh / Thành -> Quận / Huyện) -->
                        <div class="row">
                            <div class="col-md-6 col-sm-12 form-group form-group-float">
                                <label class="float-label">Tỉnh / Thành phố <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa fa-city input-icon"></i>
                                    <select name="city" id="provinceSelect" class="form-control modern-select" onchange="onProvinceChange()" required>
                                        <option value="">-- Chọn Tỉnh / Thành phố --</option>
                                        <?php 
                                        $provinces = $this->Mtinhthanh->province_all();
                                        foreach($provinces as $p):
                                        ?>
                                            <option value="<?php echo (int)$p['id']; ?>" <?php echo set_select('city', $p['id']); ?>>
                                                <?php echo html_escape($p['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="field-error-msg" id="city_error"><?php echo form_error('city'); ?></div>
                            </div>

                            <div class="col-md-6 col-sm-12 form-group form-group-float">
                                <label class="float-label">Quận / Huyện <span class="text-danger">*</span></label>
                                <div class="input-icon-wrap">
                                    <i class="fa fa-map-marked-alt input-icon"></i>
                                    <select name="DistrictId" id="districtSelect" class="form-control modern-select" required>
                                        <option value="">-- Chọn Quận / Huyện --</option>
                                    </select>
                                </div>
                                <div class="field-error-msg" id="district_error"><?php echo form_error('DistrictId'); ?></div>
                            </div>
                        </div>

                        <!-- Số nhà, tên đường chi tiết -->
                        <div class="form-group form-group-float mb-2">
                            <label class="float-label">Địa chỉ chi tiết (Số nhà, tên đường, tòa nhà, ngõ/ngách) <span class="text-danger">*</span></label>
                            <textarea name="address" id="receiver_address" class="form-control modern-textarea" rows="2" 
                                      placeholder="Ví dụ: Tòa nhà Landmark 81, số 208 Nguyễn Hữu Cảnh..." required><?php echo set_value('address', $user['address'] ?? ''); ?></textarea>
                            <div class="field-error-msg" id="address_error"><?php echo form_error('address'); ?></div>
                        </div>

                        <!-- Ghi chú đơn hàng & Lưu địa chỉ -->
                        <div class="delivery-options-sub mt-3">
                            <div class="checkbox modern-checkbox">
                                <label>
                                    <input type="checkbox" name="save_address" value="1" checked> 
                                    <span class="cr"><i class="cr-icon fa fa-check"></i></span>
                                    <span>Lưu địa chỉ này vào sổ địa chỉ để sử dụng cho các đơn hàng tiếp theo</span>
                                </label>
                            </div>
                            <div class="note-expand-wrap mt-2">
                                <a href="javascript:void(0)" onclick="jQuery('#orderNoteBox').slideToggle(200);" class="text-muted" style="font-size: 13px;">
                                    <i class="fa fa-pen"></i> Thêm ghi chú giao hàng (Giao giờ hành chính, gọi trước khi giao...)
                                </a>
                                <div id="orderNoteBox" class="mt-2" style="display: none;">
                                    <textarea name="order_note" class="form-control modern-input" rows="2" placeholder="Nhập yêu cầu đặc biệt của bạn cho shipper..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KHỐI 2: MÃ GIẢM GIÁ & VOUCHER ENGINE (AJAX) -->
                <div class="checkout-card card-shadow mb-4">
                    <div class="card-header-clean">
                        <h3 class="card-title">
                            <span class="section-badge"><i class="fa fa-ticket-alt"></i></span>
                            2. Mã giảm giá & Ưu đãi
                        </h3>
                    </div>
                    <div class="card-body-clean">
                        <div class="coupon-input-group">
                            <div class="input-group-modern">
                                <i class="fa fa-tags coupon-prefix-icon"></i>
                                <input type="text" id="couponCodeInput" class="form-control coupon-input" placeholder="Nhập mã ưu đãi (Ví dụ: NDN50K, TET2026...)" autocomplete="off">
                                <button type="button" class="btn btn-apply-coupon" id="btnApplyCoupon" onclick="applyCouponAjax()">
                                    <span class="btn-text">ÁP DỤNG</span>
                                </button>
                            </div>
                        </div>
                        <div id="couponAjaxFeedback" class="mt-2" style="display: none;"></div>

                        <!-- Gợi ý voucher nhanh -->
                        <div class="quick-vouchers-row mt-3">
                            <span class="quick-v-title text-muted font-weight-bold" style="font-size: 12px;">Gợi ý mã hot:</span>
                            <span class="badge-voucher-chip" onclick="quickFillCoupon('NDN50K')">NDN50K (Giảm 50k)</span>
                            <span class="badge-voucher-chip" onclick="quickFillCoupon('FREESHIP')">FREESHIP (Miễn ship)</span>
                            <span class="badge-voucher-chip" onclick="quickFillCoupon('VIPMEMBER')">VIPMEMBER (Giảm 100k)</span>
                        </div>
                    </div>
                </div>

                <!-- KHỐI 3: PHƯƠNG THỨC THANH TOÁN (PAYMENT GATEWAYS: COD & VIETQR DYNAMIC) -->
                <div class="checkout-card card-shadow mb-4">
                    <div class="card-header-clean">
                        <h3 class="card-title">
                            <span class="section-badge"><i class="fa fa-credit-card"></i></span>
                            3. Phương thức thanh toán
                        </h3>
                    </div>
                    <div class="card-body-clean">
                        <div class="payment-methods-grid">
                            
                            <!-- Option 1: COD (Thanh toán khi nhận hàng) -->
                            <label class="payment-method-card active" id="payMethodCardCOD" onclick="selectPaymentMethod(0)">
                                <div class="payment-radio-wrap">
                                    <input type="radio" name="payment_method" value="0" checked onchange="selectPaymentMethod(0)">
                                    <span class="radio-custom"></span>
                                </div>
                                <div class="payment-icon-box">
                                    <i class="fa fa-money-bill-wave text-success"></i>
                                </div>
                                <div class="payment-desc">
                                    <strong class="payment-name">Thanh toán khi nhận hàng (COD)</strong>
                                    <span class="payment-sub text-muted">Nhận máy, kiểm tra hàng nguyên seal rồi mới thanh toán tiền mặt cho nhân viên giao hàng.</span>
                                </div>
                            </label>

                            <!-- Option 2: VietQR / Chuyển khoản trực tuyến -->
                            <label class="payment-method-card" id="payMethodCardQR" onclick="selectPaymentMethod(1)">
                                <div class="payment-radio-wrap">
                                    <input type="radio" name="payment_method" value="1" onchange="selectPaymentMethod(1)">
                                    <span class="radio-custom"></span>
                                </div>
                                <div class="payment-icon-box">
                                    <i class="fa fa-qrcode text-danger"></i>
                                </div>
                                <div class="payment-desc">
                                    <div class="d-flex align-items-center">
                                        <strong class="payment-name">Chuyển khoản liên ngân hàng 24/7 (VietQR Siêu Tốc)</strong>
                                        <span class="badge badge-popular ml-2">Khuyên dùng</span>
                                    </div>
                                    <span class="payment-sub text-muted">Hỗ trợ quét mã QR tự động điền số tài khoản, số tiền và nội dung qua tất cả các ứng dụng Ngân hàng & Ví điện tử (MoMo, ZaloPay).</span>
                                </div>
                            </label>
                        </div>

                        <!-- VietQR Preview Panel (Hiển thị khi chọn VietQR) -->
                        <div id="vietqrPreviewPanel" class="vietqr-live-preview mt-3" style="display: none;">
                            <div class="qr-preview-box">
                                <div class="row align-items-center">
                                    <div class="col-md-4 col-sm-12 text-center">
                                        <div class="qr-code-frame">
                                            <img src="https://img.vietqr.io/image/970436-1915403967-compact2.png?amount=<?php echo (int)($money_temp + $priceShip - ($this->session->userdata('coupon_price') ?: 0)); ?>&addInfo=NDN+THANHTOAN&accountName=PHAM+BA+NAM" 
                                                 alt="VietQR Vietcombank" class="img-responsive qr-img-demo" id="vietqrDemoImg">
                                            <span class="qr-badge-live"><i class="fa fa-sync-alt fa-spin"></i> Khởi tạo mã tự động</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 col-sm-12">
                                        <div class="bank-acc-info">
                                            <h5 class="bank-title"><i class="fa fa-university text-danger"></i> Ngân hàng thụ hưởng: <strong>Vietcombank</strong></h5>
                                            <div class="copy-field-row">
                                                <span>Số tài khoản: <strong id="vietqrAccNo">1915403967</strong></span>
                                                <button type="button" class="btn btn-xs btn-outline-copy" onclick="copyToClipboard('1915403967', this)"><i class="fa fa-copy"></i> Sao chép</button>
                                            </div>
                                            <div class="copy-field-row">
                                                <span>Chủ tài khoản: <strong>PHAM BA NAM</strong></span>
                                            </div>
                                            <div class="copy-field-row">
                                                <span>Nội dung chuyển khoản: <strong class="text-danger" id="vietqrMemo">NDN [MÃ ĐƠN TỰ ĐỘNG]</strong></span>
                                            </div>
                                            <div class="qr-guide-alert mt-2">
                                                <i class="fa fa-shield-alt text-success"></i> Sau khi bấm <strong>Xác nhận đặt hàng</strong>, màn hình chuyển khoản tự động sẽ kích hoạt hệ thống kiểm tra và khớp giao dịch trong 3 giây.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <!-- CỘT PHẢI (35%): TÓM TẮT ĐƠN HÀNG STICKY (ORDER SUMMARY & CTA) -->
            <div class="col-md-4 col-sm-12">
                <div class="checkout-sidebar-sticky">
                    <div class="checkout-card card-shadow order-summary-card">
                        
                        <div class="card-header-clean summary-header">
                            <h3 class="card-title">
                                <i class="fa fa-shopping-bag text-danger"></i> Đơn hàng của bạn 
                                <span class="badge badge-items-count"><?php 
                                    $itemCount = 0;
                                    foreach($cart as $v) $itemCount += $v;
                                    echo $itemCount;
                                ?> sản phẩm</span>
                            </h3>
                            <a href="<?php echo base_url('gio-hang'); ?>" class="btn-edit-cart" title="Chỉnh sửa giỏ hàng">
                                <i class="fa fa-edit"></i> Sửa
                            </a>
                        </div>

                        <div class="card-body-clean p-0">
                            <!-- Danh sách sản phẩm thu nhỏ có ảnh, tên & biến thể -->
                            <div class="summary-items-list">
                                <?php 
                                $calculated_subtotal = 0;
                                foreach ($cart as $key => $value):
                                    $info = $cart_info[$key] ?? [];
                                    $pid = isset($info['id']) ? (int)$info['id'] : (int)(is_numeric($key) ? $key : explode('_', $key)[0]);
                                    $pRow = $this->Msanpham->product_detail_id($pid);
                                    if ($pRow):
                                        $unit_price = ($pRow['price_sale'] > 0) ? (float)$pRow['price_sale'] : (float)$pRow['price'];
                                        $item_total = $unit_price * $value;
                                        $calculated_subtotal += $item_total;
                                ?>
                                    <div class="summary-product-item">
                                        <div class="item-thumb">
                                            <img src="<?php echo base_url('public/images/products/' . $pRow['avatar']); ?>" alt="<?php echo html_escape($pRow['name']); ?>">
                                            <span class="item-qty-badge"><?php echo $value; ?></span>
                                        </div>
                                        <div class="item-info">
                                            <h6 class="item-name"><?php echo html_escape($pRow['name']); ?></h6>
                                            <?php if(!empty($info['color']) || !empty($info['capacity'])): ?>
                                                <div class="item-variant-sub">
                                                    <?php if(!empty($info['color'])) echo '<span>Màu: ' . html_escape($info['color']) . '</span>'; ?>
                                                    <?php if(!empty($info['color']) && !empty($info['capacity'])) echo ' • '; ?>
                                                    <?php if(!empty($info['capacity'])) echo '<span>' . html_escape($info['capacity']) . '</span>'; ?>
                                                </div>
                                            <?php endif; ?>
                                            <div class="item-price"><?php echo number_format($item_total); ?> đ</div>
                                        </div>
                                    </div>
                                <?php endif; endforeach; ?>
                            </div>

                            <!-- Ma trận tính toán chi tiết giá (Price Breakdown) -->
                            <div class="summary-pricing-matrix">
                                <div class="price-line">
                                    <span class="price-line-label">Tạm tính:</span>
                                    <span class="price-line-val" id="summarySubtotalText"><?php echo number_format($calculated_subtotal); ?> đ</span>
                                </div>

                                <div class="price-line">
                                    <span class="price-line-label">Phí giao hàng:</span>
                                    <span class="price-line-val font-weight-bold" id="summaryShippingText">
                                        <?php 
                                        if ($priceShip == 0) {
                                            echo '<span class="text-success"><i class="fa fa-gift"></i> Miễn phí</span>';
                                        } else {
                                            echo number_format($priceShip) . ' đ';
                                        }
                                        ?>
                                    </span>
                                </div>

                                <!-- Dòng giảm giá Coupon -->
                                <?php 
                                $couponDiscount = (float)($this->session->userdata('coupon_price') ?: 0);
                                ?>
                                <div class="price-line coupon-discount-row" id="couponDiscountRow" style="<?php echo ($couponDiscount > 0) ? 'display:flex;' : 'display:none;'; ?>">
                                    <span class="price-line-label text-success">
                                        <i class="fa fa-tag"></i> Mã ưu đãi:
                                        <a href="javascript:void(0)" onclick="removeCouponAjax()" class="btn-remove-coupon" title="Hủy mã"><i class="fa fa-times-circle"></i></a>
                                    </span>
                                    <span class="price-line-val text-success font-weight-bold" id="summaryDiscountText">
                                        -<?php echo number_format($couponDiscount); ?> đ
                                    </span>
                                </div>

                                <div class="grand-total-divider"></div>

                                <!-- TỔNG TIỀN THANH TOÁN (GRAND TOTAL) -->
                                <div class="price-line grand-total-line">
                                    <div class="grand-total-label">
                                        <div class="grand-total-title">TỔNG TIỀN THANH TOÁN:</div>
                                        <div class="grand-total-vat-text">(Đã bao gồm VAT 10%)</div>
                                    </div>
                                    <div class="grand-total-amount" id="summaryGrandTotalText">
                                        <?php 
                                        $finalTotalOrder = max(0, $calculated_subtotal + $priceShip - $couponDiscount);
                                        echo number_format($finalTotalOrder); 
                                        ?> đ
                                    </div>
                                </div>
                            </div>

                            <!-- NÚT CTA XÁC NHẬN ĐẶT HÀNG -->
                            <div class="summary-actions">
                                <button type="submit" name="dathang" id="btnSubmitOrder" class="btn btn-confirm-order">
                                    <span class="btn-title"><i class="fa fa-lock"></i> XÁC NHẬN ĐẶT HÀNG</span>
                                    <span class="btn-subtitle" style="display: block; font-size: 12px; color: #ffffff !important; opacity: 1 !important; margin-top: 5px; font-weight: 500; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                                        Cam kết bảo mật & Giao hàng an toàn
                                    </span>
                                </button>
                                
                                <div class="security-commitments">
                                    <div class="row">
                                        <div class="col-xs-4 commit-item">
                                            <i class="fa fa-shield-alt text-success"></i>
                                            <span>Bảo mật 100%</span>
                                        </div>
                                        <div class="col-xs-4 commit-item">
                                            <i class="fa fa-box-open text-primary"></i>
                                            <span>Kiểm tra khi nhận</span>
                                        </div>
                                        <div class="col-xs-4 commit-item">
                                            <i class="fa fa-sync-alt text-danger"></i>
                                            <span>1 đổi 1 30 ngày</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <?php echo form_close(); ?>

    </div>
</div>

<!-- STICKY BOTTOM CHECKOUT BAR DÀNH CHO THIẾT BỊ DI ĐỘNG -->
<div class="mobile-sticky-checkout-bar visible-xs visible-sm">
    <div class="container-fluid">
        <div class="row align-items-center" style="display: flex; align-items: center;">
            <div class="col-xs-7">
                <span class="mob-total-label">Tổng thanh toán:</span>
                <strong class="mob-total-val" id="mobileGrandTotalText"><?php echo number_format($finalTotalOrder); ?> đ</strong>
            </div>
            <div class="col-xs-5 text-right">
                <button type="button" class="btn btn-danger btn-mobile-checkout" onclick="jQuery('#checkoutMainForm').submit();">
                    ĐẶT HÀNG <i class="fa fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- CLIENT JAVASCRIPT: VALIDATION, DYNAMIC CASCADING, LIVE COUPON & VIETQR -->
<script>
var CSRF_NAME = '<?php echo $this->security->get_csrf_token_name(); ?>';
var CSRF_HASH = '<?php echo $this->security->get_csrf_hash(); ?>';
var BASE_URL  = '<?php echo base_url(); ?>';

/**
 * 1. Dynamic Administrative Cascading (Tỉnh/Thành -> Quận/Huyện) & Live Shipping Fee
 */
function onProvinceChange() {
    var provinceId = jQuery('#provinceSelect').val();
    var districtElem = jQuery('#districtSelect');

    if (!provinceId) {
        districtElem.html('<option value="">-- Chọn Quận / Huyện --</option>');
        return;
    }

    districtElem.html('<option value="">Đang tải danh sách quận huyện...</option>');

    // Tải danh sách quận/huyện
    jQuery.ajax({
        url: BASE_URL + 'giohang/district',
        type: 'GET',
        data: { provinceid: provinceId },
        success: function(htmlResponse) {
            districtElem.html(htmlResponse);
        },
        error: function() {
            districtElem.html('<option value="">Không thể tải dữ liệu quận huyện</option>');
        }
    });

    // Tính toán lại phí giao hàng theo tỉnh thành thời gian thực
    var postData = { provinceid: provinceId };
    postData[CSRF_NAME] = CSRF_HASH;

    jQuery.ajax({
        url: BASE_URL + 'giohang/calculate_shipping_ajax',
        type: 'POST',
        dataType: 'json',
        data: postData,
        success: function(res) {
            if (res.status === 'success') {
                if (res.is_free_ship) {
                    jQuery('#summaryShippingText').html('<span class="text-success"><i class="fa fa-gift"></i> Miễn phí</span>');
                } else {
                    jQuery('#summaryShippingText').text(res.price_ship_text);
                }
                jQuery('#summaryGrandTotalText').text(res.grand_total_text);
                jQuery('#mobileGrandTotalText').text(res.grand_total_text);
            }
        }
    });
}

/**
 * 2. Phương thức thanh toán (COD & VietQR Live Toggle)
 */
function selectPaymentMethod(methodId) {
    jQuery('.payment-method-card').removeClass('active');
    if (methodId === 0) {
        jQuery('#payMethodCardCOD').addClass('active');
        jQuery('#payMethodCardCOD input[type="radio"]').prop('checked', true);
        jQuery('#vietqrPreviewPanel').slideUp(200);
    } else {
        jQuery('#payMethodCardQR').addClass('active');
        jQuery('#payMethodCardQR input[type="radio"]').prop('checked', true);
        jQuery('#vietqrPreviewPanel').slideDown(250);
    }
}

/**
 * 3. Áp dụng Mã giảm giá qua AJAX (Live Coupon Engine)
 */
function applyCouponAjax() {
    var code = jQuery.trim(jQuery('#couponCodeInput').val());
    var btn = jQuery('#btnApplyCoupon');
    var feedbackBox = jQuery('#couponAjaxFeedback');

    if (!code) {
        feedbackBox.html('<div class="alert alert-warning py-2 mb-0" style="padding: 8px 12px; font-size: 13px;"><i class="fa fa-exclamation-circle"></i> Vui lòng nhập mã ưu đãi của bạn!</div>').slideDown(200);
        return;
    }

    var originalText = btn.html();
    btn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i>');

    var postData = { code: code };
    postData[CSRF_NAME] = CSRF_HASH;

    jQuery.ajax({
        url: BASE_URL + 'giohang/coupon',
        type: 'POST',
        dataType: 'json',
        data: postData,
        success: function(res) {
            btn.prop('disabled', false).html(originalText);
            if (res.status === 'success') {
                feedbackBox.html('<div class="alert alert-success py-2 mb-0" style="padding: 8px 12px; font-size: 13px;"><i class="fa fa-check-circle"></i> ' + res.message + '</div>').slideDown(200);
                jQuery('#couponDiscountRow').css('display', 'flex');
                jQuery('#summaryDiscountText').text(res.discount_formatted);
                jQuery('#summaryGrandTotalText').text(res.total_formatted);
                jQuery('#mobileGrandTotalText').text(res.total_formatted);
            } else {
                feedbackBox.html('<div class="alert alert-danger py-2 mb-0" style="padding: 8px 12px; font-size: 13px;"><i class="fa fa-times-circle"></i> ' + res.message + '</div>').slideDown(200);
            }
        },
        error: function() {
            btn.prop('disabled', false).html(originalText);
            feedbackBox.html('<div class="alert alert-danger py-2 mb-0" style="padding: 8px 12px; font-size: 13px;"><i class="fa fa-times-circle"></i> Có lỗi xảy ra trong quá trình xác thực mã. Vui lòng thử lại!</div>').slideDown(200);
        }
    });
}

function removeCouponAjax() {
    var postData = {};
    postData[CSRF_NAME] = CSRF_HASH;

    jQuery.ajax({
        url: BASE_URL + 'giohang/removecoupon',
        type: 'POST',
        dataType: 'json',
        data: postData,
        success: function(res) {
            jQuery('#couponDiscountRow').hide();
            jQuery('#couponAjaxFeedback').hide();
            jQuery('#couponCodeInput').val('');
            jQuery('#summaryGrandTotalText').text(res.total_formatted);
            jQuery('#mobileGrandTotalText').text(res.total_formatted);
        }
    });
}

function quickFillCoupon(code) {
    jQuery('#couponCodeInput').val(code);
    applyCouponAjax();
}

/**
 * 4. Clipboard Helper
 */
function copyToClipboard(text, btn) {
    var dummy = document.createElement("input");
    document.body.appendChild(dummy);
    dummy.setAttribute("value", text);
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);

    var oldHtml = jQuery(btn).html();
    jQuery(btn).html('<i class="fa fa-check text-success"></i> Đã chép!');
    setTimeout(function() {
        jQuery(btn).html(oldHtml);
    }, 2000);
}

/**
 * 5. Real-time Form Validation (Phone, Email, Name)
 */
jQuery(document).ready(function($) {
    $('#checkoutMainForm').on('submit', function(e) {
        var isValid = true;

        var name = $.trim($('#receiver_name').val());
        var phone = $.trim($('#receiver_phone').val());
        var email = $.trim($('#receiver_email').val());
        var province = $('#provinceSelect').val();
        var district = $('#districtSelect').val();
        var address = $.trim($('#receiver_address').val());

        // Validate Name
        if (name.length < 3) {
            $('#name_error').text('Họ tên người nhận phải có ít nhất 3 ký tự!');
            $('#receiver_name').addClass('is-invalid');
            isValid = false;
        } else {
            $('#name_error').text('');
            $('#receiver_name').removeClass('is-invalid');
        }

        // Validate Phone (10-11 số chuẩn VN)
        var phoneRegex = /^(0[3|5|7|8|9])[0-9]{8}$/;
        if (!phoneRegex.test(phone)) {
            $('#phone_error').text('Số điện thoại không đúng định dạng (Ví dụ: 0987654321)!');
            $('#receiver_phone').addClass('is-invalid');
            isValid = false;
        } else {
            $('#phone_error').text('');
            $('#receiver_phone').removeClass('is-invalid');
        }

        // Validate Email
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            $('#email_error').text('Địa chỉ email không hợp lệ!');
            $('#receiver_email').addClass('is-invalid');
            isValid = false;
        } else {
            $('#email_error').text('');
            $('#receiver_email').removeClass('is-invalid');
        }

        // Validate Location
        if (!province) {
            $('#city_error').text('Vui lòng chọn Tỉnh / Thành phố!');
            $('#provinceSelect').addClass('is-invalid');
            isValid = false;
        } else {
            $('#city_error').text('');
            $('#provinceSelect').removeClass('is-invalid');
        }

        if (!district) {
            $('#district_error').text('Vui lòng chọn Quận / Huyện!');
            $('#districtSelect').addClass('is-invalid');
            isValid = false;
        } else {
            $('#district_error').text('');
            $('#districtSelect').removeClass('is-invalid');
        }

        // Validate Detail Address
        if (address.length < 5) {
            $('#address_error').text('Vui lòng nhập địa chỉ cụ thể (tối thiểu 5 ký tự)!');
            $('#receiver_address').addClass('is-invalid');
            isValid = false;
        } else {
            $('#address_error').text('');
            $('#receiver_address').removeClass('is-invalid');
        }

        if (!isValid) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: $('.is-invalid').first().offset().top - 120
            }, 300);
            return false;
        }

        // Disable button & show spinner on submit
        $('#btnSubmitOrder').prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> ĐANG KHỞI TẠO ĐƠN HÀNG...');
    });
});
</script>

<!-- CSS MODERN CHECKOUT (TECH CRIMSON RED & SLATE HIGH CONTRAST) -->
<style>
/* Card Styling */
.card-shadow {
    background: #FFFFFF;
    border-radius: 12px;
    border: 1px solid #E2E8F0;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
}
.checkout-card {
    overflow: hidden;
}
/* Card Header Clean & Section Badge */
.card-header-clean {
    padding: 16px 20px;
    border-bottom: 1px solid #EDF2F7;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.card-header-clean .card-title {
    font-size: 16px;
    font-weight: 700;
    color: #1A202C;
    margin: 0;
    display: inline-flex;
    align-items: center;
    gap: 10px;
    line-height: 1;
}
.section-badge {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #FFF5F5;
    color: #D70018;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}
.card-body-clean {
    padding: 22px;
}

/* Step Progress Indicator */
.checkout-step-progress {
    padding: 16px 20px;
}
.step-indicator-wrapper {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    flex-wrap: nowrap;
}
.step-node {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: #718096;
    white-space: nowrap;
}
.step-circle {
    width: 26px;
    height: 26px;
    border-radius: 50%;
    background: #EDF2F7;
    color: #718096;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 12px;
    flex-shrink: 0;
}
.step-node.completed .step-circle {
    background: #10B981;
    color: #fff;
}
.step-node.active .step-circle {
    background: #D70018;
    color: #fff;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.15);
}
.step-node.active .step-label {
    font-weight: 700;
    color: #1A202C;
}
.step-line {
    width: 28px;
    height: 2px;
    background: #E2E8F0;
    flex-shrink: 0;
}
.step-line.active {
    background: #D70018;
}

/* Modern Inputs with Floating Feel */
.form-group-float {
    margin-bottom: 18px;
}
.float-label {
    font-size: 13px;
    font-weight: 600;
    color: #4A5568;
    margin-bottom: 6px;
    display: block;
}
.input-icon-wrap {
    position: relative;
}
.input-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #A0AEC0;
    font-size: 14px;
}
.modern-input, .modern-select {
    height: 44px;
    border: 1px solid #CBD5E0;
    border-radius: 8px;
    padding-left: 40px;
    font-size: 14px;
    color: #2D3748;
    background: #FFFFFF;
    transition: all 0.2s ease;
}
.modern-textarea {
    border: 1px solid #CBD5E0;
    border-radius: 8px;
    padding: 12px;
    font-size: 14px;
    color: #2D3748;
    transition: all 0.2s ease;
    resize: none;
}
.modern-input:focus, .modern-select:focus, .modern-textarea:focus {
    border-color: #D70018;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.12);
    outline: none;
}
.is-invalid {
    border-color: #EF4444 !important;
    background-color: #FFF5F5 !important;
}
.field-error-msg {
    color: #EF4444;
    font-size: 12px;
    margin-top: 4px;
    font-style: italic;
}

/* Coupon Engine Box */
.input-group-modern {
    display: flex;
    position: relative;
}
.coupon-prefix-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: #A0AEC0;
    z-index: 5;
}
.coupon-input {
    height: 44px;
    border: 1px solid #CBD5E0;
    border-radius: 8px 0 0 8px;
    padding-left: 38px;
    font-size: 13px;
    border-right: none;
}
.coupon-input:focus {
    border-color: #D70018;
    box-shadow: none;
}
.btn-apply-coupon {
    background: #1A202C;
    color: #fff;
    border: none;
    border-radius: 0 8px 8px 0;
    padding: 0 22px;
    font-weight: 700;
    font-size: 13px;
    transition: background 0.2s ease;
}
.btn-apply-coupon:hover {
    background: #D70018;
    color: #fff;
}
.badge-voucher-chip {
    display: inline-block;
    background: #FFF5F5;
    border: 1px dashed #FEB2B2;
    color: #C53030;
    padding: 3px 10px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
    cursor: pointer;
    margin-left: 6px;
    transition: all 0.15s ease;
}
.badge-voucher-chip:hover {
    background: #D70018;
    color: #fff;
    border-color: #D70018;
}

/* Payment Methods Grid */
.payment-methods-grid {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.payment-method-card {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    border: 1px solid #E2E8F0;
    border-radius: 10px;
    padding: 16px;
    cursor: pointer;
    background: #FFFFFF;
    transition: all 0.2s ease;
    margin-bottom: 0;
}
.payment-method-card:hover {
    border-color: #FEB2B2;
    background: #FFFDFD;
}
.payment-method-card.active {
    border-color: #D70018;
    background: #FFF9F9;
    box-shadow: 0 0 0 1px #D70018;
}
.payment-radio-wrap {
    margin-top: 3px;
}
.payment-icon-box {
    font-size: 24px;
    width: 32px;
    text-align: center;
}
.payment-desc .payment-name {
    font-size: 14px;
    color: #1A202C;
    display: block;
}
.payment-desc .payment-sub {
    font-size: 12px;
    line-height: 1.5;
    margin-top: 3px;
    display: block;
}
.badge-popular {
    background: #D70018;
    color: #fff;
    font-size: 10px;
    padding: 2px 6px;
    border-radius: 4px;
}

/* VietQR Preview Box */
.vietqr-live-preview {
    background: #F8FAFC;
    border: 1px dashed #CBD5E0;
    border-radius: 10px;
    padding: 18px;
}
.qr-code-frame {
    background: #fff;
    border: 1px solid #E2E8F0;
    border-radius: 8px;
    padding: 8px;
    display: inline-block;
}
.qr-img-demo {
    max-width: 140px;
    border-radius: 4px;
    margin: 0 auto;
}
.qr-badge-live {
    font-size: 10px;
    color: #2563EB;
    display: block;
    margin-top: 6px;
    font-weight: 600;
}
.bank-acc-info {
    font-size: 13px;
}
.bank-acc-info .bank-title {
    margin-top: 0;
    font-size: 14px;
    margin-bottom: 10px;
}
.copy-field-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 5px 0;
    border-bottom: 1px solid #EDF2F7;
}
.btn-outline-copy {
    border: 1px solid #CBD5E0;
    border-radius: 4px;
    background: #fff;
    font-size: 11px;
}
.qr-guide-alert {
    background: #ECFDF5;
    border-left: 3px solid #10B981;
    color: #065F46;
    padding: 8px 10px;
    font-size: 12px;
    border-radius: 0 4px 4px 0;
}

/* Sticky Order Summary Sidebar */
.checkout-sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
    top: 20px;
}
.summary-header .badge-items-count {
    background: #EDF2F7;
    color: #4A5568;
    font-size: 11px;
    font-weight: 600;
    margin-left: 6px;
}
.btn-edit-cart {
    font-size: 13px;
    color: #D70018;
    font-weight: 700;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 6px;
    background: #FFF5F5;
    transition: all 0.2s ease;
}
.btn-edit-cart:hover {
    background: #FED7D7;
    color: #B30014;
    text-decoration: none;
}
.btn-edit-cart i {
    font-size: 12px;
}
.summary-items-list {
    max-height: 250px;
    overflow-y: auto;
    padding: 14px 20px;
    border-bottom: 1px solid #EDF2F7;
}
.summary-items-list::-webkit-scrollbar {
    width: 4px;
}
.summary-items-list::-webkit-scrollbar-thumb {
    background: #E2E8F0;
    border-radius: 4px;
}
.summary-product-item {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 12px;
}
.summary-product-item:last-child {
    margin-bottom: 0;
}
.item-thumb {
    position: relative;
    width: 48px;
    height: 48px;
    flex: 0 0 48px;
    border: 1px solid #EDF2F7;
    border-radius: 6px;
    padding: 3px;
    background: #fff;
}
.item-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}
.item-qty-badge {
    position: absolute;
    top: -6px;
    right: -6px;
    background: #718096;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    width: 18px;
    height: 18px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}
.item-info {
    flex: 1;
}
.item-name {
    font-size: 13px;
    font-weight: 600;
    color: #1A202C;
    margin: 0;
    line-height: 1.3;
}
.item-variant-sub {
    font-size: 11px;
    color: #718096;
    margin-top: 2px;
}
.item-price {
    font-size: 12px;
    font-weight: 700;
    color: #D70018;
    margin-top: 2px;
}

/* Pricing Breakdown Matrix */
.summary-pricing-matrix {
    padding: 16px 20px;
    background: #FAFAFA;
}
.price-line {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    color: #4A5568;
    margin-bottom: 10px;
}
.btn-remove-coupon {
    color: #EF4444;
    font-size: 12px;
    margin-left: 4px;
}
.grand-total-divider {
    height: 1px;
    background: #E2E8F0;
    margin: 14px 0;
}
.grand-total-line {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 0;
    gap: 12px;
}
.grand-total-title {
    font-size: 13px;
    font-weight: 800;
    color: #1A202C;
    letter-spacing: 0.3px;
    line-height: 1.3;
}
.grand-total-vat-text {
    font-size: 11px;
    color: #718096;
    font-style: italic;
    margin-top: 2px;
}
.grand-total-amount {
    font-size: 22px;
    font-weight: 800;
    color: #D70018;
    line-height: 1;
    white-space: nowrap;
    text-align: right;
}

/* Summary Actions Box & CTA Confirm Button */
.summary-actions {
    padding: 18px 20px;
    background: #FFFFFF;
}
.btn-confirm-order {
    width: 100%;
    background: linear-gradient(135deg, #D70018 0%, #B30014 100%);
    color: #FFFFFF !important;
    border: none;
    border-radius: 10px;
    padding: 14px 16px;
    text-align: center;
    box-shadow: 0 4px 14px rgba(215, 0, 24, 0.3);
    transition: all 0.25s ease;
    cursor: pointer;
    box-sizing: border-box;
}
.btn-confirm-order:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45);
    color: #FFFFFF !important;
}
.btn-confirm-order:active {
    transform: translateY(0);
}
.btn-confirm-order .btn-title {
    display: block;
    font-size: 15px;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: #FFFFFF;
    line-height: 1.25;
}
.btn-confirm-order .btn-subtitle {
    display: block !important;
    font-size: 12px !important;
    color: #FFFFFF !important;
    opacity: 1 !important;
    margin-top: 5px !important;
    font-weight: 500 !important;
    line-height: 1.3 !important;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3) !important;
}
.security-commitments {
    margin-top: 16px;
    padding-top: 14px;
    border-top: 1px solid #F1F5F9;
    text-align: center;
}
.commit-item {
    font-size: 11px;
    color: #718096;
}
.commit-item i {
    font-size: 15px;
    display: block;
    margin-bottom: 5px;
}

/* Mobile Sticky Bottom Bar */
.mobile-sticky-checkout-bar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #FFFFFF;
    border-top: 1px solid #E2E8F0;
    box-shadow: 0 -4px 16px rgba(0,0,0,0.08);
    padding: 10px 15px;
    z-index: 999;
}
.mob-total-label {
    display: block;
    font-size: 11px;
    color: #718096;
}
.mob-total-val {
    font-size: 18px;
    color: #D70018;
    font-weight: 800;
}
.btn-mobile-checkout {
    background: #D70018;
    border: none;
    border-radius: 6px;
    padding: 10px 18px;
    font-weight: 800;
    font-size: 13px;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .step-indicator-wrapper {
        display: none;
    }
    .checkout-sidebar-sticky {
        position: static;
        margin-top: 15px;
    }
    .checkout-modern-page {
        padding-bottom: 90px;
    }
}
</style>