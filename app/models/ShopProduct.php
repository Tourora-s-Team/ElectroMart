<?php
require_once ROOT_PATH . '/core/HandleData.php';

class ShopProduct
{
    private $handleData;

    public function __construct()
    {
        $this->handleData = new HandleData();
    }

    /**
     * Lấy danh sách sản phẩm của shop
     */
    public function getShopProducts($shopID, $filters = [], $page = 1, $limit = 10)
    {
        $offset = ($page - 1) * $limit;

        $sql = "SELECT p.*, pi.ImageURL, c.CategoryName
                FROM Product p 
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND p.ShopID = pi.ShopID AND pi.IsThumbnail = 1
                LEFT JOIN Category c ON p.CategoryID = c.CategoryID
                WHERE p.ShopID = :shopID";

        $params = ['shopID' => $shopID];

        // Apply filters
        if (!empty($filters['search'])) {
            $sql .= " AND (p.ProductName LIKE :search OR p.Brand LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['category'])) {
            $sql .= " AND p.CategoryID = :category";
            $params['category'] = $filters['category'];
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $sql .= " AND p.IsActive = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['price_from'])) {
            $sql .= " AND p.Price >= :price_from";
            $params['price_from'] = $filters['price_from'];
        }

        if (!empty($filters['price_to'])) {
            $sql .= " AND p.Price <= :price_to";
            $params['price_to'] = $filters['price_to'];
        }

        // Apply sorting
        $orderBy = "p.CreateAt DESC"; // default
        if (!empty($filters['sort_by']) && !empty($filters['sort_order'])) {
            $allowedSortBy = ['ProductName', 'Price', 'StockQuantity', 'CreateAt'];
            $allowedSortOrder = ['ASC', 'DESC'];

            if (in_array($filters['sort_by'], $allowedSortBy) && in_array($filters['sort_order'], $allowedSortOrder)) {
                $orderBy = "p." . $filters['sort_by'] . " " . $filters['sort_order'];
            }
        }

        $sql .= " ORDER BY " . $orderBy;
        $sql .= " LIMIT " . (int) $limit . " OFFSET " . (int) $offset;

        $products = $this->handleData->getDataWithParams($sql, $params);
        $total = $this->getTotalProducts($shopID, $filters);

        // Calculate start and end for pagination display
        $start = $total > 0 ? (($page - 1) * $limit) + 1 : 0;
        $end = min($start + count($products) - 1, $total);

        return [
            'products' => $products,
            'pagination' => [
                'current_page' => $page,
                'total_pages' => ceil($total / $limit),
                'total_items' => $total,
                'per_page' => $limit,
                'start' => $start,
                'end' => $end,
                'total' => $total
            ]
        ];
    }

    /**
     * Lấy tổng số sản phẩm (cho pagination)
     */
    public function getTotalProducts($shopID, $filters = [])
    {
        $sql = "SELECT COUNT(*) as total FROM Product p WHERE p.ShopID = :shopID";
        $params = ['shopID' => $shopID];

        // Apply same filters
        if (!empty($filters['search'])) {
            $sql .= " AND (p.ProductName LIKE :search OR p.Brand LIKE :search)";
            $params['search'] = '%' . $filters['search'] . '%';
        }

        if (!empty($filters['category'])) {
            $sql .= " AND p.CategoryID = :category";
            $params['category'] = $filters['category'];
        }

        if (isset($filters['status']) && $filters['status'] !== '') {
            $sql .= " AND p.IsActive = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['price_from'])) {
            $sql .= " AND p.Price >= :price_from";
            $params['price_from'] = $filters['price_from'];
        }

        if (!empty($filters['price_to'])) {
            $sql .= " AND p.Price <= :price_to";
            $params['price_to'] = $filters['price_to'];
        }

        $result = $this->handleData->getDataWithParams($sql, $params);
        return $result[0]['total'];
    }

    /**
     * Lấy thống kê sản phẩm
     */
    public function getProductStats($shopID)
    {
        $sql = "SELECT 
                    COUNT(*) as total_products,
                    COUNT(CASE WHEN IsActive = 1 THEN 1 END) as active_products,
                    COUNT(CASE WHEN IsActive = 0 THEN 1 END) as inactive_products,
                    COUNT(CASE WHEN StockQuantity = 0 THEN 1 END) as out_of_stock
                FROM Product p 
                WHERE p.ShopID = :shopID";

        $result = $this->handleData->getDataWithParams($sql, ['shopID' => $shopID]);
        return $result[0];
    }

    /**
     * Lấy chi tiết sản phẩm
     */
    public function getProductDetail($productID, $shopID)
    {
        $sql = "SELECT p.*, c.CategoryName
                FROM Product p 
                LEFT JOIN Category c ON p.CategoryID = c.CategoryID
                WHERE p.ProductID = :productID AND p.ShopID = :shopID";

        $product = $this->handleData->getDataWithParams($sql, [
            'productID' => $productID,
            'shopID' => $shopID
        ]);

        if (empty($product)) {
            return null;
        }

        // Lấy hình ảnh sản phẩm
        $sql = "SELECT * FROM ProductImage 
                WHERE ProductID = :productID AND ShopID = :shopID 
                ORDER BY IsThumbnail DESC, ImageID ASC";

        $images = $this->handleData->getDataWithParams($sql, [
            'productID' => $productID,
            'shopID' => $shopID
        ]);

        return [
            'product' => $product[0],
            'images' => $images
        ];
    }

    /**
     * Thêm sản phẩm mới
     */
    public function addProduct($data)
    {
        $sql = "INSERT INTO Product (ShopID, ProductName, Brand, Description, Price, StockQuantity, CategoryID, IsActive, CreateAt, UpdateAt) 
                VALUES (:ShopID, :ProductName, :Brand, :Description, :Price, :StockQuantity, :CategoryID, :IsActive, :CreateAt, :UpdateAt)";

        return $this->handleData->execDataWithParams($sql, $data);
    }

    /**
     * Cập nhật sản phẩm
     */
    public function updateProduct($productID, $shopID, $data)
    {
        $sql = "UPDATE Product 
                SET ProductName = :ProductName, Brand = :Brand, Description = :Description, 
                    Price = :Price, StockQuantity = :StockQuantity, CategoryID = :CategoryID, 
                    IsActive = :IsActive, UpdateAt = :UpdateAt
                WHERE ProductID = :ProductID AND ShopID = :ShopID";

        $params = array_merge($data, [
            'ProductID' => $productID,
            'ShopID' => $shopID
        ]);

        return $this->handleData->execDataWithParams($sql, $params);
    }

    /**
     * Xóa sản phẩm
     */
    public function deleteProduct($productID, $shopID)
    {
        // Xóa các bản ghi phụ thuộc
        $tables = ['CartItem', 'OrderDetail', 'Review', 'WishList', 'ProductImage'];
        foreach ($tables as $table) {
            $sql = "DELETE FROM $table WHERE ProductID = :ProductID";
            $this->handleData->execDataWithParams($sql, [
                'ProductID' => $productID
            ]);
        }
        // Xóa sản phẩm cuối cùng
        $sql = "DELETE FROM Product WHERE ProductID = :ProductID AND ShopID = :ShopID";
        return $this->handleData->execDataWithParams($sql, [
            'ProductID' => $productID,
            'ShopID' => $shopID
        ]);
    }


    /**
     * Thay đổi trạng thái sản phẩm
     */
    public function toggleProductStatus($productID, $shopID, $isActive)
    {
        $sql = "UPDATE Product SET IsActive = :IsActive WHERE ProductID = :ProductID AND ShopID = :ShopID";

        return $this->handleData->execDataWithParams($sql, [
            'IsActive' => $isActive,
            'ProductID' => $productID,
            'ShopID' => $shopID
        ]);
    }

    /**
     * Thêm hình ảnh sản phẩm
     */
    public function addProductImage($productID, $shopID, $imageURL, $isThumbnail = 0)
    {
        $sql = "INSERT INTO ProductImage (ProductID, ShopID, ImageURL, IsThumbnail) 
                VALUES (:ProductID, :ShopID, :ImageURL, :IsThumbnail)";

        return $this->handleData->execDataWithParams($sql, [
            'ProductID' => $productID,
            'ShopID' => $shopID,
            'ImageURL' => $imageURL,
            'IsThumbnail' => $isThumbnail
        ]);
    }

    /**
     * Xóa hình ảnh sản phẩm
     */
    public function deleteProductImage($imageID, $shopID)
    {
        $sql = "DELETE FROM ProductImage WHERE ImageID = :ImageID AND ShopID = :ShopID";

        return $this->handleData->execDataWithParams($sql, [
            'ImageID' => $imageID,
            'ShopID' => $shopID
        ]);
    }

    /**
     * Lấy danh mục sản phẩm
     */
    public function getCategories()
    {
        $sql = "SELECT * FROM Category ORDER BY CategoryName ASC";
        return $this->handleData->getDataWithParams($sql, []);
    }

    /**
     * Kiểm tra sản phẩm có thuộc shop không
     */
    public function checkProductBelongsToShop($productID, $shopID)
    {
        $sql = "SELECT COUNT(*) as count FROM Product 
                WHERE ProductID = :ProductID AND ShopID = :ShopID";

        $result = $this->handleData->getDataWithParams($sql, [
            'ProductID' => $productID,
            'ShopID' => $shopID
        ]);

        return $result[0]['count'] > 0;
    }
}
