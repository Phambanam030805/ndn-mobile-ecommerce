<header class="main-header">

    <!-- LOGO + LINK ADMIN -->
    <a href="<?php echo base_url('admin'); ?>" class="logo">
        <span class="logo-lg">Quản trị hệ thống</span>
    </a>

    <nav class="navbar navbar-static-top" style="height: 52px">

        <!-- NÚT THU GỌN SIDEBAR -->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav" style="height: 52px; padding: 1px">

                <!-- 🔔 THÔNG BÁO ĐƠN HÀNG -->
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>

                        <!-- TỔNG SỐ ĐƠN -->
                        <span class="label label-warning">
                            <?php
    $approved     = $this->Mdonhang->orders_count_header(); 
    $not_approved = $this->Mdonhang->orders_count_header_not(); // Đảm bảo các hàm này trong Model dùng bảng 'orders'
    echo (int)$approved + (int)$not_approved;
?>
                        </span>
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <ul class="menu">
                                <li>
                                    <a href="<?php echo base_url('admin/orders'); ?>">
                                        <i class="fa fa-shopping-cart text-aqua"></i>
                                        <?php echo $not_approved; ?> đơn hàng chưa duyệt
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo base_url('admin/orders'); ?>">
                                        <i class="fa fa-truck text-green"></i>
                                        <?php echo $approved; ?> đơn hàng đang giao
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="footer">
                            <a href="<?php echo base_url('admin/orders'); ?>">Xem tất cả</a>
                        </li>
                    </ul>
                </li>

                <!-- LINK RA WEBSITE -->
                <li style="height: 52px">
                    <a target="_blank" href="<?php echo base_url(); ?>">
                        <span class="glyphicon glyphicon-home"></span>
                        <span>Website</span>
                    </a>
                </li>

                <!-- 👤 THÔNG TIN NGƯỜI DÙNG -->
                <?php
                // AN TOÀN SESSION
                $image    = (!empty($user['img'])) ? $user['img'] : 'user.png';
                $fullname = isset($user['fullname']) ? $user['fullname'] : 'Admin';
                $phone    = isset($user['phone']) ? $user['phone'] : '';
                ?>

                <li class="dropdown user user-menu" style="height: 52px; padding: 0px">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php echo base_url('public/images/admin/'.$image); ?>" class="user-image" alt="User Image">
                        <span class="hidden-xs"><?php echo $fullname; ?></span>
                    </a>

                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <img src="<?php echo base_url('public/images/admin/'.$image); ?>" class="img-circle" alt="User Image">
                            <p>
                                <?php echo $fullname; ?>
                                <small><?php echo $phone; ?></small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="<?php echo base_url('admin/useradmin/update/'.$user['id']); ?>"
                                   class="btn btn-default btn-flat">
                                    Chi tiết
                                </a>
                            </div>
                            <div class="pull-right">
                                <a href="<?php echo base_url('admin/user/logout'); ?>"
                                   class="btn btn-default btn-flat">
                                    Thoát
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

    <!-- 🎨 STYLE HEADER (PREMIUM RED GRADIENT) -->
    <style>
        .main-header {
            box-shadow: 0 4px 15px rgba(215, 0, 24, 0.2);
            border-bottom: none;
        }
        
        .main-header .navbar {
            background: linear-gradient(135deg, #d70018, #ff4757) !important;
            color: #ffffff !important;
            transition: all 0.3s ease;
        }
        
        /* Logo góc trái (Đỏ sậm hơn để tách biệt) */
        .main-header .logo {
            background: #c20015 !important;
            color: #ffffff !important;
            font-weight: 800;
            font-size: 20px;
            border-right: none;
            letter-spacing: 0.5px;
        }

        .main-header .navbar:hover {
            background: linear-gradient(135deg, #c20015, #ff4757) !important;
        }

        /* Màu icon và chữ cơ bản */
        .navbar a,
        .navbar .fa,
        .navbar .glyphicon,
        .sidebar-toggle {
            color: #ffffff !important;
            font-weight: 500;
        }

        /* Khi di chuột vào các nút trên thanh bar */
        .navbar a:hover,
        .sidebar-toggle:hover {
            color: #ffffff !important;
            background-color: rgba(0, 0, 0, 0.1) !important;
        }

        /* 🔔 Icon chuông thông báo (Màu Vàng Chanh) */
        .navbar .fa-bell-o {
            color: #ffeb3b !important; 
            font-size: 18px;
            display: inline-block;
            animation: ring 3s infinite ease-in-out;
        }

        /* 🔔 Badge số lượng thông báo (Nền trắng - Chữ đỏ) */
        .navbar .nav > li > a > .label {
            position: absolute;
            top: 6px;
            right: 4px;
            text-align: center;
            font-size: 11px;
            padding: 3px 6px;
            line-height: .9;
            border-radius: 50px;
            background-color: #ffffff !important; 
            color: #d70018 !important;
            font-weight: 900;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.2);
        }

        /* Hộp Menu xổ xuống (Dropdown) */
        .navbar .dropdown-menu {
            border-radius: 12px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
            border: none !important;
            padding: 0;
            overflow: hidden;
            background-color: #fff !important;
        }

        /* Chữ trong các Dropdown Menu */
        .navbar .dropdown-menu a {
            color: #333 !important; /* Trả lại màu chữ đen để không bị lẫn vào nền trắng */
            padding: 12px 15px !important;
            font-weight: 500;
            transition: all 0.2s;
            display: block;
            border-bottom: 1px solid #f0f2f5;
        }
        
        .navbar .dropdown-menu a:hover {
            background-color: #f8f9fa !important;
            color: #d70018 !important;
        }

        /* Icon trong Menu Thông báo */
        .navbar .dropdown-menu a i.fa-shopping-cart {
            color: #ff9800 !important; /* Màu cam cho đơn chưa duyệt */
            margin-right: 8px;
            font-size: 16px;
        }
        .navbar .dropdown-menu a i.fa-truck {
            color: #00b894 !important; /* Màu xanh cho đơn đang giao */
            margin-right: 8px;
            font-size: 16px;
        }

        /* Nút Xem tất cả dưới cùng Menu Thông Báo */
        .navbar .dropdown-menu .footer a {
            text-align: center;
            font-weight: bold;
            color: #0984e3 !important;
            background: #f8f9fa !important;
        }
        
        /* Chỗ hiển thị Avatar và Tên (Mở rộng) */
        .user-header {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;
            color: #333 !important;
        }
        .user-header p {
            color: #333 !important;
            font-weight: 700;
        }
        .user-header small {
            color: #666 !important;
            font-weight: 500;
        }

        @keyframes ring {
            0%, 100% { transform: rotate(0deg); }
            5%, 15% { transform: rotate(15deg); }
            10%, 20% { transform: rotate(-15deg); }
            25% { transform: rotate(0deg); }
        }
    </style>

</header>
