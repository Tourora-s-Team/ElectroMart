<?php
require_once ROOT_PATH . '/app/controllers/PromotionController.php';

$router->get('https://electromart.online/public/promotions', 'PromotionController@index');
$router->get('https://electromart.online/public/promotions/{id}', 'PromotionController@show');
$router->get('https://electromart.online/public/api/promotions/featured', 'PromotionController@getFeatured');
?>