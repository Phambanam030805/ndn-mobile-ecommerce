<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| CẤU HÌNH KẾT NỐI DATABASE - DỰ ÁN NDNMOBILE
| -------------------------------------------------------------------
*/

$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'      => '',
    'hostname'  => 'localhost',    // Máy chủ chứa database (mặc định XAMPP là localhost)
    'username'  => 'root',         // Tên đăng nhập database (mặc định XAMPP là root)
    'password'  => '',             // Mật khẩu (mặc định XAMPP để trống)
    'database'  => 'db_shop',      // Tên Database của bạn (phải khớp trong phpMyAdmin)
    'dbdriver'  => 'mysqli',       // Trình điều khiển kết nối
    'dbprefix'  => '',             // Tiền tố bảng (thường để trống)
    'pconnect'  => FALSE,          // Kết nối liên tục (thường để FALSE)
    
    // Hiện lỗi SQL khi đang làm bài (development) để dễ sửa
    'db_debug'  => (ENVIRONMENT !== 'production'), 
    
    'cache_on'  => FALSE,          // Bật/tắt bộ nhớ đệm
    'cachedir'  => '',
    'char_set'  => 'utf8',         // Bộ mã tiếng Việt
    'dbcollat'  => 'utf8_unicode_ci', // Kiểu so khớp tiếng Việt
    'swap_pre'  => '',
    'encrypt'   => FALSE,
    'compress'  => FALSE,
    'stricton'  => FALSE,
    'failover'  => array(),
    'save_queries' => TRUE,        // Lưu lại các câu lệnh SQL để kiểm tra lỗi
    'port'      => 3306            // Cổng mặc định của MySQL trên XAMPP
);