<?php
require_once ROOT_PATH . '/core/HandleData.php';

class Category
{
    private $CategoryID;
    private $CategoryName;
    private $Description;
    private $ImageURL;

    function __construct($_categoryID = null, $_categoryName = null, $_description = null, $_imageURL = null)
    {
        if ($_categoryID !== null) {
            $this->CategoryID = $_categoryID;
        }
        if ($_categoryName !== null) {
            $this->CategoryName = $_categoryName;
        }
        if ($_description !== null) {
            $this->Description = $_description;
        }
        if ($_imageURL !== null) {
            $this->ImageURL = $_imageURL;
        }
    }

    // Lấy tất cả danh mục
    function getAllCategories()
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM Category ORDER BY CategoryName ASC";
        $result = $handleData->getData($sql);
        return $result;
    }

    // Lấy danh mục theo ID
    function getCategoryById($categoryId)
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM Category WHERE CategoryID = :categoryId";
        $params = ['categoryId' => $categoryId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0];
        }
        return null;
    }

    // Lấy sản phẩm theo danh mục
    function getProductsByCategory($categoryId, $limit = 12)
    {
        $handleData = new HandleData();
        // Chuyển đổi limit thành integer để tránh SQL injection
        $limit = (int) $limit;
        $sql = "SELECT p.*, pi.ImageURL, c.CategoryName
                FROM Product p
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND pi.ShopID = p.ShopID
                LEFT JOIN Category c ON p.CategoryID = c.CategoryID
                WHERE p.CategoryID = :categoryId 
                AND p.IsActive = 1
                AND (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)
                ORDER BY p.CreateAt DESC
                LIMIT " . $limit;
        $params = ['categoryId' => $categoryId];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;
    }

    // Đếm số sản phẩm trong danh mục
    function countProductsByCategory($categoryId)
    {
        $handleData = new HandleData();
        $sql = "SELECT COUNT(*) as total FROM Product WHERE CategoryID = :categoryId AND IsActive = 1";
        $params = ['categoryId' => $categoryId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0]['total'];
        }
        return 0;
    }

    // Lấy danh mục phổ biến (có nhiều sản phẩm nhất)
    function getPopularCategories($limit = 8)
    {
        $handleData = new HandleData();
        // Chuyển đổi limit thành integer để tránh SQL injection
        $limit = (int) $limit;
        $sql = "SELECT c.*, COUNT(p.ProductID) as product_count
                FROM Category c
                LEFT JOIN Product p ON c.CategoryID = p.CategoryID AND p.IsActive = 1
                GROUP BY c.CategoryID
                ORDER BY product_count DESC
                LIMIT " . $limit;
        $result = $handleData->getData($sql);
        return $result;
    }
}
?>