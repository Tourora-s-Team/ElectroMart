<?php
require_once ROOT_PATH . '/app/controllers/SearchController.php';

$router->get('/electromart/public/search?q=', 'SearchController@search');


?>