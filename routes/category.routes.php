<?php
require_once ROOT_PATH . '/app/controllers/CategoryController.php';

$router->get('/electromart/public/categories', 'CategoryController@index');
$router->get('/electromart/public/categories/{id}', 'CategoryController@show');
$router->get('/electromart/public/api/categories/popular', 'CategoryController@getPopular');
?>