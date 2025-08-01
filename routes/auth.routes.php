<?php

$router->get("/electromart-o63e5.ondigitalocean.app/public/account/signup", "AuthController@showSignUp");
$router->get("/electromart-o63e5.ondigitalocean.app/public/account/signin", "AuthController@showSignIn");
$router->post("/electromart-o63e5.ondigitalocean.app/public/account/signin", "AuthController@signIn");
$router->post("/electromart-o63e5.ondigitalocean.app/public/account/signup", "AuthController@signUp");
$router->get("/electromart-o63e5.ondigitalocean.app/public/account/signout", "AuthController@signOut");
$router->get("/electromart-o63e5.ondigitalocean.app/public/account/verify-email/{code}", "AuthController@verifyEmail");
$router->post("/electromart-o63e5.ondigitalocean.app/public/account/resend-verification", "AuthController@resendVerificationEmail");

?>