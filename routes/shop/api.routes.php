<?php
/**
 * Shop API Routes
 * API endpoints for shop management functionality
 */

// Test API endpoint (no authentication required)
$router->get("/electromart/public/api/test", "TestApiController@test");

// Shop Notifications API
$router->get("/electromart/public/shop/api/notifications", "ShopApiController@getNotifications");
$router->post("/electromart/public/shop/api/notifications/mark-read", "ShopApiController@markNotificationRead");
$router->post("/electromart/public/shop/api/notifications/mark-all-read", "ShopApiController@markAllNotificationsRead");
