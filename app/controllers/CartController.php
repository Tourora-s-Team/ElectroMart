<?php
require_once ROOT_PATH . '/app/models/Cart.php';

class CartController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function showCartItem()
    {
        $cartModels = new Cart();

        // Danh sách sản phẩm trong giỏ hàng
        $cartItems = $cartModels->getAllProductCart();
        $this->view('/cart', [
            'title' => 'Giỏ hàng của bạn',
            'cartItems' => $cartItems,
        ]);
    }
}

?>