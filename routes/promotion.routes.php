<?php
require_once ROOT_PATH . '/app/controllers/PromotionController.php';

$router->get('/electromart/public/promotions', 'PromotionController@index');
$router->get('/electromart/public/promotions/{id}', 'PromotionController@show');
$router->get('/electromart/public/api/promotions/featured', 'PromotionController@getFeatured');
?>