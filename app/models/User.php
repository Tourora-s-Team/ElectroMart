<?php
require_once(__DIR__ . "/../../core/HandleData.php");

class User
{
    private $userID;
    private $userName;
    private $password;
    private $phoneNumber;
    private $email;
    private $role;
    private $isActive;

    public function getUserID()
    {
        return $this->userID;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }
    public function getRole()
    {
        return $this->role;
    }

    public function getUserData($userId)
    {
        $sql = "SELECT Email, Phonenumber, CreateAt from Users WHERE UserID = " . $userId;
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data;
    }

    public function getUserIdByEmail($email)
    {
        $sql = "SELECT UserID FROM Users WHERE Email = '$email'";
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data ? $data[0]['UserID'] : null;
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT UserID, Email, PhoneNumber, Role FROM Users WHERE Email = '$email'";
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data ? $data[0] : null;
    }

    public function createUser($email, $phone, $password)
    {
        $handleData = new HandleData();

        // Đảm bảo dùng giá trị đúng kiểu, xử lý prepared statement nếu có thể
        $email = addslashes($email);
        $phone = addslashes($phone);
        $password = addslashes($password);
        $role = 'Customer'; // Đúng kiểu chữ khớp với SET trong MySQL
        $createAt = date('Y-m-d H:i:s.v'); // DATETIME(3), vd: 2025-07-31 21:55:23.123
        $isActive = 1;

        $sql = "INSERT INTO Users (Email, PhoneNumber, Password, Role, CreateAt, IsActive)
            VALUES ('$email', '$phone', '$password', '$role', '$createAt', $isActive)";

        $handleData->execData($sql);
    }

    // Update thông tin user
    public function updateUser($userId, $email, $phone)
    {
        $handleData = new HandleData();
        $sql = "UPDATE Users SET Email = :email, PhoneNumber = :phone WHERE UserID = :userId";

        $params = [
            ':email' => $email,
            ':phone' => $phone,
            ':userId' => $userId
        ];

        return $handleData->execDataWithParams($sql, $params);
    }

    public function authenticate($loginInfo, $password)
    {
        $sql = "SELECT * FROM Users WHERE (Email = '$loginInfo' OR PhoneNumber = '$loginInfo') AND Password = '$password'";
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data;
    }

    public function checkPassword($userId, $password)
    {
        $sql = "SELECT * FROM Users WHERE UserID = :userId AND Password = :password";
        $handleData = new HandleData();
        $params = [
            ':userId' => $userId,
            ':password' => $password
        ];
        $data = $handleData->getDataWithParams($sql, $params);
        return !empty($data);
    }

    public function updatePassword($userId, $newPassword)
    {
        $sql = "UPDATE Users SET Password = :newPassword WHERE UserID = :userId";
        $handleData = new HandleData();
        $params = [
            ':newPassword' => $newPassword,
            ':userId' => $userId
        ];
        return $handleData->execDataWithParams($sql, $params);
    }
}
?>