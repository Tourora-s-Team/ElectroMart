<?php
require_once ROOT_PATH . '/app/controllers/CategoryController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/categories', 'CategoryController@index');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/categories/{id}', 'CategoryController@show');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/api/categories/popular', 'CategoryController@getPopular');
?>