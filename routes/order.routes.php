<?php
require_once ROOT_PATH . '/app/controllers/OrderController.php';

$router->post('https://electromart-t8ou8.ondigitalocean.app/public/payment/order', 'OrderController@createOrder');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/payment_vnpay', 'OrderController@vnpay');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/vnpay-return', 'OrderController@vnpayReturn');



?>