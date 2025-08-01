<?php
/**
 * Shop API Routes
 * API endpoints for shop management functionality
 */

// Test API endpoint (no authentication required)
$router->get("/electromart-o63e5.ondigitalocean.app/public/api/test", "TestApiController@test");

// Shop Notifications API
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/api/notifications", "ShopApiController@getNotifications");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/api/notifications/mark-read", "ShopApiController@markNotificationRead");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/api/notifications/mark-all-read", "ShopApiController@markAllNotificationsRead");
