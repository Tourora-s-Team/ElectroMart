<?php
require_once ROOT_PATH . '/app/controllers/ProductDetailController.php';

$router->get('https://electromart.online/public/product-detail/{id}', 'ProductDetailController@showDetail');
$router->post('https://electromart.online/public/product-detail/review', 'ProductDetailController@submitReview');

?>