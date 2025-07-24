<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../models/Customer.php");

class AccountController
{
    private $user;
    private $customer;
    private $userData;
    private $customerData;

    public function __construct()
    {
        $this->user = new User();
        $this->customer = new Customer();

        // Giả sử userId = 2 khi chưa có đăng nhập
        $userId = 2;
        $this->userData = $this->user->getUserData($userId);
        $this->customerData = $this->customer->getCustomerById($userId);
    }

    public function info()
    {
        $userData = $this->userData;
        $customerData = $this->customerData;
        require_once(__DIR__ . "/../views/account_manager/account_info.php");
    }

    public function orderHistory()
    {
        $userData = $this->userData;
        $customerData = $this->customerData;
        require_once(__DIR__ . "/../views/account_manager/order_history.php");
    }

    public function shippingAddress()
    {
        $userData = $this->userData;
        $customerData = $this->customerData;
        require_once(__DIR__ . "/../views/account_manager/shipping_address.php");
    }

    public function security()
    {
        $userData = $this->userData;
        $customerData = $this->customerData;
        require_once(__DIR__ . "/../views/account_manager/security.php");
    }
}
?>