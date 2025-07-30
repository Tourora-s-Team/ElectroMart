<?php
require_once ROOT_PATH . '/app/controllers/PaymentController.php';

$router->get('/electromart/public/payment', 'PaymentController@showPayment');
$router->post('/electromart/public/payment', 'PaymentController@handlePaymentPost');

?>