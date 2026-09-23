<section class="logo-search-wrapper" style="background: #fff; padding: 15px 0;">
  <div class="container">
    <div class="row display-flex-center">
      <!-- Logo -->
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 logo-box">
        <a href="<?php echo base_url() ?>">
            <img src="<?php echo base_url() ?>public/images/smart-mobi2.png" alt="Logo" class="img-responsive">
        </a>
      </div>
      
      <!-- Search -->
      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 search-box">
        <form action="<?php echo base_url('search'); ?>" method="get" class="search-form-modern">
          <div class="input-group">
            <input type="text" name="search" class="form-control input-search-modern" placeholder="Bạn tìm gì hôm nay?">
            <span class="input-group-btn">
              <button class="btn btn-search-modern" type="submit">
                <i class="fa fa-search"></i>
              </button>
            </span>
          </div>
        </form>
      </div>
      
      <!-- Cart & Account Quick View -->
      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 header-right">
        <div class="cart-account-wrapper">
            <!-- Account -->
            <div class="account-item">
                <a href="<?php echo base_url('thong-tin-khach-hang'); ?>" class="header-icon-link">
                    <i class="fas fa-user-circle icon-main"></i>
                    <div class="text-box hidden-sm hidden-xs">
                        <span class="top-text">Tài khoản</span>
                        <span class="bottom-text">Cá nhân</span>
                    </div>
                </a>
            </div>

            <!-- Cart -->
            <div class="cart-item-header">
                <a href="<?php echo base_url('gio-hang'); ?>" class="header-icon-link">
                    <div class="icon-with-badge">
                        <i class="fa fa-shopping-bag icon-main"></i>
                        <span class="badge-count" id="cart-count">
                            <?php echo ($this->session->userdata('cart')) ? count($this->session->userdata('cart')) : 0; ?>
                        </span>
                    </div>
                    <div class="text-box hidden-sm hidden-xs">
                        <span class="top-text">Giỏ hàng</span>
                        <span class="bottom-text" id="cart-total">
                            <?php 
                            if($this->session->userdata('cart')){
                                $this->load->model('frontend/Msanpham');
                                $cart = $this->session->userdata('cart');
                                $money = 0;
                                foreach ($cart as $key => $value) {
                                    $row = $this->Msanpham->product_detail_id($key);
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
    </div>
  </div>
</section>