<?php
require_once ROOT_PATH . '/app/controllers/PaymentController.php';

$router->get('https://electromart-t8ou8.ondigitalocean.app/public/payment', 'PaymentController@showPayment');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/payment', 'PaymentController@handlePaymentPost');

?>