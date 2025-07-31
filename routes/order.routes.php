<?php
require_once ROOT_PATH . '/app/controllers/OrderController.php';

$router->post('/electromart/public/payment/order', 'OrderController@createOrder');
$router->get('/electromart/public/payment_vnpay', 'OrderController@vnpay');
$router->get('/electromart/public/vnpay-return', 'OrderController@vnpayReturn');



?>