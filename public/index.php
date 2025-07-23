<?php
define('ROOT_PATH', dirname(__DIR__));
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/router.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
$router = new Router();

// Required routes
require_once __DIR__ . '/../routes/account_manager.php';
require_once ROOT_PATH . '/routes/HomeSuggestion.php';
require_once ROOT_PATH . '/routes/cart.php';
require_once ROOT_PATH . '/routes/search.php';


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
    <link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'main.css' ?>">
    <!-- Import Font Awesome -->
    <script src="https://kit.fontawesome.com/f6aadf5dfa.js" crossorigin="anonymous"></script>
</head>

<body>


</body>

</html>