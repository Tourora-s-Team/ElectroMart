<?php
require_once ROOT_PATH . '/app/controllers/BaseShopController.php';
require_once ROOT_PATH . '/app/models/ShopProduct.php';

class ShopProductController extends BaseShopController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ShopProduct();
    }

    // Hiển thị danh sách sản phẩm của shop
    public function index()
    {
        $page = (int) ($_GET['page'] ?? 1);
        $search = $_GET['search'] ?? '';
        $sortBy = $_GET['sort_by'] ?? 'ProductName';
        $sortOrder = $_GET['sort_order'] ?? 'ASC';
        $status = $_GET['status'] ?? '';
        $category = $_GET['category'] ?? '';

        $filters = [
            'search' => $search,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'status' => $status,
            'category' => $category
        ];

        $productsData = $this->productModel->getShopProducts($this->shopID, $filters, $page);
        $categories = $this->productModel->getCategories();
        $stats = $this->productModel->getProductStats($this->shopID);

        $breadcrumb = [
            ['text' => 'Trang chủ', 'url' => '/electromart/public/'],
            ['text' => 'Quản lý shop', 'url' => '/electromart/public/shop'],
            ['text' => 'Sản phẩm']
        ];

        $this->loadShopView('products', [
            'products' => $productsData['products'],
            'pagination' => $productsData['pagination'],
            'categories' => $categories,
            'stats' => $stats,
            'filters' => [
                'search' => $search,
                'sort_by' => $sortBy,
                'sort_order' => $sortOrder,
                'status' => $status,
                'category' => $category
            ],
            'pageTitle' => 'Quản lý sản phẩm',
            'activeTab' => 'products',
            'breadcrumb' => $breadcrumb
        ]);
    }


    // Thêm sản phẩm mới
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleAddProduct();
        }

        $categories = $this->productModel->getCategories();
        $breadcrumb = [
            ['text' => 'Trang chủ', 'url' => '/electromart/public/'],
            ['text' => 'Quản lý shop', 'url' => '/electromart/public/shop'],
            ['text' => 'Sản phẩm', 'url' => '/electromart/public/shop/products'],
            ['text' => 'Thêm sản phẩm']
        ];

        $this->loadShopView('product_add', [
            'categories' => $categories,
            'pageTitle' => 'Thêm sản phẩm',
            'activeTab' => 'products',
            'breadcrumb' => $breadcrumb
        ]);
    }

    // Sửa sản phẩm
    public function edit($productID)
    {
        // Nếu là AJAX request, trả về JSON data
        if ($this->isAjaxRequest()) {
            try {
                // Clear ALL output buffers to ensure clean JSON
                while (ob_get_level()) {
                    ob_end_clean();
                }

                // Disable any error output
                ini_set('display_errors', 0);

                // Start fresh output buffer
                ob_start();

                header('Content-Type: application/json');

                $productData = $this->getProductDetail($productID);
                if (!$productData) {
                    http_response_code(404);
                    $response = json_encode([
                        'success' => false,
                        'message' => 'Không tìm thấy sản phẩm.'
                    ]);
                    ob_clean();
                    echo $response;
                    die(); // Use die() instead of exit()
                }

                $response = json_encode([
                    'success' => true,
                    'product' => $productData['product'],
                    'images' => $productData['images']
                ]);
                ob_clean();
                echo $response;
                die(); // Use die() instead of exit()

            } catch (Exception $e) {
                // Clear any accumulated output
                while (ob_get_level()) {
                    ob_end_clean();
                }

                ini_set('display_errors', 0);
                ob_start();

                http_response_code(500);
                $response = json_encode([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi tải thông tin sản phẩm',
                    'error' => $e->getMessage()
                ]);
                ob_clean();
                echo $response;
                die(); // Use die() instead of exit()
            }
        }

        // Xử lý POST request (cập nhật sản phẩm)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEditProduct($productID);
        }

        $product = $this->getProductDetail($productID);
        if (!$product) {
            $_SESSION['error_message'] = 'Không tìm thấy sản phẩm.';
            header("Location: /electromart/public/shop/products");
            exit();
        }

        $categories = $this->productModel->getCategories();
        $breadcrumb = [
            ['text' => 'Trang chủ', 'url' => '/electromart/public/'],
            ['text' => 'Quản lý shop', 'url' => '/electromart/public/shop'],
            ['text' => 'Sản phẩm', 'url' => '/electromart/public/shop/products'],
            ['text' => 'Sửa sản phẩm']
        ];

        $this->loadShopView('product_edit', [
            'product' => $product,
            'categories' => $categories,
            'pageTitle' => 'Sửa sản phẩm',
            'activeTab' => 'products',
            'breadcrumb' => $breadcrumb
        ]);
    }
    public function update($productID)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->handleEditProduct($productID);
        } else {
            $_SESSION['error_message'] = 'Phương thức không hợp lệ.';
            header("Location: /electromart/public/shop/products");
            exit();
        }
    }




    // Cập nhật trạng thái sản phẩm (bán/ngừng bán)
    public function toggleStatus($productID = null)
    {
        // Clear any existing output and ensure clean JSON response
        if (ob_get_level()) {
            ob_clean();
        }

        // Ensure we always return JSON for this endpoint
        header('Content-Type: application/json');

        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                echo json_encode(['success' => false, 'message' => 'Phương thức không được hỗ trợ.']);
                exit();
            }

            // Handle both URL parameter and POST body patterns
            if ($productID) {
                // Pattern from products.php view: /toggle-status/{id} with JSON body
                $input = json_decode(file_get_contents('php://input'), true);
                $newStatus = $input['is_active'] ? '1' : '0';
            } else {
                // Pattern from shop-admin.js: /toggle-status with form data
                $productID = $_POST['productID'] ?? '';
                $newStatus = $_POST['status'] ?? '';
            }

            if (empty($productID) || !in_array($newStatus, ['0', '1'])) {
                echo json_encode(['success' => false, 'message' => 'Dữ liệu không hợp lệ.']);
                exit();
            }

            // Kiểm tra sản phẩm có thuộc shop không
            if (!$this->checkProductBelongsToShop($productID)) {
                echo json_encode(['success' => false, 'message' => 'Bạn không có quyền thay đổi sản phẩm này.']);
                exit();
            }

            $result = $this->updateProductStatus($productID, $newStatus);

            if ($result) {
                $statusText = $newStatus == '1' ? 'kích hoạt' : 'ngừng bán';
                echo json_encode(['success' => true, 'message' => "Đã {$statusText} sản phẩm thành công."]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Có lỗi xảy ra khi cập nhật trạng thái sản phẩm.']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'Lỗi hệ thống: ' . $e->getMessage()]);
        }
        exit();
    }

    // Xóa sản phẩm
    public function delete($productID)
    {
        // Dọn sạch output trước đó (rất quan trọng!)
        if (ob_get_length()) {
            ob_clean();
        }

        // Đặt header JSON
        header('Content-Type: application/json');

        // Xác định gọi từ AJAX hay không (mặc định là JSON)
        $isAjax = strtolower($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'xmlhttprequest';

        // Check quyền sở hữu
        if (!$this->checkProductBelongsToShop($productID)) {
            echo json_encode([
                'success' => false,
                'message' => 'Bạn không có quyền xóa sản phẩm này.'
            ]);
            return;
        }

        // Gọi xoá sản phẩm
        $result = $this->productModel->deleteProduct($productID, $this->shopID);

        echo json_encode([
            'success' => $result,
            'message' => $result ? 'Xóa sản phẩm thành công!' : 'Có lỗi xảy ra khi xóa sản phẩm.'
        ]);
        exit();
    }



    // Xử lý thêm sản phẩm
    private function handleAddProduct()
    {
        $data = [
            'ProductName'     => $_POST['product_name'] ?? '',
            'Description'     => $_POST['description'] ?? '',
            'Price'           => $_POST['price'] ?? 0.0000,
            'StockQuantity'   => $_POST['stock_quantity'] ?? 0,
            'Brand'           => $_POST['brand'] ?? '',
            'RatingProduct'   => $_POST['RatingProduct'] ?? null,
            'CategoryID'      => $_POST['category_id'] ?? 0,
            'ShopID'          => $this->shopID,
            'CreateAt' => date('Y-m-d H:i:s'),
            'UpdateAt' => date('Y-m-d H:i:s'),
            'IsActive'        => isset($_POST['is_active']) ? 1 : 0
        ];

        // Validate required fields
        if (empty($data['ProductName']) || empty($data['Price']) || empty($data['CategoryID'])) {
            $_SESSION['error_message'] = 'Vui lòng điền đầy đủ thông tin bắt buộc.';
            return;
        }

        $productID = $this->addProduct($data);

        if ($productID) {
            // Xử lý upload hình ảnh
            $this->handleProductImages($productID, $_FILES['images'] ?? []);

            $_SESSION['success_message'] = 'Thêm sản phẩm thành công!';
            header("Location: /electromart/public/shop/products");
            exit();
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi thêm sản phẩm.';
        }
    }

    // Xử lý sửa sản phẩm
    private function handleEditProduct($productID)
    {
        if (!$this->checkProductBelongsToShop($productID)) {
            $_SESSION['error_message'] = 'Bạn không có quyền sửa sản phẩm này.';
            header("Location: /electromart/public/shop/products");
            exit();
        }

        $data = [
            'ProductName' => $_POST['ProductName'] ?? '',
            'Description' => $_POST['Description'] ?? '',
            'Price' => $_POST['Price'] ?? 0,
            'StockQuantity' => $_POST['StockQuantity'] ?? 0,
            'Brand' => $_POST['Brand'] ?? '',
            'CategoryID' => $_POST['CategoryID'] ?? 0,
            'UpdateAt' => date('Y-m-d H:i:s'),
            'IsActive' => 1 // hoặc lấy từ form nếu cho phép cập nhật trạng thái
        ];

        $result = $this->productModel->updateProduct($productID, $this->shopID, $data);

        if ($result) {
            // Xử lý upload hình ảnh mới nếu có
            if (!empty($_FILES['images']['name'][0])) {
                $this->handleProductImages($productID, $_FILES['images']);
            }

            $_SESSION['success_message'] = 'Cập nhật sản phẩm thành công!';
            header("Location: /electromart/public/shop/products");
            exit();
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật sản phẩm.';
        }
    }


    // Lấy chi tiết sản phẩm
    private function getProductDetail($productID)
    {
        return $this->productModel->getProductDetail($productID, $this->shopID);
    }

    // Kiểm tra sản phẩm có thuộc shop không
    private function checkProductBelongsToShop($productID)
    {
        return $this->productModel->checkProductBelongsToShop($productID, $this->shopID);
    }

    // Thêm sản phẩm mới
    private function addProduct($data)
    {
        return $this->productModel->addProduct($data);
    }

    // Cập nhật trạng thái sản phẩm
    private function updateProductStatus($productID, $status)
    {
        return $this->productModel->toggleProductStatus($productID, $this->shopID, $status);
    }

    // Xử lý upload hình ảnh sản phẩm
    private function handleProductImages($productID, $files)
    {
        if (empty($files['name'][0]))
            return;

        $uploadDir = ROOT_PATH . '/public/images/products/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        for ($i = 0; $i < count($files['name']); $i++) {
            if ($files['error'][$i] === UPLOAD_ERR_OK) {
                $fileName = time() . '_' . $productID . '_' . $i . '.' . pathinfo($files['name'][$i], PATHINFO_EXTENSION);
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($files['tmp_name'][$i], $uploadPath)) {
                    $imageURL = '/electromart/public/images/products/' . $fileName;
                    $isThumbnail = ($i === 0) ? 1 : 0; // Ảnh đầu tiên làm thumbnail

                    $this->productModel->addProductImage($productID, $this->shopID, $imageURL, $isThumbnail);
                }
            }
        }
    }
}
