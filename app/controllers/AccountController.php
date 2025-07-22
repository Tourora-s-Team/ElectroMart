<?php
require_once(__DIR__ . "/../models/User.php");
require_once(__DIR__ . "/../models/Customer.php");
class AccountController
{
    public function info()
    {
        // Tạo các đối tượng User và Customer để lấy thông tin
        $user = new User();
        $customer = new Customer();
        // $userInfo = user->getUserInfo($_SESSION['userID']);
        // Hiện tại chưa có chức năng đăng nhập nên mặc định lấy userId = 1
        $userData = $user->getUserData(2);

        $customerData = $customer->getCustomerData(2);


        require_once(__DIR__ . "/../views/account_manager/account_info.php");
    }
    public function orderHistory()
    {

    }
}
?>