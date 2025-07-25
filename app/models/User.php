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
        $sql = "SELECT Email, Phonenumber, CreateAt from users WHERE UserID = " . $userId;
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data;
    }

    public function getUserIdByEmail($email)
    {
        $sql = "SELECT UserID FROM users WHERE Email = '$email'";
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data ? $data[0]['UserID'] : null;
    }
    public function getUserByEmail($email)
    {
        $sql = "SELECT UserID, Email, PhoneNumber, Role FROM users WHERE Email = '$email'";
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data ? $data[0] : null;
    }

    public function createUser($name, $email, $phone, $password, $birthdate)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO users (Email, PhoneNumber, Password, Role, isActive) VALUES ('$email', '$phone', '$password', 'customer', 1)";
        $handleData->execData($sql);
    }

    public function authenticate($loginInfo, $password)
    {
        $sql = "SELECT * FROM users WHERE (Email = '$loginInfo' OR PhoneNumber = '$loginInfo') AND Password = '$password'";
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data;
    }


}
?>