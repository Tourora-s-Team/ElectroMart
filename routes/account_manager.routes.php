<?php 
$router->get('/electromart/public/account/info', 'AccountController@info');
$router->post('/electromart/public/account/update-info', 'AccountController@updateInfo');

$router->get('/electromart/public/account/order-history', 'AccountController@orderHistory');

// Receiver management routes
$router->get('/electromart/public/account/receiver-info', 'AccountController@receiverInfo');
$router->post('/electromart/public/account/add-receiver', 'AccountController@addReceiver');
$router->get('/electromart/public/account/get-receiver/{id}', 'AccountController@getReceiver');
$router->post('/electromart/public/account/update-receiver', 'AccountController@updateReceiver');
$router->delete('/electromart/public/account/delete-receiver/{id}', 'AccountController@deleteReceiver');
$router->post('/electromart/public/account/set-default-receiver/{id}', 'AccountController@setDefaultReceiver');

// Security settings route
$router->get('/electromart/public/account/security', 'AccountController@security');
$router->post('/electromart/public/account/change-password', 'AccountController@changePassword');


// Wish list route
$router->get('/electromart/public/account/wish-list', 'AccountController@wishList');
$router->post('/electromart/public/account/wish-list-remove/{id}', 'AccountController@deleteWishList');
$router->post('/electromart/public/account/wish-list-add/{id}', 'AccountController@addWishList');
?>
