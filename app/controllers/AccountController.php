<?php
require_once( __DIR__ . "/../models/User.php");
require_once( __DIR__ . "/../models/Customer.php");
class AccountController
{
    public function info()
    {
        $filePath = __DIR__ . '/../views/account_manager/dashboard.php';

        if (file_exists($filePath)) {
            require_once($filePath);
        } else {
            echo "File not found!";
        }
    }

    public function orderHistory() {
        
    }
}
?>