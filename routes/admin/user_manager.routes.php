<?php
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/admin/user_manager', 'AdminUserController@index');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/admin/users/deactivate', 'AdminUserController@deactivate');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/admin/users/open', 'AdminUserController@open');
