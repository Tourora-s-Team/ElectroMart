<?php
$router->get('/electromart/public/admin/user_manager', 'AdminUserController@index');
$router->get('/electromart/public/admin/users/deactivate', 'AdminUserController@deactivate');
$router->get('/electromart/public/admin/users/open', 'AdminUserController@open');
