<?php
require_once ROOT_PATH . '/app/controllers/ProductDetailController.php';

$router->get('/electromart-o63e5.ondigitalocean.app/public/product-detail/{id}', 'ProductDetailController@showDetail');
$router->post('/electromart-o63e5.ondigitalocean.app/public/product-detail/review', 'ProductDetailController@submitReview');

?>