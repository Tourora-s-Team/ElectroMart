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

    // function __construct($userID, $userName, $password, $phoneNumber, $email, $role, $isActive = true) {
    //     $this->userID = $userID;
    //     $this->userName = $userName;
    //     $this->password = $password;
    //     $this->phoneNumber = $phoneNumber;
    //     $this->email = $email;
    //     $this->role = $role;
    //     $this->isActive = $isActive;
    // }

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
        $sql = "SELECT Email, Phonenumber from users WHERE UserID = " . $userId;
        $handleData = new HandleData();
        $data = $handleData->getData($sql);
        return $data;
    }
}
?>