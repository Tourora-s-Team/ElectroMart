<?php
require_once ROOT_PATH . '/app/controllers/ShopDetailController.php';

$router->get('https://electromart.online/public/shop-detail/{id}', 'ShopDetailController@showShopDetail');

?>