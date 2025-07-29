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

            $this->userModel->createUser($name, $email, $phone, $password, $birthdate);

            $userId = $this->userModel->getUserIdByEmail($email);

            $customerModel = new Customer();
            $customerModel->createCustomer($userId, $name, 'N/A', $birthdate);

            $userData = $this->userModel->getUserByEmail($email);
            $customerData = $customerModel->getCustomerById($userId);

            if ($userData) {
                $_SESSION['user'] = $userData;
                $_SESSION['customer'] = $customerData;
                $_SESSION['signup_success'] = 'Đăng ký thành công.';
                header("Location: /electromart/public/home");
                exit();
            } else {
                $_SESSION['signup_error'] = 'Đăng ký không thành công. Vui lòng thử lại.';
                header("Location: /electromart/public/account/signup");
            }
        }
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
}
