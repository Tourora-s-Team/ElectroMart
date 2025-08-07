<?php
require_once ROOT_PATH . '/app/controllers/CategoryController.php';

$router->get('https://electromart.online/public/categories', 'CategoryController@index');
$router->get('https://electromart.online/public/categories/{id}', 'CategoryController@show');
$router->get('https://electromart.online/public/api/categories/popular', 'CategoryController@getPopular');
?>