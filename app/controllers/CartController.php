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
        $userID = $_SESSION['user'][0]['UserID'];
        // Kiểm tra xem người dùng đã đăng nhập và có giỏ hàng hay chưa
        if (!isset($userID)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: /electromart/public/account/signin');
            exit;
        } else {
            // đăng nhập rồi thì hiển thị danh sách sản phẩm trong giỏ hàng
            $cartItems = $cartModels->getProductCart($userID);
            $this->view('/cart', [
                'title' => 'Giỏ hàng của bạn',
                'cartItems' => $cartItems,
            ]);
        }
    }
}

?>