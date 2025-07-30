<?php
require_once ROOT_PATH . '/app/controllers/PaymentController.php';

$router->get('/electromart/public/payment', 'PaymentController@getReceiver');
$router->post('/electromart/public/payment', 'PaymentController@getProductsSelectInCart');
?>