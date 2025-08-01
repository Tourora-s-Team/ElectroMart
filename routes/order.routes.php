<?php
require_once ROOT_PATH . '/app/controllers/OrderController.php';

$router->post('/electromart-o63e5.ondigitalocean.app/public/payment/order', 'OrderController@createOrder');
$router->get('/electromart-o63e5.ondigitalocean.app/public/payment_vnpay', 'OrderController@vnpay');
$router->get('/electromart-o63e5.ondigitalocean.app/public/vnpay-return', 'OrderController@vnpayReturn');



?>