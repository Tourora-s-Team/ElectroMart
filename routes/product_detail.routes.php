<?php
require_once ROOT_PATH . '/app/controllers/ProductDetailController.php';

$router->get('/electromart/public/product-detail/{id}', 'ProductDetailController@showDetail');
$router->post('/electromart/public/product-detail/review', 'ProductDetailController@submitReview');

?>