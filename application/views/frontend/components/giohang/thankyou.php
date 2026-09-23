<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 
?>
<section id="checkout-cart">
    <div class="container">
        <div class="col-md-12">
            <div class="wrapper overflow-hidden">
                <div class="checkout-content">
                    <div class="tks-header">
                        <h3 class="fa fa-check-circle"> Thông tin đơn hàng đã được gửi đến 
                            <?php 
                            if($this->session->userdata('info-customer')){
                                $data=$this->session->userdata('info-customer');
                                echo $data['email'];
                                $this->session->unset_userdata('info-customer');
                            }else{
                                if($this->session->userdata('sessionKhachHang')){
                                    $data=$this->session->userdata('sessionKhachHang');
                                    echo $data['email'];
                                }
                            }
                            ?>
                            . Qúy khách hãy đăng nhập gmail để kiểm tra thông tin đơn hàng.
                        </h3>
                    </div>
                    <div class="tks-content" style="min-height: 1px;
                    overflow: hidden;">
                    <div class="col-xs-12 col-sm-12 col-md-7 col-login-checkout" style="margin-bottom: 20px">
                        <table class="table tks-tabele-info-cus">
                            <thead>
                                <tr>
                                    <th colspan="2">Thông tin thanh toán nhận hàng</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Khách hàng :</td>
                                    <td><?php echo $get['fullname'] ?></td>
                                </tr>
                                <tr>
                                    <td>Số điện thoại :</td>
                                    <td><?php echo $get['phone'] ?></td>
                                </tr>
                                <tr>
                                    <td>Địa chỉ thanh toán :</td>
                                    <td><?php echo $get['address'] ?>, <?php echo $this->Mquanhuyen->district_name($get['district'] )?>, <?php echo $this->Mtinhthanh->province_name($get['province'] )?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-5 products-detail">
                        <div class="no-margin-table" style="width: 95%; float: right;">
                            <table class="table" style="color: #333;">
                                <thead>
                                    <tr>
                                        <th colspan="3" style="font-weight: 600;">Thông tin đơn hàng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="background: #fafafa; color: #333;" class="text-transform font-weight-600">
                                        <td>Sản phẩm</td>
                                        <td class="text-center">Màu</td>
                                        <td class="text-center">Dung lượng</td>
                                        <td class="text-center">Số lượng</td>
                                        <td class="text-center">Giá</td>
                                        <td class="text-center">Tổng</td>
                                    </tr>
                                    <?php
                                    $data = $this->Mchitietdonhang->orderdetail_order($get['id']);
                                    $money = 0;
                                    $total2 = 0;
                                    foreach ($data as $value) :
                                        $productId = isset($value['product_id']) ? $value['product_id'] : (isset($value['productid']) ? $value['productid'] : null);
                                        $row = !empty($productId) ? $this->Msanpham->product_detail_id($productId) : null;
                                        if (!$row) {
                                            continue;
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $row['name']; ?></td>
                                            <td class="text-center"><?php echo !empty($value['color']) ? $value['color'] : '-'; ?></td>
                                            <td class="text-center"><?php echo !empty($value['capacity']) ? $value['capacity'] : '-'; ?></td>
                                            <td class="text-center"><?php echo $value['count']; ?></td>
                                            <td class="text-center">    
                                                <?php echo number_format($value['price']);?>
                                            </td>
                                            <td class="text-right"><?php echo number_format($value['count'] * $value['price']); ?> VNĐ</td>
                                            <?php $total = $value['count'] * $value['price'];
                                            $total2 += $total;?>

                                        </tr>
                                    <?php endforeach; ?>
                                    <tr style="background: #fafafa">
                                        <td colspan="5">Tổng cộng :</td>
                                        <td class="text-right">
                                            <?php 
                                            echo number_format($total2);
                                            ?> VNĐ
                                        </td>
                                    </tr>
                                    <tr style="background: #fafafa">
                                        <td colspan="5">Vận chuyển</td>
                                        <td class="text-right"><?php echo number_format($get['price_ship']).' VNĐ'; ?></td>
                                    </tr>
                                    <?php 
                                    if($get['coupon'] != 0){
                                        echo '<tr style="background: #fafafa">
                                        <td colspan="5">Voucher</td>
                                        <td class="text-right">'.number_format(-$get['coupon']).' VNĐ</td>
                                        </tr>';
                                    }
                                    ?>
                                    <tr style="background: #fafafa">
                                        <td colspan="5" class="font-weight-600">Thành tiền<br/><span style="font-style: italic;">(Tổng số tiền thanh toán)</span></td>
                                        <td class="text-right" style="font-weight: 600; font-size: 17px;color: red;"><?php echo number_format($get['money']).' VNĐ'; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="btn-tks clearfix">
                    <button type="button" onclick="window.location.href='<?php echo base_url() ?>trang-chu'" class="btn-next-checkout pull-left">Tiếp tục mua hàng</button>
                    <button type="button" onclick="window.print()" class="btn-update-order pull-left">In</button>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
