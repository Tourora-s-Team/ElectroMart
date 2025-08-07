<?php

$router->get("https://electromart.online/public/account/signup", "AuthController@showSignUp");
$router->get("https://electromart.online/public/account/signin", "AuthController@showSignIn");
$router->post("https://electromart.online/public/account/signin", "AuthController@signIn");
$router->post("https://electromart.online/public/account/signup", "AuthController@signUp");
$router->get("https://electromart.online/public/account/signout", "AuthController@signOut");
$router->get("https://electromart.online/public/account/verify-email/{code}", "AuthController@verifyEmail");
$router->post("https://electromart.online/public/account/resend-verification", "AuthController@resendVerificationEmail");

?>