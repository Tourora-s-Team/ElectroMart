<?php
require_once ROOT_PATH . '/app/models/Product.php';

class ProductDetailController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function showDetail($productId)
    {
        $productModels = new Product();
        // Lấy thông tin chi tiết sản phẩm theo ID
        $product = $productModels->getProductById($productId);

        if (!$product) {
            // Nếu không tìm thấy sản phẩm, có thể hiển thị thông báo lỗi hoặc chuyển hướng
            header('Location: /electromart/public/home');
            exit;
        }

        $this->view('/product/detail/{id}', [
            'title' => 'Chi tiết sản phẩm - ' . htmlspecialchars($product['ProductName']),
            'product' => $product,
        ]);
    }
}
?>