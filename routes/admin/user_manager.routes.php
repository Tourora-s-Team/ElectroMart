<?php
$router->get('/electromart-o63e5.ondigitalocean.app/public/admin/user_manager', 'AdminUserController@index');
$router->get('/electromart-o63e5.ondigitalocean.app/public/admin/users/deactivate', 'AdminUserController@deactivate');
$router->get('/electromart-o63e5.ondigitalocean.app/public/admin/users/open', 'AdminUserController@open');
