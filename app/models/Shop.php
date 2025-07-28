<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Shop
{
    private $ShopID = 0;
    private $ShopName = '';

    function __construct()
    {

    }

    function getAllShops()
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM shop";
        $result = $handleData->getData($sql);
        return $result;
    }

    function getShopById($shopId)
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM shop WHERE ShopID = :shopId";
        $params = ['shopId' => $shopId];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result[0];
    }
    // cập nhật đánh giá của shop
    public function updateRatingShop($shopId)
    {
        $handleData = new HandleData();

        $sql = "SELECT AVG(RatingProduct) AS avg_rating FROM product WHERE ShopID = :shopId";
        $params = ['shopId' => $shopId];
        $avgRating = $handleData->getDataWithParams($sql, $params);

        $updateSql = "UPDATE shop SET RatingShop = :avg WHERE ShopID = :shopId";
        $params = [
            'avg' => $avgRating[0]['avg_rating'],
            'shopId' => $shopId,
        ];
        $result = $handleData->getDataWithParams($updateSql, $params);

        // Kiểm tra nếu có kết quả trả về
        if (count($result) > 0) {
            return $result[0]; // Trả về sản phẩm đầu tiên
        }

        return null;
    }
    public function countProductShop($shopId)
    {
        $handleData = new HandleData();
        $sql = "SELECT COUNT(ProductID) AS count FROM product WHERE ShopID = :shopId";
        $params = ['shopId' => $shopId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0]['count']; // Trả về số lượng sản phẩm
        }

        return 0; // Không có sản phẩm nào
    }

    public function getProductShop($shopId)
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, s.ShopName, s.ShopID, c.CategoryName, pi.ImageURL
            FROM product p
            LEFT JOIN shop s ON p.ShopID = s.ShopID
            LEFT JOIN category c ON p.CategoryID = c.CategoryID
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE p.ShopID = :shopId";
        $params = ['shopId' => $shopId];
        $result = $handleData->getDataWithParams($sql, $params);

        // Kiểm tra nếu có kết quả trả về
        if (count($result) > 0) {
            return $result; // Trả về sản phẩm đầu tiên
        }

        return null;
    }
}

?>