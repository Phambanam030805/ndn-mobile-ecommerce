<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Thư viện tích hợp VNPay Payment Gateway
 * Phiên bản: VNPay API v2.1.0
 * 
 * Cần cấu hình trong Admin > Cấu hình hệ thống:
 * - vnpay_terminal_id (VNP_TMNCODE)
 * - vnpay_secret_key  (VNP_HASHSECRET)
 * - vnpay_api_url     (URL sandbox hoặc production)
 */
class Vnpay {

    // URL Sandbox (dùng khi test)
    const SANDBOX_URL   = 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html';
    // URL Production (dùng khi go-live)
    const PRODUCTION_URL = 'https://pay.vnpay.vn/vpcpay.html';

    /**
     * Tạo URL thanh toán VNPay
     *
     * @param array $params Gồm: order_id, amount, order_desc, return_url, tmncode, secret_key, is_sandbox
     * @return string URL redirect sang VNPay
     */
    public function create_payment_url(array $params): string
    {
        $vnp_TxnRef    = $params['order_id'];          // Mã đơn hàng
        $vnp_Amount    = $params['amount'] * 100;       // Số tiền x100 (VNPay tính đơn vị VNĐ x100)
        $vnp_OrderInfo = $params['order_desc'];         // Mô tả đơn hàng
        $vnp_ReturnUrl = $params['return_url'];         // URL nhận kết quả từ VNPay
        $vnp_TmnCode   = $params['tmncode'];            // Mã Terminal
        $vnp_HashSecret= $params['secret_key'];         // Khóa bí mật
        $vnp_Locale    = 'vn';                          // Ngôn ngữ: vn hoặc en
        $vnp_BankCode  = $params['bank_code'] ?? '';    // Mã ngân hàng (để trống = hiển thị tất cả)
        $vnp_IpAddr    = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $vnp_CreateDate= date('YmdHis');
        $vnp_ExpireDate= date('YmdHis', strtotime('+15 minutes'));

        // Tạo mảng input data
        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => "billpayment",
            "vnp_ReturnUrl"  => $vnp_ReturnUrl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
        ];

        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sắp xếp theo thứ tự alphabet (bắt buộc của VNPay)
        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        // Tạo chữ ký HMAC-SHA512
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // Chọn URL
        $base_url = isset($params['is_sandbox']) && $params['is_sandbox']
            ? self::SANDBOX_URL
            : self::PRODUCTION_URL;

        $vnpUrl = $base_url . '?' . $query . 'vnp_SecureHash=' . $vnp_SecureHash;

        return $vnpUrl;
    }

    /**
     * Xác minh chữ ký từ VNPay IPN/Return
     *
     * @param array  $vnp_data     Dữ liệu GET từ VNPay callback
     * @param string $secret_key   Khóa bí mật VNPay
     * @return bool  true nếu chữ ký hợp lệ
     */
    public function verify_signature(array $vnp_data, string $secret_key): bool
    {
        $vnp_SecureHash = $vnp_data['vnp_SecureHash'] ?? '';

        // Xóa các trường không dùng để tính hash
        unset($vnp_data['vnp_SecureHashType'], $vnp_data['vnp_SecureHash']);

        ksort($vnp_data);
        $hashData = '';
        $i = 0;
        foreach ($vnp_data as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
            } else {
                $hashData .= urlencode($key) . '=' . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $secret_key);
        return ($secureHash === $vnp_SecureHash);
    }

    /**
     * Lấy mô tả mã phản hồi từ VNPay
     *
     * @param string $code Mã phản hồi VNPay (vnp_ResponseCode)
     * @return string Mô tả tiếng Việt
     */
    public function get_response_message(string $code): string
    {
        $messages = [
            '00' => 'Giao dịch thành công',
            '07' => 'Trừ tiền thành công. Giao dịch bị nghi ngờ (liên hệ ngân hàng)',
            '09' => 'Thẻ/Tài khoản chưa đăng ký dịch vụ Internet Banking',
            '10' => 'Xác thực thông tin thẻ/tài khoản không đúng quá 3 lần',
            '11' => 'Đã hết hạn chờ thanh toán',
            '12' => 'Thẻ/Tài khoản bị khóa',
            '13' => 'Nhập sai mật khẩu OTP',
            '24' => 'Khách hàng hủy giao dịch',
            '51' => 'Tài khoản không đủ số dư',
            '65' => 'Vượt quá hạn mức giao dịch trong ngày',
            '75' => 'Ngân hàng thanh toán đang bảo trì',
            '79' => 'Nhập sai mật khẩu thanh toán quá số lần quy định',
            '99' => 'Lỗi không xác định',
        ];
        return $messages[$code] ?? 'Lỗi không xác định (mã: ' . $code . ')';
    }
}
