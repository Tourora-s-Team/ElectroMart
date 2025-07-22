<?php
class Customer
{
    private $customerID;
    private $userID;
    private $fullName;
    private $gender;
    private $birthDate;
    private $loyaltyPoint;

    function __construct($customerID, $userID, $fullName, $gender, $birthDate, $loyaltyPoint)
    {
        $this->customerID = $customerID;
        $this->userID = $userID;
        $this->fullName = $fullName;
        $this->gender = $gender;
        $this->birthDate = $birthDate;
        $this->loyaltyPoint = $loyaltyPoint;
    }

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

    public function getCustomerInfo()
    {
        return [
            'customerID' => $this->customerID,
            'userID' => $this->userID,
            'fullName' => $this->fullName,
            'gender' => $this->gender,
            'birthDate' => $this->birthDate,
            'loyaltyPoint' => $this->loyaltyPoint
        ];
    }
}