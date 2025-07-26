<?php

$router->get("/electromart/public/account/signup", "AuthController@showSignUp");
$router->get("/electromart/public/account/signin", "AuthController@showSignIn");
$router->post("/electromart/public/account/signin", "AuthController@signIn");
$router->post("/electromart/public/account/signup", "AuthController@signUp");
$router->get("/electromart/public/account/signout", "AuthController@signOut");

?>