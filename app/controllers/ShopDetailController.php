<?php
require_once ROOT_PATH . '/app/models/Shop.php';
require_once ROOT_PATH . '/app/models/Product.php';
class ShopDetailController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }
    public function showShopDetail($id)// Hàm hiển thị chi tiết shop
    {

        $shopModel = new Shop();
        // Lấy thông tin chi tiết shop theo ID
        $shop = $shopModel->getShopById($id);
        $shopModel->updateRatingShop($id);
        $countProduct = $shopModel->countProductShop($id);

        // Lấy thông tin chi tiết sản phẩm theo ID shop
        $idShop = $shop['ShopID'];
        $product = $shopModel->getProductShop($idShop);

        if (!$shop) {
            // Nếu không tìm thấy shop, có thể hiển thị thông báo lỗi hoặc chuyển hướng
            header('Location: /electromart/public/home');
            exit;
        }
        // Hiển thị trang chi tiết shop
        $this->view('/shop-detail', [
            'shop' => $shop,
            'countProduct' => $countProduct,
            'product' => $product,

        ]);
    }
}

?>