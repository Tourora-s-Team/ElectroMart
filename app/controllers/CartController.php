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
    public function addToCart()
    {
        $productId = $_POST['product_id'] ?? null;
        $userId = $_SESSION['user'][0]['UserID']; // nếu có đăng nhập
        $quantity = $_POST['quantity'] ?? null;

        if (!isset($userId)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: /electromart/public/account/signin');
            exit;
        } else {
            $cartModels = new Cart();
            $cardId = $cartModels->getCartID($userId);
            $shopId = $cartModels->getShopID($productId);
            $cartModels->addProductCart($cardId, $productId, $quantity, $shopId);

            header('Location: /electromart/public/cart');
            exit;
        }
    }
    public function deleteFromCart()
    {
        $cartItemId = $_POST['cart_id'] ?? null;
        $productId = $_POST['product_id'] ?? null;

        if ($cartItemId && $productId) {
            $cartModels = new Cart();
            $cartModels->removeProductCart($cartItemId, $productId);
            header('Location: /electromart/public/cart');
            exit;
        } else {
            // Xử lý lỗi nếu không có cartItemId hoặc productId
            echo "Vui lòng cung cấp đầy đủ thông tin để xóa sản phẩm.";
        }
    }

}
?>