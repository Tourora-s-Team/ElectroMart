<?php
require_once ROOT_PATH . '/app/controllers/PaymentController.php';

$router->get('/electromart-o63e5.ondigitalocean.app/public/payment', 'PaymentController@showPayment');
$router->post('/electromart-o63e5.ondigitalocean.app/public/payment', 'PaymentController@handlePaymentPost');

?>