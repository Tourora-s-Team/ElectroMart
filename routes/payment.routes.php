<?php
require_once ROOT_PATH . '/app/controllers/PaymentController.php';

$router->get('https://electromart.online/public/payment', 'PaymentController@showPayment');
$router->post('https://electromart.online/public/payment', 'PaymentController@handlePaymentPost');

?>