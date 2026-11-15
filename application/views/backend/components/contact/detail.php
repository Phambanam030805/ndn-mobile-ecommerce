<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <i class="fa fa-envelope-open text-red" style="font-size: 24px; vertical-align: middle; margin-right: 6px;"></i>
            Chi tiết liên hệ & thư gửi
            <small style="font-weight: 400; color: #7f8c8d; font-size: 13px;">Thông tin khách hàng, nội dung thư và phản hồi nhanh</small>
        </h1>
        <div class="breadcrumb" style="top: 12px; background: transparent; padding: 0; display: flex; align-items: center; gap: 8px;">
            <a class="btn btn-modern-back" href="<?php echo base_url('admin/contact'); ?>" role="button">
                <i class="fa fa-arrow-left"></i> Quay lại hộp thư
            </a>
            <a class="btn btn-modern-trash-action" href="<?php echo base_url('admin/contact/trash/'.$row['id']); ?>" role="button" onclick="return confirm('Chuyển thư này vào thùng rác?')">
                <i class="fa fa-trash-o"></i> Xóa thư
            </a>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                
                <!-- Flash Messages (Toast Fixed) -->
                <?php if($this->session->flashdata('success')): ?>
                    <div class="alert alert-success alert-modern alert-toast-fixed">
                        <i class="fa fa-check-circle" style="font-size: 20px; color: #10b981;"></i>
                        <span style="font-weight: 500; font-size: 14px; color: #065f46;"><?php echo $this->session->flashdata('success'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-left: auto;">&times;</button>
                    </div>
                <?php endif; ?>

                <?php if($this->session->flashdata('error')): ?>
                    <div class="alert alert-danger alert-modern alert-toast-fixed">
                        <i class="fa fa-exclamation-triangle" style="font-size: 20px; color: #ef4444;"></i>
                        <span style="font-weight: 500; font-size: 14px; color: #991b1b;"><?php echo $this->session->flashdata('error'); ?></span>
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true" style="margin-left: auto;">&times;</button>
                    </div>
                <?php endif; ?>

                <div class="row">
                    <!-- Cột trái: Nội dung thư liên hệ -->
                    <div class="col-lg-8 col-md-8">
                        <div class="modern-detail-card">
                            <div class="card-header-styled">
                                <h3>
                                    <i class="fa fa-file-text-o"></i> 
                                    <span>Tiêu đề: <b><?php echo htmlspecialchars($row['title']); ?></b></span>
                                </h3>
                                <div class="header-status-tag">
                                    <?php if($row['status'] == 1): ?>
                                        <span class="status-pill status-read"><i class="fa fa-check"></i> Đã đọc / Đã xử lý</span>
                                    <?php else: ?>
                                        <span class="status-pill status-unread"><i class="fa fa-clock-o"></i> Chưa đọc</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="card-body-styled">
                                <div class="message-meta-bar">
                                    <div class="meta-item">
                                        <i class="fa fa-calendar"></i>
                                        <span>Gửi lúc: <b><?php echo htmlspecialchars(isset($row['created_at']) ? $row['created_at'] : date('Y-m-d H:i:s')); ?></b></span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fa fa-hashtag"></i>
                                        <span>Mã liên hệ: <b>#<?php echo $row['id']; ?></b></span>
                                    </div>
                                </div>

                                <div class="mail-body-content-box">
                                    <div class="mail-body-label">
                                        <i class="fa fa-quote-left"></i> Nội dung thư của khách hàng:
                                    </div>
                                    <div class="mail-body-text">
                                        <?php 
                                            $textContent = !empty($row['fulltext']) ? $row['fulltext'] : $row['content']; 
                                            echo nl2br(htmlspecialchars($textContent));
                                        ?>
                                    </div>
                                </div>

                                <?php 
                                    $customer_email = !empty($row['email']) ? trim($row['email']) : '';
                                    $customer_phone = !empty($row['phone']) ? trim($row['phone']) : '';
                                    $clean_phone    = preg_replace('/[^0-9]/', '', $customer_phone);

                                    // Soạn sẵn liên kết trực tiếp mở Gmail Web chuyên nghiệp
                                    $gmail_su   = rawurlencode('NDN Mobile - Phản hồi liên hệ: ' . $row['title']);
                                    $gmail_body = rawurlencode("Kính gửi Quý khách " . $row['fullname'] . ",\n\nNDN Mobile xin chân thành cảm ơn Quý khách đã gửi liên hệ về: \"" . $row['title'] . "\".\n\nVề yêu cầu của Quý khách, Ban quản trị NDN Mobile xin phản hồi như sau:\n\n[Nhập nội dung tư vấn/hỗ trợ tại đây]\n\nNếu Quý khách cần hỗ trợ thêm thông tin gì, xin vui lòng phản hồi email này hoặc liên hệ hotline để được phục vụ nhanh nhất.\n\nTrân trọng cảm ơn Quý khách,\n--\nBan Quản trị & CSKH NDN Mobile\nHotline: 1800.6868 | 0903.123.456\nWebsite: http://localhost/ndnmobile/");
                                    $gmail_link = "https://mail.google.com/mail/?view=cm&fs=1&to=" . urlencode($customer_email) . "&su=" . $gmail_su . "&body=" . $gmail_body;

                                    // Link Zalo
                                    $zalo_link = !empty($clean_phone) ? "https://zalo.me/" . $clean_phone : "";
                                ?>

                                <!-- Thanh thao tác phản hồi đa kênh -->
                                <div class="quick-reply-wrapper">
                                    <div class="quick-reply-label">
                                        <i class="fa fa-paper-plane text-red"></i> <b>Kênh liên lạc & Phản hồi trực tiếp cho khách:</b>
                                    </div>
                                    <div class="quick-reply-bar">
                                        <!-- 1. Gửi Email thực tế qua Gmail Web -->
                                        <?php if(!empty($customer_email)): ?>
                                            <a href="<?php echo $gmail_link; ?>" target="_blank" class="btn-reply-email" title="Mở thẳng Gmail để soạn thư trả lời khách hàng">
                                                <i class="fa fa-envelope"></i> Soạn gửi Gmail cho khách
                                            </a>
                                            <button type="button" class="btn-copy-action" onclick="copyContactText('<?php echo htmlspecialchars($customer_email); ?>', 'Địa chỉ Email');" title="Sao chép địa chỉ Email">
                                                <i class="fa fa-copy"></i> Chép Email
                                            </button>
                                        <?php endif; ?>

                                        <!-- 2. Kênh Zalo & Hotline (Tránh bị trang trắng tel:) -->
                                        <?php if(!empty($customer_phone)): ?>
                                            <a href="<?php echo $zalo_link; ?>" target="_blank" class="btn-zalo-phone" title="Mở Zalo nhắn tin hoặc gọi điện cho khách hàng">
                                                <i class="fa fa-comments"></i> Nhắn / Gọi Zalo (<?php echo htmlspecialchars($customer_phone); ?>)
                                            </a>
                                            <button type="button" class="btn-copy-action btn-copy-phone" onclick="copyContactText('<?php echo htmlspecialchars($customer_phone); ?>', 'Số điện thoại');" title="Sao chép SĐT vào bộ nhớ tạm">
                                                <i class="fa fa-phone"></i> Chép SĐT
                                            </button>
                                        <?php endif; ?>

                                        <!-- 3. Đổi trạng thái có xác nhận -->
                                        <a href="<?php echo base_url('admin/contact/status/'.$row['id']); ?>" 
                                           onclick="return confirm('<?php echo ($row['status'] == 1) ? 'Bạn có chắc chắn muốn đánh dấu thư này là CHƯA XEM / CHƯA XỬ LÝ?' : 'Bạn có chắc chắn muốn đánh dấu thư này là ĐÃ XEM / ĐÃ XỬ LÝ?'; ?>');"
                                           class="btn-toggle-status <?php echo ($row['status'] == 1) ? 'btn-status-unread' : 'btn-status-read'; ?>"
                                           title="Bấm đổi trạng thái xử lý thư">
                                            <i class="fa <?php echo ($row['status'] == 1) ? 'fa-undo' : 'fa-check-circle'; ?>"></i> 
                                            <?php echo ($row['status'] == 1) ? 'Đánh dấu Chưa đọc' : 'Đánh dấu Đã xử lý'; ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Cột phải: Hồ sơ người gửi -->
                    <div class="col-lg-4 col-md-4">
                        <div class="modern-detail-card">
                            <div class="card-header-styled">
                                <h3><i class="fa fa-user-circle-o"></i> Thông tin người gửi</h3>
                            </div>
                            <div class="card-body-styled">
                                <div class="sender-avatar-wrap">
                                    <div class="sender-avatar-circle">
                                        <?php 
                                            $initial = !empty($row['fullname']) ? mb_strtoupper(mb_substr($row['fullname'], 0, 1, 'UTF-8')) : 'K';
                                            echo $initial;
                                        ?>
                                    </div>
                                    <h4 class="sender-name"><?php echo htmlspecialchars($row['fullname']); ?></h4>
                                    <span class="sender-role-label">Khách hàng liên hệ</span>
                                </div>

                                <div class="contact-info-list">
                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-phone text-muted"></i> Số điện thoại:</span>
                                        <b class="info-val">
                                            <?php if(!empty($row['phone'])): ?>
                                                <a href="javascript:void(0);" onclick="copyContactText('<?php echo htmlspecialchars($row['phone']); ?>', 'Số điện thoại'); window.location.href='tel:<?php echo htmlspecialchars($row['phone']); ?>';" class="val-link" title="Bấm để sao chép & gọi điện">
                                                    <?php echo htmlspecialchars($row['phone']); ?> <i class="fa fa-copy" style="font-size: 11px;"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa cập nhật</span>
                                            <?php endif; ?>
                                        </b>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-envelope-o text-muted"></i> Hộp thư Email:</span>
                                        <b class="info-val">
                                            <?php if(!empty($row['email'])): ?>
                                                <a href="<?php echo $gmail_link; ?>" target="_blank" class="val-link" title="Bấm mở soạn Gmail gửi khách">
                                                    <?php echo htmlspecialchars($row['email']); ?> <i class="fa fa-external-link" style="font-size: 11px;"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa cập nhật</span>
                                            <?php endif; ?>
                                        </b>
                                    </div>
                                </div>

                                <div class="support-hint-box">
                                    <div class="hint-icon"><i class="fa fa-info-circle"></i></div>
                                    <div class="hint-text">
                                        <b>Chính sách phản hồi:</b>
                                        <p>Nên phản hồi khách hàng trong vòng 24h làm việc qua Email hoặc Hotline để nâng cao điểm hài lòng và trải nghiệm dịch vụ.</p>
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

    /* Buttons */
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

    .btn-modern-trash-action {
        background: #fef2f2;
        color: #dc2626 !important;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        border: 1.5px solid #fee2e2;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-modern-trash-action:hover {
        background: #dc2626;
        color: #ffffff !important;
        border-color: #dc2626;
    }

    /* Modern Card */
    .modern-detail-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 15px -2px rgba(0, 0, 0, 0.04);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .card-header-styled {
        padding: 16px 20px;
        background: #fafbfc;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }
    .card-header-styled h3 {
        font-size: 15px;
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
        padding: 22px 20px;
    }

    /* Status Pill */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }
    .status-read {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }
    .status-unread {
        background: #fff7ed;
        color: #c2410c;
        border: 1px solid #fed7aa;
    }

    /* Meta Bar */
    .message-meta-bar {
        display: flex;
        gap: 20px;
        padding-bottom: 14px;
        margin-bottom: 18px;
        border-bottom: 1px dashed #e2e8f0;
        font-size: 12.5px;
        color: #64748b;
        flex-wrap: wrap;
    }
    .meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    /* Message Box */
    .mail-body-content-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        margin-bottom: 22px;
    }
    .mail-body-label {
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
    }
    .mail-body-text {
        font-size: 14px;
        line-height: 1.7;
        color: #1e293b;
        white-space: pre-wrap;
    }

    /* Quick Action Wrapper & Buttons */
    .quick-reply-wrapper {
        margin-top: 20px;
        padding-top: 18px;
        border-top: 1px dashed #e2e8f0;
    }
    .quick-reply-label {
        font-size: 13px;
        color: #334155;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .quick-reply-bar {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .btn-reply-email {
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff !important;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3);
        transition: all 0.2s ease;
    }
    .btn-reply-email:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(215, 0, 24, 0.45);
    }

    .btn-zalo-phone {
        background: #0068ff;
        color: #ffffff !important;
        border: 1.5px solid #0056d6;
        padding: 9px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none !important;
        box-shadow: 0 4px 12px rgba(0, 104, 255, 0.25);
        transition: all 0.2s ease;
    }
    .btn-zalo-phone:hover {
        background: #0056d6;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 104, 255, 0.35);
    }

    .btn-copy-action {
        background: #ffffff;
        color: #475569;
        border: 1.5px solid #cbd5e1;
        padding: 9px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s ease;
    }
    .btn-copy-action:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        color: #0f172a;
    }
    .btn-copy-phone {
        border-color: #bbf7d0;
        color: #166534;
        background: #f0fdf4;
    }
    .btn-copy-phone:hover {
        background: #dcfce7;
        border-color: #86efac;
        color: #14532d;
    }

    .btn-toggle-status {
        padding: 9px 15px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-status-read {
        background: #ecfdf5;
        color: #047857 !important;
        border: 1.5px solid #a7f3d0;
    }
    .btn-status-read:hover {
        background: #059669;
        color: #fff !important;
    }
    .btn-status-unread {
        background: #fffbeb;
        color: #b45309 !important;
        border: 1.5px solid #fde68a;
    }
    .btn-status-unread:hover {
        background: #d97706;
        color: #fff !important;
    }

    /* Toast Fixed */
    .alert-toast-fixed {
        position: fixed !important;
        top: 65px !important;
        right: 25px !important;
        z-index: 99999 !important;
        min-width: 330px !important;
        max-width: 480px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.18) !important;
        border-left: 5px solid #10b981 !important;
        background: #ffffff !important;
        border-radius: 12px !important;
        padding: 14px 20px !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        animation: toastSlideIn 0.35s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    @keyframes toastSlideIn {
        from {
            transform: translateX(110%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    /* Sender Info Column */
    .sender-avatar-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        padding-bottom: 18px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 18px;
    }
    .sender-avatar-circle {
        width: 64px;
        height: 64px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d70018 0%, #b91c1c 100%);
        color: #ffffff;
        font-size: 26px;
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 14px rgba(215, 0, 24, 0.25);
        margin-bottom: 10px;
    }
    .sender-name {
        margin: 0 0 4px;
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
    }
    .sender-role-label {
        font-size: 12px;
        color: #64748b;
        background: #f1f5f9;
        padding: 2px 10px;
        border-radius: 12px;
        font-weight: 500;
    }

    .contact-info-list {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-bottom: 20px;
    }
    .info-row {
        display: flex;
        flex-direction: column;
        gap: 4px;
        font-size: 13px;
    }
    .info-label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
    }
    .info-val {
        color: #1e293b;
        font-weight: 600;
        word-break: break-all;
    }
    .val-link {
        color: var(--primary) !important;
        text-decoration: none !important;
    }
    .val-link:hover {
        text-decoration: underline !important;
    }

    /* Hint box */
    .support-hint-box {
        background: #eff6ff;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        padding: 12px 14px;
        display: flex;
        gap: 10px;
        font-size: 12px;
        color: #1e40af;
        line-height: 1.5;
    }
    .support-hint-box p {
        margin: 4px 0 0;
        color: #3b82f6;
    }
    .hint-icon {
        font-size: 18px;
        color: #2563eb;
        margin-top: 2px;
    }
</style>

<script>
function copyContactText(text, label) {
    if (!text) return;
    navigator.clipboard.writeText(text).then(function() {
        showCustomToast('Đã sao chép ' + label + ': ' + text);
    }).catch(function() {
        var tempInput = document.createElement("input");
        tempInput.value = text;
        document.body.appendChild(tempInput);
        tempInput.select();
        document.execCommand("copy");
        document.body.removeChild(tempInput);
        showCustomToast('Đã sao chép ' + label + ': ' + text);
    });
}

function showCustomToast(msg) {
    $('.contact-custom-toast').remove();
    var toast = $('<div class="alert alert-success alert-modern alert-toast-fixed contact-custom-toast"><i class="fa fa-check-circle" style="font-size:20px; color:#10b981;"></i><span style="font-weight:500; font-size:14px; color:#065f46;">' + msg + '</span></div>');
    $('body').append(toast);
    setTimeout(function() {
        toast.fadeOut(500, function() { $(this).remove(); });
    }, 3500);
}

$(document).ready(function() {
    if ($('.alert-toast-fixed').length) {
        setTimeout(function() {
            $('.alert-toast-fixed').fadeOut(600, function() {
                $(this).remove();
            });
        }, 4000);
    }
});
</script>