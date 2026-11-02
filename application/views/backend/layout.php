<!DOCTYPE html>
<html>
<head>
	<base href="<?php echo base_url(); ?>"></base>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title ?></title>
  <link rel="icon" type="image/svg+xml" href="<?php echo base_url('public/images/favicon.svg'); ?>">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="public/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="public/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="public/css/AdminLTE.css">
  <link rel="stylesheet" href="public/css/ionicons.min.css">
  <meta property="fb:app_id" content="659513967881060">
  
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="public/css/_all-skins.min.css">

  <!-- jQuery 2.2.3 -->
  <script src="public/js/jquery-2.2.3.min.js"></script>
  <script src="public/js/loader.js"></script>
  <script src="public/ckeditor/ckeditor.js"></script>
  <style>
    .content-header h1, th, label{
      color: #333;
    }
    label{font-weight: 600 !important;}
    .maudo{color: red}
    .mauxanh18{color: green;}

    /* CỐ ĐỊNH HEADER & CỘT MENU BÊN TRÁI (SIDEBAR) ĐỨNG YÊN, NỘI DUNG CUỘN ĐẦY ĐỦ TRÊN CẢ TRANG */
    html, body {
      min-height: 100% !important;
      height: auto !important;
      overflow-x: hidden !important;
      overflow-y: auto !important;
    }
    .wrapper {
      min-height: 100vh !important;
      height: auto !important;
      overflow: visible !important;
    }
    .main-header {
      position: fixed !important;
      top: 0;
      left: 0;
      right: 0;
      z-index: 1030;
    }
    .main-sidebar {
      position: fixed !important;
      top: 0;
      bottom: 0;
      left: 0;
      padding-top: 50px !important;
      height: 100vh !important;
      overflow-y: auto !important;
      z-index: 810;
    }
    /* Thanh cuộn mảnh cho menu bên trái */
    .main-sidebar::-webkit-scrollbar {
      width: 4px;
    }
    .main-sidebar::-webkit-scrollbar-thumb {
      background: rgba(255,255,255,0.2);
      border-radius: 4px;
    }
    .content-wrapper {
      padding-top: 50px !important;
      padding-bottom: 50px !important;
      margin-left: 250px !important;
      min-height: 100vh !important;
      height: auto !important;
      overflow: visible !important;
      transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }

    /* 📌 CỐ ĐỊNH HOÀN TOÀN TIÊU ĐỀ TRANG (CONTENT-HEADER) ĐỨNG IM NHƯ SIDEBAR */
    .content-header {
      position: fixed !important;
      top: 50px !important;
      left: 250px !important;
      right: 0 !important;
      height: 60px !important;
      z-index: 800 !important;
      background: #ecf0f5 !important;
      padding: 10px 25px !important;
      border-bottom: 1px solid #d2d6de !important;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04) !important;
      display: flex !important;
      align-items: center !important;
      justify-content: space-between !important;
      transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    body.sidebar-mini-active .content-header,
    .sidebar-collapse .content-header {
      left: 64px !important;
      padding-left: 25px !important;
    }
    .content-header > h1 {
      margin: 0 !important;
      line-height: 1 !important;
    }
    .content-header > .breadcrumb {
      position: static !important;
      top: auto !important;
      right: auto !important;
      float: none !important;
      margin: 0 !important;
      padding: 0 !important;
    }

    /* Chỉ đẩy phần nội dung xuống 60px đối với các trang có thanh .content-header */
    .content-header ~ .content,
    .content-header + .content {
      margin-top: 60px !important;
      padding: 15px 20px 40px !important;
    }

    /* Trang không có .content-header (như Dashboard) thì nội dung sát lên trên */
    .content {
      margin-top: 0 !important;
      padding: 15px 20px 40px !important;
    }

    /* Đảm bảo thẻ cha không có overflow ẩn làm mất tác dụng sticky */
    .content .row,
    .content .col-md-12,
    .content .col-lg-12 {
      overflow: visible !important;
    }

    /* 🔍 CỐ ĐỊNH HOÀN TOÀN THANH TÌM KIẾM & BỘ LỌC (TOOLBAR FILTER) ĐỨNG IM BẤT ĐỘNG */
    .filter-card-wrapper {
      position: fixed !important;
      top: 110px !important;
      left: 270px !important;
      right: 20px !important;
      height: 72px !important;
      z-index: 750 !important;
      background: #ffffff !important;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08) !important;
      border: 1px solid #cbd5e1 !important;
      border-radius: 12px !important;
      margin: 0 !important;
      padding: 15px 20px !important;
      display: flex !important;
      align-items: center !important;
      transition: left 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
    .filter-card-wrapper form {
      width: 100% !important;
    }

    /* Khi có thanh tìm kiếm cố định thì đẩy bảng dữ liệu xuống thêm 85px */
    .filter-card-wrapper ~ .box,
    .filter-card-wrapper + .box {
      margin-top: 85px !important;
    }

    @media (max-width: 767px) {
      .main-header .navbar {
        margin-left: 0 !important;
      }
      .content-header {
        left: 0 !important;
      }
      .content-wrapper {
        margin-left: 0 !important;
      }
      .filter-card-wrapper {
        position: static !important;
        left: 0 !important;
        right: 0 !important;
        height: auto !important;
      }
      .filter-card-wrapper ~ .box,
      .filter-card-wrapper + .box {
        margin-top: 15px !important;
      }
    }
  </style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">
    <!-- Vung Header -->
    <?php $this->load->view('backend/modules/header'); ?>


    <!-- ./Vung Header -->
    <?php $this->load->view('backend/modules/menu'); ?>
    <?php 
    if(isset($com, $view))
    {
      $this->load->view('backend/components/'.$com.'/'.$view);
    }

    ?>

  </div><!-- ./wrapper -->
  <!-- Bootstrap 3.3.6 -->
  <script src="public/js/bootstrap.js"></script>
  <!-- AdminLTE App -->
  <script src="public/js/app.min.js"></script>
</body>
</html>
