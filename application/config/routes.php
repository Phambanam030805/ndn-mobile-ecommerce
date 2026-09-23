<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'trangchu/index';
$route['trang-chu'] = 'trangchu/index';

// --- ROUTE SẢN PHẨM ---
$route['san-pham/(:num)'] = 'sanpham/index/$1';
$route['san-pham/(:any)/(:num)'] = 'sanpham/category/$1/$2';
$route['san-pham/(:any)'] = 'sanpham/category/$1';
$route['san-pham'] = 'sanpham/index';
$route['chi-tiet/(:any)'] = 'sanpham/detail/$1';

// --- ROUTE TIN TỨC ---
$route['tin-tuc/(:num)'] = 'tintuc/index/$1';
$route['tin-tuc/(:any)'] = 'tintuc/detail/$1';
$route['tin-tuc'] = 'tintuc/index';

// --- ROUTE TÌM KIẾM ---
$route['search/(:any)/(:num)'] = 'search/index';
$route['search/(:any)'] = 'search/index';
$route['search'] = 'search';

$route['lien-he'] = 'lienhe/index';
$route['dang-nhap'] = 'dangnhap/dangnhap';
$route['quen-mat-khau'] = 'dangnhap/forget_password';
$route['dang-ky'] = 'dangnhap/dangky';
$route['dang-xuat'] = 'dangnhap/dangxuat';
$route['gio-hang'] = 'giohang/index';
$route['checkout'] = 'giohang/checkout';
$route['info-order'] = 'giohang/info_order';
$route['thankyou'] = 'giohang/thankyou';
$route['thong-tin-khach-hang'] = 'thongtin/index';
$route['gioi-thieu'] = 'gioithieu/index';

// --- TÀI KHOẢN ---
$route['account/orders/(:num)'] = 'thongtin/order';
$route['account/orders/update/(:num)'] = 'thongtin/update/$1';
$route['reset_password'] = 'thongtin/reset_password';

// --- ADMIN DASHBOARD ---
$route['admin'] = 'admin/dashboard';

// --- TÀI KHOẢN ADMIN ---
$route['admin/user/login'] = 'admin/user/login';
$route['admin/user/logout'] = 'admin/user/logout';
$route['admin/user/logout.html'] = 'admin/user/logout';

// --- QUẢN LÝ COUPON ---
$route['admin/coupon'] ='admin/coupon';
$route['admin/coupon/(:num)'] ='admin/coupon/index/$1';
$route['admin/coupon/insert'] ='admin/coupon/insert';
$route['admin/coupon/update/(:num)'] ='admin/coupon/update/$1';
$route['admin/coupon/status/(:num)'] ='admin/coupon/status/$1';
$route['admin/coupon/recyclebin'] ='admin/coupon/recyclebin';
$route['admin/coupon/recyclebin/(:num)'] ='admin/coupon/recyclebin/$1';
$route['admin/coupon/trash/(:num)'] ='admin/coupon/trash/$1';
$route['admin/coupon/delete/(:num)'] ='admin/coupon/delete/$1';
$route['admin/coupon/restore/(:num)'] ='admin/coupon/restore/$1';

// --- QUẢN LÝ SẢN PHẨM ---
$route['admin/product'] ='admin/product';
$route['admin/product/(:num)'] ='admin/product/index/$1';
$route['product/insert'] ='admin/product/insert';
$route['product/status/(:num)'] ='admin/product/status/$1';
$route['product/update/(:num)'] ='admin/product/update/$1';
$route['product/import/(:num)'] ='admin/product/import/$1';
$route['product/recyclebin'] ='admin/product/recyclebin';
$route['product/trash/(:num)'] ='admin/product/trash/$1';
$route['product/recyclebin/(:num)'] ='admin/product/recyclebin/$1';

// --- QUẢN LÝ NHÀ SẢN XUẤT ---
$route['admin/producer'] ='admin/producer';
$route['admin/producer/(:num)'] ='admin/producer/index/$1';
$route['producer/insert'] ='admin/producer/insert';
$route['producer/status/(:num)'] ='admin/producer/status/$1';
$route['producer/update/(:num)'] ='admin/producer/update/$1';
$route['producer/recyclebin'] ='admin/producer/recyclebin';
$route['producer/trash/(:num)'] ='admin/producer/trash/$1';
$route['producer/recyclebin/(:num)'] ='admin/producer/recyclebin/$1';

// --- QUẢN LÝ DANH MỤC ---
$route['admin/category'] ='admin/category';
$route['admin/category/(:num)'] ='admin/category/index/$1';
$route['category/insert'] ='admin/category/insert';
$route['category/update/(:num)'] ='admin/category/update/$1';
$route['category/status/(:num)'] ='admin/category/status/$1';
$route['category/recyclebin'] ='admin/category/recyclebin';
$route['category/recyclebin/(:num)'] ='admin/category/recyclebin/$1';
$route['category/trash/(:num)'] ='admin/category/trash/$1';
$route['category/delete/(:num)'] ='admin/category/delete/$1';
$route['category/restore/(:num)'] ='admin/category/restore/$1';

// --- QUẢN LÝ BÀI VIẾT ---
$route['admin/content'] ='admin/content';
$route['admin/content/(:num)'] ='admin/content/index/$1';
$route['admin/content/update/(:num)'] ='admin/content/update/$1';
$route['admin/content/status/(:num)'] ='admin/content/status/$1';
$route['admin/content/insert'] ='admin/content/insert';
$route['admin/content/recyclebin'] ='admin/content/recyclebin';
$route['admin/content/recyclebin/(:num)'] ='admin/content/recyclebin/$1';
$route['admin/content/trash/(:num)'] ='admin/content/trash/$1';
$route['admin/content/delete/(:num)'] ='admin/content/delete/$1';
$route['admin/content/restore/(:num)'] ='admin/content/restore/$1';

// --- QUẢN LÝ SLIDERS ---
$route['admin/sliders'] ='admin/sliders';
$route['admin/sliders/(:num)'] ='admin/sliders/index/$1';
$route['admin/sliders/insert'] ='admin/sliders/insert';
$route['sliders/update/(:num)'] ='admin/sliders/update/$1';
$route['sliders/status/(:num)'] ='admin/sliders/status/$1';
$route['sliders/recyclebin'] ='admin/sliders/recyclebin';
$route['sliders/recyclebin/(:num)'] ='admin/sliders/recyclebin/$1';
$route['sliders/trash/(:num)'] ='admin/sliders/trash/$1';
$route['sliders/delete/(:num)'] ='admin/sliders/delete/$1';
$route['sliders/restore/(:num)'] ='admin/sliders/restore/$1';

// --- QUẢN LÝ KHÁCH HÀNG ---
$route['admin/customer'] ='admin/customer';
$route['admin/customer/(:num)'] ='admin/customer/index/$1';
$route['customer/update/(:num)'] ='admin/customer/update/$1';
$route['customer/status/(:num)'] ='admin/customer/status/$1';
$route['customer/recyclebin'] ='admin/customer/recyclebin';
$route['customer/recyclebin/(:num)'] ='admin/customer/recyclebin/$1';
$route['customer/trash/(:num)'] ='admin/customer/trash/$1';
$route['customer/delete/(:num)'] ='admin/customer/delete/$1';
$route['customer/restore/(:num)'] ='admin/customer/restore/$1';

// --- QUẢN LÝ ĐƠN HÀNG ---
$route['admin/orders'] ='admin/orders';
$route['admin/orders/(:num)'] ='admin/orders/index/$1';

// --- QUẢN LÝ NHÂN VIÊN ---
$route['admin/useradmin']='admin/useradmin/index';
$route['admin/useradmin/(:num)'] ='admin/useradmin/index/$1';
$route['useradmin/insert']='admin/useradmin/insert';

// --- QUẢN LÝ LIÊN HỆ ---
$route['admin/contact'] ='admin/contact/index';
$route['admin/contact/detail/(:num)'] ='admin/contact/detail/$1';
$route['admin/contact/(:num)'] ='admin/contact/index/$1';
$route['admin/contact/recyclebin'] ='admin/contact/recyclebin';

// --- QUẢN LÝ ĐÁNH GIÁ ---
$route['admin/reviews'] ='admin/reviews';
$route['admin/reviews/(:num)'] ='admin/reviews/index/$1';
$route['admin/reviews/status/(:num)'] ='admin/reviews/status/$1';
$route['admin/reviews/recyclebin'] ='admin/reviews/recyclebin';
$route['admin/reviews/recyclebin/(:num)'] ='admin/reviews/recyclebin/$1';
$route['admin/reviews/trash/(:num)'] ='admin/reviews/trash/$1';
$route['admin/reviews/restore/(:num)'] ='admin/reviews/restore/$1';
$route['admin/reviews/delete/(:num)'] ='admin/reviews/delete/$1';

// --- LỖI VÀ MẶC ĐỊNH ---
$route['admin/(:any)']='admin/E403/index';
$route['admin/403']='admin/E403/index';
$route['404_override'] = 'Error404';

$route['translate_uri_dashes'] = FALSE;

// Chi tiết sản phẩm (Đặt cuối cùng để không tranh chấp với các trang khác)
$route['(:any)'] = 'sanpham/detail/$1';
