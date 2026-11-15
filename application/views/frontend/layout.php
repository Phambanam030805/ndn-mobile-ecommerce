<!DOCTYPE html>
<html lang="vi" class="notranslate" translate="no">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate">

    <title>
        <?php 
            if(isset($title)) echo $title;
            else echo "NDN Mobile - Điện thoại di động chính hãng";
        ?>
    </title>

    <link rel="icon" type="image/svg+xml" href="<?php echo base_url('public/images/favicon.svg'); ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url('public/css/bootstrap.css'); ?>" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS giao diện -->
    <link href="<?php echo base_url('public/css/lte.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/owl.carousel.min.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/AdminLTE.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/style-jc.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/menu-tab.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/style.css?v='.filemtime(FCPATH.'public/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/jquery.bxslider.css'); ?>" rel="stylesheet">
    <link href="<?php echo base_url('public/css/flexslider.css'); ?>" rel="stylesheet">

    <!-- jQuery (PHẢI TRƯỚC bootstrap.js) -->
    <script src="<?php echo base_url('public/js/jquery-2.2.3.min.js'); ?>"></script>
    <script>
        var base_url = '<?php echo base_url(); ?>';
    </script>
</head>

<body>

<div class="thetop"></div>

<!-- Facebook SDK -->
<div id="fb-root"></div>
<script>
(function(d, s, id) {
    if (d.getElementById(id)) return;
    var js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8";
    d.getElementsByTagName(s)[0].parentNode.insertBefore(js, null);
}(document, 'script', 'facebook-jssdk'));
</script>

<!-- TOPBAR -->
<?php $this->load->view('frontend/modules/topbar'); ?>

<!-- LOGO + SEARCH -->
<?php $this->load->view('frontend/modules/logo-search'); ?>

<!-- MENU -->
<section id="main-nav-section" style="position: relative; z-index: 1000; overflow: visible !important;">
    <?php $this->load->view('frontend/modules/panel-left'); ?>
</section>

<!-- CONTENT -->
<?php
if (isset($com, $view)) {
    $this->load->view('frontend/components/'.$com.'/'.$view);
} else {
    $this->load->view('frontend/components/Error404/index');
}
?>

<!-- FOOTER -->
<?php $this->load->view('frontend/modules/footer'); ?>

<!-- JS (bootstrap phải sau jQuery) -->
<script src="<?php echo base_url('public/js/bootstrap.js'); ?>"></script>

<!-- Các JS khác -->
<script src="<?php echo base_url('public/js/app.min.js'); ?>"></script>
<script src="<?php echo base_url('public/js/owl.carousel.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery.jcarousel.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jcarousel.connected-carousels.js'); ?>"></script>
<script src="<?php echo base_url('public/js/scroll.js'); ?>"></script>
<script src="<?php echo base_url('public/js/search-quick.js'); ?>"></script>
<script src="<?php echo base_url('public/js/custom-owl.js'); ?>"></script>
<script src="<?php echo base_url('public/js/jquery.flexslider.js'); ?>"></script>

<!-- Scroll to top -->
<div class="scrolltop">
    <div class="scroll icon" title="Lên đầu trang">
        <i class="fa fa-angle-up fa-4x"></i>
    </div>
</div>

<!-- 🤖 NÚT TRỢ LÝ AI NỔI -->
<div id="ndn-ai-launcher" onclick="toggleAiChat()" title="Trò chuyện với Trợ lý AI NDN Mobile">
    <div class="ai-launcher-pulse"></div>
    <div class="ai-launcher-badge">AI 24/7</div>
    <div class="ai-launcher-icon">
        <i class="fas fa-robot"></i>
    </div>
</div>

<!-- 💬 NÚT ZALO TƯ VẤN (SĐT 0794358619) -->
<a id="ndn-zalo-launcher" href="https://zalo.me/0794358619" target="_blank" rel="noopener noreferrer" title="Chat Zalo tư vấn: 0794.358.619">
    <div class="zalo-launcher-pulse"></div>
    <div class="zalo-launcher-badge">Zalo</div>
    <div class="zalo-launcher-icon">
        <svg viewBox="0 0 40 40" width="28" height="28" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M7 19.5C7 11.492 12.82 5 20 5C27.18 5 33 10.82 33 18C33 25.18 27.18 31 20 31C18.156 31 16.398 30.613 14.812 29.914L8 32L9.688 26.688C8.016 24.633 7 22.18 7 19.5Z" fill="#0068FF"/>
            <path d="M12.5 15.5H19L13.8 23.5H19.5V25H12V23.5L17.2 15.5H12.5V15.5ZM21.5 16.5C21.5 15.67 22.17 15 23 15C23.83 15 24.5 15.67 24.5 16.5V25H21.5V16.5ZM26.5 16.5C26.5 15.67 27.17 15 28 15C28.83 15 29.5 15.67 29.5 16.5V25H26.5V16.5Z" fill="none"/>
            <text x="20" y="24" font-family="'Segoe UI', -apple-system, Arial, sans-serif" font-size="13" font-weight="900" fill="#ffffff" text-anchor="middle" font-style="italic" letter-spacing="-0.5">Zalo</text>
        </svg>
    </div>
</a>

<!-- 💬 HỘP THOẠI TRÒ CHUYỆN AI CHUYÊN NGHIỆP NDN MOBILE -->
<div id="ndn-ai-chatbox" class="ndn-ai-chatbox">
    <!-- Header -->
    <div class="ai-header">
        <div class="ai-header-left">
            <div class="ai-avatar-wrap">
                <i class="fas fa-robot"></i>
                <span class="ai-status-dot"></span>
            </div>
            <div class="ai-header-info">
                <h4 class="ai-header-title">Trợ lý AI NDN Mobile</h4>
                <p class="ai-header-sub"><i class="fas fa-circle" style="color: #2ecc71; font-size: 8px;"></i> Sẵn sàng hỗ trợ 24/7</p>
            </div>
        </div>
        <div class="ai-header-actions">
            <button type="button" class="ai-btn-reset" onclick="resetAiChat()" title="Làm mới cuộc trò chuyện"><i class="fas fa-sync-alt"></i></button>
            <button type="button" class="ai-btn-close" onclick="toggleAiChat()" title="Đóng khung chat"><i class="fas fa-times"></i></button>
        </div>
    </div>

    <!-- Message Body -->
    <div id="ai-chat-messages" class="ai-body">
        <div class="ai-msg-row ai-bot">
            <div class="ai-msg-avatar"><i class="fas fa-robot"></i></div>
            <div class="ai-msg-bubble">
                <p>👋 <strong>Xin chào Quý khách!</strong> Em là <strong>Trợ lý AI của NDN Mobile</strong>.</p>
                <p>Em có thể hỗ trợ anh/chị:</p>
                <ul style="padding-left: 18px; margin: 6px 0;">
                    <li>Tư vấn chọn mua điện thoại theo hãng & tầm giá.</li>
                    <li>Tra cứu chính sách bảo hành 24/7, đổi trả 1-1.</li>
                    <li>Hướng dẫn đặt hàng, thanh toán VietQR & ship COD.</li>
                </ul>
                <p style="margin-bottom: 0;">Anh/chị cần em hỗ trợ dòng máy hay vấn đề gì ạ?</p>
            </div>
        </div>

        <!-- Gợi ý nhanh -->
        <div class="ai-quick-replies" id="ai-quick-replies">
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Tư vấn iPhone dưới 20 triệu')">📱 iPhone dưới 20 triệu</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Điện thoại Samsung bán chạy')">🔥 Samsung hot nhất</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Chính sách bảo hành 24/7 thế nào?')">🛡️ Bảo hành 24/7</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Có hỗ trợ trả góp 0% không?')">💳 Trả góp 0%</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Địa chỉ shop ở đâu?')">📍 Địa chỉ cửa hàng</span>
        </div>
    </div>

    <!-- Input Footer -->
    <div class="ai-footer">
        <form id="ai-chat-form" onsubmit="handleAiSubmit(event)">
            <input type="text" id="ai-chat-input" placeholder="Hỏi về điện thoại, giá cả, bảo hành..." autocomplete="off">
            <button type="submit" id="ai-chat-send" title="Gửi tin nhắn">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
        <div class="ai-powered-by">
            <span>Powered by NDN Smart AI • Tư vấn thông minh 24/7</span>
        </div>
    </div>
</div>

<style>
/* NÚT TẢI LÊN ĐẦU TRANG & NÚT TRỢ LÝ AI (HÌNH TRÒN ĐỒNG BỘ - XẾP DỌC CHUẨN) */
.scrolltop {
    position: fixed !important;
    right: 20px !important;
    bottom: 20px !important;
    width: 48px !important;
    height: 48px !important;
    margin: 0 !important;
    z-index: 9997 !important;
}

.scroll.icon {
    position: static !important;
    width: 48px !important;
    height: 48px !important;
    border-radius: 50% !important;
    background: #d70018 !important;
    padding: 0 !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    box-shadow: 0 4px 15px rgba(215, 0, 24, 0.4) !important;
    transition: all 0.3s ease !important;
}

.scroll.icon:hover {
    background: #b80014 !important;
    transform: scale(1.08) translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(215, 0, 24, 0.6) !important;
}

.scroll.icon i,
.scroll.icon .fa {
    font-size: 22px !important;
    color: #ffffff !important;
    margin: 0 !important;
    line-height: 1 !important;
    display: inline-block !important;
}

/* NÚT TRỢ LÝ AI NỔI (Nằm ở giữa: bottom 80px) */
#ndn-ai-launcher {
    position: fixed !important;
    right: 20px !important; /* Cùng trục dọc với scrolltop */
    bottom: 80px !important; /* Cách nút cuộn trang 12px thoáng mát */
    width: 48px !important;
    height: 48px !important;
    border-radius: 50% !important;
    background: linear-gradient(135deg, #d70018 0%, #ff3838 100%) !important;
    color: #fff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    z-index: 9998 !important;
    box-shadow: 0 4px 15px rgba(215, 0, 24, 0.45) !important;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
}
#ndn-ai-launcher:hover {
    transform: scale(1.08) translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(215, 0, 24, 0.65) !important;
}
.ai-launcher-icon {
    font-size: 22px;
    transition: transform 0.3s;
}
.ai-launcher-badge {
    position: absolute;
    top: -6px;
    right: -4px;
    background: #00b894;
    color: #fff;
    font-size: 8.5px;
    font-weight: 700;
    padding: 1px 5px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    letter-spacing: 0.5px;
}
.ai-launcher-pulse {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(215, 0, 24, 0.4);
    animation: aiPulse 2s infinite;
    z-index: -1;
}

/* NÚT ZALO TRÒN (Nằm trên cùng: bottom 140px) */
#ndn-zalo-launcher {
    position: fixed !important;
    right: 20px !important; /* Cùng trục dọc với scrolltop & AI */
    bottom: 140px !important; /* Nằm ngay phía trên nút AI 60px */
    width: 48px !important;
    height: 48px !important;
    border-radius: 50% !important;
    background: #0068ff !important;
    color: #fff !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    z-index: 9998 !important;
    box-shadow: 0 4px 15px rgba(0, 104, 255, 0.45) !important;
    transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
    text-decoration: none !important;
}
#ndn-zalo-launcher:hover {
    transform: scale(1.08) translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(0, 104, 255, 0.7) !important;
}
.zalo-launcher-icon {
    display: flex;
    align-items: center;
    justify-content: center;
}
.zalo-launcher-badge {
    position: absolute;
    top: -6px;
    right: -4px;
    background: #ff4757;
    color: #fff;
    font-size: 8.5px;
    font-weight: 700;
    padding: 1px 5px;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    letter-spacing: 0.5px;
}
.zalo-launcher-pulse {
    position: absolute;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background: rgba(0, 104, 255, 0.4);
    animation: zaloPulse 2s infinite;
    z-index: -1;
}

@keyframes zaloPulse {
    0% { transform: scale(1); opacity: 0.8; }
    70% { transform: scale(1.4); opacity: 0; }
    100% { transform: scale(1.4); opacity: 0; }
}

@keyframes aiPulse {
    0% { transform: scale(1); opacity: 0.8; }
    70% { transform: scale(1.4); opacity: 0; }
    100% { transform: scale(1.4); opacity: 0; }
}
@keyframes pulse-ai {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}


/* CHATBOX POPUP (Chiều cao vừa vặn, không đè lên thanh Navigation) */
.ndn-ai-chatbox {
    position: fixed;
    right: 20px;
    bottom: 80px;
    width: 360px;
    max-width: calc(100vw - 30px);
    height: 460px;
    max-height: calc(100vh - 160px); /* Đảm bảo không đè lên thanh Menu */
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.22);
    display: none;
    flex-direction: column;
    z-index: 9999;
    overflow: hidden;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    border: 1px solid rgba(0,0,0,0.08);
    animation: aiFadeUp 0.3s ease;
}
@keyframes aiFadeUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Chat Header */
.ai-header {
    background: linear-gradient(135deg, #d70018 0%, #b30013 100%);
    color: #fff;
    padding: 12px 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ai-header-left {
    display: flex;
    align-items: center;
    gap: 12px;
}
.ai-avatar-wrap {
    position: relative;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.ai-status-dot {
    position: absolute;
    bottom: 0;
    right: 0;
    width: 10px;
    height: 10px;
    background: #2ecc71;
    border: 2px solid #fff;
    border-radius: 50%;
}
.ai-header-title {
    margin: 0;
    font-size: 15px;
    font-weight: 700;
    color: #fff;
}
.ai-header-sub {
    margin: 2px 0 0 0;
    font-size: 11px;
    opacity: 0.9;
    color: #f1f2f6;
}
.ai-header-actions button {
    background: transparent;
    border: none;
    color: #fff;
    font-size: 15px;
    padding: 5px;
    cursor: pointer;
    opacity: 0.8;
    transition: opacity 0.2s;
}
.ai-header-actions button:hover {
    opacity: 1;
}

/* Chat Body */
.ai-body {
    flex: 1;
    overflow-y: auto;
    padding: 14px;
    background: #f8f9fa;
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.ai-msg-row {
    display: flex;
    gap: 8px;
    max-width: 88%;
}
.ai-msg-row.ai-bot {
    align-self: flex-start;
}
.ai-msg-row.ai-user {
    align-self: flex-end;
    flex-direction: row-reverse;
}
.ai-msg-avatar {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: #d70018;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
    margin-top: 2px;
}
.ai-msg-bubble {
    background: #fff;
    padding: 10px 14px;
    border-radius: 14px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    font-size: 13.5px;
    line-height: 1.5;
    color: #2c3e50;
    border-top-left-radius: 2px;
    word-break: break-word;
}
.ai-msg-row.ai-user .ai-msg-bubble {
    background: #d70018;
    color: #fff;
    border-top-left-radius: 14px;
    border-top-right-radius: 2px;
}
.ai-msg-bubble p:last-child {
    margin-bottom: 0;
}

/* Product Cards in Chat (Thiết kế nằm ngang gọn gàng) */
.ai-product-grid {
    display: flex;
    flex-direction: column;
    gap: 6px;
    margin-top: 8px;
}
.ai-product-card {
    background: #fff;
    border: 1px solid #e1e8ed;
    border-radius: 8px;
    padding: 6px 10px;
    display: flex !important;
    align-items: center;
    gap: 10px;
    text-align: left;
    transition: transform 0.2s, box-shadow 0.2s;
    text-decoration: none !important;
}
.ai-product-card:hover {
    transform: translateX(3px);
    box-shadow: 0 3px 8px rgba(0,0,0,0.08);
}
.ai-product-card img {
    width: 38px;
    height: 38px;
    object-fit: contain;
    margin-bottom: 0;
    flex-shrink: 0;
}
.ai-product-card-info {
    flex: 1;
    min-width: 0;
}
.ai-product-card .p-name {
    font-size: 12px;
    font-weight: 600;
    color: #2c3e50;
    line-height: 1.3;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 2px;
    height: auto;
}
.ai-product-card .p-price {
    font-size: 11.5px;
    font-weight: 700;
    color: #d70018;
}

/* Quick Replies */
.ai-quick-replies {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-top: 5px;
}
.ai-quick-chip {
    background: #fff;
    border: 1px solid #e2e8f0;
    color: #4a5568;
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.ai-quick-chip:hover {
    background: #d70018;
    color: #fff;
    border-color: #d70018;
}

/* Chat Footer */
.ai-footer {
    padding: 10px 14px 8px 14px;
    background: #fff;
    border-top: 1px solid #eee;
}
#ai-chat-form {
    display: flex;
    align-items: center;
    background: #f1f2f6;
    border-radius: 24px;
    padding: 4px 6px 4px 14px;
    border: 1px solid transparent;
    transition: border-color 0.2s;
}
#ai-chat-form:focus-within {
    border-color: #d70018;
    background: #fff;
    box-shadow: 0 0 0 2px rgba(215, 0, 24, 0.1);
}
#ai-chat-input {
    flex: 1;
    border: none;
    background: transparent;
    font-size: 13px;
    outline: none;
    padding: 6px 0;
}
#ai-chat-send {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: #d70018;
    color: #fff;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.2s;
}
#ai-chat-send:hover {
    transform: scale(1.05);
}
.ai-powered-by {
    text-align: center;
    margin-top: 4px;
    font-size: 9.5px;
    color: #a0aec0;
}

/* Responsive Mobile */
@media (max-width: 480px) {
    #ndn-ai-launcher {
        right: 70px;
        bottom: 15px;
        width: 44px;
        height: 44px;
    }
    .ndn-ai-chatbox {
        right: 10px;
        left: 10px;
        width: auto;
        bottom: 70px;
        height: 460px;
    }
}
</style>

<script>
// Logic Quản lý AI Chatbot
function toggleAiChat() {
    var box = $('#ndn-ai-chatbox');
    if (box.is(':visible')) {
        box.fadeOut(200);
    } else {
        box.css('display', 'flex').hide().fadeIn(200);
        $('#ai-chat-input').focus();
        scrollAiToBottom();
    }
}

function openAiChat(initialQuestion) {
    var box = $('#ndn-ai-chatbox');
    box.css('display', 'flex').hide().fadeIn(200);
    scrollAiToBottom();
    if (initialQuestion) {
        sendAiMessage(initialQuestion);
    } else {
        $('#ai-chat-input').focus();
    }
}

function resetAiChat() {
    $('#ai-chat-messages').html(`
        <div class="ai-msg-row ai-bot">
            <div class="ai-msg-avatar"><i class="fas fa-robot"></i></div>
            <div class="ai-msg-bubble">
                <p>👋 <strong>Xin chào Quý khách!</strong> Cuộc trò chuyện đã được làm mới.</p>
                <p>Anh/chị cần em hỗ trợ tư vấn chọn mua điện thoại hay thắc mắc về chính sách tại NDN Mobile ạ?</p>
            </div>
        </div>
        <div class="ai-quick-replies" id="ai-quick-replies">
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Tư vấn iPhone dưới 20 triệu')">📱 iPhone dưới 20 triệu</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Điện thoại Samsung bán chạy')">🔥 Samsung hot nhất</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Chính sách bảo hành 24/7 thế nào?')">🛡️ Bảo hành 24/7</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Có hỗ trợ trả góp 0% không?')">💳 Trả góp 0%</span>
            <span class="ai-quick-chip" onclick="sendAiQuickMessage('Địa chỉ shop ở đâu?')">📍 Địa chỉ cửa hàng</span>
        </div>
    `);
    scrollAiToBottom();
}

function handleAiSubmit(e) {
    e.preventDefault();
    var input = $('#ai-chat-input');
    var text = input.val().trim();
    if (text) {
        sendAiMessage(text);
        input.val('');
    }
}

function sendAiQuickMessage(text) {
    sendAiMessage(text);
}

function sendAiMessage(text) {
    // 1. Thêm tin nhắn của User
    var userHtml = `
        <div class="ai-msg-row ai-user">
            <div class="ai-msg-bubble">${escapeHtml(text)}</div>
        </div>
    `;
    $('#ai-chat-messages').append(userHtml);

    // 2. Thêm loading bubble từ bot
    var loadingId = 'ai-loading-' + Date.now();
    var loadingHtml = `
        <div class="ai-msg-row ai-bot" id="${loadingId}">
            <div class="ai-msg-avatar"><i class="fas fa-robot"></i></div>
            <div class="ai-msg-bubble" style="color: #7f8c8d;">
                <i class="fas fa-circle-notch fa-spin"></i> Trợ lý AI đang tra cứu câu trả lời...
            </div>
        </div>
    `;
    $('#ai-chat-messages').append(loadingHtml);
    scrollAiToBottom();

    // 3. Gửi Ajax tới Controller Ai_chat
    $.ajax({
        url: '<?php echo base_url("ai-chat/ask"); ?>',
        type: 'POST',
        data: { question: text },
        dataType: 'json',
        success: function(res) {
            $('#' + loadingId).remove();
            if (res && res.status === 'success') {
                var formattedText = formatAiMarkdown(res.reply);
                
                // Card sản phẩm nếu có (Hiển thị ngang gọn gàng)
                var prodHtml = '';
                if (res.products && res.products.length > 0) {
                    prodHtml += '<div class="ai-product-grid">';
                    res.products.forEach(function(p) {
                        prodHtml += `
                            <a href="${p.url}" target="_blank" class="ai-product-card">
                                <img src="${p.avatar}" alt="${p.name}" onerror="this.src='<?php echo base_url('public/images/products/no-image.png'); ?>'">
                                <div class="ai-product-card-info">
                                    <div class="p-name">${p.name}</div>
                                    <div class="p-price">${p.price}</div>
                                </div>
                            </a>
                        `;
                    });
                    prodHtml += '</div>';
                }

                // Gợi ý nhanh nếu có
                var chipsHtml = '';
                if (res.quick_suggestions && res.quick_suggestions.length > 0) {
                    chipsHtml += '<div class="ai-quick-replies" style="margin-top: 8px;">';
                    res.quick_suggestions.forEach(function(s) {
                        chipsHtml += `<span class="ai-quick-chip" onclick="sendAiQuickMessage('${escapeHtml(s)}')">${escapeHtml(s)}</span>`;
                    });
                    chipsHtml += '</div>';
                }

                var botHtml = `
                    <div class="ai-msg-row ai-bot">
                        <div class="ai-msg-avatar"><i class="fas fa-robot"></i></div>
                        <div class="ai-msg-bubble">
                            <div>${formattedText}</div>
                            ${prodHtml}
                            ${chipsHtml}
                        </div>
                    </div>
                `;
                $('#ai-chat-messages').append(botHtml);
            } else {
                showBotError(loadingId, res.reply || 'Dạ hệ thống đang bận một chút, anh/chị vui lòng thử lại nhé!');
            }
            scrollAiToBottom();
        },
        error: function() {
            $('#' + loadingId).remove();
            showBotError(null, 'Dạ tạm thời không kết nối được tới máy chủ AI. Quý khách vui lòng gọi Hotline 0794.358.619 để được hỗ trợ nhanh nhất ạ!');
            scrollAiToBottom();
        }
    });
}

function showBotError(loadingId, msg) {
    if (loadingId) $('#' + loadingId).remove();
    var errHtml = `
        <div class="ai-msg-row ai-bot">
            <div class="ai-msg-avatar"><i class="fas fa-robot"></i></div>
            <div class="ai-msg-bubble" style="border-left: 3px solid #d70018;">
                <p>${msg}</p>
            </div>
        </div>
    `;
    $('#ai-chat-messages').append(errHtml);
}

function scrollAiToBottom() {
    var container = document.getElementById('ai-chat-messages');
    if (container) {
        setTimeout(function() {
            container.scrollTop = container.scrollHeight;
        }, 50);
    }
}

function escapeHtml(text) {
    return text.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;").replace(/"/g, "&quot;").replace(/'/g, "&#039;");
}

function formatAiMarkdown(text) {
    // Chuyển Markdown đơn giản: **bold**, *italic*, \n sang <br>
    var html = text
        .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
        .replace(/\*(.*?)\*/g, '<em>$1</em>')
        .replace(/\n/g, '<br>');
    return html;
}
</script>



<!-- ✅ KÍCH HOẠT TỰ ĐỘNG TRƯỢT (BANNER & SẢN PHẨM) -->
<script>
$(document).ready(function() {
    // Banner chính (Owl 2)
    if ($('.owl-carousel-slider').length) {
        $('.owl-carousel-slider').owlCarousel({
            loop: false,
            margin: 15,
            nav: false,
            dots: false,
            responsive: {
                0: { items: 1 },
                480: { items: 2 },
                768: { items: 3 },
                1024: { items: 4 },
                1366: { items: 5 }
            }
        });
    }

    // Danh sách sản phẩm (Owl 2)
    if ($('.owl-carousel-product').length) {
        $('.owl-carousel-product').owlCarousel({
            loop: true,
            margin: 10,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            dots: false,
            responsive: {
                0: { items: 1 },
                480: { items: 2 },
                768: { items: 3 },
                992: { items: 4 },
                1200: { items: 5 }
            }
        });
    }
});
</script>
<script>
$(document).ready(function() {
    if ($('.flexslider').length) {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails",
            smoothHeight: true
        });
    }
});
$(window).load(function() {
    if ($('.flexslider').length && !$('.flexslider').hasClass('flexslider-initialized')) {
        $('.flexslider').flexslider({
            animation: "slide",
            controlNav: "thumbnails"
        });
    }
});
</script>
<script>
function toggleWishlist(productId) {
    $.ajax({
        url: base_url + 'yeu-thich/them/' + productId,
        type: 'POST',
        dataType: 'json',
        data: {
            '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
        },
        success: function(res) {
            if (res.status === 'login_required') {
                alert('Vui lòng đăng nhập để lưu sản phẩm vào danh sách yêu thích!');
                window.location.href = res.redirect;
            } else if (res.status === 'success') {
                // Cập nhật số lượng trên header badge
                $('#wishlist-count').text(res.count);

                // Cập nhật nút bấm nếu có trên trang
                var $btnText = $('#wishlist-text-' + productId);
                var $btnIcon = $('#wishlist-icon-' + productId);
                if (res.action === 'added') {
                    if ($btnText.length) $btnText.text('Đã thích ❤️');
                    if ($btnIcon.length) $btnIcon.css('color', '#d70018');
                } else {
                    if ($btnText.length) $btnText.text('Yêu thích');
                    if ($btnIcon.length) $btnIcon.css('color', '');
                }

                alert(res.message);
            }
        },
        error: function() {
            alert('Có lỗi xảy ra, vui lòng thử lại!');
        }
    });
}

// Hàm xử lý mở email và form liên hệ tiện lợi trên mọi thiết bị
function openEmailModal(e, email) {
    if (e) e.preventDefault();
    if (!email) email = 'phambanam385@gmail.com';
    $('#modalEmailAddress').text(email);
    $('#modalEmailGmailLink').attr('href', 'https://mail.google.com/mail/u/0/?fs=1&to=' + encodeURIComponent(email) + '&tf=cm&su=' + encodeURIComponent('NDN Mobile - Khách hàng liên hệ'));
    $('#quickContactAlert').hide();
    $('#emailContactModal').modal('show');
}

function handleOpenMailClient() {
    var email = $('#modalEmailAddress').text() || 'phambanam385@gmail.com';
    var mailtoUrl = 'mailto:' + email + '?subject=' + encodeURIComponent('NDN Mobile - Khách hàng liên hệ');
    window.location.href = mailtoUrl;

    setTimeout(function() {
        var $alert = $('#quickContactAlert');
        $alert.css({'background-color': '#fffbeb', 'color': '#b45309', 'border': '1px solid #fde68a', 'display': 'block'})
              .html('<i class="fas fa-info-circle"></i> <b>Lưu ý:</b> Nếu máy tính chưa cài phần mềm Email (như Outlook), bạn hãy điền form ở trên hoặc bấm nút <b>Sao chép Email</b> để gửi thư nhé!');
    }, 1200);
}

function copyEmailToClipboard() {
    var email = $('#modalEmailAddress').text() || 'phambanam385@gmail.com';
    var $btn = $('#btnCopyEmail');
    var originalHtml = $btn.html();

    function onSuccess() {
        $btn.html('<i class="fas fa-check" style="color:#10b981;"></i> <span style="color:#059669; font-weight:700;">Đã sao chép!</span>')
            .css({'background-color': '#ecfdf5', 'border-color': '#10b981'});
        setTimeout(function() {
            $btn.html(originalHtml).css({'background-color': '', 'border-color': ''});
        }, 2500);
    }

    if (navigator.clipboard) {
        navigator.clipboard.writeText(email).then(onSuccess).catch(function() {
            fallbackCopy(email, onSuccess);
        });
    } else {
        fallbackCopy(email, onSuccess);
    }
}

function fallbackCopy(text, cb) {
    var tempInput = document.createElement("input");
    tempInput.value = text;
    document.body.appendChild(tempInput);
    tempInput.select();
    document.execCommand("copy");
    document.body.removeChild(tempInput);
    if (cb) cb();
}

function submitQuickContact() {
    var fullname = $.trim($('#qc_fullname').val());
    var phone = $.trim($('#qc_phone').val());
    var email = $.trim($('#qc_email').val());
    var content = $.trim($('#qc_content').val());
    var $alert = $('#quickContactAlert');
    var $btn = $('#btnSubmitQuickContact');
    var $btnText = $('#qc_btn_text');
    var $icon = $('#qc_icon_send');

    if (!fullname) {
        $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
              .html('<i class="fas fa-exclamation-circle"></i> Vui lòng nhập họ và tên của bạn!');
        $('#qc_fullname').focus();
        return;
    }
    if (!phone) {
        $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
              .html('<i class="fas fa-exclamation-circle"></i> Vui lòng nhập số điện thoại để shop liên hệ lại!');
        $('#qc_phone').focus();
        return;
    }
    if (!email) {
        $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
              .html('<i class="fas fa-exclamation-circle"></i> Vui lòng nhập địa chỉ email của bạn!');
        $('#qc_email').focus();
        return;
    }
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
              .html('<i class="fas fa-exclamation-circle"></i> Định dạng email không hợp lệ (ví dụ: name@gmail.com)!');
        $('#qc_email').focus();
        return;
    }
    if (!content) {
        $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
              .html('<i class="fas fa-exclamation-circle"></i> Vui lòng nhập nội dung câu hỏi hoặc yêu cầu cần tư vấn!');
        $('#qc_content').focus();
        return;
    }

    $btn.prop('disabled', true);
    $icon.attr('class', 'fas fa-spinner fa-spin');
    $btnText.text('Đang gửi tin nhắn...');
    $alert.hide();

    $.ajax({
        url: '<?php echo base_url("lienhe/ajax_send"); ?>',
        type: 'POST',
        dataType: 'json',
        data: {
            fullname: fullname,
            phone: phone,
            email: email,
            title: 'Khách gửi qua popup website: ' + fullname,
            content: content
        },
        success: function(res) {
            $btn.prop('disabled', false);
            $icon.attr('class', 'fas fa-paper-plane');
            $btnText.text('Gửi tin nhắn cho NDN Mobile');

            if (res.status === 'success') {
                $alert.css({'background-color': '#ecfdf5', 'color': '#065f46', 'border': '1px solid #a7f3d0', 'display': 'block'})
                      .html('<i class="fas fa-check-circle" style="color: #10b981; font-size: 15px;"></i> <b>Gửi tin nhắn thành công!</b><br>' + res.message);
                $('#qc_content').val('');
                setTimeout(function() {
                    $('#emailContactModal').modal('hide');
                    $alert.hide();
                }, 3500);
            } else {
                $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
                      .html('<i class="fas fa-exclamation-circle"></i> ' + (res.message || 'Có lỗi xảy ra, vui lòng thử lại!'));
            }
        },
        error: function() {
            $btn.prop('disabled', false);
            $icon.attr('class', 'fas fa-paper-plane');
            $btnText.text('Gửi tin nhắn cho NDN Mobile');
            $alert.css({'background-color': '#fee2e2', 'color': '#b91c1c', 'border': '1px solid #fca5a5', 'display': 'block'})
                  .html('<i class="fas fa-exclamation-circle"></i> Không thể gửi lúc này do lỗi kết nối. Vui lòng thử lại hoặc gọi Hotline 0794.358.619!');
        }
    });
}
</script>

<?php 
$qc_customer = $this->session->userdata('sessionKhachHang');
$qc_fullname = $this->session->userdata('fullname') ? $this->session->userdata('fullname') : (is_array($qc_customer) && isset($qc_customer['fullname']) ? $qc_customer['fullname'] : '');
$qc_email = $this->session->userdata('email') ? $this->session->userdata('email') : (is_array($qc_customer) && isset($qc_customer['email']) ? $qc_customer['email'] : '');
$qc_phone = $this->session->userdata('phone') ? $this->session->userdata('phone') : (is_array($qc_customer) && isset($qc_customer['phone']) ? $qc_customer['phone'] : '');
?>

<!-- MODAL LIÊN HỆ & GỬI TIN NHẮN NHANH -->
<div class="modal fade" id="emailContactModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" style="z-index: 99999;">
  <div class="modal-dialog" role="document" style="margin-top: 8vh; max-width: 480px; width: 94%;">
    <div class="modal-content" style="border-radius: 14px; overflow: hidden; border: none; box-shadow: 0 16px 40px rgba(0,0,0,0.28);">
      <div class="modal-header" style="background: linear-gradient(135deg, #d70018 0%, #b30014 100%); color: #fff; padding: 15px 20px;">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: #fff; opacity: 0.9; font-size: 24px; text-shadow: none;"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="emailModalLabel" style="font-weight: 700; font-size: 16px; margin: 0; display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-envelope-open-text"></i> Gửi Tin Nhắn & Liên Hệ Nhanh
        </h4>
      </div>
      <div class="modal-body" style="padding: 18px 20px;">
        <div style="background: #fef2f2; border-left: 4px solid #ef4444; padding: 9px 12px; border-radius: 6px; font-size: 12.5px; color: #991b1b; margin-bottom: 15px; line-height: 1.45;">
            <strong><i class="fas fa-headset"></i> Bạn cần hỗ trợ hoặc tư vấn sản phẩm?</strong><br>
            Gửi tin nhắn ngay bên dưới, NDN Mobile sẽ liên hệ lại qua SĐT hoặc Email trong thời gian sớm nhất!
        </div>

        <!-- Alert thông báo kết quả AJAX -->
        <div id="quickContactAlert" style="display: none; margin-bottom: 14px; padding: 10px 12px; border-radius: 6px; font-size: 13px; line-height: 1.4;"></div>

        <!-- Form gửi tin nhắn nhanh -->
        <form id="quickContactForm" onsubmit="event.preventDefault(); submitQuickContact();">
            <div class="row" style="margin: 0 -5px 10px -5px;">
                <div class="col-xs-12 col-sm-6" style="padding: 0 5px 10px 5px;">
                    <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block;">Họ và tên <span style="color:#ef4444;">*</span></label>
                    <input type="text" id="qc_fullname" name="fullname" class="form-control" placeholder="Nhập họ và tên..." required value="<?php echo htmlspecialchars($qc_fullname); ?>" style="border-radius: 6px; height: 38px; font-size: 13px;">
                </div>
                <div class="col-xs-12 col-sm-6" style="padding: 0 5px 10px 5px;">
                    <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block;">Số điện thoại <span style="color:#ef4444;">*</span></label>
                    <input type="tel" id="qc_phone" name="phone" class="form-control" placeholder="Ví dụ: 0912345678" required value="<?php echo htmlspecialchars($qc_phone); ?>" style="border-radius: 6px; height: 38px; font-size: 13px;">
                </div>
            </div>

            <div style="margin-bottom: 10px;">
                <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block;">Email nhận phản hồi <span style="color:#ef4444;">*</span></label>
                <input type="email" id="qc_email" name="email" class="form-control" placeholder="email_cua_ban@gmail.com" required value="<?php echo htmlspecialchars($qc_email); ?>" style="border-radius: 6px; height: 38px; font-size: 13px;">
            </div>

            <div style="margin-bottom: 14px;">
                <label style="font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block;">Nội dung tin nhắn cần hỗ trợ <span style="color:#ef4444;">*</span></label>
                <textarea id="qc_content" name="content" rows="3" class="form-control" placeholder="Ví dụ: Shop tư vấn giúp mình mẫu iPhone 17 Pro Max hoặc tình trạng đơn hàng..." required style="border-radius: 6px; font-size: 13px; resize: vertical;"></textarea>
            </div>

            <button type="submit" id="btnSubmitQuickContact" class="btn btn-block" style="background: linear-gradient(135deg, #d70018 0%, #b30014 100%); color: #fff; font-weight: 700; font-size: 14px; padding: 10px 16px; border-radius: 8px; border: none; box-shadow: 0 4px 12px rgba(215, 0, 24, 0.3); transition: all 0.2s;">
                <i class="fas fa-paper-plane" id="qc_icon_send" style="margin-right: 6px;"></i> <span id="qc_btn_text">Gửi tin nhắn cho NDN Mobile</span>
            </button>
        </form>

        <!-- Kênh liên hệ trực tiếp khác -->
        <div style="margin-top: 18px; padding-top: 14px; border-top: 1px dashed #e5e7eb;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; font-size: 12px;">
                <span style="color: #6b7280; font-weight: 600;">Hòm thư chính thức:</span>
                <span id="modalEmailAddress" style="font-weight: 700; color: #d70018; letter-spacing: 0.2px;">phambanam385@gmail.com</span>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px;">
                <button type="button" id="btnCopyEmail" onclick="copyEmailToClipboard()" class="btn btn-default" style="font-size: 12px; font-weight: 600; border-radius: 6px; border: 1px solid #d1d5db; color: #374151; padding: 8px 10px; display: flex; align-items: center; justify-content: center; gap: 5px;">
                    <i class="fas fa-copy"></i> Sao chép Email
                </button>
                <a href="tel:0794358619" class="btn btn-default" style="font-size: 12px; font-weight: 600; border-radius: 6px; border: 1px solid #bbf7d0; color: #15803d; background: #f0fdf4; padding: 8px 10px; display: flex; align-items: center; justify-content: center; gap: 5px; text-decoration: none;">
                    <i class="fas fa-phone-alt"></i> 0794.358.619
                </a>
            </div>

            <div style="margin-top: 10px; display: flex; justify-content: center; align-items: center; gap: 14px; font-size: 12px;">
                <a id="modalEmailGmailLink" href="https://mail.google.com/mail/u/0/?fs=1&to=phambanam385@gmail.com&tf=cm" target="_blank" rel="noopener noreferrer" style="color: #4b5563; text-decoration: none;" title="Mở trang Gmail nếu bạn đã đăng nhập tài khoản Google trên trình duyệt">
                    <i class="fab fa-google" style="color: #ea4335;"></i> Mở Gmail Web
                </a>
                <span style="color: #d1d5db;">|</span>
                <a href="javascript:void(0)" onclick="handleOpenMailClient()" style="color: #4b5563; text-decoration: none;" title="Mở ứng dụng Outlook hoặc Mail có sẵn trên máy">
                    <i class="fas fa-envelope" style="color: #3b82f6;"></i> Mở ứng dụng Mail
                </a>
                <span style="color: #d1d5db;">|</span>
                <a href="<?php echo base_url('lien-he'); ?>" style="color: #4b5563; text-decoration: none;" title="Đến trang Liên hệ chính thức">
                    <i class="fas fa-external-link-alt" style="color: #8b5cf6;"></i> Trang Liên Hệ
                </a>
            </div>
        </div>
      </div>
      <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #eee; padding: 9px 15px; text-align: center;">
        <small style="color: #888; font-size: 11.5px;">NDN Mobile luôn phản hồi yêu cầu của Quý khách trong thời gian sớm nhất</small>
      </div>
    </div>
  </div>
</div>

</body>
</html>
