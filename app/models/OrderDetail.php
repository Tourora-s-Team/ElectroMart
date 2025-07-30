<?php
require_once ROOT_PATH . '/core/HandleData.php';
class OrderDetail
{
    // public function getOrderID($userId)
    // {
    //     $handleData = new HandleData();
    //     $sql = "SELECT OrderID FROM orders WHERE UserID = :userId ORDER BY OrderDate DESC LIMIT 1";
    //     $params = [':userId' => $userId];
    //     $handleData->getDataWithParams($sql, $params);
    //     return $handleData->getLastInsertId();
    // }

    public function addOrderDetail($orderId, $productId, $quantity, $price, $shopId)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO orderdetail (OrderID, ProductID, Quantity, UnitPrice, ShopID) VALUES (:orderId, :productId, :quantity, :price, :shopId)";
        $params = [
            'orderId' => $orderId,
            'productId' => $productId,
            'quantity' => $quantity,
            'price' => $price,
            'shopId' => $shopId
        ];
        return $handleData->execDataWithParams($sql, $params);
    }
}
?>