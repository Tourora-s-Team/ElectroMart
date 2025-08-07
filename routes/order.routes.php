<?php
require_once ROOT_PATH . '/app/controllers/OrderController.php';

$router->post('https://electromart.online/public/payment/order', 'OrderController@createOrder');
$router->get('https://electromart.online/public/payment_vnpay', 'OrderController@vnpay');
$router->get('https://electromart.online/public/vnpay-return', 'OrderController@vnpayReturn');



?>