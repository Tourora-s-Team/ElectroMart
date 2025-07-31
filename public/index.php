<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Sử dụng session để quản lý trạng thái người dùng
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT_PATH', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/router.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$router = new Router();

// Required routes
require_once ROOT_PATH . '/routes/account_manager.routes.php';
require_once ROOT_PATH . '/routes/auth.routes.php';
require_once ROOT_PATH . '/routes/home.routes.php';
require_once ROOT_PATH . '/routes/cart.routes.php';
require_once ROOT_PATH . '/routes/search.routes.php';
require_once ROOT_PATH . '/routes/product_detail.routes.php';
require_once ROOT_PATH . '/routes/address.routes.php';
require_once ROOT_PATH . '/routes/shop_detail.routes.php';
require_once ROOT_PATH . '/routes/payment.routes.php';
require_once ROOT_PATH . '/routes/order.routes.php';

require_once ROOT_PATH . '/routes/admin/orders_manager.routes.php';
require_once ROOT_PATH . '/routes/admin/products_manager.routes.php';
require_once ROOT_PATH . '/routes/admin/financial_manager.routes.php';
require_once ROOT_PATH . '/routes/admin/user_manager.routes.php';


$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Electro Mart</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'base.css' ?>">
    <!-- Import Font Awesome -->
    <link rel="stylesheet" href="/electromart/public/fontawesome/css/all.min.css">
</head>

<body>


</body>

</html>