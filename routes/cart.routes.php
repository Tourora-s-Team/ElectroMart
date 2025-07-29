<?php
require_once ROOT_PATH . '/app/controllers/CartController.php';

$router->get('/electromart/public/cart', 'CartController@showCartItem');
$router->post('/electromart/public/cart/add', 'CartController@addToCart');
$router->post('/electromart/public/cart/remove', 'CartController@deleteFromCart');

?>