<?php
require_once ROOT_PATH . '/core/HandleData.php';
require_once ROOT_PATH . '/app/models/Product.php';
class WishList {

    public function addItem($productID, $userId) {
        $handleData = new HandleData();
        $productModel = new Product();

        $shopId = $productModel->getShopIdByProductId($productID);
        $sql = "INSERT INTO WishList (ProductID, CreateAt, ShopID, UserID) VALUES (:productID, :createdAt, :shopID, :userID)";
        return $handleData->execDataWithParams($sql, [
            ':userID' => $userId,
            ':createdAt' => date('Y-m-d H:i:s'),
            ':shopID' => $shopId,
            ':productID' => $productID
        ]);
    }

    public function getAllProductIDByUserId($userId) {
        $handleData = new HandleData();
        $sql = "SELECT ProductID FROM WishList WHERE UserID = :userID";
        return $handleData->getDataWithParams($sql, [
            ':userID' => $userId
        ]);
    }

    public function removeItemById($productID, $userId) {
        $handleData = new HandleData();
        $sql = "DELETE FROM WishList WHERE ProductID = :productID AND UserID = :userID";
        return $handleData->execDataWithParams($sql, [
            ':userID' => $userId,
            ':productID' => $productID
        ]);
    }
}
?>