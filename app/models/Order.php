<?php

class Order
{
    private $orderID;
    private $OrderDate;
    private $Status;
    private $ShippingFee;
    private $TotalAmount;

    public function getAllOrders()
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM orders where UserID = " . $_SESSION['user_id'];
        $result = $handleData->getData($sql);
        return $result;
    }

    public function getAllOrdersByUserId($userId)
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM orders WHERE UserID = :userId";
        $params = [':userId' => $userId];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;
    }
    public function addOrder($status, $shippingFee, $totalAmount, $userId)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO orders (OrderDate, Status, ShippingFee, TotalAmount, UserID) VALUES (now(), :status, :shippingFee, :totalAmount, :userId)";
        $params = [
            ':status' => $status,
            ':shippingFee' => $shippingFee,
            ':totalAmount' => $totalAmount,
            ':userId' => $userId,
        ];
        $handleData->getDataWithParams($sql, $params);
        return $handleData->getLastInsertId(); // lấy ID đơn hàng vừa chèn


    }

}

?>