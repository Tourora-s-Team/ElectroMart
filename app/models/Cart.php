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

    function getCardID($userID)
    {
        $handleData = new HandleData();
        $sql = "SELECT CartID FROM cart WHERE UserID = :userID";
        $params = ['userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['CartID'] : null;
    }
    function getProductCart($userID)
    {
        $cardID = $this->getCardID($userID);
        $handleData = new HandleData();
        $sql = "SELECT p.ProductName, pi.ImageURL, p.Price, ci.Quantity
                FROM product p
                LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
                     JOIN cartitem ci ON ci.ProductID = p.ProductID
                     JOIN cart c ON c.CartID = ci.CartID
                WHERE (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL) AND ci.CartID = :cardID AND c.UserID = :userID;";
        $params = ['cardID' => $cardID, 'userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;

    }
    // function getShopID($productID)
    // {
    //     $handleData = new HandleData();
    //     $sql = 'SELECT s.ShopID FROM product p
    //             JOIN shop s ON p.ShopID = s.ShopID
    //             WHERE p.ProductID = :productID';
    //     $params = ['productID' => $productID];
    //     $result = $handleData->getDataWithParams($sql, $params);
    //     return $result ? $result[0]['ShopID'] : null;
    // }
    // function addToCartItem()
    // {
    //     $cardID = $this->getCardID($userID);

    //     $handleData = new HandleData();

    // }
}
?>