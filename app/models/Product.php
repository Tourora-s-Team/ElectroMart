<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Product
{
    private $ProductID;
    private $ProductName;
    private $Price;

    function __construct($_productID = null, $_productName = null, $_productPrice = null)
    {
        if ($_productID !== null) {
            $this->ProductID = $_productID;
        }
        if ($_productName !== null) {
            $this->ProductName = $_productName;
        }
        if ($_productPrice !== null) {
            $this->Price = $_productPrice;
        }
    }

    function getAllProduct()//hàm lấy tất cả sản phẩm
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM Product p
            LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND pi.ShopID = p.ShopID
            WHERE p.IsActive = 1 AND (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)";
        $result = $handleData->getData($sql);
        return $result;
    }


    function searchProduct($keyword)// hàm tìm kiếm sản phẩm theo từ khóa
    {
        // Thêm dấu % vào từ khóa
        $keyword = "%" . $keyword . "%";

        // Tạo đối tượng HandleData
        $handleData = new HandleData();

        // Câu lệnh SQL với tham số :keyword
        $sql = "SELECT p.*, pi.ImageURL
            FROM Product p
            LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND pi.ShopID = p.ShopID
            WHERE p.IsActive = 1 AND (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)
            AND (p.ProductName LIKE :keyword OR p.Brand LIKE :keyword)";
        $params = ['keyword' => $keyword];
        // Truyền giá trị cho :keyword
        $result = $handleData->getDataWithParams($sql, $params);

        return $result;
    }

    function getProductById($productId)// hàm lấy thông tin sản phẩm theo ProductID
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL, s.ShopName, r.Rating, c.CategoryName
            FROM Product p
            LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND pi.ShopID = p.ShopID
            LEFT JOIN Shop s ON p.ShopID = s.ShopID
            LEFT JOIN Review r ON p.ProductID = r.ProductID AND r.ShopID = p.ShopID
            LEFT JOIN Category c ON p.CategoryID = c.CategoryID
            WHERE p.ProductID = :productId AND p.IsActive = 1";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        // Kiểm tra nếu có kết quả trả về
        if (count($result) > 0) {
            return $result[0]; // Trả về sản phẩm đầu tiên
        }

        return null; // Không tìm thấy sản phẩm
    }
    public function updateRatingProduct($productId)// Cập nhật rating trung bình của sản phẩm
    {
        $handleData = new HandleData();

        $sql = "SELECT AVG(Rating) AS avg_rating FROM Review WHERE ProductID = :productId";
        $params = ['productId' => $productId];
        $avgRating = $handleData->getDataWithParams($sql, $params);


        $updateSql = "UPDATE Product SET RatingProduct = :avg WHERE ProductID = :productId";
        $params = [
            'avg' => $avgRating[0]['avg_rating'],
            'productId' => $productId
        ];
        $result = $handleData->getDataWithParams($updateSql, $params);

        // Kiểm tra nếu có kết quả trả về
        if (count($result) > 0) {
            return $result[0]; // Trả về sản phẩm đầu tiên
        }

        return null;
    }
    public function countReviewProduct($productId)// Hàm đếm số lượng đánh giá của sản phẩm
    {
        $handleData = new HandleData();
        $sql = "SELECT COUNT(ReviewID) AS count FROM Review WHERE ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0]['count']; // Trả về số lượng đánh giá
        }

        return 0; // Không có đánh giá nào
    }

    public function getReviewComment($productId)// Hàm lấy danh sách đánh giá của sản phẩm
    {
        $handleData = new HandleData();
        $sql = "SELECT r.*, c.FullName
            FROM Review r
            LEFT JOIN Customer c ON r.UserID = c.UserID
            WHERE r.ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        return $result; // Trả về danh sách đánh giá
    }
    public function addReviewComment($rating, $comment, $productId, $shopId, $userId)// Hàm thêm đánh giá sản phẩm
    {
        $handleData = new HandleData();
        // Thêm đánh giá vào cơ sở dữ liệu
        $sql = "INSERT INTO Review (Rating, Comment, CreateAt, UserID, ProductID, ShopID) VALUES (:rating, :comment, NOW(),:userId,:productId, :shopId)";
        $params = [
            'productId' => $productId,
            'userId' => $userId,
            'rating' => $rating,
            'comment' => $comment,
            'shopId' => $shopId
        ];
        $handleData->execDataWithParams($sql, $params);

        // Cập nhật lại rating trung bình của sản phẩm
        $this->updateRatingProduct($productId);

    }
    public function getRelatedProduct($categoryId)// Hàm lấy sản phẩm liên quan theo CategoryID
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM Product p
            LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND pi.ShopID = p.ShopID
            WHERE p.CategoryID = :categoryId AND p.IsActive = 1 
            AND (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)";
        $params = ['categoryId' => $categoryId];
        $result = $handleData->getDataWithParams($sql, $params);

        return $result ?? []; // Trả về mảng, tránh lỗi null

    }

    public function getShopIdByProductId($productId)
    {
        $handleData = new HandleData();
        $sql = "SELECT ShopID FROM Product WHERE ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0]['ShopID'];
        }

        return null;
    }

    public function getProductsWithImagesByIDs(array $productIDs)
    {
        if (empty($productIDs)) {
            return [];
        }

        // Tạo placeholders (?, ?, ?, ...)
        $placeholders = implode(',', array_fill(0, count($productIDs), '?'));

        $sql = "
        SELECT 
            p.*, 
            pi.ImageID, 
            pi.ImageURL, 
            pi.IsThumbnail, 
            pi.ShopID AS ImageShopID
        FROM Product p
        LEFT JOIN ProductImage pi 
            ON p.ProductID = pi.ProductID 
            AND pi.IsThumbnail = 1
        WHERE p.ProductID IN ($placeholders)
        ORDER BY p.ProductID
    ";

        $handleData = new HandleData();
        return $handleData->getDataWithParams($sql, $productIDs);
    }

    public function minusStockProduct($productId, $quantity)
    {
        $handleData = new HandleData();
        $sql = "UPDATE Product SET StockQuantity = StockQuantity - :quantity WHERE ProductID = :productId";
        $params = [
            ':quantity' => $quantity,
            ':productId' => $productId,
        ];
        $handleData->execDataWithParams($sql, $params);
    }
}
?>