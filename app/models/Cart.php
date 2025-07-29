<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Cart
{

    function __construct()
    {

    }

    function getAllProductCart()
    {
        $handleData = new HandleData();
        $sql = "SELECT p.ProductName, pi.ImageURL, p.Price, ci.Quantity
                FROM product p
                LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
                     JOIN cartitem ci ON ci.ProductID = p.ProductID
                WHERE pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL";
        $result = $handleData->getData($sql);
        return $result;
    }
    function getProductCart($userID)
    {
        $cartID = $this->getCartID($userID);
        $handleData = new HandleData();
        $sql = "SELECT p.ProductName, pi.ImageURL, p.Price, ci.Quantity, ci.CartID, ci.ProductID
                FROM product p
                     JOIN cartitem ci ON ci.ProductID = p.ProductID
                     JOIN cart c ON c.CartID = ci.CartID
                     LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
                WHERE (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL) AND ci.CartID = :cartID AND c.UserID = :userID;";
        $params = ['cartID' => $cartID, 'userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;

    }
    function getCartID($userID)
    {
        $handleData = new HandleData();
        $sql = "SELECT CartID FROM cart WHERE UserID = :userID";
        $params = ['userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['CartID'] : null;
    }

    public function getShopID($productID)
    {
        $handleData = new HandleData();
        $sql = 'SELECT s.ShopID FROM product p
                JOIN shop s ON p.ShopID = s.ShopID
                WHERE p.ProductID = :productID';
        $params = ['productID' => $productID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['ShopID'] : null;
    }
    public function addProductCart($cartId, $productId, $quantity, $shopId)
    {
        $handleData = new HandleData();
        $sql = "INSERT INTO cartitem (CartID, ProductID, Quantity, ShopID) VALUES (:cartId, :productId, :quantity, :shopId)";
        $params = [
            'cartId' => $cartId,
            'productId' => $productId,
            'quantity' => $quantity,
            'shopId' => $shopId,
        ];
        $handleData->execDataWithParams($sql, $params);
    }
    public function removeProductCart($cartItemId, $productId)
    {
        $handleData = new HandleData();
        $sql = "DELETE FROM cartitem WHERE CartID = :cartItemId AND ProductID = :productId";
        $params = [
            'cartItemId' => $cartItemId,
            'productId' => $productId
        ];
        $handleData->execDataWithParams($sql, $params);
    }
}
?>