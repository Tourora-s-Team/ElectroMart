<?php
require_once ROOT_PATH . '/app/controllers/ShopDetailController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/shop-detail/{id}', 'ShopDetailController@showShopDetail');

?>