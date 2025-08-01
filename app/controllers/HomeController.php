<?php
require_once ROOT_PATH . '/app/models/Product.php';
require_once ROOT_PATH . '/app/models/Customer.php';
require_once ROOT_PATH . '/app/models/Category.php';
require_once ROOT_PATH . '/app/models/Promotion.php';

class HomeController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function index()// Hàm hiển thị trang chủ
    {
        $productModels = new Product();
        $categoryModel = new Category();
        $promotionModel = new Promotion();

        // Lấy cả products và productImages
        $products = $productModels->getAllProduct();

        // Lấy danh mục phổ biến
        $popularCategories = $categoryModel->getPopularCategories(8);

        // Lấy khuyến mãi nổi bật
        $featuredPromotions = $promotionModel->getFeaturedPromotions(6);

        $this->view('/home', [
            'title' => 'ElectroMart - Linh kiện điện tử chất lượng',
            'products' => $products,
            'categories' => $popularCategories,
            'promotions' => $featuredPromotions
        ]);
    }
}
?>