<?php
require_once ROOT_PATH . '/app/controllers/ShopDetailController.php';

$router->get('/electromart/public/shop-detail/{id}', 'ShopDetailController@showShopDetail');

?>