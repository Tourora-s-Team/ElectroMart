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

}

?>