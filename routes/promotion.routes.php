<?php
require_once ROOT_PATH . '/app/controllers/PromotionController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/promotions', 'PromotionController@index');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/promotions/{id}', 'PromotionController@show');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/api/promotions/featured', 'PromotionController@getFeatured');
?>