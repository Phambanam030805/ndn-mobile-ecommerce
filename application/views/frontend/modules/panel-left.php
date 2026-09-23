<div class="menu-pri modern-main-menu">
    <div class="container">
        <div class="panel-left hidden-md hidden-lg">
            <!--MOBILE-->
            <nav class="navbar navbar-default hidden-md hidden-lg" role="navigation">
                <div class="container-fluid" style="background-color: #0f9ed8;">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar primary-color"></span>
                            <span class="icon-bar primary-color"></span>
                            <span class="icon-bar primary-color"></span>
                        </button>
                        <a class="navbar-brand" style="color: #fff;" href="#">Danh mục sản phẩm</a>
                    </div>
                    <div class="collapse navbar-collapse navbar-ex1-collapse hidden-md hidden-lg">

                        <?php
                        $listcat = $this->Mdanhmuc->category_menu(0);
                        $html_menu='<ul class="nav navbar-nav">';
                        foreach ($listcat as $menu) {
                            $parentid = $menu['id'];
                            $submenu = $this->Mdanhmuc->category_menu($parentid);
                            $html_menu.='<li class="dropdown">';
                            $html_menu.="<a href='".base_url()."san-pham/".$menu['link']."' class='dropdown-toggle' data-toggle='dropdown'>";
                            $html_menu.=$menu['name'];
                            if(!empty($submenu)){
                                $html_menu.='<i class="fa fa-angle-right pull-right" aria-hidden="true">';
                                $html_menu.='</i>';
                            }
                            $html_menu.="</a>";
                            if(count($submenu))
                            {
                                $html_menu.='<ul class="dropdown-menu">';
                                foreach ($submenu as $menu1){
                                    $html_menu.='<li>';
                                    $html_menu.="<a href='".base_url()."san-pham/".$menu1['link']."'> ".$menu1['name']."</a>";
                                    $html_menu.="</li>";    
                                }
                                $html_menu.="</ul>";
                            }
                            $html_menu.="</li>";
                        }
                        $html_menu.="</ul>";
                        echo $html_menu;
                        ?>  
                    </div><!-- /.navbar-collapse -->
                </div>
            </nav>
            <!--MD LG-->
        </div>
<div class="col-md-12 col-lg-12 panel-right hidden-xs" style="width: 100% !important; float: none !important; padding: 0 !important;">
<ul class="menu-right modern-nav-list" style="display: flex !important; justify-content: center !important; align-items: center !important; margin: 0; padding: 0; list-style: none; width: 100%; gap: 20px;">
        <li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
        
        <li><a href="<?php echo base_url('san-pham'); ?>">Sản phẩm</a></li>
        
        <?php
        $listcat = $this->Mdanhmuc->category_menu(0);
        foreach ($listcat as $menu) {
            echo '<li>';
            echo "<a href='".base_url('san-pham/'.$menu['link'])."'>";
            echo $menu['name'];
            echo "</a>";
            echo '</li>';
        }
        ?>
        
        <li><a href="<?php echo base_url('tin-tuc/1'); ?>">Tin tức</a></li>
        <li><a href="<?php echo base_url('gioi-thieu'); ?>">Giới thiệu</a></li>
        <li><a href="<?php echo base_url('lien-he'); ?>">Liên hệ</a></li>
    </ul>
</div>
    </div>
</div>