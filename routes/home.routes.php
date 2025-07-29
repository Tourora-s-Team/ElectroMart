<?php
require_once ROOT_PATH . '/app/controllers/HomeController.php';
$router->get('/electromart/public/', 'HomeController@index');
$router->get('/electromart/public/home', 'HomeController@index');
?>