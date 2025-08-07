<?php
/**
 * Shop API Routes
 * API endpoints for shop management functionality
 */

// Test API endpoint (no authentication required)
$router->get("https://electromart.online/public/api/test", "TestApiController@test");

// Shop Notifications API
$router->get("https://electromart.online/public/shop/api/notifications", "ShopApiController@getNotifications");
$router->post("https://electromart.online/public/shop/api/notifications/mark-read", "ShopApiController@markNotificationRead");
$router->post("https://electromart.online/public/shop/api/notifications/mark-all-read", "ShopApiController@markAllNotificationsRead");
$router->get('https://electromart.online/public/shop/finance/revenue-chart', 'ShopApiController@getRevenueChartJSON');