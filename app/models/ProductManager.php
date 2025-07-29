<?php
require_once ROOT_PATH . '/core/HandleData.php';

class ProductManager extends HandleData
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->connectDB();
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // <== Thêm dòng này
    }

    public function lockProductById($productId)
    {
        $sql = "UPDATE Product SET IsActive = 0 WHERE ProductID = :productId";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['productId' => $productId]);
    }

    public function getAllProductsWithImages($search = '', $sortBy = 'StockQuantity', $sortOrder = 'ASC')
    {
        $sql = "SELECT 
                    p.ProductID,
                    p.ProductName,
                    p.Description as ProductType,
                    p.StockQuantity,
                    p.Brand,
                    p.Price,
                    p.IsActive,
                    pi.ImageURL
                FROM Product p
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID";

        $params = [];

        if (!empty($search)) {
            $sql .= " WHERE p.ProductName LIKE :search";
            $params[':search'] = "%{$search}%";
        }

        $allowedSortColumns = ['ProductName', 'StockQuantity', 'Brand', 'Price'];
        if (!in_array($sortBy, $allowedSortColumns)) {
            $sortBy = 'StockQuantity';
        }

        $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';
        $sql .= " ORDER BY p.{$sortBy} {$sortOrder}";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM Product WHERE ProductID = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function deleteProduct($id)
    {
        $sql = "DELETE FROM Product WHERE ProductID = :id";
        $params = [':id' => $id];
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data)
    {
        // Kiểm tra các trường bắt buộc
        if (
            empty($data['ProductName']) ||
            empty($data['Description']) ||
            empty($data['Price']) ||
            empty($data['StockQuantity']) ||
            empty($data['Brand']) ||
            empty($data['CategoryID']) ||
            empty($data['ShopID'])

        ) {
            throw new Exception("Thiếu dữ liệu bắt buộc cho sản phẩm.");
        }

        try {
            $stmt = $this->pdo->prepare("
            INSERT INTO Product (
                ProductName, Description, Price, StockQuantity, Brand,
                CreateAt, UpdateAt, IsActive, CategoryID, ShopID
            ) VALUES (
                :name, :description, :price, :stock, :brand,
                NOW(), NOW(), 1, :categoryId, :shopId
            )
        ");

            $stmt->execute([
                ':name' => $data['ProductName'],
                ':description' => $data['Description'],
                ':price' => $data['Price'],
                ':stock' => $data['StockQuantity'],
                ':brand' => $data['Brand'],
                ':categoryId' => $data['CategoryID'],
                ':shopId' => $data['ShopID']
            ]);

            $productId = $this->pdo->lastInsertId();

            // 2. Thêm ảnh nếu có
            if (!empty($data['ImageURL'])) {
                $stmtImg = $this->pdo->prepare("
                INSERT INTO ProductImage (ProductID, ImageURL, ShopID, IsThumbnail)
                VALUES (:productId, :imageUrl, :shopId, :isThumb)
            ");

                $stmtImg->execute([
                    ':productId' => $productId,
                    ':imageUrl'  => $data['ImageURL'],
                    ':shopId'    => $data['ShopID'],
                    ':isThumb'   => 1
                ]);
            }

            return true;
        } catch (PDOException $e) {
            $errorCode = $e->getCode();
            $errorMsg = $e->getMessage();
            // Bắt lỗi cụ thể
            if (str_contains($errorMsg, 'foreign key constraint')) {
                throw new Exception("Lỗi ràng buộc khóa ngoại: Có thể CategoryID hoặc ShopID không tồn tại.");
            } elseif (str_contains($errorMsg, 'Integrity constraint violation')) {
                throw new Exception("Lỗi ràng buộc dữ liệu: dữ liệu có thể trùng lặp hoặc sai định dạng.");
            } elseif (str_contains($errorMsg, 'Cannot be null')) {
                throw new Exception("Một trường dữ liệu bắt buộc bị null.");
            } else {
                // Lỗi không xác định
                throw new Exception("Lỗi khi thêm sản phẩm: " . $errorMsg);
            }
        }
    }

    public function getAllProducts()
    {
        $stmt = $this->pdo->prepare("SELECT * FROM Product");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id, $data)
    {
        $sql = "UPDATE Orders SET name = :name, type = :type, stock_quantity = :stock_quantity,
            price = :price, brand = :brand, image_url = :image_url WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':name' => $data['product_name'],
            ':type' => $data['product_type'],
            ':stock_quantity' => $data['stock_quantity'],
            ':price' => $data['price'],
            ':brand' => $data['brand'],
            ':image_url' => $data['image_url']
        ]);
    }

    public function updateProduct($data)
    {
        try {
            $this->pdo->beginTransaction();

            // Cập nhật bảng Product
            $sql = "UPDATE Product SET 
                ProductName = :ProductName,
                Description = :Description,
                StockQuantity = :StockQuantity,
                Price = :Price,
                Brand = :Brand,
                ShopID = :ShopID,
                CategoryID = :CategoryID
                WHERE ProductID = :ProductID";


            $stmt = $this->pdo->prepare($sql);
            $isUpdated = $stmt->execute([
                ':ProductName' => $data['ProductName'],
                ':Description' => $data['Description'],
                ':StockQuantity' => $data['StockQuantity'],
                ':Price' => $data['Price'],
                ':Brand' => $data['Brand'],
                ':ShopID' => $data['ShopID'],
                ':CategoryID' => $data['CategoryID'],
                ':ProductID' => $data['ProductID'],
            ]);

            // Cập nhật ảnh nếu có
            if (!empty($data['ImageURL'])) {
                $checkSql = "SELECT COUNT(*) FROM ProductImage WHERE ProductID = :id";
                $checkStmt = $this->pdo->prepare($checkSql);
                $checkStmt->execute([':id' => $data['ProductID']]);
                $count = $checkStmt->fetchColumn();

                if ($count > 0) {
                    $imgSql = "UPDATE ProductImage 
                           SET ImageURL = :image_url, CreateAt = NOW()
                           WHERE ProductID = :id AND IsPrimary = 1";
                } else {
                    $imgSql = "INSERT INTO ProductImage (ProductID, ImageURL, IsPrimary, CreateAt)
                           VALUES (:id, :image_url, 1, NOW())";
                }

                $imgStmt = $this->pdo->prepare($imgSql);
                $imgStmt->execute([
                    ':id' => $data['ProductID'],
                    ':image_url' => $data['ImageURL']
                ]);
            }

            $this->pdo->commit();
            return $isUpdated;
        } catch (Exception $e) {
            $this->pdo->rollBack();
        }
    }


    public function addProduct($data)
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Thêm sản phẩm
            $sql = "INSERT INTO Product 
            (ProductName, Description, Price, StockQuantity, Brand, ShopID, CategoryID, CreateAt, UpdatedAt, IsActive) 
            VALUES 
            (:name, :description, :price, :stock, :brand, :shop_id, :category_id, NOW(), NOW(), 1)";

            $stmt = $this->pdo->prepare($sql);
            $result = $stmt->execute([
                ':name'         => $data['name'],
                ':description'  => $data['description'],
                ':price'        => $data['price'],
                ':stock'        => $data['stock'],
                ':brand'        => $data['brand'],
                ':shop_id'      => $data['shop_id'],
                ':category_id'  => $data['category_id']
            ]);

            if (!$result) {
                throw new Exception("Không thể thêm sản phẩm");
            }

            $productId = $this->pdo->lastInsertId();

            // 2. Thêm ảnh nếu có
            if (!empty($data['image_url'])) {
                $imgSql = "INSERT INTO ProductImage 
                (ProductID, ImageURL, IsPrimary, CreateAt) 
                VALUES 
                (:product_id, :image_url, 1, NOW())";

                $imgStmt = $this->pdo->prepare($imgSql);
                $imgStmt->execute([
                    ':product_id' => $productId,
                    ':image_url' => $data['image_url']
                ]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Lỗi khi thêm sản phẩm: " . $e->getMessage());
            return false;
        }
    }


    public function exportToTxt()
    {
        $products = $this->getAllProductsWithImages();
        $content = "Tên sản phẩm|Loại sản phẩm|Số lượng|Thương hiệu|Giá|URL ảnh\n";

        foreach ($products as $product) {
            $content .= $product['ProductName'] . '|' .
                $product['ProductType'] . '|' .
                $product['StockQuantity'] . '|' .
                $product['Brand'] . '|' .
                $product['Price'] . '|' .
                ($product['ImageURL'] ?? 'Không có ảnh') . "\n";
        }

        return $content;
    }

    public function getProductCount()
    {
        $sql = "SELECT COUNT(*) as total FROM Product";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
