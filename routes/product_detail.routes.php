<?php
require_once ROOT_PATH . '/app/controllers/ProductDetailController.php';

$router->get('/electromart/public/deltail/{id}', 'ProductDetailController@showDetail');


?>