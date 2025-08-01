<?php
$router->get('/electromart-o63e5.ondigitalocean.app/public/account/info', 'AccountController@info');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/update-info', 'AccountController@updateInfo');

$router->get('/electromart-o63e5.ondigitalocean.app/public/account/order-history', 'AccountController@orderHistory');

// Receiver management routes
$router->get('/electromart-o63e5.ondigitalocean.app/public/account/receiver-info', 'AccountController@receiverInfo');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/add-receiver', 'AccountController@addReceiver');
$router->get('/electromart-o63e5.ondigitalocean.app/public/account/get-receiver/{id}', 'AccountController@getReceiver');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/update-receiver', 'AccountController@updateReceiver');
$router->delete('/electromart-o63e5.ondigitalocean.app/public/account/delete-receiver/{id}', 'AccountController@deleteReceiver');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/set-default-receiver/{id}', 'AccountController@setDefaultReceiver');

// Security settings route
$router->get('/electromart-o63e5.ondigitalocean.app/public/account/security', 'AccountController@security');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/change-password', 'AccountController@changePassword');


// Wish list route
$router->get('/electromart-o63e5.ondigitalocean.app/public/account/wish-list', 'AccountController@wishList');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/wish-list-remove/{id}', 'AccountController@deleteWishList');
$router->post('/electromart-o63e5.ondigitalocean.app/public/account/wish-list-add/{id}', 'AccountController@addWishList');
?>