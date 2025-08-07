<?php
require_once ROOT_PATH . '/app/controllers/HomeController.php';
$router->get('https://electromart.online/public/', 'HomeController@index');
$router->get('https://electromart.online/public/home', 'HomeController@index');
?>