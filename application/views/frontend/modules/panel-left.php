<div class="main-navigation-bar">
    <div class="container">
        
        <!-- Mobile Navbar -->
        <div class="mobile-nav-toggle hidden-md hidden-lg">
            <button type="button" class="btn-mobile-toggle" data-toggle="collapse" data-target="#mobileMainMenu">
                <i class="fas fa-bars"></i>
                <span>DANH MỤC MENU</span>
            </button>
            <div class="collapse" id="mobileMainMenu">
                <ul class="mobile-menu-list">
                    <li><a href="<?php echo base_url(); ?>"><i class="fas fa-home"></i> Trang chủ</a></li>
                    <li><a href="<?php echo base_url('san-pham'); ?>"><i class="fas fa-mobile-alt"></i> Tất cả sản phẩm</a></li>
                    <?php
                    $listcat = $this->Mdanhmuc->category_menu(0);
                    foreach ($listcat as $menu):
                        $submenu = $this->Mdanhmuc->category_menu($menu['id']);
                    ?>
                        <li>
                            <a href="<?php echo base_url('san-pham/'.$menu['link']); ?>">
                                <?php echo htmlspecialchars($menu['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                    <li><a href="<?php echo base_url('tin-tuc/1'); ?>"><i class="fas fa-newspaper"></i> Tin tức</a></li>
                    <li><a href="<?php echo base_url('gioi-thieu'); ?>"><i class="fas fa-info-circle"></i> Giới thiệu</a></li>
                    <li><a href="<?php echo base_url('lien-he'); ?>"><i class="fas fa-phone"></i> Liên hệ</a></li>
                </ul>
            </div>
        </div>

        <!-- Desktop Navigation Bar Hiện Đại -->
        <div class="desktop-nav-wrapper hidden-xs hidden-sm">
            <ul class="nav-links-modern">
                <!-- Trang chủ -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url(); ?>" class="nav-link-m <?php echo (uri_string() == '' || uri_string() == 'trang-chu') ? 'active' : ''; ?>">
                        <i class="fas fa-home nav-icon-m"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>

                <!-- Danh mục động: Điện thoại (có dropdown hãng) -->
                <?php
                $listcat = $this->Mdanhmuc->category_menu(0);
                foreach ($listcat as $menu):
                    $submenu = $this->Mdanhmuc->category_menu($menu['id']);
                    $has_sub = count($submenu) > 0;
                    
                    // Icon tương ứng danh mục
                    $icon = 'fa-mobile-alt';
                    if (strpos(mb_strtolower($menu['name']), 'phụ kiện') !== false) {
                        $icon = 'fa-headphones-alt';
                    }
                ?>
                    <li class="nav-item-m <?php echo $has_sub ? 'has-dropdown' : ''; ?>">
                        <a href="<?php echo base_url('san-pham/'.$menu['link']); ?>" class="nav-link-m">
                            <i class="fas <?php echo $icon; ?> nav-icon-m"></i>
                            <span><?php echo htmlspecialchars(trim($menu['name'])); ?></span>
                            <?php if($has_sub): ?>
                                <i class="fas fa-chevron-down nav-arrow"></i>
                            <?php endif; ?>
                        </a>

                        <?php if($has_sub): ?>
                            <!-- Dropdown Menu Sang Trọng -->
                            <div class="nav-dropdown-menu">
                                <div class="dropdown-inner">
                                    <div class="dropdown-heading">Thương hiệu / Phân loại</div>
                                    <ul class="sub-links-grid">
                                        <?php foreach ($submenu as $sub): ?>
                                            <li>
                                                <a href="<?php echo base_url('san-pham/'.$sub['link']); ?>">
                                                    <i class="fas fa-angle-right"></i>
                                                    <span><?php echo htmlspecialchars($sub['name']); ?></span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>

                <!-- Tất cả sản phẩm -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url('san-pham'); ?>" class="nav-link-m <?php echo (uri_string() == 'san-pham') ? 'active' : ''; ?>">
                        <i class="fas fa-th-large nav-icon-m"></i>
                        <span>Tất cả sản phẩm</span>
                    </a>
                </li>

                <!-- Khuyến mãi Hot -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url('khuyen-mai'); ?>" class="nav-link-m <?php echo (strpos(uri_string(), 'khuyen-mai') !== false) ? 'active' : ''; ?>">
                        <i class="fas fa-fire nav-icon-m" style="color: #ffb703; animation: pulse 1.5s infinite;"></i>
                        <span>Khuyến mãi hot</span>
                    </a>
                </li>

                <!-- Bán chạy nhất -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url('ban-chay'); ?>" class="nav-link-m <?php echo (strpos(uri_string(), 'ban-chay') !== false) ? 'active' : ''; ?>">
                        <i class="fas fa-crown nav-icon-m" style="color: #f59e0b;"></i>
                        <span>Bán chạy</span>
                    </a>
                </li>

                <!-- Tin tức công nghệ -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url('tin-tuc/1'); ?>" class="nav-link-m <?php echo (strpos(uri_string(), 'tin-tuc') !== false) ? 'active' : ''; ?>">
                        <i class="fas fa-bolt nav-icon-m" style="color: #ffeb3b;"></i>
                        <span>Tin công nghệ</span>
                    </a>
                </li>

                <!-- Giới thiệu -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url('gioi-thieu'); ?>" class="nav-link-m <?php echo (uri_string() == 'gioi-thieu') ? 'active' : ''; ?>">
                        <i class="fas fa-shield-alt nav-icon-m"></i>
                        <span>Về chúng tôi</span>
                    </a>
                </li>

                <!-- Liên hệ -->
                <li class="nav-item-m">
                    <a href="<?php echo base_url('lien-he'); ?>" class="nav-link-m <?php echo (uri_string() == 'lien-he') ? 'active' : ''; ?>">
                        <i class="fas fa-headset nav-icon-m"></i>
                        <span>Liên hệ & Hỗ trợ</span>
                    </a>
                </li>
            </ul>
        </div>

    </div>
</div>

<style>
/* CSS Thanh Điều Hướng Hiện Đại (Modern Navigation Bar) */
.main-navigation-bar {
    background: linear-gradient(90deg, #d70018 0%, #b80014 100%) !important;
    box-shadow: 0 4px 15px rgba(215, 0, 24, 0.2) !important;
    position: relative !important;
    z-index: 1000 !important;
    overflow: visible !important;
}

.main-navigation-bar .container {
    max-width: 1360px !important;
    width: 100% !important;
    padding-left: 10px !important;
    padding-right: 10px !important;
}

.desktop-nav-wrapper {
    width: 100% !important;
    overflow: visible !important;
}

.nav-links-modern {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
    gap: 2px !important;
    flex-wrap: nowrap !important;
}

.nav-item-m {
    position: relative;
    flex-shrink: 0 !important;
}

.nav-link-m {
    display: inline-flex !important;
    align-items: center !important;
    gap: 6px !important;
    color: #ffffff !important;
    text-decoration: none !important;
    font-size: 13px !important;
    font-weight: 600 !important;
    padding: 12px 11px !important;
    border-radius: 6px !important;
    transition: all 0.25s ease !important;
    letter-spacing: 0.1px;
    white-space: nowrap !important;
}

.nav-link-m span {
    white-space: nowrap !important;
    display: inline-block !important;
}

.nav-icon-m {
    font-size: 13.5px;
    opacity: 0.95;
    flex-shrink: 0;
}

.nav-arrow {
    font-size: 10px;
    margin-left: 2px;
    transition: transform 0.25s ease;
    opacity: 0.8;
}

/* Hover & Active Effects */
.nav-link-m:hover,
.nav-item-m:hover > .nav-link-m,
.nav-link-m.active {
    background: rgba(0, 0, 0, 0.18) !important;
    color: #ffffff !important;
}

.nav-item-m:hover .nav-arrow {
    transform: rotate(180deg);
}

/* Dropdown Menu Đẳng Cấp */
.nav-dropdown-menu {
    position: absolute !important;
    top: 100% !important;
    left: 0 !important;
    min-width: 380px !important;
    background: #ffffff !important;
    border-radius: 12px !important;
    box-shadow: 0 14px 35px rgba(0,0,0,0.22) !important;
    border: 1px solid #e2e8f0 !important;
    padding: 16px !important;
    display: none !important;
    z-index: 999999 !important;
}

/* Cầu nối hover để chuột rê xuống không bị mất */
.nav-dropdown-menu::before {
    content: '';
    position: absolute;
    top: -10px;
    left: 0;
    width: 100%;
    height: 12px;
    background: transparent;
}

.nav-item-m:hover .nav-dropdown-menu,
.nav-item-m.has-dropdown:hover .nav-dropdown-menu {
    display: block !important;
    animation: fadeInDownMenu 0.2s cubic-bezier(0.165, 0.84, 0.44, 1) forwards !important;
}

@keyframes fadeInDownMenu {
    from {
        opacity: 0;
        transform: translateY(8px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dropdown-heading {
    font-size: 11.5px;
    font-weight: 700;
    text-transform: uppercase;
    color: #d70018;
    letter-spacing: 0.8px;
    padding-bottom: 8px;
    border-bottom: 1.5px solid #f2f2f2;
    margin-bottom: 10px;
}

.sub-links-grid {
    list-style: none;
    margin: 0;
    padding: 0;
    display: grid !important;
    grid-template-columns: repeat(2, 1fr) !important;
    gap: 6px 12px !important;
}

.sub-links-grid li a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 12px;
    border-radius: 6px;
    color: #333 !important;
    font-size: 13.5px;
    font-weight: 600;
    text-decoration: none !important;
    transition: all 0.2s ease;
}

.sub-links-grid li a:hover {
    background: #fff5f5;
    color: #d70018 !important;
    padding-left: 16px;
}

.sub-links-grid li a i {
    font-size: 11px;
    color: #bbb;
    transition: transform 0.2s ease, color 0.2s ease;
}

.sub-links-grid li a:hover {
    background: #fff5f5;
    color: #d70018 !important;
    padding-left: 22px;
}

.sub-links-grid li a:hover i {
    color: #d70018;
    transform: translateX(3px);
}

/* Mobile Toggle */
.mobile-nav-toggle {
    padding: 10px 0;
}
.btn-mobile-toggle {
    width: 100%;
    background: rgba(0,0,0,0.15);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    padding: 10px 15px;
    border-radius: 6px;
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 10px;
}
.mobile-menu-list {
    list-style: none;
    padding: 10px 0 0 0;
    margin: 0;
    background: #fff;
    border-radius: 8px;
    margin-top: 8px;
    overflow: hidden;
}
.mobile-menu-list li a {
    display: block;
    padding: 12px 18px;
    color: #333;
    border-bottom: 1px solid #f5f5f5;
    font-weight: 600;
    text-decoration: none;
}
.mobile-menu-list li a:hover {
    background: #f8f9fa;
    color: #d70018;
}
</style>