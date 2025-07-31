<?php
require_once ROOT_PATH . '/core/HandleData.php';

class Payment
{

    public function savePayment($data)
    {
        if (!isset($_SESSION['user'][0]['UserID'])) {
            throw new Exception("User is not logged in. Cannot save payment.");
        }

        $userId = $_SESSION['user'][0]['UserID'];

        $handleData = new HandleData();

        $sql = "INSERT INTO payment (OrderID, PaymentMethod, Amount, PaymentDate, Status, TransactionCode, Note, UserID)
            VALUES (:order_id, :paymentmethod, :amount, NOW(), :status, :transaction_no, :note, :user_id)";

        $params = [
            ':order_id' => $data['order_id'],
            ':paymentmethod' => $data['vnp_PaymentMethod'] ?? 'VNPAY',
            ':amount' => $data['vnp_Amount'],
            ':status' => $data['vnp_ResponseCode'] === '00' ? 'Success' : 'Failed',
            ':transaction_no' => $data['vnp_TransactionNo'] ?? null,
            ':note' => $data['vnp_OrderInfo'] ?? '',
            ':user_id' => $userId,
        ];

        $handleData->getDataWithParams($sql, $params);
    }
}
?>