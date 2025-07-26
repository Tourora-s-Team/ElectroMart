<?php 
$router->get('/electromart/public/account/info', 'AccountController@info');
$router->get('/electromart/public/account/order-history', 'AccountController@orderHistory');
$router->get('/electromart/public/account/shipping-address', 'AccountController@shippingAddress');
$router->get('/electromart/public/account/security', 'AccountController@security');
$router->post('/electromart/public/account/update-info', 'AccountController@updateInfo');

?>
