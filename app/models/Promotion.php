<?php
require_once ROOT_PATH . '/core/HandleData.php';

class Promotion
{
    private $PromotionID;
    private $Title;
    private $Description;
    private $DiscountPercent;
    private $StartDate;
    private $EndDate;
    private $ImageURL;
    private $IsActive;

    function __construct($_promotionID = null, $_title = null, $_description = null, $_discountPercent = null)
    {
        if ($_promotionID !== null) {
            $this->PromotionID = $_promotionID;
        }
        if ($_title !== null) {
            $this->Title = $_title;
        }
        if ($_description !== null) {
            $this->Description = $_description;
        }
        if ($_discountPercent !== null) {
            $this->DiscountPercent = $_discountPercent;
        }
    }

    // Lấy tất cả khuyến mãi đang hoạt động
    function getActivePromotions()
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM Promotion 
                WHERE StartDate <= NOW() 
                AND EndDate >= NOW() 
                ORDER BY StartDate DESC";
        $result = $handleData->getData($sql);
        return $result;
    }

    // Lấy khuyến mãi theo ID
    function getPromotionById($promotionId)
    {
        $handleData = new HandleData();
        $sql = "SELECT * FROM Promotion WHERE PromotionID = :promotionId";
        $params = ['promotionId' => $promotionId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0];
        }
        return null;
    }

    // Lấy khuyến mãi nổi bật (có discount cao nhất)
    function getFeaturedPromotions($limit = 6)
    {
        $handleData = new HandleData();
        // Chuyển đổi limit thành integer để tránh SQL injection
        $limit = (int) $limit;
        $sql = "SELECT * FROM Promotion 
                WHERE StartDate <= NOW() 
                AND EndDate >= NOW() 
                ORDER BY DiscountValue DESC 
                LIMIT " . $limit;
        $result = $handleData->getData($sql);
        return $result;
    }

    // Lấy sản phẩm có khuyến mãi - đơn giản hóa vì không có bảng ProductPromotion
    function getPromotionProducts($promotionId, $limit = 12)
    {
        $handleData = new HandleData();
        // Chuyển đổi limit thành integer để tránh SQL injection
        $limit = (int) $limit;
        // Lấy các sản phẩm ngẫu nhiên để demo (vì không có bảng liên kết ProductPromotion)
        $sql = "SELECT p.*, pi.ImageURL, :discount_value as DiscountValue
                FROM Product p
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND pi.ShopID = p.ShopID
                WHERE p.IsActive = 1
                AND (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)
                ORDER BY RAND()
                LIMIT " . $limit;
        $params = ['discount_value' => 500000]; // Giá trị giảm giá mặc định
        $result = $handleData->getDataWithParams($sql, $params);
        return $result;
    }

    // Kiểm tra sản phẩm có khuyến mãi hay không - đơn giản hóa
    function getProductPromotion($productId)
    {
        // Vì không có bảng ProductPromotion, trả về null
        return null;
    }
}
?>