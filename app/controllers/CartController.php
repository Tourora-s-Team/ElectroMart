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

        // Check if the user is logged in and has a cart
        if (!isset($_SESSION['user']['UserID'])) {
            // Redirect to login or show an error
            header('Location: /electromart/public/account/signin');
            exit;
        }

        // Danh sách sản phẩm trong giỏ hàng
        $cartItems = $cartModels->getProductCart($_SESSION['user']['UserID']);
        $this->view('/cart', [
            'title' => 'Giỏ hàng của bạn',
            'cartItems' => $cartItems,
        ]);
    }
}

?>