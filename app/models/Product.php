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


    function searchProduct($keyword)
    {
        // Thêm dấu % vào từ khóa
        $keyword = "%" . $keyword . "%";

        // Tạo đối tượng HandleData
        $handleData = new HandleData();

        // Câu lệnh SQL với tham số :keyword
        $sql = "SELECT p.*, pi.ImageURL
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE (pi.IsThumbnail = 1 OR pi.IsThumbnail IS NULL)
            AND (p.ProductName LIKE :keyword OR p.Brand LIKE :keyword)";
        $params = ['keyword' => $keyword];
        // Truyền giá trị cho :keyword
        $result = $handleData->getDataWithParams($sql, $params);

        return $result;
    }

    function getProductById($productId)
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL, s.ShopName, r.Rating, c.CategoryName
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            LEFT JOIN shop s ON p.ShopID = s.ShopID
            LEFT JOIN review r ON p.ProductID = r.ProductID
            LEFT JOIN category c ON p.CategoryID = c.CategoryID
            WHERE p.ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        // Kiểm tra nếu có kết quả trả về
        if (count($result) > 0) {
            return $result[0]; // Trả về sản phẩm đầu tiên
        }

        return null; // Không tìm thấy sản phẩm
    }
    public function updateRatingProduct($productId)
    {
        $handleData = new HandleData();

        $sql = "SELECT AVG(Rating) AS avg_rating FROM review WHERE ProductID = :productId";
        $params = ['productId' => $productId];
        $avgRating = $handleData->getDataWithParams($sql, $params);


        $updateSql = "UPDATE product SET RatingProduct = :avg WHERE ProductID = :productId";
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
    public function countReviewProduct($productId)
    {
        $handleData = new HandleData();
        $sql = "SELECT COUNT(ReviewID) AS count FROM review WHERE ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        if (count($result) > 0) {
            return $result[0]['count']; // Trả về số lượng đánh giá
        }

        return 0; // Không có đánh giá nào
    }

    public function getReviewComment($productId)
    {
        $handleData = new HandleData();
        $sql = "SELECT r.*, c.FullName
            FROM review r
            LEFT JOIN customer c ON r.UserID = c.UserID
            WHERE r.ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        return $result; // Trả về danh sách đánh giá
    }
    public function addReviewComment($rating, $comment, $productId, $shopId, $userId)
    {
        $handleData = new HandleData();
        // Thêm đánh giá vào cơ sở dữ liệu
        $sql = "INSERT INTO review (Rating, Comment, CreateAt, UserID, ProductID, ShopID) VALUES (:rating, :comment, NOW(),:userId,:productId, :shopId)";
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
    public function getRelatedProduct($categoryId)
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE p.CategoryId = :categoryId";
        $params = ['categoryId' => $categoryId];
        $result = $handleData->getDataWithParams($sql, $params);

        return $result ?? []; // Trả về mảng, tránh lỗi null

    }



}
?>