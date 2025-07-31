<?php
require_once ROOT_PATH . '/app/models/ProductManager.php';
require_once ROOT_PATH . '/app/controllers/BaseAdminController.php';

class AdminProductsController extends BaseAdminController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct(); // Kiểm tra quyền admin
        $this->productModel = new ProductManager();
    }

    public function index()
    {
        $search = $_GET['search'] ?? '';
        $sortBy = $_GET['sort_by'] ?? 'StockQuantity';
        $sortOrder = $_GET['sort_order'] ?? 'ASC';

        $products = $this->productModel->getAllProductsWithImages($search, $sortBy, $sortOrder);
        $totalProducts = $this->productModel->getProductCount();

        $this->loadAdminView('../app/views/admin/ProductsFE.php', [
            'products' => $products,
            'totalProducts' => $totalProducts,
            'pageTitle' => "Quản lý sản phẩm",
            'currentPage' => 'products',
            'activeTab' => 'products',
            'pageSubtitle' => 'Danh sách sản phẩm hiện có'
        ]);
    }
    // Lấy sản phẩm theo ID
    public function get($id)
    {
        echo json_encode($this->productModel->getById($id));
    }



    public function delete($id)
    {
        require_once ROOT_PATH . '/app/models/ProductManager.php'; // Gọi model Product
        $product = new ProductManager(); // Gọi model
        $product->deleteByID($id); // Xoá sản phẩm theo ID
        // Có thể redirect hoặc in ra thông báo
        if ($product) {
            echo "Deleted successfully";
        } else {
            echo "Failed to delete";
        }
        header('Location: /electromart/public/admin/products'); // Quay lại danh sách sản phẩm
        exit;
    }




    // Thêm hoặc cập nhật sản phẩm

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['ProductName'] ?? '';
            $category = $_POST['CategoryID'] ?? '';
            $quantity = $_POST['StockQuantity'] ?? 0;
            $brand = $_POST['Brand'] ?? '';
            $price = $_POST['Price'] ?? 0;
            $imageUrl = $_POST['ImageURL'] ?? '';

            require_once ROOT_PATH . '/app/models/ProductManager.php';
            $productModel = new ProductManager();
            $result = $productModel->insert([
                'ProductName' => $name,
                'CategoryID' => $category,
                'StockQuantity' => $quantity,
                'Brand' => $brand,
                'Price' => $price,
                'ImageURL' => $imageUrl
            ]);

            echo json_encode(['success' => $result]);
        }
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $data = [
                'ProductID' => $_POST['ProductID'],
                'ProductName' => $_POST['ProductName'] ?? '',
                'Description' => $_POST['Description'] ?? '',
                'StockQuantity' => $_POST['StockQuantity'] ?? 0,
                'Price' => $_POST['Price'] ?? 0,
                'Brand' => $_POST['Brand'] ?? '',
                'ImageURL' => $_POST['ImageURL'] ?? '',
                'ShopID' => $_POST['ShopID'] ?? null,
                'CategoryID' => $_POST['CategoryID'] ?? null
            ];


            require_once ROOT_PATH . '/app/models/ProductManager.php';
            $productModel = new ProductManager();

            $result = $productModel->updateProduct($data);

            // Phản hồi JSON
            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit;
        }
    }




    public function add()
    {
        // Lấy dữ liệu từ form (POST)
        $data = [
            'ProductName' => $_POST['ProductName'] ?? '',
            'Description' => $_POST['Description'] ?? '',
            'StockQuantity' => $_POST['StockQuantity'] ?? 0,
            'Price' => $_POST['Price'] ?? 0,
            'Brand' => $_POST['Brand'] ?? '',
            'ImageURL' => $_POST['ImageURL'] ?? '',
            'ShopID' => $_POST['ShopID'] ?? null,
            'CategoryID' => $_POST['CategoryID'] ?? null
        ];

        require_once ROOT_PATH . '/app/models/ProductManager.php';
        $productModel = new ProductManager();

        try {
            $result = $productModel->insert($data);

            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm thành công.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Không thể thêm sản phẩm.']);
            }
        } catch (Exception $e) {
            // Trả lỗi cụ thể về cho phía front-end
            echo json_encode([
                'success' => false,
                'message' => 'Lỗi khi thêm sản phẩm: ' . $e->getMessage()
            ]);
        }
        exit;
    }



    public function exportTxt()
    {
        require_once ROOT_PATH . '/app/models/ProductManager.php';
        $productModel = new ProductManager();
        $products = $productModel->getAllProducts();

        // Gửi header để tải file
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="DanhSachSanPham.txt"');

        // Tiêu đề
        echo "ID\tTên sản phẩm\tLoại sản phẩm\tSố lượng\tThương hiệu\tGiá sản phẩm\n";

        // Duyệt dữ liệu
        foreach ($products as $p) {
            $id = $p['ProductID'] ?? '';
            $name = $p['ProductName'] ?? '';
            $desc = $p['Description'] ?? '';
            $qty = $p['StockQuantity'] ?? '';
            $brand = $p['Brand'] ?? '';
            $price = $p['Price'] ?? '';

            echo "$id\t$name\t$desc\t$qty\t$brand\t$price\n";
        }

        exit;
    }



    public function search()
    {
        $search = $_GET['q'] ?? '';
        $products = $this->productModel->getAllProductsWithImages($search);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($products);
        exit;
    }
}
