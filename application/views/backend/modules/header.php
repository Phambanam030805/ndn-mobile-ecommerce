<header class="main-header">

    <!-- LOGO + LINK ADMIN (Khớp chuẩn 230px của sidebar) -->
    <a href="<?php echo base_url('admin'); ?>" class="logo">
        <span class="logo-mini"><b>NDN</b></span>
        <span class="logo-lg"><i class="fa fa-shield"></i> <b>NDN</b> Mobile</span>
    </a>

    <!-- NAVBAR (margin-left: 250px chuẩn AdminLTE) -->
    <nav class="navbar navbar-static-top" role="navigation">

        <!-- THANH ĐIỀU HƯỚNG BÊN PHẢI -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- 🔔 THÔNG BÁO ĐƠN HÀNG -->
                <?php
                    $shipping_count = $this->Mdonhang->orders_count_header(); // Đang giao
                    $pending_count  = $this->Mdonhang->orders_count_header_not(); // Chờ duyệt
                    $total_notif    = (int)$shipping_count + (int)$pending_count;
                ?>
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle notif-bell-btn" data-toggle="dropdown" title="Thông báo đơn hàng">
                        <i class="fa fa-bell-o bell-icon"></i>
                        <?php if($total_notif > 0): ?>
                            <span class="label notif-badge"><?php echo $total_notif; ?></span>
                        <?php endif; ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-modern">
                        <li class="header-notif-title">
                            <i class="fa fa-bell text-red"></i> Bạn có <b><?php echo $total_notif; ?></b> đơn hàng cần lưu ý
                        </li>
                        <li>
                            <ul class="menu notif-items-list">
                                <li>
                                    <a href="<?php echo base_url('admin/orders'); ?>">
                                        <div class="notif-item-icon bg-warning-soft">
                                            <i class="fa fa-clock-o text-warning"></i>
                                        </div>
                                        <div class="notif-item-text">
                                            <span class="notif-item-main"><b><?php echo $pending_count; ?></b> đơn hàng chờ duyệt</span>
                                            <span class="notif-item-sub">Cần xử lý và xác nhận ngay</span>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('admin/orders'); ?>">
                                        <div class="notif-item-icon bg-info-soft">
                                            <i class="fa fa-truck text-info"></i>
                                        </div>
                                        <div class="notif-item-text">
                                            <span class="notif-item-main"><b><?php echo $shipping_count; ?></b> đơn đang giao hàng</span>
                                            <span class="notif-item-sub">Đang trên đường giao khách</span>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer-notif">
                            <a href="<?php echo base_url('admin/orders'); ?>">
                                Xem danh sách đơn hàng <i class="fa fa-arrow-right"></i>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- 🌐 LINK RA CỬA HÀNG BÁN HÀNG -->
                <li class="header-website-btn">
                    <a target="_blank" href="<?php echo base_url(); ?>" title="Xem website ngoài trang chủ">
                        <i class="fa fa-globe"></i>
                        <span>Xem Website</span>
                    </a>
                </li>

                <!-- 👤 USER DROPDOWN PROFILE -->
                <?php
                    $image    = (!empty($user['img'])) ? $user['img'] : 'user.png';
                    $fullname = isset($user['fullname']) ? $user['fullname'] : 'Admin';
                    $phone    = isset($user['phone']) ? $user['phone'] : 'Quản trị viên cấp cao';
                ?>
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle user-pill-btn" data-toggle="dropdown">
                        <img src="<?php echo base_url('public/images/admin/'.$image); ?>" class="user-image" alt="Avatar" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png'">
                        <span class="hidden-xs user-name-label"><?php echo $fullname; ?></span>
                        <i class="fa fa-angle-down hidden-xs" style="font-size: 11px; opacity: 0.8; margin-left: 2px;"></i>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-modern user-dropdown-box">
                        <li class="user-card-header">
                            <img src="<?php echo base_url('public/images/admin/'.$image); ?>" class="img-circle" alt="Avatar" onerror="this.src='https://cdn-icons-png.flaticon.com/512/3135/3135715.png'">
                            <h4><?php echo $fullname; ?></h4>
                            <span class="badge-role"><i class="fa fa-shield"></i> Quản trị hệ thống</span>
                        </li>

                        <li class="user-action-footer">
                            <a href="<?php echo base_url('admin/useradmin/update/'.$user['id']); ?>" class="btn-profile-action">
                                <i class="fa fa-user-circle-o"></i> Tài khoản
                            </a>
                            <a href="<?php echo base_url('admin/user/logout'); ?>" class="btn-profile-logout">
                                <i class="fa fa-sign-out"></i> Đăng xuất
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- 🎨 STYLE HEADER CHUẨN KÍCH THƯỚC ADMINLTE -->
    <style>
        .main-header {
            box-shadow: 0 4px 15px rgba(215, 0, 24, 0.15) !important;
            border-bottom: none !important;
            position: relative;
            z-index: 1030;
        }

        /* 1. Đặt background đỏ cho toàn bộ .main-header để không bao giờ bị hở khoảng trắng */
        .main-header {
            background: linear-gradient(135deg, #d70018 0%, #dc2626 50%, #b91c1c 100%) !important;
        }

        /* 2. Ẩn logo cũ */
        .main-header .logo {
            display: none !important;
        }

        /* 3. Navbar: Đặt margin-left ăn khớp theo độ rộng Sidebar */
        .main-header .navbar {
            margin-left: 250px !important;
            min-height: 50px !important;
            height: 50px !important;
            background: transparent !important;
            border: none !important;
            border-radius: 0 !important;
            padding: 0 15px 0 0 !important;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        body.sidebar-mini-active .main-header .navbar,
        body.sidebar-collapse .main-header .navbar,
        .sidebar-collapse .main-header .navbar {
            margin-left: 64px !important;
        }



        /* 4. Menu bên phải: Căn chỉnh chiều cao 50px đều tăm tắp */
        .main-header .navbar-custom-menu {
            float: right !important;
            height: 50px !important;
        }
        .main-header .navbar-custom-menu .navbar-nav {
            height: 50px !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin: 0 !important;
        }
        .main-header .navbar-custom-menu .navbar-nav > li {
            height: auto !important;
            float: none !important;
            display: flex !important;
            align-items: center !important;
        }

        /* Nút Chuông Thông Báo */
        .notif-bell-btn {
            position: relative;
            padding: 7px 11px !important;
            border-radius: 8px !important;
            background: rgba(255, 255, 255, 0.14) !important;
            transition: all 0.2s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
        }
        .notif-bell-btn:hover {
            background: rgba(255, 255, 255, 0.24) !important;
            color: #ffffff !important;
        }
        .notif-bell-btn .bell-icon {
            color: #ffffff !important;
            font-size: 16px !important;
        }
        .notif-badge {
            position: absolute !important;
            top: -5px !important;
            right: -5px !important;
            background: #ffffff !important;
            color: #d70018 !important;
            font-size: 10.5px !important;
            font-weight: 800 !important;
            padding: 2px 6px !important;
            border-radius: 20px !important;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2) !important;
            border: 1.5px solid #d70018 !important;
            line-height: 1 !important;
        }

        /* Nút Xem Website */
        .header-website-btn a {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            background: rgba(255, 255, 255, 0.16) !important;
            color: #ffffff !important;
            padding: 6px 14px !important;
            border-radius: 8px !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            transition: all 0.2s ease !important;
            text-decoration: none !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }
        .header-website-btn a:hover {
            background: #ffffff !important;
            color: #d70018 !important;
            box-shadow: 0 3px 10px rgba(0,0,0,0.12) !important;
        }

        /* User Pill Menu Button */
        .user-pill-btn {
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            background: rgba(0, 0, 0, 0.16) !important;
            padding: 4px 12px 4px 5px !important;
            border-radius: 25px !important;
            color: #ffffff !important;
            transition: all 0.2s ease !important;
            border: 1px solid rgba(255, 255, 255, 0.15) !important;
        }
        .user-pill-btn:hover {
            background: rgba(0, 0, 0, 0.26) !important;
            color: #ffffff !important;
        }
        .user-pill-btn .user-image {
            width: 30px !important;
            height: 30px !important;
            border-radius: 50% !important;
            object-fit: cover !important;
            border: 1.5px solid #ffffff !important;
            margin: 0 !important;
            float: none !important;
        }
        .user-name-label {
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #ffffff !important;
            letter-spacing: 0.2px !important;
        }

        /* Dropdown Popups Hiện đại */
        .dropdown-menu-modern {
            border-radius: 14px !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 15px 35px -5px rgba(15, 23, 42, 0.18), 0 5px 15px rgba(0, 0, 0, 0.06) !important;
            background: #ffffff !important;
            padding: 0 !important;
            overflow: hidden !important;
            margin-top: 6px !important;
        }

        /* Notifications Dropdown */
        .header-notif-title {
            padding: 12px 16px !important;
            background: #f8fafc !important;
            border-bottom: 1px solid #f1f5f9 !important;
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #334155 !important;
        }
        .notif-items-list {
            padding: 0 !important;
            margin: 0 !important;
            list-style: none !important;
            max-height: 250px !important;
            overflow-y: auto !important;
        }
        .notif-items-list li a {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
            padding: 12px 16px !important;
            border-bottom: 1px solid #f8fafc !important;
            text-decoration: none !important;
            color: #334155 !important;
            transition: background 0.15s ease !important;
        }
        .notif-items-list li a:hover {
            background: #f8fafc !important;
        }
        .notif-item-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            flex-shrink: 0;
        }
        .bg-warning-soft { background: #fef3c7; }
        .bg-info-soft { background: #e0f2fe; }
        .notif-item-text {
            display: flex;
            flex-direction: column;
        }
        .notif-item-main {
            font-size: 12.5px;
            color: #0f172a;
        }
        .notif-item-sub {
            font-size: 11px;
            color: #94a3b8;
        }
        .footer-notif {
            padding: 9px !important;
            text-align: center !important;
            background: #f8fafc !important;
            border-top: 1px solid #f1f5f9 !important;
        }
        .footer-notif a {
            color: #d70018 !important;
            font-size: 12px !important;
            font-weight: 700 !important;
            text-decoration: none !important;
        }

        /* User Dropdown Box */
        .user-dropdown-box {
            width: 240px !important;
        }
        .user-card-header {
            padding: 18px 16px 14px !important;
            text-align: center !important;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%) !important;
            border-bottom: 1px solid #e2e8f0 !important;
        }
        .user-card-header img {
            width: 58px !important;
            height: 58px !important;
            border-radius: 50% !important;
            border: 2px solid #ffffff !important;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1) !important;
            margin-bottom: 6px !important;
            object-fit: cover !important;
        }
        .user-card-header h4 {
            margin: 0 0 4px !important;
            font-size: 14px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
        }
        .badge-role {
            font-size: 10.5px !important;
            font-weight: 600 !important;
            color: #b91c1c !important;
            background: #fee2e2 !important;
            padding: 2px 8px !important;
            border-radius: 20px !important;
            display: inline-block !important;
        }
        .user-action-footer {
            padding: 10px 14px !important;
            display: flex !important;
            gap: 8px !important;
            background: #ffffff !important;
        }
        .btn-profile-action {
            flex: 1;
            padding: 7px 10px;
            background: #f1f5f9;
            color: #334155 !important;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.15s ease;
        }
        .btn-profile-action:hover {
            background: #e2e8f0;
            color: #0f172a !important;
        }
        .btn-profile-logout {
            flex: 1;
            padding: 7px 10px;
            background: #fef2f2;
            color: #dc2626 !important;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            text-decoration: none !important;
            transition: all 0.15s ease;
        }
        .btn-profile-logout:hover {
            background: #fee2e2;
        }

        /* Responsive Mobile */
        @media (max-width: 767px) {
            .main-header .navbar {
                margin-left: 0 !important;
            }
            .main-header .logo {
                width: 100% !important;
                float: none !important;
            }
        }
    </style>

</header>
