<?php
/**
 * Shop API Routes
 * API endpoints for shop management functionality
 */

// Test API endpoint (no authentication required)
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/api/test", "TestApiController@test");

// Shop Notifications API
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/notifications", "ShopApiController@getNotifications");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/notifications/mark-read", "ShopApiController@markNotificationRead");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/notifications/mark-all-read", "ShopApiController@markAllNotificationsRead");
