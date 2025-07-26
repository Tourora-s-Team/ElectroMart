<?php

class Order {
    private $orderID;
    private $OrderDate;
    private $Status;
    private $ShippingFee;
    private $TotalAmount;

    public function getAllOrders() {
        $handleData = new HandleData();
        $sql = "SELECT * FROM orders where UserID = " . $_SESSION['user_id'];
        $result = $handleData->getData($sql);
        return $result;
    }

    public function getAllOrdersByUserId($userId) {
        $handleData = new HandleData();
        $sql = "SELECT * FROM orders WHERE UserID = :userId";
        $params = [':userId' => $userId];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;
    }
}

?>