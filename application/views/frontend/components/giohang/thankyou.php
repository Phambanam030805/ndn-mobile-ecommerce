<?php 
defined('BASEPATH') OR exit('No direct script access allowed'); 

// 1. Chuẩn bị dữ liệu hiển thị hóa đơn
$orderCode = !empty($get['orderCode']) ? $get['orderCode'] : 'N/A';
$orderDate = !empty($get['orderdate']) ? date('d/m/Y - H:i', strtotime($get['orderdate'])) : date('d/m/Y - H:i');
$customerName = !empty($get['fullname']) ? $get['fullname'] : 'Khách hàng';
$customerPhone = !empty($get['phone']) ? $get['phone'] : '';

// Địa chỉ đầy đủ
$deliveryAddress = !empty($get['address']) ? $get['address'] : '';
if (!empty($get['district'])) {
    $deliveryAddress .= ', ' . $this->Mquanhuyen->district_name($get['district']);
}
if (!empty($get['province'])) {
    $deliveryAddress .= ', ' . $this->Mtinhthanh->province_name($get['province']);
}

// Phương thức thanh toán
$paymentMethodName = ((int)($get['payment_method'] ?? 0) === 1) ? 'Chuyển khoản VietQR' : 'Thanh toán khi nhận hàng (COD)';

// Thông tin cửa hàng chuẩn hóa
$storeConfig = $this->Mcauhinh->configuration_detail();
$storeTitle   = !empty($storeConfig['title']) ? $storeConfig['title'] : 'NDN Mobile';
$storeHotline = !empty($storeConfig['hotline']) ? $storeConfig['hotline'] : '0794.358.619';
$storeAddress = !empty($storeConfig['address']) ? $storeConfig['address'] : 'Hà Nội, Việt Nam';
$storeEmail   = !empty($storeConfig['mail_smtp']) ? $storeConfig['mail_smtp'] : 'hotro@ndnmobile.vn';
?>

<!-- ========================================== -->
<!-- 1. GIAO DIỆN SCREEN THÔNG THƯỜNG TRÊN WEB  -->
<!-- ========================================== -->
<section id="checkout-cart" class="thankyou-screen-view" style="padding: 40px 0; background: #f8fafc; min-height: 80vh;">
    <div class="container">
        <div class="col-md-12">
            <div style="background: #fff; border-radius: 16px; box-shadow: 0 4px 25px rgba(0,0,0,0.06); overflow: hidden; border: 1px solid #edf2f7; padding: 35px 30px;">
                
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success" style="border-radius: 10px; font-size: 14px; margin-bottom: 25px;">
                        <i class="fa fa-check-circle"></i> <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php endif; ?>
                
                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger" style="border-radius: 10px; font-size: 14px; margin-bottom: 25px;">
                        <i class="fa fa-exclamation-triangle"></i> <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php endif; ?>

                <?php if(!empty($get)): ?>
                    <div style="text-align: center; margin-bottom: 35px;">
                        <div style="width: 70px; height: 70px; border-radius: 50%; background: #e8f8f0; color: #2ecc71; display: inline-flex; align-items: center; justify-content: center; font-size: 36px; margin-bottom: 15px;">
                            <i class="fa fa-check"></i>
                        </div>
                        <h2 style="font-size: 24px; font-weight: 700; color: #1e293b; margin: 0 0 8px;">Đặt Hàng Thành Công!</h2>
                        <p style="color: #64748b; font-size: 14px; margin: 0;">
                            Cảm ơn bạn đã mua hàng tại <?php echo htmlspecialchars($storeTitle); ?>. Mã đơn hàng của bạn là: <strong style="color: #d70018; font-size: 16px;">#<?php echo htmlspecialchars($orderCode); ?></strong>
                        </p>
                        <?php if(!empty($customer_email)): ?>
                            <p style="color: #0284c7; font-size: 13px; margin-top: 6px;">
                                <i class="fa fa-envelope-o"></i> Chi tiết đơn hàng và biên lai đã được gửi đến hộp thư: <strong><?php echo htmlspecialchars($customer_email); ?></strong>
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <!-- Thông tin người nhận -->
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 25px;">
                            <div style="background: #f8fafc; border-radius: 12px; padding: 22px; border: 1px solid #e2e8f0; height: 100%;">
                                <h4 style="font-size: 15px; font-weight: 700; color: #334155; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; text-transform: uppercase;">
                                    <i class="fa fa-user-circle" style="color: #d70018;"></i> Thông tin nhận hàng
                                </h4>
                                <table style="width: 100%; font-size: 14px; line-height: 2;">
                                    <tr>
                                        <td style="color: #64748b; width: 35%;">Người nhận:</td>
                                        <td><strong><?php echo htmlspecialchars($customerName); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #64748b;">Số điện thoại:</td>
                                        <td><strong><?php echo htmlspecialchars($customerPhone); ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #64748b;">Địa chỉ giao:</td>
                                        <td><?php echo htmlspecialchars($deliveryAddress); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="color: #64748b;">Hình thức:</td>
                                        <td>
                                            <span style="display: inline-block; padding: 2px 10px; border-radius: 6px; font-size: 12px; font-weight: 600; background: #e0f2fe; color: #0369a1;">
                                                <?php echo htmlspecialchars($paymentMethodName); ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- Chi tiết sản phẩm & Tổng tiền -->
                        <div class="col-md-6 col-sm-12" style="margin-bottom: 25px;">
                            <div style="background: #f8fafc; border-radius: 12px; padding: 22px; border: 1px solid #e2e8f0; height: 100%;">
                                <h4 style="font-size: 15px; font-weight: 700; color: #334155; margin-top: 0; margin-bottom: 16px; border-bottom: 1px solid #e2e8f0; padding-bottom: 10px; text-transform: uppercase;">
                                    <i class="fa fa-shopping-bag" style="color: #d70018;"></i> Chi tiết sản phẩm
                                </h4>
                                
                                <div style="max-height: 200px; overflow-y: auto; margin-bottom: 15px;">
                                    <?php 
                                        $subtotal_items = 0;
                                        if(!empty($order_items)): 
                                            foreach($order_items as $item):
                                                $line_price = (float)$item['price'] * (int)$item['count'];
                                                $subtotal_items += $line_price;
                                                $p_info = $this->Msanpham->product_detail_id($item['product_id']);
                                    ?>
                                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px dashed #e2e8f0; font-size: 13px;">
                                            <div>
                                                <strong style="color: #1e293b;"><?php echo htmlspecialchars($p_info ? $p_info['name'] : 'Điện thoại'); ?></strong>
                                                <div style="color: #64748b; font-size: 12px;">
                                                    <?php if(!empty($item['color'])): ?>Màu: <?php echo htmlspecialchars($item['color']); ?> | <?php endif; ?>
                                                    <?php if(!empty($item['capacity'])): ?>Bộ nhớ: <?php echo htmlspecialchars($item['capacity']); ?> | <?php endif; ?>
                                                    SL: <?php echo (int)$item['count']; ?>
                                                </div>
                                            </div>
                                            <div style="font-weight: 700; color: #334155;">
                                                <?php echo number_format($line_price); ?> đ
                                            </div>
                                        </div>
                                    <?php 
                                            endforeach;
                                        endif; 
                                    ?>
                                </div>

                                <!-- Bảng tổng hợp chi phí -->
                                <div style="border-top: 2px solid #e2e8f0; padding-top: 10px; font-size: 13px; line-height: 2;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748b;">Tạm tính sản phẩm:</span>
                                        <strong><?php echo number_format($subtotal_items); ?> đ</strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #64748b;">Phí vận chuyển:</span>
                                        <strong><?php echo number_format((float)$get['price_ship']); ?> đ</strong>
                                    </div>
                                    <?php if(!empty($coupon_discount) && $coupon_discount > 0): ?>
                                        <div style="display: flex; justify-content: space-between; color: #16a34a;">
                                            <span>Mã giảm giá (Coupon):</span>
                                            <strong>-<?php echo number_format($coupon_discount); ?> đ</strong>
                                        </div>
                                    <?php endif; ?>
                                    <div style="display: flex; justify-content: space-between; font-size: 16px; margin-top: 6px; padding-top: 6px; border-top: 1px solid #e2e8f0;">
                                        <span style="font-weight: 700; color: #1e293b;">Tổng thanh toán:</span>
                                        <strong style="color: #d70018; font-weight: 800; font-size: 18px;"><?php echo number_format((float)$get['money']); ?> đ</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nút thao tác trên màn hình web -->
                    <div class="thankyou-action-buttons" style="text-align: center; margin-top: 20px; display: flex; gap: 15px; justify-content: center;">
                        <a href="<?php echo base_url('trang-chu'); ?>" class="btn btn-continue-shopping" style="background: #d70018; color: #fff; font-weight: 700; padding: 12px 28px; border-radius: 10px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                            <i class="fa fa-shopping-cart"></i> Tiếp tục mua hàng
                        </a>
                        <button type="button" onclick="printInvoice()" class="btn btn-print-invoice" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 12px 24px; border-radius: 10px; border: 1px solid #cbd5e1; display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                            <i class="fa fa-print"></i> In hóa đơn
                        </button>
                    </div>

                <?php else: ?>
                    <div style="text-align: center; padding: 50px 0;">
                        <i class="fa fa-shopping-basket" style="font-size: 48px; color: #cbd5e1; margin-bottom: 15px; display: block;"></i>
                        <h3 style="color: #1e293b; font-weight: 700;">Bạn chưa có đơn hàng nào vừa thực hiện!</h3>
                        <p style="color: #64748b; font-size: 14px;">Hãy khám phá các mẫu điện thoại mới nhất và đặt hàng ngay hôm nay.</p>
                        <a href="<?php echo base_url('san-pham'); ?>" class="btn" style="background: #d70018; color: #fff; font-weight: 700; padding: 10px 24px; border-radius: 8px; margin-top: 10px; text-decoration: none;">
                            Xem danh sách sản phẩm
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<!-- ========================================================== -->
<!-- 2. TEMPLATE HÓA ĐƠN CHUYÊN NGHIỆP DÀNH RIÊNG CHO MÁY IN (A4) -->
<!-- ========================================================== -->
<?php if(!empty($get)): ?>
<div class="print-invoice-sheet" id="printInvoiceSheet">
    <!-- Header hóa đơn -->
    <div class="print-header">
        <div class="print-header-brand">
            <div class="print-brand-title">NDN MOBILE</div>
            <div class="print-brand-desc">Hệ Thống Bán Lẻ Điện Thoại Di Động Chính Hãng</div>
            <div class="print-brand-info"><strong>Địa chỉ:</strong> <?php echo htmlspecialchars($storeAddress); ?></div>
            <div class="print-brand-info"><strong>Hotline:</strong> <?php echo htmlspecialchars($storeHotline); ?> | <strong>Email:</strong> <?php echo htmlspecialchars($storeEmail); ?></div>
            <div class="print-brand-info"><strong>Mã số DN:</strong> 0109887766 - Sở KH&ĐT Cấp</div>
        </div>
        <div class="print-header-invoice-meta">
            <h1 class="print-invoice-title">HÓA ĐƠN BÁN HÀNG</h1>
            <div class="print-invoice-subtitle">ORDER RECEIPT</div>
            <div class="print-meta-row"><strong>Mã đơn hàng:</strong> <span class="print-meta-code">#<?php echo htmlspecialchars($orderCode); ?></span></div>
            <div class="print-meta-row"><strong>Ngày đặt hàng:</strong> <?php echo htmlspecialchars($orderDate); ?></div>
            <div class="print-meta-row"><strong>Trạng thái:</strong> Đã tiếp nhận đơn hàng</div>
        </div>
    </div>

    <!-- Khung thông tin khách hàng & giao nhận -->
    <div class="print-section-box">
        <div class="print-section-title">THÔNG TIN KHÁCH HÀNG & GIAO HÀNG</div>
        <div class="print-customer-grid">
            <div class="print-customer-col">
                <div class="print-data-row">
                    <span class="print-data-label">Họ và tên:</span>
                    <strong class="print-data-val"><?php echo htmlspecialchars($customerName); ?></strong>
                </div>
                <div class="print-data-row">
                    <span class="print-data-label">Số điện thoại:</span>
                    <strong class="print-data-val"><?php echo htmlspecialchars($customerPhone); ?></strong>
                </div>
                <?php if(!empty($customer_email)): ?>
                <div class="print-data-row">
                    <span class="print-data-label">Email:</span>
                    <span class="print-data-val"><?php echo htmlspecialchars($customer_email); ?></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="print-customer-col">
                <div class="print-data-row">
                    <span class="print-data-label">Địa chỉ giao:</span>
                    <span class="print-data-val"><?php echo htmlspecialchars($deliveryAddress); ?></span>
                </div>
                <div class="print-data-row">
                    <span class="print-data-label">Hình thức:</span>
                    <strong class="print-data-val"><?php echo htmlspecialchars($paymentMethodName); ?></strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Bảng danh sách sản phẩm -->
    <div class="print-table-wrapper">
        <table class="print-items-table">
            <thead>
                <tr>
                    <th style="width: 5%; text-align: center;">STT</th>
                    <th style="width: 52%; text-align: left;">Tên sản phẩm / Quy cách</th>
                    <th style="width: 15%; text-align: right;">Đơn giá</th>
                    <th style="width: 8%; text-align: center;">SL</th>
                    <th style="width: 20%; text-align: right;">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $stt = 1;
                    $calc_subtotal = 0;
                    if(!empty($order_items)):
                        foreach($order_items as $item):
                            $p_info = $this->Msanpham->product_detail_id($item['product_id']);
                            $pName = $p_info ? $p_info['name'] : 'Sản phẩm';
                            $itemPrice = (float)$item['price'];
                            $itemQty = (int)$item['count'];
                            $lineMoney = $itemPrice * $itemQty;
                            $calc_subtotal += $lineMoney;
                ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $stt++; ?></td>
                        <td>
                            <div class="print-product-name"><?php echo htmlspecialchars($pName); ?></div>
                            <?php if(!empty($item['color']) || !empty($item['capacity'])): ?>
                                <div class="print-product-spec">
                                    <?php if(!empty($item['color'])): ?>Màu: <?php echo htmlspecialchars($item['color']); ?> <?php endif; ?>
                                    <?php if(!empty($item['capacity'])): ?>| Dung lượng: <?php echo htmlspecialchars($item['capacity']); ?> <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td style="text-align: right;"><?php echo number_format($itemPrice); ?> đ</td>
                        <td style="text-align: center; font-weight: bold;"><?php echo $itemQty; ?></td>
                        <td style="text-align: right; font-weight: bold;"><?php echo number_format($lineMoney); ?> đ</td>
                    </tr>
                <?php 
                        endforeach;
                    endif; 
                ?>
            </tbody>
        </table>
    </div>

    <!-- Khối tóm tắt tài chính -->
    <div class="print-summary-container">
        <table class="print-summary-table">
            <tr>
                <td class="print-sum-label">Tạm tính tiền hàng:</td>
                <td class="print-sum-value"><?php echo number_format($calc_subtotal); ?> đ</td>
            </tr>
            <tr>
                <td class="print-sum-label">Phí vận chuyển:</td>
                <td class="print-sum-value"><?php echo number_format((float)$get['price_ship']); ?> đ</td>
            </tr>
            <?php if(!empty($coupon_discount) && $coupon_discount > 0): ?>
            <tr>
                <td class="print-sum-label">Chiết khấu Voucher (Coupon):</td>
                <td class="print-sum-value" style="color: #16a34a;">-<?php echo number_format($coupon_discount); ?> đ</td>
            </tr>
            <?php endif; ?>
            <tr class="print-sum-grand-row">
                <td class="print-sum-grand-label">TỔNG CỘNG THANH TOÁN:</td>
                <td class="print-sum-grand-value"><?php echo number_format((float)$get['money']); ?> đ</td>
            </tr>
        </table>
    </div>

    <!-- Lời cảm ơn và chính sách -->
    <div class="print-note-box">
        <p><strong>* Ghi chú:</strong> Quý khách vui lòng kiểm tra kỹ máy và hóa đơn trước khi nhận hàng. Máy được bảo hành chính hãng theo chính sách đổi trả tiêu chuẩn của NDN Mobile trong vòng 30 ngày.</p>
        <p style="text-align: center; font-style: italic; margin-top: 4px; font-weight: 600;">Cảm ơn quý khách đã tin tưởng và đồng hành cùng NDN Mobile!</p>
    </div>

    <!-- Chữ ký 2 bên -->
    <div class="print-signatures-row">
        <div class="print-sign-col">
            <div class="print-sign-role">KHÁCH HÀNG</div>
            <div class="print-sign-note">(Ký và ghi rõ họ tên)</div>
            <div class="print-sign-space"></div>
            <div class="print-sign-name"><?php echo htmlspecialchars($customerName); ?></div>
        </div>
        <div class="print-sign-col">
            <div class="print-sign-role">ĐẠI DIỆN NDN MOBILE</div>
            <div class="print-sign-note">(Ký, đóng dấu xác nhận)</div>
            <div class="print-sign-space"></div>
            <div class="print-sign-name">Bộ phận Bán Hàng & CSKH</div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- ============================================================== -->
<!-- 3. CSS ĐỘC QUYỀN: BẢO VỆ IN ẤN CHUẨN A4 VÀ CLEAN UI/UX SCREEN -->
<!-- ============================================================== -->
<style>
/* CSS SCREEN (MẶC ĐỊNH) */
.print-invoice-sheet {
    display: none; /* Ẩn hoàn toàn khỏi màn hình duyệt web thông thường */
}

/* ========================================================= */
/* CSS PRINT: TỐI ƯU HÓA HOÀN HẢO CHO MÁY IN & XUẤT FILE PDF  */
/* ========================================================= */
@media print {
    /* 1. Thiết lập trang A4 Chuẩn & Triệt tiêu Header/Footer của trình duyệt (link thankyou, ngày giờ, số trang) */
    @page {
        size: A4 portrait;
        margin: 0; /* Margin 0 sẽ tự động ẩn URL và tiêu đề mặc định của trình duyệt */
    }

    /* 2. Kỹ thuật in ấn chuẩn: Ẩn tất cả mọi thứ trong body, chỉ hiển thị duy nhất #printInvoiceSheet */
    body * {
        visibility: hidden !important;
    }
    #printInvoiceSheet,
    #printInvoiceSheet * {
        visibility: visible !important;
    }
    #printInvoiceSheet {
        display: block !important;
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 14mm 16mm !important;
        background: #ffffff !important;
        box-sizing: border-box !important;
        page-break-inside: avoid !important;
    }

    /* Ẩn triệt để toàn bộ các khối ngoài */
    header,
    nav,
    footer,
    section:not(#checkout-cart),
    .main-header,
    .topbar,
    .header,
    .header-content,
    .logo-search-wrapper,
    .header-main-grid,
    .header-logo-area,
    .header-search-area,
    .header-user-actions,
    #main-nav-section,
    #panel-left,
    .menu-tab,
    .navbar,
    .breadcrumbs,
    .breadcrumb,
    #checkout-cart,
    .thankyou-screen-view,
    .thankyou-action-buttons,
    .scrolltop,
    .scroll,
    #ndn-ai-launcher,
    #ndn-zalo-launcher,
    #ndn-ai-chatbox,
    .fb-root,
    #fb-root,
    iframe,
    .modal,
    .tooltip {
        display: none !important;
        height: 0 !important;
        max-height: 0 !important;
        margin: 0 !important;
        padding: 0 !important;
        overflow: hidden !important;
    }

    /* Header hóa đơn */
    .print-header {
        display: flex !important;
        justify-content: space-between !important;
        align-items: flex-start !important;
        border-bottom: 2px solid #0f172a !important;
        padding-bottom: 12px !important;
        margin-bottom: 14px !important;
    }
    .print-header-brand {
        width: 58% !important;
    }
    .print-brand-title {
        font-size: 20pt !important;
        font-weight: 800 !important;
        color: #d70018 !important;
        letter-spacing: -0.5px !important;
        line-height: 1.1 !important;
        margin-bottom: 2px !important;
        text-transform: uppercase !important;
    }
    .print-brand-desc {
        font-size: 9pt !important;
        font-weight: 600 !important;
        color: #475569 !important;
        margin-bottom: 6px !important;
    }
    .print-brand-info {
        font-size: 9pt !important;
        color: #334155 !important;
        line-height: 1.45 !important;
    }

    .print-header-invoice-meta {
        width: 40% !important;
        text-align: right !important;
    }
    .print-invoice-title {
        font-size: 16pt !important;
        font-weight: 800 !important;
        color: #0f172a !important;
        margin: 0 !important;
        line-height: 1.2 !important;
        text-transform: uppercase !important;
    }
    .print-invoice-subtitle {
        font-size: 8.5pt !important;
        color: #64748b !important;
        letter-spacing: 1.5px !important;
        font-weight: 600 !important;
        margin-bottom: 8px !important;
    }
    .print-meta-row {
        font-size: 9.5pt !important;
        color: #1e293b !important;
        line-height: 1.5 !important;
    }
    .print-meta-code {
        color: #d70018 !important;
        font-weight: 800 !important;
        font-size: 10.5pt !important;
    }

    /* Khung thông tin khách hàng */
    .print-section-box {
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 10px 14px !important;
        margin-bottom: 14px !important;
        background: #fafbfc !important;
        page-break-inside: avoid !important;
    }
    .print-section-title {
        font-size: 9pt !important;
        font-weight: 800 !important;
        color: #475569 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.5px !important;
        border-bottom: 1px dashed #cbd5e1 !important;
        padding-bottom: 5px !important;
        margin-bottom: 8px !important;
    }
    .print-customer-grid {
        display: flex !important;
        justify-content: space-between !important;
        gap: 15px !important;
    }
    .print-customer-col {
        width: 48% !important;
    }
    .print-data-row {
        font-size: 9pt !important;
        line-height: 1.6 !important;
        display: flex !important;
    }
    .print-data-label {
        color: #64748b !important;
        width: 32% !important;
        flex-shrink: 0 !important;
    }
    .print-data-val {
        color: #0f172a !important;
        width: 68% !important;
    }

    /* Bảng sản phẩm */
    .print-table-wrapper {
        margin-bottom: 14px !important;
        page-break-inside: avoid !important;
    }
    .print-items-table {
        width: 100% !important;
        border-collapse: collapse !important;
        border: 1px solid #94a3b8 !important;
        font-size: 9pt !important;
    }
    .print-items-table thead th {
        background: #f1f5f9 !important;
        color: #0f172a !important;
        font-weight: 700 !important;
        padding: 7px 8px !important;
        border: 1px solid #94a3b8 !important;
        text-transform: uppercase !important;
        font-size: 8.5pt !important;
    }
    .print-items-table tbody td {
        padding: 7px 8px !important;
        border: 1px solid #cbd5e1 !important;
        color: #1e293b !important;
        vertical-align: middle !important;
    }
    .print-product-name {
        font-weight: 700 !important;
        color: #0f172a !important;
        font-size: 9.5pt !important;
    }
    .print-product-spec {
        font-size: 8pt !important;
        color: #64748b !important;
        margin-top: 2px !important;
    }

    /* Khối tính tổng tài chính */
    .print-summary-container {
        display: flex !important;
        justify-content: flex-end !important;
        margin-bottom: 14px !important;
        page-break-inside: avoid !important;
    }
    .print-summary-table {
        width: 56% !important;
        border-collapse: collapse !important;
        font-size: 9.5pt !important;
    }
    .print-summary-table td {
        padding: 4px 6px !important;
        white-space: nowrap !important;
    }
    .print-sum-label {
        text-align: right !important;
        color: #475569 !important;
    }
    .print-sum-value {
        text-align: right !important;
        font-weight: 600 !important;
        color: #0f172a !important;
    }
    .print-sum-grand-row {
        border-top: 2px solid #0f172a !important;
        border-bottom: 2px solid #0f172a !important;
    }
    .print-sum-grand-label {
        font-weight: 800 !important;
        color: #0f172a !important;
        font-size: 10.5pt !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        white-space: nowrap !important;
    }
    .print-sum-grand-value {
        font-weight: 800 !important;
        color: #d70018 !important;
        font-size: 12pt !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        white-space: nowrap !important;
    }

    /* Ghi chú & Lời cảm ơn */
    .print-note-box {
        border: 1px dashed #cbd5e1 !important;
        background: #f8fafc !important;
        border-radius: 4px !important;
        padding: 8px 12px !important;
        margin-bottom: 16px !important;
        font-size: 8pt !important;
        color: #475569 !important;
        line-height: 1.4 !important;
        page-break-inside: avoid !important;
    }
    .print-note-box p {
        margin: 0 !important;
    }

    /* Chữ ký 2 bên */
    .print-signatures-row {
        display: flex !important;
        justify-content: space-between !important;
        margin-top: 10px !important;
        padding: 0 30px !important;
        page-break-inside: avoid !important;
    }
    .print-sign-col {
        width: 40% !important;
        text-align: center !important;
    }
    .print-sign-role {
        font-size: 9.5pt !important;
        font-weight: 700 !important;
        color: #0f172a !important;
        text-transform: uppercase !important;
    }
    .print-sign-note {
        font-size: 8pt !important;
        font-style: italic !important;
        color: #64748b !important;
    }
    .print-sign-space {
        height: 60px !important;
    }
    .print-sign-name {
        font-size: 9pt !important;
        font-weight: 700 !important;
        color: #0f172a !important;
    }
}
</style>

<!-- ============================================== -->
<!-- 4. JAVASCRIPT KÍCH HOẠT HÀNH ĐỘNG IN HÓA ĐƠN -->
<!-- ============================================== -->
<script>
function printInvoice() {
    window.print();
}
</script>
