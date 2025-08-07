<?php
$router->get('https://electromart.online/public/admin/user_manager', 'AdminUserController@index');
$router->get('https://electromart.online/public/admin/users/deactivate', 'AdminUserController@deactivate');
$router->get('https://electromart.online/public/admin/users/open', 'AdminUserController@open');
