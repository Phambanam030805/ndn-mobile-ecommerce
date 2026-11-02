<section class="logo-search-wrapper" style="background: #fff; padding: 14px 0; border-bottom: 1px solid #ebebeb;">
  <div class="container">
    <div class="header-main-grid">
      
      <!-- 1. Logo NDN Mobile Tối Giản Hiện Đại -->
      <div class="header-logo-area">
        <a href="<?php echo base_url(); ?>" class="modern-brand-logo" title="Trang chủ NDN Mobile">
          <div class="brand-icon-shape">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <rect x="5" y="2" width="14" height="20" rx="3.5" stroke="#fff" stroke-width="2"/>
              <line x1="10" y1="18" x2="14" y2="18" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
              <circle cx="12" cy="5" r="1" fill="#fff"/>
            </svg>
          </div>
          <div class="brand-text-wrapper">
            <span class="brand-main">NDN<span class="brand-dot">.</span></span>
            <span class="brand-sub">MOBILE</span>
          </div>
        </a>
      </div>
      
      <!-- 2. Khung Tìm Kiếm Tối Ưu -->
      <div class="header-search-area">
        <form action="<?php echo base_url('search'); ?>" method="get" class="search-form-clean">
          <div class="search-input-box">
            <input type="text" name="search" class="search-field" placeholder="Bạn tìm điện thoại gì hôm nay? (iPhone, Samsung, Xiaomi, OPPO...)" autocomplete="off">
            <button class="search-submit-btn" type="submit" title="Tìm kiếm">
              <i class="fa fa-search"></i>
            </button>
          </div>
        </form>
      </div>
      
      <!-- 3. Cụm Tiện Ích Hiện Đại (Tài khoản, Yêu thích, So sánh, Giỏ hàng) -->
      <div class="header-actions-area">
        
        <!-- Yêu thích -->
        <a href="<?php echo base_url('yeu-thich'); ?>" class="header-btn-item" title="Xem danh sách yêu thích">
            <div class="btn-icon-wrapper">
                <i class="fas fa-heart text-danger"></i>
                <span class="count-badge badge-red" id="wishlist-count">
                    <?php 
                    if($this->session->userdata('sessionKhachHang')){
                        $user_id = $this->session->userdata('id');
                        echo $this->db->where('user_id', $user_id)->count_all_results('wishlists');
                    } else {
                        echo 0;
                    }
                    ?>
                </span>
            </div>
            <div class="btn-text-content">
                <span class="btn-title">Yêu thích</span>
            </div>
        </a>

        <!-- So sánh -->
        <a href="<?php echo base_url('so-sanh'); ?>" class="header-btn-item" title="Xem bảng so sánh sản phẩm">
            <div class="btn-icon-wrapper">
                <i class="fas fa-exchange-alt text-primary"></i>
                <span class="count-badge badge-blue" id="compare-count">
                    <?php 
                    $compare_list = $this->session->userdata('compare_list');
                    echo !empty($compare_list) ? count($compare_list) : 0;
                    ?>
                </span>
            </div>
            <div class="btn-text-content">
                <span class="btn-title">So sánh</span>
            </div>
        </a>

        <!-- Giỏ hàng -->
        <a href="<?php echo base_url('gio-hang'); ?>" class="header-btn-item header-cart-pill" title="Xem giỏ hàng">
            <div class="btn-icon-wrapper">
                <i class="fas fa-shopping-bag"></i>
                <span class="count-badge badge-cart" id="cart-count">
                    <?php echo ($this->session->userdata('cart')) ? count($this->session->userdata('cart')) : 0; ?>
                </span>
            </div>
            <div class="btn-text-content">
                <span class="btn-title">Giỏ hàng</span>
                <span class="btn-subtitle" id="cart-total">
                    <?php 
                    if($this->session->userdata('cart')){
                        $this->load->model('frontend/Msanpham');
                        $cart = $this->session->userdata('cart');
                        $cart_info = $this->session->userdata('cart_info') ?? [];
                        $money = 0;
                        foreach ($cart as $key => $value) {
                            $prod_id = isset($cart_info[$key]['id']) ? $cart_info[$key]['id'] : (is_numeric($key) ? $key : explode('_', $key)[0]);
                            $row = $this->Msanpham->product_detail_id($prod_id);
                            if ($row) {
                                $money += ($row['price_sale'] > 0 ? $row['price_sale'] : $row['price']) * $value;
                            }
                        }
                        echo number_format($money).' đ';
                    } else {
                        echo '0 đ';
                    }
                    ?>
                </span>
            </div>
        </a>

      </div>
    </div>
  </div>
</section>

<style>
/* CSS Độc Quyền Header: Dùng CSS Flexbox thay vì Bootstrap Grid để cố định tỷ lệ chuẩn 100% */
.header-main-grid {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    width: 100% !important;
    gap: 30px !important;
}

/* 1. Logo NDN Mobile Tối Giản Hiện Đại */
.header-logo-area {
    flex: 0 0 190px !important;
    max-width: 190px !important;
}
.modern-brand-logo {
    display: inline-flex !important;
    align-items: center !important;
    gap: 10px !important;
    text-decoration: none !important;
    user-select: none;
    transition: transform 0.2s ease;
}
.modern-brand-logo:hover {
    transform: scale(1.02);
}
.brand-icon-shape {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: linear-gradient(135deg, #d70018 0%, #b30014 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 10px rgba(215, 0, 24, 0.25);
    flex-shrink: 0;
}
.brand-text-wrapper {
    display: flex;
    flex-direction: column;
    line-height: 1;
}
.brand-main {
    font-size: 22px;
    font-weight: 900;
    letter-spacing: -0.5px;
    color: #1a1a1a;
    font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
}
.brand-dot {
    color: #d70018;
}
.brand-sub {
    font-size: 9.5px;
    font-weight: 700;
    letter-spacing: 2.5px;
    color: #d70018;
    margin-top: 3px;
}

/* 2. Thanh tìm kiếm */
.header-search-area {
    flex: 1 1 auto !important;
    max-width: 460px !important;
}
.search-form-clean {
    margin: 0 !important;
    width: 100% !important;
}
.search-input-box {
    display: flex !important;
    align-items: center !important;
    background: #f5f5f7 !important;
    border: 1.5px solid #e0e0e0 !important;
    border-radius: 25px !important;
    padding: 3px 5px 3px 18px !important;
    transition: all 0.3s ease !important;
}
.search-input-box:focus-within {
    border-color: #d70018 !important;
    background: #fff !important;
    box-shadow: 0 0 0 3px rgba(215, 0, 24, 0.1) !important;
}
.search-field {
    flex: 1 !important;
    border: none !important;
    outline: none !important;
    background: transparent !important;
    height: 34px !important;
    font-size: 13px !important;
    color: #333 !important;
    padding: 0 !important;
}
.search-submit-btn {
    border: none !important;
    outline: none !important;
    background: #d70018 !important;
    color: #fff !important;
    width: 34px !important;
    height: 34px !important;
    border-radius: 50% !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    cursor: pointer !important;
    transition: transform 0.2s ease !important;
    font-size: 13px !important;
}
.search-submit-btn:hover {
    transform: scale(1.05) !important;
}

/* 3. Cụm Tiện Ích Phải */
.header-actions-area {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 20px !important;
    flex-shrink: 0 !important;
}

.header-btn-item {
    display: inline-flex !important;
    align-items: center !important;
    gap: 8px !important;
    text-decoration: none !important;
    color: #333 !important;
    padding: 6px 10px !important;
    border-radius: 10px !important;
    transition: background 0.2s ease, transform 0.15s ease !important;
}
.header-btn-item:hover {
    background: #f7f7f7 !important;
    color: #d70018 !important;
    transform: translateY(-1px) !important;
}

/* Icon tròn viền tinh tế */
.btn-icon-wrapper {
    position: relative !important;
    width: 36px !important;
    height: 36px !important;
    border-radius: 50% !important;
    background: #f3f4f6 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    font-size: 16px !important;
    flex-shrink: 0 !important;
}

/* Badge số lượng nổi */
.count-badge {
    position: absolute !important;
    top: -4px !important;
    right: -6px !important;
    font-size: 10px !important;
    font-weight: 700 !important;
    min-width: 17px !important;
    height: 17px !important;
    line-height: 15px !important;
    text-align: center !important;
    border-radius: 10px !important;
    padding: 0 4px !important;
    border: 2px solid #fff !important;
}
.badge-red {
    background: #e74c3c !important;
    color: #fff !important;
}
.badge-blue {
    background: #2980b9 !important;
    color: #fff !important;
}
.badge-cart {
    background: #d70018 !important;
    color: #fff !important;
}

/* Text nội dung nút */
.btn-text-content {
    display: flex !important;
    flex-direction: column !important;
    line-height: 1.2 !important;
    text-align: left !important;
}
.btn-title {
    font-size: 13px !important;
    font-weight: 600 !important;
}
.btn-subtitle {
    font-size: 11px !important;
    color: #d70018 !important;
    font-weight: 700 !important;
}

/* Nút Giỏ Hàng nổi bật hơn */
.header-cart-pill {
    background: #fff5f5 !important;
    border: 1px solid #ffe3e3 !important;
}
.header-cart-pill .btn-icon-wrapper {
    background: #ffe5e5 !important;
    color: #d70018 !important;
}
.header-cart-pill:hover {
    background: #ffe8e8 !important;
}

/* Reponsive */
@media (max-width: 991px) {
    .header-main-grid {
        flex-wrap: wrap !important;
        gap: 15px !important;
        justify-content: center !important;
    }
    .header-logo-area {
        flex: 0 0 100% !important;
        max-width: 100% !important;
        text-align: center !important;
    }
    .header-logo-img {
        margin: 0 auto !important;
    }
    .header-search-area {
        flex: 0 0 100% !important;
        max-width: 100% !important;
    }
    .header-actions-area {
        flex: 0 0 100% !important;
        justify-content: center !important;
        gap: 10px !important;
    }
}
</style>