<?php
require_once ROOT_PATH . '/app/controllers/CartController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/cart', 'CartController@showCartItem');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/cart/add', 'CartController@addToCart');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/cart/remove', 'CartController@deleteFromCart');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/cart/update', 'CartController@updateQuantityFromCart');

?>