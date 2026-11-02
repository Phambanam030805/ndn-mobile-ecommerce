<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Modern Enterprise SaaS Sidebar Navigation for NDN Mobile Admin
 * Features:
 * - Real-time animated status badges (orders, contacts, reviews)
 * - Dynamic route matching & auto-expanded active sections
 * - Instant client-side menu filter search
 * - Collapsible mini-sidebar support (64px) with floating tooltips
 * - Bottom Admin profile card with quick actions
 */

// 1. Fetch real-time metrics
$sidebar_metrics = admin_sidebar_metrics();
$pending_orders  = $sidebar_metrics['pending_orders'];
$shipping_orders = $sidebar_metrics['shipping_orders'];
$unread_contacts = $sidebar_metrics['unread_contacts'];
$pending_reviews = $sidebar_metrics['pending_reviews'];

// 2. Identify active route
$cur_seg1 = $this->uri->segment(1, '');
$cur_seg2 = $this->uri->segment(2, '');
$cur_seg3 = $this->uri->segment(3, '');

// Map current module key
$active_menu = 'dashboard';
if ($cur_seg2 === 'product') {
    $active_menu = 'product';
} elseif ($cur_seg2 === 'category') {
    $active_menu = 'category';
} elseif ($cur_seg2 === 'producer') {
    $active_menu = 'producer';
} elseif ($cur_seg2 === 'coupon') {
    $active_menu = 'coupon';
} elseif ($cur_seg2 === 'contact') {
    $active_menu = 'contact';
} elseif ($cur_seg2 === 'orders') {
    $active_menu = 'orders';
} elseif ($cur_seg2 === 'customer') {
    $active_menu = 'customer';
} elseif ($cur_seg2 === 'reviews') {
    $active_menu = 'reviews';
} elseif ($cur_seg2 === 'configuration') {
    $active_menu = 'configuration';
} elseif ($cur_seg2 === '' || $cur_seg2 === 'dashboard') {
    $active_menu = 'dashboard';
}

// User context
$auth_user = $this->session->userdata('sessionadmin');
$user_name = !empty($auth_user['fullname']) ? $auth_user['fullname'] : 'Admin';
$user_avatar = !empty($auth_user['img']) ? base_url('public/images/admin/' . $auth_user['img']) : 'https://cdn-icons-png.flaticon.com/512/3135/3135715.png';
$user_role = (isset($auth_user['role']) && (int)$auth_user['role'] === 1) ? 'Super Admin' : 'Quản trị viên';
$user_id = !empty($auth_user['id']) ? $auth_user['id'] : 1;
?>

<aside class="main-sidebar ndn-saas-sidebar">
    <div class="sidebar-inner-container">

        <!-- BRAND BANNER (HEADER TRONG SIDEBAR DÀNH CHO MINI-MODE & DESKTOP) -->
        <div class="sidebar-brand-panel">
            <a href="<?php echo base_url('admin'); ?>" class="brand-link" title="NDN Mobile Dashboard">
                <div class="brand-logo-icon">
                    <i class="fa fa-shield"></i>
                </div>
                <div class="brand-text-block">
                    <span class="brand-name">NDN Mobile</span>
                </div>
            </a>
            <button type="button" class="btn-toggle-mini-sidebar hidden-xs" id="btnToggleMiniSidebar" title="Thu gọn / Mở rộng Sidebar">
                <i class="fa fa-chevron-left" id="sidebarChevronIcon"></i>
            </button>
        </div>

        <!-- SEARCH / FILTER MENU NHANH -->
        <div class="sidebar-search-box">
            <div class="search-input-group">
                <i class="fa fa-search search-icon"></i>
                <input type="text" id="adminSidebarSearch" class="form-control sidebar-search-input" placeholder="Tìm kiếm menu..." autocomplete="off">
                <button type="button" class="btn-clear-search" id="btnClearSidebarSearch" style="display: none;">
                    <i class="fa fa-times-circle"></i>
                </button>
            </div>
        </div>

        <!-- DANH SÁCH MENU ĐIỀU HƯỚNG HIỆN ĐẠI -->
        <section class="sidebar-nav-scroll">
            <ul class="sidebar-menu ndn-menu-tree" id="ndnAdminMenu">

                <!-- 1. TỔNG QUAN / DASHBOARD -->
                <li class="menu-item-node <?php echo ($active_menu === 'dashboard') ? 'active' : ''; ?>" data-nav-name="thong ke tong quan dashboard">
                    <a href="<?php echo base_url('admin'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Bảng điều khiển & Thống kê">
                        <span class="nav-icon-wrap icon-primary">
                            <i class="fa fa-th-large"></i>
                        </span>
                        <span class="nav-label">Bảng điều khiển</span>
                    </a>
                </li>

                <!-- CATEGORY 1: QUẢN LÝ CỬA HÀNG -->
                <li class="menu-section-header" data-section-name="QUẢN LÝ CỬA HÀNG">
                    <span>QUẢN LÝ CỬA HÀNG</span>
                </li>

                <!-- SẢN PHẨM -->
                <li class="menu-item-node <?php echo ($active_menu === 'product') ? 'active' : ''; ?>" data-nav-name="san pham danh sach them moi">
                    <a href="<?php echo base_url('admin/product'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Quản lý Sản phẩm">
                        <span class="nav-icon-wrap icon-success">
                            <i class="fa fa-cube"></i>
                        </span>
                        <span class="nav-label">Sản phẩm</span>
                    </a>
                </li>

                <!-- LOẠI SẢN PHẨM / DANH MỤC -->
                <li class="menu-item-node <?php echo ($active_menu === 'category') ? 'active' : ''; ?>" data-nav-name="loai san pham danh muc">
                    <a href="<?php echo base_url('admin/category'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Loại sản phẩm & Danh mục">
                        <span class="nav-icon-wrap icon-info">
                            <i class="fa fa-sitemap"></i>
                        </span>
                        <span class="nav-label">Loại sản phẩm</span>
                    </a>
                </li>

                <!-- NHÀ CUNG CẤP / THƯƠNG HIỆU -->
                <li class="menu-item-node <?php echo ($active_menu === 'producer') ? 'active' : ''; ?>" data-nav-name="nha cung cap thuong hieu producer">
                    <a href="<?php echo base_url('admin/producer'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Nhà cung cấp & Thương hiệu">
                        <span class="nav-icon-wrap icon-warning">
                            <i class="fa fa-building"></i>
                        </span>
                        <span class="nav-label">Nhà cung cấp</span>
                    </a>
                </li>

                <!-- CATEGORY 2: QUẢN LÝ BÁN HÀNG -->
                <li class="menu-section-header" data-section-name="QUẢN LÝ BÁN HÀNG">
                    <span>QUẢN LÝ BÁN HÀNG</span>
                </li>

                <!-- ĐƠN HÀNG (CÓ BADGE ĐỘNG PULSING RED) -->
                <li class="menu-item-node <?php echo ($active_menu === 'orders') ? 'active' : ''; ?>" data-nav-name="don hang ban hang orders">
                    <a href="<?php echo base_url('admin/orders'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Quản lý Đơn đặt hàng">
                        <span class="nav-icon-wrap icon-danger">
                            <i class="fa fa-shopping-bag"></i>
                        </span>
                        <span class="nav-label">Đơn hàng</span>
                        <?php if ($pending_orders > 0): ?>
                            <span class="sidebar-badge badge-pulse" title="<?php echo $pending_orders; ?> đơn hàng mới">
                                <?php echo $pending_orders; ?> mới
                            </span>
                        <?php elseif ($shipping_orders > 0): ?>
                            <span class="sidebar-badge badge-info" title="<?php echo $shipping_orders; ?> đơn đang giao">
                                <?php echo $shipping_orders; ?> gửi
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- KHÁCH HÀNG -->
                <li class="menu-item-node <?php echo ($active_menu === 'customer') ? 'active' : ''; ?>" data-nav-name="khach hang customer tai khoan">
                    <a href="<?php echo base_url('admin/customer'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Hồ sơ Khách hàng">
                        <span class="nav-icon-wrap icon-purple">
                            <i class="fa fa-users"></i>
                        </span>
                        <span class="nav-label">Khách hàng</span>
                    </a>
                </li>

                <!-- MÃ GIẢM GIÁ / COUPONS -->
                <li class="menu-item-node <?php echo ($active_menu === 'coupon') ? 'active' : ''; ?>" data-nav-name="ma giam gia coupon khuyen mai">
                    <a href="<?php echo base_url('admin/coupon'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Mã ưu đãi & Giảm giá">
                        <span class="nav-icon-wrap icon-cyan">
                            <i class="fa fa-ticket"></i>
                        </span>
                        <span class="nav-label">Mã giảm giá</span>
                    </a>
                </li>

                <!-- LIÊN HỆ / YÊU CẦU CSKH (CÓ BADGE ĐỘNG) -->
                <li class="menu-item-node <?php echo ($active_menu === 'contact') ? 'active' : ''; ?>" data-nav-name="lien he contact tin nhan">
                    <a href="<?php echo base_url('admin/contact'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Yêu cầu Liên hệ & Hộp thư">
                        <span class="nav-icon-wrap icon-teal">
                            <i class="fa fa-envelope-o"></i>
                        </span>
                        <span class="nav-label">Liên hệ</span>
                        <?php if ($unread_contacts > 0): ?>
                            <span class="sidebar-badge badge-warning" title="<?php echo $unread_contacts; ?> tin chưa đọc">
                                <?php echo $unread_contacts; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- ĐÁNH GIÁ & BÌNH LUẬN (CÓ BADGE ĐỘNG) -->
                <li class="menu-item-node <?php echo ($active_menu === 'reviews') ? 'active' : ''; ?>" data-nav-name="danh gia binh luan reviews comments">
                    <a href="<?php echo base_url('admin/reviews'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Đánh giá & Bình luận sản phẩm">
                        <span class="nav-icon-wrap icon-amber">
                            <i class="fa fa-star-half-o"></i>
                        </span>
                        <span class="nav-label">Đánh giá & Bình luận</span>
                        <?php if ($pending_reviews > 0): ?>
                            <span class="sidebar-badge badge-warning" title="<?php echo $pending_reviews; ?> đánh giá chờ duyệt">
                                <?php echo $pending_reviews; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- CATEGORY 3: HỆ THỐNG -->
                <li class="menu-section-header" data-section-name="CÀI ĐẶT">
                    <span>HỆ THỐNG & CÀI ĐẶT</span>
                </li>

                <!-- CẤU HÌNH HỆ THỐNG -->
                <li class="menu-item-node <?php echo ($active_menu === 'configuration') ? 'active' : ''; ?>" data-nav-name="cau hinh he thong setting config">
                    <a href="<?php echo base_url('admin/configuration/update'); ?>" class="nav-pill" data-toggle="tooltip" data-placement="right" title="Cấu hình Website & Cửa hàng">
                        <span class="nav-icon-wrap icon-slate">
                            <i class="fa fa-sliders"></i>
                        </span>
                        <span class="nav-label">Cấu hình hệ thống</span>
                    </a>
                </li>

                <!-- THOÁT / LOGOUT -->
                <li class="menu-item-node" data-nav-name="thoat dang xuat logout">
                    <a href="<?php echo base_url('admin/user/logout'); ?>" class="nav-pill nav-pill-logout" data-toggle="tooltip" data-placement="right" title="Đăng xuất khỏi hệ thống">
                        <span class="nav-icon-wrap icon-logout">
                            <i class="fa fa-sign-out"></i>
                        </span>
                        <span class="nav-label">Thoát</span>
                    </a>
                </li>

                <!-- DÒNG THÔNG BÁO KHÔNG TÌM THẤY KHI SEARCH -->
                <li class="no-menu-found" id="noMenuFoundMsg" style="display: none;">
                    <i class="fa fa-info-circle"></i> Không tìm thấy chức năng phù hợp
                </li>

            </ul>
        </section>

    </div>
</aside>

<!-- BACKDROP CHO MOBILE RESPONSIVE DRAWER -->
<div class="sidebar-mobile-backdrop" id="sidebarMobileBackdrop"></div>

<!-- STYLES CHUYÊN NGHIỆP: MODERN ENTERPRISE SAAS DASHBOARD THEME -->
<style>
/* 1. SIDEBAR CONTAINER & FOUNDATION */
.ndn-saas-sidebar {
    background: #0f172a !important; /* Dark Slate / Charcoal */
    border-right: 1px solid #1e293b !important;
    width: 250px !important;
    height: 100vh !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    bottom: 0 !important;
    padding: 0 !important;
    margin: 0 !important;
    z-index: 1040 !important;
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.15) !important;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
}

.sidebar-inner-container {
    display: flex;
    flex-direction: column;
    height: 100%;
    position: relative;
    overflow: hidden;
}

/* 2. BRAND PANEL */
.sidebar-brand-panel {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0 16px;
    height: 60px;
    background: #0b1120;
    border-bottom: 1px solid #1e293b;
    flex-shrink: 0;
}
.brand-link {
    display: flex;
    align-items: center;
    gap: 12px;
    text-decoration: none !important;
    color: #ffffff !important;
    overflow: hidden;
}
.brand-logo-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #d70018 0%, #991b1b 100%);
    color: #ffffff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(215, 0, 24, 0.35);
}
.brand-text-block {
    display: flex;
    flex-direction: column;
    line-height: 1.2;
    transition: opacity 0.2s ease;
}
.brand-name {
    font-size: 16px;
    font-weight: 800;
    letter-spacing: 0.5px;
    color: #ffffff;
}
.brand-badge-v2 {
    font-size: 10px;
    font-weight: 700;
    color: #ef4444;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}
.btn-toggle-mini-sidebar {
    background: transparent;
    border: none;
    color: #64748b;
    width: 28px;
    height: 28px;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    transition: all 0.2s ease;
}
.btn-toggle-mini-sidebar:hover {
    background: #1e293b;
    color: #ffffff;
}

/* 3. SIDEBAR SEARCH BOX */
.sidebar-search-box {
    padding: 12px 14px 6px;
    flex-shrink: 0;
}
.search-input-group {
    position: relative;
    width: 100%;
}
.search-input-group .search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #64748b;
    font-size: 13px;
    pointer-events: none;
}
.sidebar-search-input {
    width: 100% !important;
    background: #1e293b !important;
    border: 1px solid #334155 !important;
    color: #e2e8f0 !important;
    border-radius: 8px !important;
    height: 36px !important;
    padding-left: 34px !important;
    padding-right: 28px !important;
    font-size: 13px !important;
    transition: all 0.2s ease !important;
}
.sidebar-search-input:focus {
    border-color: #ef4444 !important;
    background: #0f172a !important;
    box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.2) !important;
    outline: none !important;
}
.sidebar-search-input::placeholder {
    color: #64748b;
    font-size: 12px;
}
.btn-clear-search {
    position: absolute;
    right: 8px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    color: #94a3b8;
    cursor: pointer;
    font-size: 14px;
    padding: 0;
    line-height: 1;
}

/* 4. SCROLLABLE MENU TREE */
.sidebar-nav-scroll {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 8px 10px;
}
.sidebar-nav-scroll::-webkit-scrollbar {
    width: 4px;
}
.sidebar-nav-scroll::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 4px;
}

.ndn-menu-tree {
    list-style: none;
    padding: 0;
    margin: 0;
}
.menu-section-header {
    padding: 16px 12px 6px;
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    user-select: none;
}

.menu-item-node {
    margin-bottom: 4px;
}
.nav-pill {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 12px;
    border-radius: 8px;
    color: #94a3b8 !important;
    text-decoration: none !important;
    font-size: 13.5px;
    font-weight: 500;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}
.nav-pill:hover {
    background: #1e293b;
    color: #ffffff !important;
    transform: translateX(2px);
}
.menu-item-node.active .nav-pill {
    background: linear-gradient(90deg, rgba(215, 0, 24, 0.16) 0%, rgba(215, 0, 24, 0.04) 100%);
    color: #ffffff !important;
    font-weight: 600;
}
.menu-item-node.active .nav-pill::before {
    content: '';
    position: absolute;
    left: 0;
    top: 4px;
    bottom: 4px;
    width: 3.5px;
    background: #ef4444;
    border-radius: 0 4px 4px 0;
    box-shadow: 0 0 10px rgba(239, 68, 68, 0.8);
}

/* Nav Icons with subtle themed colors */
.nav-icon-wrap {
    width: 22px;
    height: 22px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
    color: #94a3b8;
    transition: transform 0.2s ease, color 0.2s ease;
}
.nav-pill:hover .nav-icon-wrap {
    transform: scale(1.1);
    color: #ffffff;
}
.menu-item-node.active .nav-icon-wrap {
    color: #ef4444 !important;
}

/* Specific icon theme accents */
.icon-primary { color: #60a5fa; }
.icon-success { color: #34d399; }
.icon-info    { color: #38bdf8; }
.icon-warning { color: #fbbf24; }
.icon-danger  { color: #f87171; }
.icon-purple  { color: #c084fc; }
.icon-cyan    { color: #22d3ee; }
.icon-teal    { color: #2dd4bf; }
.icon-amber   { color: #f59e0b; }
.icon-slate   { color: #94a3b8; }
.icon-logout  { color: #f43f5e; }

.nav-label {
    flex: 1;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.3;
}

/* 5. DYNAMIC STATUS BADGES (PULSING RED & CHIPS) */
.sidebar-badge {
    padding: 2px 7px;
    font-size: 10px;
    font-weight: 700;
    border-radius: 20px;
    line-height: 1.2;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    flex-shrink: 0;
}
.badge-pulse {
    background: #ef4444;
    color: #ffffff;
    box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    animation: sidebarPulse 1.8s infinite;
}
@keyframes sidebarPulse {
    0% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.7);
    }
    70% {
        box-shadow: 0 0 0 6px rgba(239, 68, 68, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(239, 68, 68, 0);
    }
}
.badge-info {
    background: #0284c7;
    color: #ffffff;
}
.badge-warning {
    background: #d97706;
    color: #ffffff;
}
.no-menu-found {
    padding: 20px 12px;
    font-size: 12px;
    color: #64748b;
    text-align: center;
}

/* 6. MINI-SIDEBAR COMPACT MODE (64px) */
body.sidebar-mini-active .ndn-saas-sidebar {
    width: 64px !important;
}
body.sidebar-mini-active .brand-text-block,
body.sidebar-mini-active .sidebar-search-box,
body.sidebar-mini-active .menu-section-header,
body.sidebar-mini-active .nav-label,
body.sidebar-mini-active .sidebar-badge {
    display: none !important;
}
body.sidebar-mini-active .sidebar-brand-panel {
    justify-content: center;
    padding: 0 4px;
    position: relative;
}
body.sidebar-mini-active .brand-link {
    display: none !important;
}
body.sidebar-mini-active .btn-toggle-mini-sidebar {
    display: flex !important;
    margin: 0 auto !important;
    width: 38px;
    height: 38px;
    background: #1e293b;
    color: #ffffff;
    font-size: 14px;
    border-radius: 8px;
}
body.sidebar-mini-active .nav-pill {
    justify-content: center;
    padding: 10px 0;
    width: 44px;
    margin: 0 auto 6px;
}
body.sidebar-mini-active .nav-pill:hover {
    transform: none;
}

/* Content wrapper margin sync with mini sidebar */
body.sidebar-mini-active .content-wrapper,
body.sidebar-mini-active .main-header .navbar {
    margin-left: 64px !important;
}
body.sidebar-mini-active .content-header {
    left: 64px !important;
    padding-left: 25px !important;
}
body.sidebar-mini-active .filter-card-wrapper {
    left: 84px !important;
}

/* 8. MOBILE OFF-CANVAS DRAWER & BACKDROP */
.sidebar-mobile-backdrop {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(15, 23, 42, 0.6);
    backdrop-filter: blur(4px);
    -webkit-backdrop-filter: blur(4px);
    z-index: 1035;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.sidebar-mobile-backdrop.active {
    display: block;
    opacity: 1;
}

@media (max-width: 1024px) {
    .ndn-saas-sidebar {
        transform: translateX(-100%) !important;
        width: 260px !important;
    }
    body.sidebar-mobile-open .ndn-saas-sidebar {
        transform: translateX(0) !important;
    }
    .btn-toggle-mini-sidebar {
        display: none !important;
    }
}
</style>

<!-- JAVASCRIPT ĐIỀU HƯỞNG SIDEBAR SAAS: SEARCH, MINI-COLLAPSE & ACCORDION -->
<script>
(function() {
    'use strict';

    function initMiniSidebar() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initMiniSidebar, 50);
            return;
        }
        var $ = jQuery;

        // 1. Khôi phục trạng thái Mini-sidebar từ localStorage
        var savedMiniState = localStorage.getItem('ndn_admin_sidebar_mini');
        if (savedMiniState === 'true' && $(window).width() > 1024) {
            $('body').addClass('sidebar-mini-active');
            $('#sidebarChevronIcon').removeClass('fa-chevron-left').addClass('fa-chevron-right');
            $('#btnToggleMiniSidebar').attr('title', 'Mở rộng Menu');
        }

        // 2. Nút Toggle Mini-sidebar
        $(document).off('click.miniSidebar', '#btnToggleMiniSidebar').on('click.miniSidebar', '#btnToggleMiniSidebar', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').toggleClass('sidebar-mini-active');
            var isMini = $('body').hasClass('sidebar-mini-active');
            localStorage.setItem('ndn_admin_sidebar_mini', isMini ? 'true' : 'false');
            
            if (isMini) {
                $('#sidebarChevronIcon').removeClass('fa-chevron-left').addClass('fa-chevron-right');
                $(this).attr('title', 'Mở rộng Menu');
            } else {
                $('#sidebarChevronIcon').removeClass('fa-chevron-right').addClass('fa-chevron-left');
                $(this).attr('title', 'Thu gọn Menu');
            }
        });

        // 3. Nút Toggle Off-Canvas Mobile (Tương thích nút Hamburger trên Header)
        $('.sidebar-toggle, [data-toggle="offcanvas"]').off('click').on('click', function(e) {
            e.preventDefault();
            if ($(window).width() <= 1024) {
                $('body').toggleClass('sidebar-mobile-open');
                $('#sidebarMobileBackdrop').toggleClass('active');
            } else {
                $('#btnToggleMiniSidebar').trigger('click');
            }
        });

        // Đóng drawer khi click vào backdrop
        $('#sidebarMobileBackdrop').on('click', function() {
            $('body').removeClass('sidebar-mobile-open');
            $(this).removeClass('active');
        });

        // 4. Lọc Menu nhanh bằng ô tìm kiếm (Instant Client-side Search)
        $('#adminSidebarSearch').on('input', function() {
            var keyword = $(this).val().toLowerCase().trim();
            if (keyword.length > 0) {
                $('#btnClearSidebarSearch').show();
            } else {
                $('#btnClearSidebarSearch').hide();
            }

            var visibleCount = 0;
            $('.menu-item-node').each(function() {
                var navData = ($(this).data('nav-name') || '').toLowerCase();
                var navText = $(this).text().toLowerCase();
                if (navData.indexOf(keyword) > -1 || navText.indexOf(keyword) > -1) {
                    $(this).show();
                    visibleCount++;
                } else {
                    $(this).hide();
                }
            });

            // Ẩn/hiện tiêu đề section
            $('.menu-section-header').each(function() {
                if (keyword.length > 0) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });

            if (visibleCount === 0 && keyword.length > 0) {
                $('#noMenuFoundMsg').show();
            } else {
                $('#noMenuFoundMsg').hide();
            }
        });

        // Nút xóa từ khóa tìm kiếm
        $('#btnClearSidebarSearch').on('click', function() {
            $('#adminSidebarSearch').val('').trigger('input').focus();
        });

        // 5. Khởi tạo Tooltip Bootstrap cho Icon-only mode
        if ($.fn.tooltip) {
            $('[data-toggle="tooltip"]').tooltip({
                container: 'body',
                trigger: 'hover'
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMiniSidebar);
    } else {
        initMiniSidebar();
    }
})();
</script>