<?php
require_once ROOT_PATH . '/app/controllers/AboutController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/about', 'AboutController@index');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/about/contact', 'AboutController@contact');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/about/submit-contact', 'AboutController@submitContact');
?>