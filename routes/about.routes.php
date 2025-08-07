<?php
require_once ROOT_PATH . '/app/controllers/AboutController.php';

$router->get('https://electromart.online/public/about', 'AboutController@index');
$router->get('https://electromart.online/public/about/contact', 'AboutController@contact');
$router->post('https://electromart.online/public/about/submit-contact', 'AboutController@submitContact');
?>