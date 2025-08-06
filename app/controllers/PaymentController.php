<?php
require_once ROOT_PATH . '/app/models/Receiver.php';
require_once ROOT_PATH . '/app/models/Product.php';


class PaymentController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }

    public function handlePaymentPost()
    {
        ob_clean(); // ✅ Xóa sạch mọi output có thể có trước đó
        header('Content-Type: application/json');
        $rawData = file_get_contents("php://input");
        $data = json_decode($rawData, true);

        $productModel = new Product();
        $detailedItems = [];

        foreach ($data['items'] as $item) {
            $product = $productModel->getProductById($item['product_id']); // Lấy thông tin sản phẩm từ DB
            if ($product) {
                $detailedItems[] = [
                    'ShopID' => $product['ShopID'],
                    'ShopName' => $product['ShopName'],
                    'ProductName' => $product['ProductName'],
                    'ImageURL' => $product['ImageURL'] ?? $item['image'] ?? '/public/images/no-image.jpg',
                    'Price' => $product['Price'],
                    'Quantity' => $item['quantity'],
                    'Variation' => $product['Brand'] ?? null,
                    'OriginalPrice' => $product['OriginalPrice'] ?? null,
                    'ProductID' => $product['ProductID'],
                ];
            }
        }

        $_SESSION['payment_data'] = [
            'items' => $detailedItems,
            'total' => $data['total']
        ];

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'success',
            'message' => 'Đã nhận dữ liệu thanh toán',
            'data' => $_SESSION['payment_data']
        ]);
        exit;
    }

    public function showPayment()
    {
        $userId = $_SESSION['user'][0]['UserID'] ?? null;
        if (!$userId) {
            header('Location: https://electromart-t8ou8.ondigitalocean.app/public/account/signin');
            exit;
        }
        $receiverModel = new Receiver();
        $receivers = $receiverModel->getAllReceiversByUserId($userId);

        $paymentData = $_SESSION['payment_data'] ?? null; // Lấy sản phẩm từ session
        $this->view('/payment', [
            'title' => 'Thông tin người nhận',
            'receivers' => $receivers,
            'paymentData' => $paymentData
        ]);
    }
}


?>