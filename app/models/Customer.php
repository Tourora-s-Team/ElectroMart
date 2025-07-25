<?php
require_once(__DIR__ . "/../../core/HandleData.php");
class Customer
{
    private $customerID;
    private $userID;
    private $fullName;
    private $gender;
    private $birthDate;
    private $loyaltyPoint;

    // function __construct($customerID, $userID, $fullName, $gender, $birthDate, $loyaltyPoint)
    // {
    //     $this->customerID = $customerID;
    //     $this->userID = $userID;
    //     $this->fullName = $fullName;
    //     $this->gender = $gender;
    //     $this->birthDate = $birthDate;
    //     $this->loyaltyPoint = $loyaltyPoint;
    // }

    public function getCustomerID()
    {
        return $this->customerID;
    }

    public function getUserID()
    {
        return $this->userID;
    }

    public function getLoyaltyPoint()
    {
        return $this->loyaltyPoint;
    }

    public function getCustomerById($userId)
    {
        $handleData = new HandleData();
        $sql = "SELECT FullName, Gender, BirthDate, LoyaltyPoint FROM customer WHERE UserID = " . $userId;
        $res = $handleData->getData($sql);
        return $res;
    }

    public function createCustomer($userID, $fullName, $gender, $birthDate)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO customer (UserID, FullName, Gender, BirthDate) VALUES ('$userID', '$fullName', '$gender', '$birthDate')";
        $handleData->execData($sql);
    }
}