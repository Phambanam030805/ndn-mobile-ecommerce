<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Định dạng tiền tệ VNĐ
 */
if ( ! function_exists('render_price')) {
    function render_price($price) {
        return number_format($price) . ' ₫';
    }
}

/**
 * Rút gọn văn bản (Dùng cho mô tả ngắn sản phẩm hoặc tin tức)
 */
if ( ! function_exists('word_limiter_custom')) {
    function word_limiter_custom($str, $limit = 20) {
        $str = strip_tags($str);
        if (str_word_count($str, 0) > $limit) {
            $words = str_word_count($str, 2);
            $pos = array_keys($words);
            $str = substr($str, 0, $pos[$limit]) . '...';
        }
        return $str;
    }
}

/**
 * Hiển thị trạng thái đơn hàng bằng Badge màu sắc (Dùng cho Admin)
 */
if ( ! function_exists('render_order_status')) {
    function render_order_status($status) {
        switch ($status) {
            case 0: return '<span class="label label-warning">Chưa kiểm tra</span>';
            case 1: return '<span class="label label-primary">Đang xử lý</span>';
            case 2: return '<span class="label label-success">Đã giao hàng</span>';
            case 3: return '<span class="label label-danger">Đã hủy</span>';
            default: return '<span class="label label-default">Không xác định</span>';
        }
    }
}
