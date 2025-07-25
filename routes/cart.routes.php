<?php
require_once ROOT_PATH . '/app/controllers/CartController.php';

$router->get('/electromart/public/cart', 'CartController@showCartItem');


?>