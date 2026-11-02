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

                                <!-- Thanh thao tác nhanh -->
                                <div class="quick-reply-bar">
                                    <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>?subject=Re: <?php echo urlencode($row['title']); ?>" class="btn-reply-email">
                                        <i class="fa fa-envelope"></i> Gửi email trả lời khách
                                    </a>
                                    <?php if(!empty($row['phone'])): ?>
                                        <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>" class="btn-call-phone">
                                            <i class="fa fa-phone"></i> Gọi hotline khách: <?php echo htmlspecialchars($row['phone']); ?>
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?php echo base_url('admin/contact/status/'.$row['id']); ?>" class="btn-toggle-status">
                                        <i class="fa fa-exchange"></i> Đổi trạng thái (<?php echo ($row['status'] == 1) ? 'Đánh dấu Chưa đọc' : 'Đánh dấu Đã xử lý'; ?>)
                                    </a>
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
                                                <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>" class="val-link"><?php echo htmlspecialchars($row['phone']); ?></a>
                                            <?php else: ?>
                                                <span class="text-muted">Chưa cập nhật</span>
                                            <?php endif; ?>
                                        </b>
                                    </div>

                                    <div class="info-row">
                                        <span class="info-label"><i class="fa fa-envelope-o text-muted"></i> Hộp thư Email:</span>
                                        <b class="info-val">
                                            <?php if(!empty($row['email'])): ?>
                                                <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="val-link"><?php echo htmlspecialchars($row['email']); ?></a>
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

    /* Action Buttons */
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

    .btn-call-phone {
        background: #ecfdf5;
        color: #059669 !important;
        border: 1.5px solid #a7f3d0;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-call-phone:hover {
        background: #10b981;
        color: #ffffff !important;
        border-color: #10b981;
    }

    .btn-toggle-status {
        background: #f1f5f9;
        color: #475569 !important;
        border: 1.5px solid #cbd5e1;
        padding: 8px 14px;
        border-radius: 10px;
        font-size: 12.5px;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        text-decoration: none !important;
        transition: all 0.2s ease;
    }
    .btn-toggle-status:hover {
        background: #e2e8f0;
        color: #1e293b !important;
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