<?php

$router->get("https://electromart-t8ou8.ondigitalocean.app/public/account/signup", "AuthController@showSignUp");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/account/signin", "AuthController@showSignIn");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/account/signin", "AuthController@signIn");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/account/signup", "AuthController@signUp");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/account/signout", "AuthController@signOut");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/account/verify-email/{code}", "AuthController@verifyEmail");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/account/resend-verification", "AuthController@resendVerificationEmail");

?>