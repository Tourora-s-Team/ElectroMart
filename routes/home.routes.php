<?php
require_once ROOT_PATH . '/app/controllers/HomeController.php';
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/', 'HomeController@index');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/home', 'HomeController@index');
?>