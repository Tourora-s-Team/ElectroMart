<?php
$router->get('https://electromart.online/public/account/info', 'AccountController@info');
$router->post('https://electromart.online/public/account/update-info', 'AccountController@updateInfo');

$router->get('https://electromart.online/public/account/order-history', 'AccountController@orderHistory');

// Receiver management routes
$router->get('https://electromart.online/public/account/receiver-info', 'AccountController@receiverInfo');
$router->post('https://electromart.online/public/account/add-receiver', 'AccountController@addReceiver');
$router->get('https://electromart.online/public/account/get-receiver/{id}', 'AccountController@getReceiver');
$router->post('https://electromart.online/public/account/update-receiver', 'AccountController@updateReceiver');
$router->delete('https://electromart.online/public/account/delete-receiver/{id}', 'AccountController@deleteReceiver');
$router->post('https://electromart.online/public/account/set-default-receiver/{id}', 'AccountController@setDefaultReceiver');

// Security settings route
$router->get('https://electromart.online/public/account/security', 'AccountController@security');
$router->post('https://electromart.online/public/account/change-password', 'AccountController@changePassword');


// Wish list route
$router->get('https://electromart.online/public/account/wish-list', 'AccountController@wishList');
$router->post('https://electromart.online/public/account/wish-list-remove/{id}', 'AccountController@deleteWishList');
$router->post('https://electromart.online/public/account/wish-list-add/{id}', 'AccountController@addWishList');
?>