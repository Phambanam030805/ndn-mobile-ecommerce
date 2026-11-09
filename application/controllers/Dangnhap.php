<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Controller Đăng nhập / Đăng ký / Quên mật khẩu cho người dùng
 * CodeIgniter 3 - Hardened Security & Password Hashing Architecture
 *
 * @property CI_Loader $load
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_DB_query_builder $db
 * @property CI_Email $email
 * @property Mkhachhang $Mkhachhang
 * @property Mdanhmuc $Mdanhmuc
 * @property Mcauhinh $Mcauhinh
 * @property Msanpham $Msanpham
 * @property Mnguoidung $Mnguoidung
 * @property array $data
 */
class Dangnhap extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('frontend/Mkhachhang');
        $this->load->model('frontend/Mdanhmuc');
        $this->load->model('frontend/Mcauhinh');
        $this->load->model('frontend/Msanpham');
        $this->load->model('backend/Mnguoidung');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper('string');
        $this->data['com'] = 'dangnhap';
    }

    /**
     * Đăng ký tài khoản khách hàng mới
     * URL: /dang-ky
     */
    public function dangky()
    {
        if ($this->session->userdata('sessionKhachHang')) {
            redirect('trang-chu', 'refresh');
            return;
        }

        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|trim|is_unique[users.username]|min_length[5]|max_length[32]|alpha_dash');
        $this->form_validation->set_rules('name', 'Họ và tên', 'required|trim|min_length[2]|max_length[100]');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required|min_length[6]|max_length[64]');
        $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('phone', 'Số điện thoại', 'required|trim|min_length[10]|max_length[11]|numeric');

        if ($this->form_validation->run() === TRUE) {
            $raw_password = $this->input->post('password');
            $bcrypt_hash = password_hash($raw_password, PASSWORD_BCRYPT, ['cost' => 12]);

            $userData = [
                'username'   => $this->input->post('username', TRUE),
                'fullname'   => $this->input->post('name', TRUE),
                'email'      => strtolower(trim($this->input->post('email', TRUE))),
                'phone'      => $this->input->post('phone', TRUE),
                'password'   => $bcrypt_hash,
                'role'       => 3, // Vai trò: Khách hàng
                'status'     => 1,
                'trash'      => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            $this->db->trans_start();

            $this->Mkhachhang->customer_insert($userData);
            $customer_id = $this->db->insert_id();

            // Tặng mã giảm giá 50.000đ dành riêng cho thành viên mới
            $coupon_code = 'WELCOME-' . strtoupper(random_string('alnum', 8));
            $coupon = [
                'code'            => $coupon_code,
                'discount'        => 50000,
                'limit_number'    => 1,
                'number_used'     => 0,
                'expiration_date' => date('Y-m-d', strtotime('+1 month')),
                'description'     => 'Mã giảm giá 50.000đ dành cho thành viên mới đăng ký',
                'created_at'      => date('Y-m-d H:i:s'),
                'status'          => 1,
                'trash'           => 1,
                'customer_id'     => $customer_id
            ];
            $this->db->insert('coupons', $coupon);

            $this->db->trans_complete();

            if ($this->db->trans_status() === FALSE) {
                $this->data['error'] = 'Có lỗi xảy ra trong quá trình tạo tài khoản. Vui lòng thử lại!';
            } else {
                $this->session->set_flashdata('success', 'Đăng ký tài khoản thành công! Bạn nhận được mã ưu đãi 50.000đ: <strong>' . htmlspecialchars($coupon_code) . '</strong>');
                redirect('dang-nhap', 'refresh');
                return;
            }
        }

        $this->data['title'] = 'NDN Mobile - Đăng ký tài khoản';
        $this->data['view']  = 'dangky';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Đăng nhập tài khoản (Khách hàng & Quản trị viên)
     * URL: /dang-nhap
     */
    public function dangnhap()
    {
        if ($this->session->userdata('sessionKhachHang')) {
            redirect('trang-chu', 'refresh');
            return;
        }

        if ($this->session->userdata('sessionadmin')) {
            redirect('admin', 'refresh');
            return;
        }

        $this->form_validation->set_rules('username', 'Tên đăng nhập', 'required|trim');
        $this->form_validation->set_rules('password', 'Mật khẩu', 'required');

        if ($this->form_validation->run() === TRUE) {
            $username = trim($this->input->post('username', TRUE));
            $raw_password = (string)$this->input->post('password');

            // 1. Kiểm tra tài khoản Khách hàng (Role = 3)
            $customer = $this->db->where('username', $username)
                                 ->where('role', 3)
                                 ->where('status', 1)
                                 ->where('trash', 1)
                                 ->get('users')
                                 ->row_array();

            if ($customer && $this->verify_and_rehash_password($raw_password, $customer['password'], $customer['id'])) {
                $this->session->set_userdata('sessionKhachHang', $customer);
                $this->session->set_userdata('id', $customer['id']);
                $this->session->set_userdata('email', $customer['email']);
                $this->session->set_userdata('fullname', $customer['fullname']);

                // Chuyển hướng thông minh sau khi đăng nhập thành công
                if ($this->session->userdata('redirect_back')) {
                    $redirect_url = $this->session->userdata('redirect_back');
                    $this->session->unset_userdata('redirect_back');
                    redirect($redirect_url, 'refresh');
                } elseif ($this->session->userdata('cart')) {
                    redirect('gio-hang', 'refresh');
                } else {
                    redirect('trang-chu', 'refresh');
                }
                return;
            }

            // 2. Kiểm tra tài khoản Quản trị viên (Role = 1)
            $adminUser = $this->db->where('username', $username)
                                  ->where('role', 1)
                                  ->where('status', 1)
                                  ->where('trash', 1)
                                  ->get('users')
                                  ->row_array();

            if ($adminUser && $this->verify_and_rehash_password($raw_password, $adminUser['password'], $adminUser['id'])) {
                $this->session->set_userdata('sessionadmin', $adminUser);
                $this->session->set_userdata('id', $adminUser['id']);
                $this->session->set_userdata('fullname', $adminUser['fullname']);
                $this->session->set_userdata('img', $adminUser['img']);
                redirect('admin', 'refresh');
                return;
            }

            $this->data['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác!';
        }

        $this->data['title'] = 'NDN Mobile - Đăng nhập';
        $this->data['view']  = 'dangnhap';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Xác thực mật khẩu đa tầng (Bcrypt / MD5 / SHA1) và tự động Rehash sang Bcrypt chuẩn
     */
    private function verify_and_rehash_password($rawPassword, $storedHash, $userId)
    {
        if (empty($storedHash)) {
            return false;
        }

        $isValid = false;

        // 1. Kiểm tra Bcrypt tiêu chuẩn
        if (password_verify($rawPassword, $storedHash)) {
            $isValid = true;
            // Kiểm tra xem chi phí cost có cần nâng cấp không
            if (password_needs_rehash($storedHash, PASSWORD_BCRYPT, ['cost' => 12])) {
                $newHash = password_hash($rawPassword, PASSWORD_BCRYPT, ['cost' => 12]);
                $this->db->where('id', (int)$userId)->update('users', ['password' => $newHash]);
            }
        }
        // 2. Tương thích ngược: Mật khẩu cũ được băm bằng MD5
        elseif (md5($rawPassword) === $storedHash) {
            $isValid = true;
            $newHash = password_hash($rawPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            $this->db->where('id', (int)$userId)->update('users', ['password' => $newHash]);
        }
        // 3. Tương thích ngược: Mật khẩu cũ được băm bằng SHA1
        elseif (sha1($rawPassword) === $storedHash) {
            $isValid = true;
            $newHash = password_hash($rawPassword, PASSWORD_BCRYPT, ['cost' => 12]);
            $this->db->where('id', (int)$userId)->update('users', ['password' => $newHash]);
        }

        return $isValid;
    }

    /**
     * Đăng xuất tài khoản khách hàng
     * URL: /dang-xuat
     */
    public function dangxuat()
    {
        $this->session->unset_userdata('sessionKhachHang');
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('fullname');
        redirect('trang-chu', 'refresh');
    }

    /**
     * Bước 1: Quên mật khẩu - Gửi mã OTP xác minh qua Email
     * URL: /quen-mat-khau
     */
    public function quen_mat_khau()
    {
        if ($this->session->userdata('sessionKhachHang')) {
            redirect('trang-chu', 'refresh');
            return;
        }

        if ($this->input->post()) {
            $email = strtolower(trim((string)$this->input->post('email', TRUE)));

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->data['error'] = 'Vui lòng nhập địa chỉ email hợp lệ!';
            } else {
                $user = $this->Mkhachhang->customer_detail_email($email);

                if (!$user) {
                    $this->data['error'] = 'Email này chưa được đăng ký trong hệ thống NDN Mobile!';
                } else {
                    $otp = sprintf('%06d', mt_rand(100000, 999999));
                    $expired_at = date('Y-m-d H:i:s', strtotime('+15 minutes'));

                    $this->db->trans_start();

                    // Xóa các OTP cũ chưa sử dụng của email này
                    $this->db->where('email', $email)->delete('password_resets');

                    // Ghi nhận OTP mới
                    $this->db->insert('password_resets', [
                        'email'      => $email,
                        'token'      => $otp,
                        'created_at' => date('Y-m-d H:i:s'),
                        'expired_at' => $expired_at,
                        'used'       => 0
                    ]);

                    $this->db->trans_complete();

                    if ($this->db->trans_status() === FALSE) {
                        $this->data['error'] = 'Có lỗi xảy ra khi tạo mã xác minh. Vui lòng thử lại!';
                    } else {
                        $config_db = $this->Mcauhinh->configuration_detail();

                        $this->load->library('email');
                        $this->email->clear();
                        $email_config = [
                            'protocol'    => 'smtp',
                            'smtp_host'   => 'smtp.gmail.com',
                            'smtp_port'   => 465,
                            'smtp_crypto' => 'ssl',
                            'smtp_timeout'=> 30,
                            'smtp_user'   => $config_db['mail_smtp'],
                            'smtp_pass'   => str_replace(' ', '', $config_db['mail_smtp_password']),
                            'charset'     => 'utf-8',
                            'newline'     => "\r\n",
                            'crlf'        => "\r\n",
                            'mailtype'    => 'html',
                        ];
                        $this->email->initialize($email_config);
                        $this->email->from($config_db['mail_smtp'], $config_db['title']);
                        $this->email->to($email);
                        $this->email->subject('Mã OTP khôi phục mật khẩu - NDN Mobile');

                        $body = '
                        <div style="font-family: Arial, sans-serif; max-width: 480px; margin: 0 auto; border: 1px solid #edf2f7; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                            <div style="background: #d70018; padding: 24px; text-align: center;">
                                <h2 style="color: #fff; margin: 0; font-size: 22px; font-weight: 700;">NDN Mobile</h2>
                            </div>
                            <div style="padding: 30px; background: #fff;">
                                <p style="font-size: 15px; color: #334155;">Xin chào <strong>' . htmlspecialchars($user['fullname'], ENT_QUOTES, 'UTF-8') . '</strong>,</p>
                                <p style="font-size: 14px; color: #64748b; line-height: 1.6;">Bạn vừa yêu cầu khôi phục mật khẩu tài khoản tại NDN Mobile. Dưới đây là mã xác thực OTP của bạn:</p>
                                <div style="text-align: center; margin: 28px 0;">
                                    <span style="font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #d70018; background: #fff5f5; padding: 14px 28px; border-radius: 10px; border: 2px dashed #d70018; display: inline-block;">' . $otp . '</span>
                                </div>
                                <p style="color: #ef4444; font-size: 13px; font-weight: 600;">⚠️ Mã có hiệu lực trong vòng 15 phút. Tuyệt đối không chia sẻ mã này cho bất kỳ ai.</p>
                                <p style="color: #64748b; font-size: 13px;">Nếu bạn không thực hiện yêu cầu này, vui lòng bỏ qua email.</p>
                                <hr style="border: none; border-top: 1px solid #f1f5f9; margin: 24px 0;">
                                <p style="color: #94a3b8; font-size: 12px; text-align: center; margin: 0;">© ' . date('Y') . ' NDN Mobile. Hotline hỗ trợ: 1800.6868</p>
                            </div>
                        </div>';

                        $this->email->message($body);

                        if ($this->email->send()) {
                            $this->session->set_userdata('reset_email', $email);
                            redirect('nhap-otp', 'refresh');
                            return;
                        } else {
                            log_message('error', 'Lỗi gửi mail OTP: ' . $this->email->print_debugger(['headers']));
                            $this->data['error'] = 'Không thể gửi email OTP do lỗi kết nối máy chủ gửi thư. Vui lòng thử lại sau!';
                        }
                    }
                }
            }
        }

        $this->data['title'] = 'NDN Mobile - Quên mật khẩu';
        $this->data['view']  = 'forget_password';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Bước 2: Nhập và kiểm tra mã OTP
     * URL: /nhap-otp
     */
    public function nhap_otp()
    {
        $email = $this->session->userdata('reset_email');
        if (!$email) {
            redirect('quen-mat-khau', 'refresh');
            return;
        }

        if ($this->input->post()) {
            $otp_input = trim((string)$this->input->post('otp', TRUE));

            $record = $this->db
                ->where('email', $email)
                ->where('token', $otp_input)
                ->where('used', 0)
                ->where('expired_at >=', date('Y-m-d H:i:s'))
                ->get('password_resets')
                ->row_array();

            if ($record) {
                // Đánh dấu mã đã sử dụng
                $this->db->where('id', (int)$record['id'])->update('password_resets', ['used' => 1]);
                $this->session->set_userdata('otp_verified', TRUE);
                redirect('dat-lai-mat-khau', 'refresh');
                return;
            } else {
                $this->data['error'] = 'Mã OTP không chính xác hoặc đã hết hiệu lực!';
            }
        }

        $this->data['email_hint'] = preg_replace('/(.{3}).+(@.+)/', '$1***$2', $email);
        $this->data['title'] = 'NDN Mobile - Nhập mã OTP';
        $this->data['view']  = 'nhap_otp';
        $this->load->view('frontend/layout', $this->data);
    }

    /**
     * Bước 3: Đặt lại mật khẩu mới
     * URL: /dat-lai-mat-khau
     */
    public function dat_lai_mat_khau()
    {
        $email    = $this->session->userdata('reset_email');
        $verified = $this->session->userdata('otp_verified');

        if (!$email || !$verified) {
            redirect('quen-mat-khau', 'refresh');
            return;
        }

        $this->form_validation->set_rules('password', 'Mật khẩu mới', 'required|min_length[6]|max_length[64]');
        $this->form_validation->set_rules('re_password', 'Nhập lại mật khẩu', 'required|matches[password]');

        if ($this->form_validation->run() === TRUE) {
            $new_password = (string)$this->input->post('password');
            $bcrypt_hash = password_hash($new_password, PASSWORD_BCRYPT, ['cost' => 12]);

            $user = $this->Mkhachhang->customer_detail_email($email);
            if ($user) {
                $this->Mkhachhang->customer_update(['password' => $bcrypt_hash], $user['id']);
            }

            // Hủy toàn bộ session reset mật khẩu
            $this->session->unset_userdata('reset_email');
            $this->session->unset_userdata('otp_verified');

            $this->session->set_flashdata('success', 'Mật khẩu của bạn đã được cập nhật thành công! Vui lòng đăng nhập lại.');
            redirect('dang-nhap', 'refresh');
            return;
        }

        $this->data['title'] = 'NDN Mobile - Đặt mật khẩu mới';
        $this->data['view']  = 'dat_lai_mat_khau';
        $this->load->view('frontend/layout', $this->data);
    }
}
