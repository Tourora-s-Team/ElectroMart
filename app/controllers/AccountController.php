<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../models/Customer.php");

class AccountController
{
    private $userID;
    private $user;
    private $customer;
    private $userData;
    private $customerData;

    public function __construct()
    {
        $this->userID = $_SESSION["user"][0]["UserID"];
        $this->user = new User();
        $this->customer = new Customer();

        // Lấy userId từ session, nếu không có thì null
        $userId = $_SESSION['user'][0]['UserID'] ?? null;
        if ($userId != null) {
            $this->userData = $this->user->getUserData($userId);
            $this->customerData = $this->customer->getCustomerById($userId);
        }
        else {
            $this->userData = null;
            $this->customerData = null;
        }
    }

    private function isUserLoggedIn()
    {
        // Nếu người dùng chưa đăng nhập thì chuyển hướng đến trang đăng nhập và trả về false
        if ($this->userData == null) {
            header("Location: /electromart/public/account/signin");
            return false;
        }
        return true;
    }

    public function info()
    {   
        // Gọi hàm để kiểm tra tình trạng đăng nhập
        if ($this->isUserLoggedIn() === false) {
            return;
        }
        $userData = $this->userData;
        $customerData = $this->customerData;
        $this->userData = $this->user->getUserData($this->userID);
        $this->customerData = $this->customer->getCustomerById($this->userID);
        require_once(__DIR__ . "/../views/account_manager/account_info.php");
    }

    public function updateInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $gender = $_POST['gender'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $dateOfBirth = $_POST['date-of-birth'];
            $birthDateFormatted = DateTime::createFromFormat('d/m/Y', $dateOfBirth)->format('Y-m-d');
            
            
            // Cập nhật thông tin người dùng
            $this->user->updateUser($this->userID, $email, $phone);
            $this->customer->updateCustomer($this->userID, $name, $gender, $birthDateFormatted);

            // Sau khi cập nhật, lấy lại dữ liệu mới
            $this->userData = $this->user->getUserData($this->userID);
            $this->customerData = $this->customer->getCustomerById($this->userID);
            header("Location: /electromart/public/account/info");
            exit();
        }
    }

    public function orderHistory()
    { 
        if (!$this->isUserLoggedIn()) {
            return;
        }
        $customerData = $this->customerData;

        require_once(__DIR__ . "/../models/Order.php");
        $orderModel = new Order();
        $orderHistory = $orderModel->getAllOrdersByUserId($this->userID);

        $orderCount = count($orderHistory);
        require_once(__DIR__ . "/../views/account_manager/order_history.php");
        if ($orderCount == 0) {
            $orderHistory = null; 
        }
    }

    public function shippingAddress()
    {
        if (!$this->isUserLoggedIn()) {
            return;
        }
        $customerData = $this->customerData;
        require_once(__DIR__ . "/../views/account_manager/receiver_info.php");
    }

    public function security()
    {
        $userData = $this->userData;
        $customerData = $this->customerData;
        require_once(__DIR__ . "/../views/account_manager/security.php");
    }
}
?>