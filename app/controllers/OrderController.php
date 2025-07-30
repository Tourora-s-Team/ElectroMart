<?php
require_once ROOT_PATH . '/app/models/Order.php';

class OrderController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function createOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Phương thức không hợp lệ";
            exit;
        }
        if (!isset($_SESSION['user'][0]['UserID'])) {
            echo "Bạn chưa đăng nhập!";
            exit;
        }

        // Lấy dữ liệu từ form
        $userId = $_SESSION['user'][0]['UserID'];
        $status = 'Processing';
        $shippingFee = isset($_POST['shippingFee']) ? floatval($_POST['shippingFee']) : 0;
        $totalAmount = isset($_POST['totalAmount']) ? floatval($_POST['totalAmount']) : 0;
        $products = isset($_POST['products']) ? $_POST['products'] : [];
        // $paymentMethod = $_POST['paymentMethod'] ?? 'cod';
        // $receiverId = $_POST['receiverId'] ?? null;

        if (empty($products) || !$totalAmount) {
            echo "Thiếu dữ liệu sản phẩm hoặc tổng tiền!";
            exit;
        }

        $orderModel = new Order();
        $orderId = $orderModel->createOrder($status, $shippingFee, $totalAmount, $userId);
        var_dump($orderId); // Thêm dòng này để kiểm tra giá trị
        if (!$orderId) {
            die('Không lấy được OrderID!');
        }
        foreach ($products as $item) {
            if (
                !isset($item['ProductID']) ||
                !isset($item['Quantity']) ||
                !isset($item['Price']) ||
                !isset($item['ShopID']) ||
                $item['ProductID'] == 0
            ) {
                var_dump($item);
                die('Thiếu hoặc sai dữ liệu sản phẩm!');
            }
            $result = $orderModel->createOrderDetail(
                $orderId,
                $item['ProductID'],
                $item['Quantity'],
                $item['Price'],
                $item['ShopID']
            );
            if (!$result) {
                echo $orderId;
                var_dump($item);
                die('Insert OrderDetail thất bại!');
            }
        }
        // Sau khi tạo đơn hàng thành công, chuyển hướng về trang chủ hoặc trang cảm ơn
        header("Location: /electromart/public/home");
        exit;
    }
}
?>