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
        $sql = "SELECT * FROM Orders where UserID = " . $_SESSION['user_id'];
        $result = $handleData->getData($sql);
        return $result;
    }

    public function getAllOrdersByUserId($userId)
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM Orders WHERE UserID = :userId";
        $params = [':userId' => $userId];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;
    }
    public function createOrder($status, $shippingFee, $totalAmount, $userId)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO Orders (OrderDate, Status, ShippingFee, TotalAmount, UserID) VALUES (now(), :status, :shippingFee, :totalAmount, :userId)";
        $params = [
            ':status' => $status,
            ':shippingFee' => $shippingFee,
            ':totalAmount' => $totalAmount,
            ':userId' => $userId,
        ];
        $insertResult = $handleData->getDataWithParams($sql, $params);
        if ($insertResult === false) {
            die("❌ Insert vào bảng Orders thất bại!");
        }
        // Lấy OrderID mới nhất của user này
        $sqlGet = "SELECT OrderID FROM Orders WHERE UserID = :userId ORDER BY OrderID DESC LIMIT 1";
        $result = $handleData->getDataWithParams($sqlGet, [':userId' => $userId]);
        if (!$result) {
            die("❌ Không thể lấy OrderID sau khi insert.");
        }

        return (int) $result[0]['OrderID'];
    }
    public function createOrderDetail($orderId, $productId, $quantity, $total, $shopId)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO OrderDetail (OrderID, ProductID, Quantity, UnitPrice, ShopID) VALUES (:orderId, :productId, :quantity, :total, :shopId)";
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