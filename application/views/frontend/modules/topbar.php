<section id="topbar" class="hidden-xs" style="background: #f8f9fa; border-bottom: 1px solid #eee; padding: 5px 0; font-size: 13px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-sm-6 text-left">
                <span style="margin-right: 20px;"><a href="tel:0794358619" style="color: inherit; text-decoration: none;"><i class="fas fa-phone-alt" style="color: #d70018;"></i> 0794358619</a></span>
                <span><a href="mailto:phambanam385@gmail.com" onclick="openEmailModal(event, 'phambanam385@gmail.com')" style="color: inherit; text-decoration: none;"><i class="fas fa-envelope" style="color: #d70018;"></i> phambanam385@gmail.com</a></span>
            </div>
            <div class="col-md-6 col-sm-6 text-right">
                <ul class="list-inline" style="margin-bottom: 0;">
                    <?php 
                    if($this->session->userdata('sessionadmin')){
                        $admin = $this->session->userdata('sessionadmin');
                        $admin_name = $admin['fullname'] ?? 'Admin';
                        echo "<li><a href='".base_url('admin')."' style='color: #d70018; font-weight: bold;'><i class='fas fa-user-shield'></i> Quản trị: $admin_name</a></li>";
                        echo "<li><a href='".base_url('admin/user/logout')."' style='color: #64748b;'><i class='fas fa-sign-out-alt'></i> [ Đăng xuất Admin ]</a></li>";
                    } elseif($this->session->userdata('sessionKhachHang')){
                        $name = $this->session->userdata('fullname');
                        echo "<li><a href='".base_url('thong-tin-khach-hang')."' style='color: #333;'><i class='fas fa-user-circle'></i> Xin chào: $name</a></li>";
                        echo "<li><a href='".base_url('dang-xuat')."' style='color: #d70018;'><i class='fas fa-sign-out-alt'></i> [ Thoát ]</a></li>";
                    } else {
                        echo "<li><a href='".base_url('dang-ky')."' style='color: #333;'><i class='fas fa-user-plus'></i> Đăng ký</a></li>";
                        echo "<li><a href='".base_url('dang-nhap')."' style='color: #333;'><i class='fas fa-sign-in-alt'></i> Đăng nhập</a></li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</section>