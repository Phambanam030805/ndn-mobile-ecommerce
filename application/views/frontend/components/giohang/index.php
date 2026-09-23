<section id="content">
    <div class="container cart-page-wrapper" style="margin-top: 5px; margin-bottom: 50px;">
        <?php if($this->session->userdata('cart')):
            $cart = $this->session->userdata('cart');
            $total = 0;
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h2 class="section-title-modern" style="margin-bottom: 10px;">Giỏ hàng của bạn</h2>
                </div>
            </div>
            
            <?php echo form_open('', array('id' => 'cartformpage')); ?>
                <div class="row">
                    <!-- Cột trái: Danh sách sản phẩm -->
                    <div class="col-md-8 col-sm-12">
                        <div class="card-shadow cart-list-container" style="margin-top: 0;">
                            <div class="table-responsive">
                                <table class="table table-cart-modern">
                                    <thead>
                                        <tr>
                                            <th colspan="2">Sản phẩm</th>
                                            <th class="text-center">Giá</th>
                                            <th class="text-center">Số lượng</th>
                                            <th class="text-center">Thành tiền</th>
                                            <th class="text-center"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $cart_info = $this->session->userdata('cart_info');
                                        foreach ($cart as $key => $value) :
                                            $info = $cart_info[$key];
                                            $row = $this->Msanpham->product_detail_id($info['id']);
                                            if ($row) :
                                                $price = ($row['price_sale'] > 0) ? $row['price_sale'] : $row['price'];
                                                $subtotal = $price * $value;
                                                $total += $subtotal;
                                            ?>
                                            <tr>
                                                <td class="cart-img">
                                                    <a href="<?php echo $row['alias'] ?>">
                                                        <img src="<?php echo base_url(); ?>public/images/products/<?php echo $row['avatar'] ?>" alt="<?php echo $row['name'] ?>">
                                                    </a>
                                                </td>
                                                <td class="cart-name">
                                                    <a href="<?php echo $row['alias'] ?>" style="font-weight: bold;"><?php echo $row['name'] ?></a>
                                                    <?php if(!empty($info['color']) || !empty($info['capacity'])): ?>
                                                        <div class="cart-variant-info" style="font-size: 12px; color: #777; margin-top: 4px;">
                                                            <?php if($info['color']) echo '<span>Màu: '.$info['color'].'</span>'; ?>
                                                            <?php if($info['color'] && $info['capacity']) echo ' | '; ?>
                                                            <?php if($info['capacity']) echo '<span>Dung lượng: '.$info['capacity'].'</span>'; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center text-danger font-weight-bold">
                                                    <?php echo number_format($price) ?>₫
                                                </td>
                                                <td class="text-center" style="width: 120px;">
                                                    <input name="quantity" id="<?php echo $key ?>" 
                                                           class="form-control text-center input-qty-modern" 
                                                           type="number" value="<?php echo $value ?>" min="1" 
                                                           onchange="onChangeSL('<?php echo $key ?>')">
                                                </td>
                                                <td class="text-center font-weight-bold">
                                                    <?php echo number_format($subtotal) ?>₫
                                                </td>
                                                <td class="text-center">
                                                    <a href="javascript:void(0)" class="btn-remove-cart" onclick="onRemoveProduct('<?php echo $key; ?>')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endif; endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-footer-modern">
                                <a href="san-pham" class="btn btn-link text-danger">
                                    <i class="fa fa-arrow-left"></i> Tiếp tục mua hàng
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Thanh toán -->
                    <div class="col-md-4 col-sm-12">
                        <div class="card-shadow cart-summary-container" style="margin-top: 0 !important;">
                            <div class="summary-header">
                                <h4>Tóm tắt đơn hàng</h4>
                            </div>
                            <div class="summary-body">
                                <div class="summary-line">
                                    <span>Tạm tính:</span>
                                    <span><?php echo number_format($total) ?>₫</span>
                                </div>
                                <?php $price_ship = $this->Mcauhinh->config_price_ship($total); ?>
                                <div class="summary-line">
                                    <span>Giao hàng:</span>
                                    <span><?php echo number_format($price_ship) ?>₫</span>
                                </div>
                                <hr>
                                <div class="summary-line total-line">
                                    <span>Tổng tiền:</span>
                                    <span class="text-danger"><?php echo number_format($total + $price_ship) ?>₫</span>
                                </div>
                                <p class="promo-text"><i class="fa fa-gift"></i> Mua tại cửa hàng giảm 5%</p>
                                <button type="button" onclick="window.location.href='info-order'" class="btn btn-danger btn-block btn-checkout-modern">
                                    THANH TOÁN NGAY <i class="fa fa-chevron-right"></i>
                                </button>
                                <div class="payment-trust">
                                    <p style="font-size: 13px; color: #666; margin-bottom: 8px;">Thanh toán an toàn với nhiều phương thức</p>
                                    <div class="payment-icons text-center">
                                        <img src="https://img.icons8.com/color/48/000000/visa.png" alt="Visa" style="height: 30px; margin: 0 4px;" title="Thanh toán qua Visa">
                                        <img src="https://img.icons8.com/color/48/000000/mastercard.png" alt="MasterCard" style="height: 30px; margin: 0 4px;" title="Thanh toán qua MasterCard">
                                        <img src="https://img.icons8.com/color/48/000000/jcb.png" alt="JCB" style="height: 30px; margin: 0 4px;" title="Thanh toán qua thẻ JCB">
                                        <img src="https://img.icons8.com/color/48/000000/cash-in-hand.png" alt="COD" style="height: 30px; margin: 0 4px;" title="Thanh toán tiền mặt khi nhận hàng">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        <?php else: ?>
            <!-- Giỏ hàng trống -->
            <div class="cart-empty-state text-center">
                <div class="empty-icon">
                    <i class="fa fa-shopping-basket"></i>
                </div>
                <h3>Giỏ hàng của bạn đang trống!</h3>
                <p>Hãy dạo quanh một vòng và chọn cho mình những sản phẩm ưng ý nhé.</p>
                <a href="san-pham" class="btn btn-danger btn-lg btn-modern mt-4">
                    <i class="fa fa-shopping-cart"></i> MUA SẮM NGAY
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    function onChangeSL(id){
        var sl = document.getElementById(id).value;
        var strurl="<?php echo base_url();?>"+'/sanpham/update';
        jQuery.ajax({
            url: strurl,
            type: 'POST',
            dataType: 'json',
            data: {id: id, sl:sl, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
            success: function(data) {
                document.location.reload(true);
            }
        });
    }
    function onRemoveProduct(id){
        var strurl="<?php echo base_url();?>"+'/sanpham/remove';
        if(confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
            jQuery.ajax({
                url: strurl,
                type: 'POST',
                dataType: 'json',
                data: {id: id, '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'},
                success: function(data) {
                    document.location.reload(true);
                }
            });
        }
    }
</script>