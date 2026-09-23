<?php echo form_open('info-order'); ?>
<?php  
// Lưu ý: Logic kiểm tra giỏ hàng này nên nằm ở Controller. 
// Nếu để ở đây, hãy đảm bảo không có khoảng trắng trước thẻ <?php
if(!$this->session->userdata('cart')){
    redirect('gio-hang');
}
$user = $this->session->userdata('sessionKhachHang');
if(!$user){
    $user = array('fullname' => '', 'email' => '', 'phone' => '', 'address' => '');
}
?>
<section id="checkout-cart">
    <div class="container">
        <div class="col-md-12">
            <div class="wrapper overflow-hidden" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                
                <?php if(!$this->session->userdata('sessionKhachHang')): ?>
                    <div class="alert alert-info" style="font-size: 15px; margin-bottom: 20px;">
                        <i class="fas fa-user-circle"></i> Bạn đã có tài khoản? 
                        <a href="dang-nhap" style="color: #0f9ed8; font-weight: bold; text-decoration: underline;">Bấm vào đây để đăng nhập</a> để nhận ưu đãi thành viên.
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- CỘT TRÁI: THÔNG TIN GIAO HÀNG -->
                    <div class="col-xs-12 col-sm-12 col-md-8">
                        <div class="checkout-content">
                            <h4 style="font-weight: bold; text-transform: uppercase; color: #333; margin-bottom: 20px; border-bottom: 2px solid #0f9ed8; padding-bottom: 10px; display: inline-block;">
                                Địa chỉ giao hàng
                            </h4>
                            <div class="wrap-info">
                                <table class="table tinfo" style="width: 100%; border: none;">
                                    <tbody>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: middle; border: none;">Họ tên người nhận: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <input type="text" class="form-control" placeholder="Nhập đầy đủ họ và tên" name="name" value="<?php echo set_value('name', $user['fullname']) ?>">
                                                <div class="error" style="color: red; font-style: italic; font-size: 12px;"><?php echo form_error('name')?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: middle; border: none;">Email liên hệ: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <input type="text" class="form-control" name="email" value="<?php echo set_value('email', $user['email']) ?>" placeholder="Ví dụ: nva@gmail.com">
                                                <div class="error" style="color: red; font-style: italic; font-size: 12px;"><?php echo form_error('email')?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: middle; border: none;">Số điện thoại: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <input type="text" class="form-control" placeholder="Số điện thoại nhận hàng" name="phone" value="<?php echo set_value('phone', $user['phone']) ?>">
                                                <div class="error" style="color: red; font-style: italic; font-size: 12px;"><?php echo form_error('phone')?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: middle; border: none;">Tỉnh/Thành phố: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <select name="city" id="province" onchange="loadDistricts_NDN()" class="form-control next-select">
                                                    <option value="">--- Chọn tỉnh thành ---</option>
                                                    <?php 
                                                    $list = $this->Mtinhthanh->province_all();
                                                    foreach($list as $row):?>
                                                        <option value="<?php echo $row['id']; ?>" <?php echo set_select('city', $row['id']); ?>>
                                                            <?php echo $row['name']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="error" style="color: red; font-style: italic; font-size: 12px;"><?php echo form_error('city')?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: middle; border: none;">Quận/Huyện: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <select name="DistrictId" id="district" class="form-control next-select">
                                                    <option value="">--- Chọn quận huyện ---</option>
                                                </select>
                                                <div class="error" style="color: red; font-style: italic; font-size: 12px;"><?php echo form_error('DistrictId')?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: top; border: none; padding-top: 10px;">Địa chỉ nhận hàng: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <textarea name="address" placeholder="Số nhà, tên đường, thôn/xóm..." class="form-control" rows="3" style="height: auto !important;"><?php echo set_value('address', $user['address']) ?></textarea>
                                                <div class="error" style="color: red; font-style: italic; font-size: 12px;"><?php echo form_error('address')?></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: middle; border: none;">Mã giảm giá:</td>
                                            <td style="border: none;">
                                                <div class="input-group">
                                                    <input id="coupon" style="border-radius: 4px 0 0 4px;" type="text" class="form-control" placeholder="Nhập mã ưu đãi" name="coupon">
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-info" type="button" onclick="checkCoupon()" style="border-radius: 0 4px 4px 0;">Áp dụng</button>
                                                    </span>
                                                </div>
                                                <div id="result_coupon" style="margin-top: 5px; font-size: 13px;"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="width30 text-right td-right-order" style="vertical-align: top; border: none; padding-top: 10px;">Thanh toán: <span class="require_symbol">* </span></td>
                                            <td style="border: none;">
                                                <div class="radio">
                                                    <label><input type="radio" name="payment_method" value="0" checked> <b>COD</b> (Thanh toán khi nhận hàng)</label>
                                                </div>
                                                <div class="radio">
                                                    <label><input type="radio" name="payment_method" value="1"> <b>Online</b> (Chuyển khoản / Ví điện tử)</label>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- CỘT PHẢI: TÓM TẮT ĐƠN HÀNG -->
                    <div class="col-xs-12 col-sm-12 col-md-4">
                        <div class="order-summary" style="background: #fbfbfb; border: 1px solid #eee; padding: 15px; border-radius: 8px;">
                            <h4 style="font-weight: bold; margin-bottom: 15px; color: #333;">Đơn hàng của bạn</h4>
                            <table class="table table-condensed" style="font-size: 14px;">
                                <thead>
                                    <tr style="font-weight: bold; background: #f4f4f4;">
                                        <th>Sản phẩm</th>
                                        <th class="text-right">Tổng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $money = 0;
                                    if($this->session->userdata('cart')):
                                        $cart = $this->session->userdata('cart');
                                        foreach ($cart as $key => $value) :
                                            $row = $this->Msanpham->product_detail_id($key);
                                            if($row):
                                                $price_end = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                                                $total = $price_end * $value;
                                                $money += $total;
                                    ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?> <strong style="color: #0f9ed8;">x<?php echo $value; ?></strong></td>
                                            <td class="text-right"><?php echo number_format($total); ?> đ</td>
                                        </tr>
                                    <?php endif; endforeach; endif; ?>
                                </tbody>
                                <tfoot style="border-top: 2px solid #ddd;">
                                    <tr>
                                        <td>Tạm tính:</td>
                                        <td class="text-right"><?php echo number_format($money); ?> đ</td>
                                    </tr>
                                    <tr>
                                        <td>Phí giao hàng:</td>
                                        <td class="text-right"><?php echo number_format($this->Mcauhinh->config_price_ship($money)); ?> đ</td>
                                    </tr>
                                    <?php if($this->session->userdata('coupon_price')): 
                                        $discount = $this->session->userdata('coupon_price');
                                    ?>
                                        <tr style="color: #27ae60;">
                                            <td>Mã giảm giá: <a onclick="removeCoupon()" style="color: red; cursor: pointer;"><i class="fas fa-times-circle"></i></a></td>
                                            <td class="text-right">-<?php echo number_format($discount); ?> đ</td>
                                        </tr>
                                    <?php else: $discount = 0; endif; ?>
                                    
                                    <tr style="background: #fff9e6; font-size: 18px; font-weight: bold;">
                                        <td style="color: #e74c3c;">THÀNH TIỀN:</td>
                                        <td class="text-right" style="color: #e74c3c;">
                                            <?php 
                                                $total_pay = $money + $this->Mcauhinh->config_price_ship($money) - $discount;
                                                echo number_format($total_pay); 
                                            ?> đ
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div style="margin-top: 20px;">
                                <button type="submit" name="dathang" class="btn btn-primary btn-block" style="padding: 12px; font-size: 16px; font-weight: bold; background: #0f9ed8; border: none; border-radius: 4px; box-shadow: 0 4px 6px rgba(15, 158, 216, 0.2);">
                                    XÁC NHẬN ĐẶT HÀNG
                                </button>
                                <p class="text-center" style="font-size: 12px; margin-top: 10px; color: #777; font-style: italic;">
                                    (Vui lòng kiểm tra kỹ thông tin trước khi đặt)
                                </p>
                            </div>
                        </div>
                    </div>
                </div> <!-- End .row -->

            </div>
        </div>
    </div>
</section>
<?php echo form_close(); ?>

<script>
    jQuery(document).ready(function($) {
        // Hàm load Quận/Huyện
        window.loadDistricts_NDN = function() {
            var provinceid = $("#province").val();
            if(!provinceid) return;
            var strurl = "<?php echo site_url('giohang/district'); ?>";
            $.ajax({
                url: strurl,
                type: 'GET',
                data: { 'provinceid': provinceid },
                success: function(data) {
                    $('#district').html(data);
                }
            });
        };

        // Hàm kiểm tra Coupon
        window.checkCoupon = function() {
            var code = $("input[name='coupon']").val();
            if(!code) {
                alert('Vui lòng nhập mã giảm giá');
                return;
            }
            var strurl = "<?php echo site_url('giohang/coupon');?>";
            $.ajax({
                url: strurl,
                type: 'POST',
                data: { 
                    code: code,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    $('#result_coupon').html(data);
                    // Nếu thành công thì reload để cập nhật giá
                    if(data.indexOf("thành công") !== -1) {
                        setTimeout(function(){ location.reload(); }, 1500);
                    }
                }
            });
        };

        // Hàm xóa Coupon
        window.removeCoupon = function() {
            var strurl = "<?php echo site_url('giohang/removecoupon');?>";
            $.ajax({
                url: strurl,
                type: 'POST',
                data: {
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                },
                success: function(data) {
                    location.reload();
                }
            });
        };
    });
</script>