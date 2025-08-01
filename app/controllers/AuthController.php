<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../models/Customer.php");

class AuthController
{
    private $userModel;
    private $userData;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function showSignUp()
    {
        require_once(__DIR__ . '/../views/sign_up.php');
    }

    public function showSignIn($error = null)
    {
        require_once(__DIR__ . '/../views/sign_in.php');
    }


    public function signIn()
    {
        if (isset($_POST['loginInfo']) && isset($_POST['password'])) {
            $loginInfo = $_POST['loginInfo'];
            $password = $_POST['password'];
            $userData = $this->userModel->authenticate($loginInfo, $password);
            // Kiểm tra xem tài khoản có bị khoá hay không
            // Truy vấn để lấy IsActive từ database

            // Tách thành mảng
            $roles = explode(',', $userData[0]['Role']);

            if ($userData) {
                if ($userData[0]['IsActive'] == 0) {
                    $_SESSION['login_error'] = 'Tài khoản của bạn đã bị khóa.';
                    header("Location: /electromart/public/account/signin");
                    exit();
                } else {
                    $_SESSION['user'] = $userData;
                    $_SESSION['login_success'] = "Đăng nhập thành công.";
                    if (in_array('Admin', $roles)) {
                        header("Location: /electromart/public/admin/orders");
                    } elseif (in_array('Customer', $roles) || in_array('Seller', $roles)) {
                        $customerModel = new Customer();
                        $customerData = $customerModel->getCustomerById($userData[0]['UserID']);
                        $_SESSION['customer'] = $customerData;
                        header("Location: /electromart/public/home");
                    }
                    exit();
                }
            } else {
                $_SESSION['login_error'] = 'Thông tin đăng nhập không chính xác.';
                header("Location: /electromart/public/account/signin");
            }
        }
    }

    public function signUp()
    {
        if (isset($_POST["registerName"]) && isset($_POST["registerEmail"]) && isset($_POST["registerPhone"]) && isset($_POST["registerPassword"]) && isset($_POST["registerBirthdate"])) {
            $name = $_POST["registerName"];
            $email = $_POST["registerEmail"];
            $phone = $_POST["registerPhone"];
            $password = $_POST["registerPassword"];
            $birthdate = $_POST["registerBirthdate"];

            require_once __DIR__ . '/MailController.php';

            $mail = new MailController();
            $toEmail = $email;
            $toName = $name;

            $verificationCode = bin2hex(random_bytes(8)); // Tạo mã xác thực ngẫu nhiên

            $_SESSION['verification_code'] = $verificationCode;
            $_SESSION['pending_user_data'] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password' => $password,
                'birthdate' => $birthdate
            ];

            $mail->sendVerificationEmail($toEmail, $toName, $verificationCode);

            // Hiển thị trang yêu cầu người dùng xác minh email
            require_once(__DIR__ . '/../views/email_verification.php');
            exit();
        }
    }

    public function verifyEmail($code)
    {
        // Kiểm tra mã xác minh có hợp lệ không
        if (empty($code)) {
            $_SESSION['verification_error'] = 'Mã xác minh không hợp lệ.';
            header("Location: /electromart/public/account/signup");
            exit();
        }

        // Kiểm tra session có dữ liệu xác minh không
        if (!isset($_SESSION['verification_code']) || !isset($_SESSION['pending_user_data'])) {
            $_SESSION['verification_error'] = 'Phiên xác minh đã hết hạn. Vui lòng đăng ký lại.';
            header("Location: /electromart/public/account/signup");
            exit();
        }

        // So sánh mã xác minh
        if ($_SESSION['verification_code'] !== $code) {
            $_SESSION['verification_error'] = 'Mã xác minh không chính xác.';
            header("Location: /electromart/public/account/signup");
            exit();
        }

        // Lấy dữ liệu user từ session
        $userData = $_SESSION['pending_user_data'];
        $name = $userData['name'];
        $email = $userData['email'];
        $phone = $userData['phone'];
        $password = $userData['password'];
        $birthdate = $userData['birthdate'];

        try {
            // Tạo user trong database
            $this->userModel->createUser($email, $phone, $password);

            $userId = $this->userModel->getUserIdByEmail($email);

            // Tạo customer
            $customerModel = new Customer();
            $customerModel->createCustomer($userId, $name, 'N/A', $birthdate);

            // Lấy dữ liệu user và customer
            $userData = $this->userModel->getUserByEmail($email);
            $customerData = $customerModel->getCustomerById($userId);

            if ($userData) {
                // Lưu vào session
                $_SESSION['user'] = $userData;
                $_SESSION['customer'] = $customerData;
                $_SESSION['message'] = 'Xác minh email thành công! Chào mừng bạn đến với ElectroMart. Vui lòng đăng nhập để tiếp tục.';
                $_SESSION['status_type'] = 'success';

                $mail = new MailController();
                // Gửi email chào mừng
                $mail->sendWelcomeEmail($email, $name);

                // Xóa dữ liệu tạm thời
                unset($_SESSION['verification_code']);
                unset($_SESSION['pending_user_data']);

                header("Location: /electromart/public/");
                exit();
            } else {
                $_SESSION['signup_error'] = 'Có lỗi xảy ra trong quá trình tạo tài khoản. Vui lòng thử lại.';
                header("Location: /electromart/public/account/signup");
                exit();
            }
        } catch (Exception $e) {
            // $_SESSION['signup_error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
            $_SESSION['signup_error'] = 'Email hoặc số điện thoại đã được sử dụng.';
            header("Location: /electromart/public/account/signup");
            exit();
        }
    }

    public function resendVerificationEmail()
    {
        if (isset($_SESSION['pending_user_data'])) {
            $userData = $_SESSION['pending_user_data'];

            require_once __DIR__ . '/MailController.php';
            $mail = new MailController();

            $verificationCode = bin2hex(random_bytes(8));
            $_SESSION['verification_code'] = $verificationCode;

            $mail->sendVerificationEmail($userData['email'], $userData['name'], $verificationCode);

            echo json_encode(['success' => true, 'message' => 'Email xác minh đã được gửi lại.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Không tìm thấy thông tin đăng ký.']);
        }
        exit();
    }

    public function signOut(): never
    {

        session_start();

        // Xóa thông tin user trong session
        unset($_SESSION['user']);

        // Hoặc xóa toàn bộ session nếu bạn không cần giữ gì khác
        $_SESSION = [];
        session_destroy();

        // Chuyển về trang chủ
        header("Location: /electromart/public/home");
        exit();
    }

    public function authenticateAdminRole()
    {
        if (isset($_SESSION['user'])) {
            $roles = explode(',', $_SESSION['user'][0]['Role']);
            return in_array('Admin', $roles);
        }
        return false;
    }

    public function authenticateShopRole()
    {
        if (isset($_SESSION['user'])) {
            $roles = explode(',', $_SESSION['user'][0]['Role']);
            return in_array('Seller', $roles);
        }
        return false;
    }
}
