<?php
require_once ROOT_PATH . '/app/models/Receiver.php';
require_once ROOT_PATH . '/app/models/Order.php';
require_once ROOT_PATH . '/app/models/OrderDetail.php';

class OrderController
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
    public function createOrder()
    {
        $userId = $_SESSION['user'][0]['UserID'];
        if (!isset($userId)) {
            // chưa đăng nhập thì chuyển hướng đến trang đăng nhập
            header('Location: /electromart/public/account/signin');
            exit;
        } else {
            // xử lý từng item đã chọn
            if (isset($_POST['selected_items']) && is_array($_POST['selected_items'])) {
                $orderModel = new Order();
                $status = 'Đang xử lý';
                $shippingFee = 20000; // Phí vận chuyển cố định
                $totalAmount = 150000; // Tổng tiền hàng (ví dụ)

                // Lấy orderID vừa tạo
                $orderId = $orderModel->addOrder($status, $shippingFee, $totalAmount, $userId);

                $orderDetailModel = new OrderDetail();
                foreach ($_POST['selected_items'] as $itemKey) {
                    list($productId, $quantity, $price, $shopId) = explode('_', $itemKey);
                    $orderDetailModel->addOrderDetail($orderId, $productId, $quantity, $price, $shopId);
                }
            }

            header('Location: /electromart/public/payment');
        }
    }
}

?>