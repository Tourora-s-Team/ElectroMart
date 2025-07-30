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
    public function createOrder($status, $shippingFee, $totalAmount, $userId)
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
        // Lấy OrderID mới nhất của user này
        $sqlGet = "SELECT OrderID FROM orders WHERE UserID = :userId ORDER BY OrderID DESC LIMIT 1";
        $result = $handleData->getDataWithParams($sqlGet, [':userId' => $userId]);
        return $result ? (int) $result[0]['OrderID'] : 0;
    }
    public function createOrderDetail($orderId, $productId, $quantity, $total, $shopId)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO orderdetail (OrderID, ProductID, Quantity, UnitPrice, ShopID) VALUES (:orderId, :productId, :quantity, :total, :shopId)";
        $params = [
            ':orderId' => $orderId,
            ':productId' => $productId,
            ':quantity' => $quantity,
            ':total' => $total,
            ':shopId' => $shopId
        ];
        return $handleData->execDataWithParams($sql, $params);
    }
}

?>