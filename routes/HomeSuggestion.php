<?php
require_once ROOT_PATH . '/app/controllers/HomeController.php';

$router->add('/', ['controller' => 'HomeController', 'action' => 'index']);
$router->add('/home', ['controller' => 'HomeController', 'action' => 'index']);

?>