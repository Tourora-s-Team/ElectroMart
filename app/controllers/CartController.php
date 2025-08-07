<?php
require_once ROOT_PATH . '/app/models/Cart.php';

class CartController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }
    public function showCartItem()// Hiển thị giỏ hàng của người dùng
    {
        $cartModels = new Cart();
        $userID = $_SESSION['user'][0]['UserID'];
        // Kiểm tra xem người dùng đã đăng nhập và có giỏ hàng hay chưa
        if (!isset($userID)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: https://electromart.online/public/account/signin');
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
    public function addToCart()// Hàm thêm sản phẩm vào giỏ hàng
    {
        $productId = $_POST['product_id'] ?? null;
        $userId = $_SESSION['user'][0]['UserID']; // nếu có đăng nhập
        $quantity = $_POST['quantity'] ?? null;

        if (!isset($userId)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: https://electromart.online/public/account/signin');
            exit;
        } else {
            if (!$productId || !$quantity) {
                // Xử lý lỗi nếu không có productId hoặc quantity
                $_SESSION['message'] = "Không tìm thấy mã sản phẩm.";
                $_SESSION['status_type'] = "error";
                return;
            } else {
                $cartModels = new Cart();
                $cardId = $cartModels->getCartID($userId);
                $shopId = $cartModels->getShopID($productId);
                $cartModels->addProductCart($cardId, $productId, $quantity, $shopId);
                $_SESSION['message'] = "Thêm sản phẩm vào giỏ hàng thành công.";
                $_SESSION['status_type'] = "success";
                header('Location: https://electromart.online/public');
            }
        }
    }
    public function deleteFromCart()// Hàm xóa sản phẩm khỏi giỏ hàng
    {
        $cartItemId = $_POST['cart_id'] ?? null;
        $productId = $_POST['product_id'] ?? null;

        if ($cartItemId && $productId) {
            $cartModels = new Cart();
            $cartModels->removeProductCart($cartItemId, $productId);
            $_SESSION['message'] = "Xóa sản phẩm khỏi giỏ hàng thành công.";
            $_SESSION['status_type'] = "success";
            header('Location: https://electromart.online/public/cart');
            exit;
        } else {
            // Xử lý lỗi nếu không có cartItemId hoặc productId
            $_SESSION['message'] = "Thiếu thông tin để xóa sản phẩm.";
            $_SESSION['status_type'] = "error";
        }
    }
    public function updateQuantityFromCart()// Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    {
        $cartItemId = $_POST['cart_id'];
        $productId = $_POST['product_id'];
        $quantity = $_POST['quantity'];
        if ($cartItemId && $productId && $quantity) {
            $cartModels = new Cart();
            $cartModels->updateQuantityCart($cartItemId, $productId, $quantity);
            header('Location: https://electromart.online/public/cart');
            exit;
        } else {
            // Xử lý lỗi nếu không có cartItemId, productId hoặc quantity
            echo "Vui lòng cung cấp đầy đủ thông tin để cập nhật số lượng sản phẩm.";
        }
    }
    public function getCartCount()
    {
        if (!isset($_SESSION['user'])) {
            echo json_encode(['count' => 0]);
            return;
        }
        $userId = $_SESSION['user'][0]['UserID']; // nếu có đăng nhập
        $cartModels = new Cart();
        $count = $cartModels->cartCount($userId);
        header('Content-Type: application/json');
        echo json_encode(['count' => $count]);
        exit;
    }

}
?>