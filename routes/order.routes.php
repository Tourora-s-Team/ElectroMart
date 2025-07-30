<?php
require_once ROOT_PATH . '/app/controllers/OrderController.php';

$router->post('/electromart/public/payment/order', 'OrderController@createOrder');

?>