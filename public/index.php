<?php
// Khai báo đường dẫn gốc
define('ROOT_PATH', dirname(__DIR__));

// Load configuration và core files
require_once ROOT_PATH . '/config/database.php';
require_once ROOT_PATH . '/core/Router.php';

session_start();

// Khởi tạo Router
$router = new Router();

// Load routes
require_once ROOT_PATH . '/routes/HomeSuggestion.php';

// Dispatch route
try {
    $router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} catch (Exception $e) {
    // Xử lý lỗi routing
    echo $e->getMessage();
}
?>