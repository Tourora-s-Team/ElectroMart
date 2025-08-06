<?php
require_once ROOT_PATH . '/app/controllers/SearchController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/search?q=', 'SearchController@search');


?>