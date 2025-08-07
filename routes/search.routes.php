<?php
require_once ROOT_PATH . '/app/controllers/SearchController.php';

$router->get('https://electromart.online/public/search?q=', 'SearchController@search');


?>