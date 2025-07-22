<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Product
{
    private $ProductID = 0;
    private $ProductName = '';

    function __construct()
    {

    }

    function getAllProduct()
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL";
        $result = $handleData->getData($sql);
        return $result;
    }
}
?>