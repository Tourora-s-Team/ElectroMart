<?php
require_once ROOT_PATH . '/app/controllers/CartController.php';

$router->get('/electromart-o63e5.ondigitalocean.app/public/cart', 'CartController@showCartItem');
$router->post('/electromart-o63e5.ondigitalocean.app/public/cart/add', 'CartController@addToCart');
$router->post('/electromart-o63e5.ondigitalocean.app/public/cart/remove', 'CartController@deleteFromCart');
$router->post('/electromart-o63e5.ondigitalocean.app/public/cart/update', 'CartController@updateQuantityFromCart');

?>