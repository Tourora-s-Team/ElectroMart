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

        // Truyền giá trị cho :keyword
        $result = $handleData->getDataWithParams($sql, ['keyword' => $keyword]);

        return $result;
    }

    function getProductById($productId)
    {
        $handleData = new HandleData();
        $sql = "SELECT p.*, pi.ImageURL
            FROM product p
            LEFT JOIN productimage pi ON p.ProductID = pi.ProductID
            WHERE p.ProductID = :productId";
        $params = ['productId' => $productId];
        $result = $handleData->getDataWithParams($sql, $params);

        // Kiểm tra nếu có kết quả trả về
        if (count($result) > 0) {
            return $result[0]; // Trả về sản phẩm đầu tiên
        }

        return null; // Không tìm thấy sản phẩm
    }
}
?>