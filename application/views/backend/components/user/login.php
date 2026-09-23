<html lang="">
	<head>
        <base href="<?php echo base_url(); ?>"></base>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Hệ thống quản lý cơ sở dữ liệu</title>
        <link rel="shortcut icon" href="public/images/templates/favicon.png" />
		<link rel="stylesheet" href="public/css/bootstrap.css">
		<link rel="stylesheet" href="public/css/login.css">
		<link rel="stylesheet" href="public/css/font-awesome.min.css">

        <style>
            body {
                background: #ffecec; /* đỏ nhạt mờ nhẹ */
            }
            h2 {
                color: #e60000 !important; /* màu đỏ thương hiệu cho tiêu đề */
                font-weight: bold;
            }
            .btn-login {
                background-color: #e60000 !important;
                border: none !important;
                font-weight: bold;
            }
            .btn-login:hover {
                background-color: #cc0000 !important; /* đậm hơn khi hover */
            }
        </style>
    </head>

    <body>
        <div class="container khung">
            <div class="title">
                <h2 class="text-center">NDN Mobile</h2>
            </div>
            <hr>
            <div class="myform">
                <?php echo form_open('admin/user/login', array('name' => 'form1', 'role' => 'form')); ?>
                    <div class="row form-row">
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                           <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập">
                        </div>
                        <div class="error" id="password_error"><?php echo form_error('username')?></div>
                    </div>
                    <div class="row form-row">
                        <div class="input-group">
                           <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                           <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                        </div>
                        <div class="error" id="password_error"><?php echo form_error('password')?></div>
                    </div>
                    <div class="row form-row" style="width:100%; margin-top: 15px;">
                        <button type="submit" class="form-control btn btn-primary btn-login">Đăng nhập</button>
                    </div>
                    <?php  if(isset($error)):?>
                        <div class="row">
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            </div>
                        </div>
                    <?php  endif;?>
                <?php echo form_close(); ?>
            </div>
            <hr>
        </div>

        <nav class="navbar navbar-fixed-bottom" role="navigation">
            <div class="container">
               <h5 class="text-center" style="color:#333;">
                   Copyright © 2025 
                   <a href="#" style="color:#e60000; font-weight:bold; text-decoration:none;">
                       NDN Mobile
                   </a>
               </h5>
            </div>
        </nav>

        <!-- jQuery -->
        <script src="public/js/jquery-2.2.3.min.js"></script>
		<script src="public/js/bootstrap.js"></script>
	</body>
</html>
