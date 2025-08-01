<?php
require_once ROOT_PATH . '/app/models/Category.php';
require_once ROOT_PATH . '/app/models/Product.php';

class CategoryController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    // Hiển thị trang danh sách tất cả danh mục
    public function index()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getAllCategories();

        // Lấy số lượng sản phẩm cho mỗi danh mục
        foreach ($categories as &$category) {
            $category['product_count'] = $categoryModel->countProductsByCategory($category['CategoryID']);
        }

        $this->view('categories/index', [
            'title' => 'Danh mục sản phẩm - ElectroMart',
            'categories' => $categories
        ]);
    }

    // Hiển thị sản phẩm theo danh mục
    public function show($categoryId)
    {
        $categoryModel = new Category();
        $productModel = new Product();

        $category = $categoryModel->getCategoryById($categoryId);
        if (!$category) {
            http_response_code(404);
            $this->view('error', ['message' => 'Danh mục không tồn tại']);
            return;
        }

        $products = $categoryModel->getProductsByCategory($categoryId, 20);
        $totalProducts = $categoryModel->countProductsByCategory($categoryId);

        $this->view('categories/show', [
            'title' => $category['CategoryName'] . ' - ElectroMart',
            'category' => $category,
            'products' => $products,
            'totalProducts' => $totalProducts
        ]);
    }

    // API để lấy danh mục phổ biến (dùng cho AJAX)
    public function getPopular()
    {
        $categoryModel = new Category();
        $categories = $categoryModel->getPopularCategories(8);

        header('Content-Type: application/json');
        echo json_encode($categories);
    }
}
?>