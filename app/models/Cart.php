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
}
?>