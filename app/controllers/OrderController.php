<?php
require_once ROOT_PATH . '/app/models/Order.php';

class OrderController
{
    private function view($view, $data = [])
    {
        extract($data);
        require_once ROOT_PATH . '/app/views/' . $view . '.php';
    }
    public function vnpayReturn()
    {
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
        $method = $_POST['paymentMethodFinal'] ?? 'cod';
        if ($method == 'cod') {
            header("Location: /electromart/public/home");
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
<!-- 
http://localhost/vnpay_php/vnpay_return.php?
vnp_Amount=1420000000&
vnp_BankCode=NCB&
vnp_BankTranNo=VNP15109185&
vnp_CardType=ATM&vnp_OrderInfo=Thanh+toan+GD%3A1753935855&
vnp_PayDate=20250731112730&vnp_ResponseCode=00&
vnp_TmnCode=50PNFZGW&vnp_TransactionNo=15109185&
vnp_TransactionStatus=00&
vnp_TxnRef=1753935855&
vnp_SecureHash=f9be19306a98a6650bf77db1ff50fa6957941411253e0cecedcd4f00c0d324373f687453f7037e9436835e25a1befdb9f05f8721a904af909818fa8cda5b4e31 -->