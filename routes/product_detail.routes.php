<?php
require_once ROOT_PATH . '/app/controllers/ProductDetailController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/product-detail/{id}', 'ProductDetailController@showDetail');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/product-detail/review', 'ProductDetailController@submitReview');

?>