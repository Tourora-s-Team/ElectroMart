<?php
require_once ROOT_PATH . '/app/models/Cart.php';
require_once ROOT_PATH . '/app/models/Receiver.php';
require_once ROOT_PATH . '/app/models/Payment.php';

class PaymentController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function getReceiver()// Hàm lấy thông tin người nhận
    {
        $userId = $_SESSION['user'][0]['UserID'];
        if (!isset($userId)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: /electromart/public/account/signin');
            exit;
        } else {
            $receiverModel = new Receiver();
            $receivers = $receiverModel->getAllReceiversByUserId($userId);
            $this->view('/payment', [
                'title' => 'Thông tin người nhận',
                'receivers' => $receivers,
            ]);
        }
    }
    public function getProductsSelectInCart()// Hàm lấy sản phẩm tùy chọn trong giỏ hàng
    {
        $input = json_decode(file_get_contents('php://input'), true);

        // In ra để kiểm tra
        echo "<pre>";
        print_r($input);
        echo "</pre>";
        exit;
    }
}

?>