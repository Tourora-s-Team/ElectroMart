<?php
require_once ROOT_PATH . '/app/controllers/AboutController.php';

$router->get('/electromart/public/about', 'AboutController@index');
$router->get('/electromart/public/about/contact', 'AboutController@contact');
$router->post('/electromart/public/about/submit-contact', 'AboutController@submitContact');
?>