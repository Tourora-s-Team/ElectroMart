<?php
require_once ROOT_PATH . '/app/controllers/ShopDetailController.php';

$router->get('/electromart-o63e5.ondigitalocean.app/public/shop-detail/{id}', 'ShopDetailController@showShopDetail');

?>