<?php
require_once ROOT_PATH . '/app/models/Promotion.php';
require_once ROOT_PATH . '/app/models/Product.php';

class PromotionController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    // Hiển thị trang danh sách khuyến mãi
    public function index()
    {
        $promotionModel = new Promotion();
        $promotions = $promotionModel->getActivePromotions();

        $this->view('promotions/index', [
            'title' => 'Khuyến mãi - ElectroMart',
            'promotions' => $promotions
        ]);
    }

    // Hiển thị chi tiết khuyến mãi và sản phẩm
    public function show($promotionId)
    {
        $promotionModel = new Promotion();

        $promotion = $promotionModel->getPromotionById($promotionId);
        if (!$promotion) {
            http_response_code(404);
            $this->view('error', ['message' => 'Khuyến mãi không tồn tại']);
            return;
        }

        $products = $promotionModel->getPromotionProducts($promotionId, 20);

        $this->view('promotions/show', [
            'title' => $promotion['Title'] . ' - ElectroMart',
            'promotion' => $promotion,
            'products' => $products
        ]);
    }

    // API để lấy khuyến mãi nổi bật (dùng cho AJAX)
    public function getFeatured()
    {
        $promotionModel = new Promotion();
        $promotions = $promotionModel->getFeaturedPromotions(6);

        header('Content-Type: application/json');
        echo json_encode($promotions);
    }
}
?>