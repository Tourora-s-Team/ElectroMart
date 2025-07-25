<?php
require_once ROOT_PATH . '/core/HandleData.php';
    class Search{
        function __construct()
    {

    }

    function getAllProductSearch()
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL ";
        $result = $handleData->getData($sql);
        return $result;
    }

    function execSearch($keyword){
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)
            AND (p.ProductName LIKE :keyword OR p.Brand LIKE :keyword)";    
    }
    }
?>