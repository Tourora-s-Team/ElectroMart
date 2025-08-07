<?php
require_once ROOT_PATH . '/app/controllers/CartController.php';

$router->get('https://electromart.online/public/cart', 'CartController@showCartItem');
$router->post('https://electromart.online/public/cart/add', 'CartController@addToCart');
$router->post('https://electromart.online/public/cart/remove', 'CartController@deleteFromCart');
$router->post('https://electromart.online/public/cart/update', 'CartController@updateQuantityFromCart');
$router->get('https://electromart.online/public/api/cartCount', 'CartController@getCartCount');

?>