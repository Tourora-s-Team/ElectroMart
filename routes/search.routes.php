<?php
require_once ROOT_PATH . '/app/controllers/SearchController.php';

$router->get('/electromart-o63e5.ondigitalocean.app/public/search?q=', 'SearchController@search');


?>