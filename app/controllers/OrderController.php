<?php
require_once ROOT_PATH . '/app/models/Order.php';
require_once ROOT_PATH . '/app/models/Payment.php';

class OrderController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }
    public function vnpayReturn()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $vnp_HashSecret = "JT7NJO4J3MZWICBAZZE5NUK56EWS8BTR";
        $vnp_SecureHash = $_GET['vnp_SecureHash'] ?? '';
        $inputData = [];

        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $hashData = '';
        $i = 0;
        foreach ($inputData as $key => $value) {
            $hashData .= ($i++ ? '&' : '') . urlencode($key) . "=" . urlencode($value);
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $isValid = ($secureHash === $vnp_SecureHash);

        $this->view('/vnpay_return', [
            'title' => 'Kết quả thanh toán VNPay',
            'query' => $_GET,
            'isValid' => $isValid
        ]);
        if ($isValid && $_GET['vnp_ResponseCode'] === '00') {
            $orderId = $_SESSION['order_id'] ?? null;

            if (!$orderId) {
                echo "Không tìm thấy OrderID";
                exit;
            }

            // Gán vào mảng $vnpayData để truyền sang Payment::savePayment()
            $vnpayData = [
                'order_id' => $orderId,
                'vnp_Amount' => $_GET['vnp_Amount'] / 100, // chia lại vì trước đó nhân 100
                'vnp_ResponseCode' => $_GET['vnp_ResponseCode'] ?? '',
                'vnp_TransactionNo' => $_GET['vnp_TransactionNo'] ?? '',
                'vnp_OrderInfo' => $_GET['vnp_OrderInfo'] ?? '',
                'vnp_PaymentMethod' => $_GET['vnp_BankCode'] ?? 'VNPAY',
            ];

            // Gọi models
            $paymentModel = new Payment();
            $paymentModel->savePayment($vnpayData);

            // Xoá session nếu cần
            unset($_SESSION['order_id']);

        }
    }


    public function vnpay()
    {
        if (!isset($_SESSION['vnpay_payment'])) {
            echo "Không có thông tin thanh toán!";
            exit;
        }
        $paymentData = $_SESSION['vnpay_payment'];
        unset($_SESSION['vnpay_payment']);

        $amount = $paymentData['amount'];
        $language = $paymentData['language'];
        $bankCode = $paymentData['bankCode'];


        //code thanh toán vnpay
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        /*
         * To change this license header, choose License Headers in Project Properties.
         * To change this template file, choose Tools | Templates
         * and open the template in the editor.
         */

        $vnp_TmnCode = "50PNFZGW"; //Mã định danh merchant kết nối (Terminal Id)
        $vnp_HashSecret = "JT7NJO4J3MZWICBAZZE5NUK56EWS8BTR"; //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/electromart/public/vnpay-return"; //URL trả về sau khi thanh toán thành công
        $vnp_apiUrl = "http://sandbox.vnpayment.vn/merchant_webapi/merchant.html";
        $apiUrl = "https://sandbox.vnpayment.vn/merchant_webapi/api/transaction";
        //Config input format
//Expire
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        // end config file


        $vnp_TxnRef = time(); //Mã giao dịch thanh toán tham chiếu của merchant
        $vnp_Amount = $amount; // Số tiền thanh toán
        $vnp_Locale = $language; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = $bankCode;//Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
            // "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);//  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();

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
        $totalAmount = isset($_POST['amount']) ? floatval($_POST['amount']) : 0;
        $products = isset($_POST['products']) ? $_POST['products'] : [];
        // $paymentMethod = $_POST['paymentMethod'] ?? 'cod';
        // $receiverId = $_POST['receiverId'] ?? null;

        if (empty($products) || !$totalAmount) {
            echo "Thiếu dữ liệu sản phẩm hoặc tổng tiền!";
            exit;
        }

        $orderModel = new Order();
        $orderId = $orderModel->createOrder($status, $shippingFee, $totalAmount, $userId);
        $_SESSION['order_id'] = $orderId;

        var_dump($orderId);
        var_dump($products); // Thêm dòng này để kiểm tra giá trị
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
        $method = $_POST['paymentMethodFinal'] ?? 'cod';
        if ($method == 'cod') {
            // Gán vào mảng $vnpayData để truyền sang Payment::savePayment()
            $CodData = [
                'order_id' => $orderId,
                'PaymentMethod' => $method,
                'Amount' => $totalAmount,
            ];
            var_dump($CodData);
            // exit;
            $paymentModel = new Payment();
            $paymentModel->savePaymentCod($CodData);

            header("Location: /electromart/public/account/order-history");
            exit;
        } elseif ($method == 'vnpay') {
            $_SESSION['vnpay_payment'] = [
                'amount' => $totalAmount,
                'language' => $_POST['language'] ?? 'vn',
                'bankCode' => $_POST['bankCode'] ?? '',
            ];
            header("Location: /electromart/public/payment_vnpay");
            exit;
        } else {
            echo "Phương thức thanh toán không hợp lệ!";
            exit;
        }
    }
}
?>