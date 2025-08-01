<?php
/**
 * Shop Management Routes
 * Routes for shop management functionality
 */

// Shop Dashboard
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop", "ShopManagementController@dashboard");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/dashboard", "ShopManagementController@dashboard");

// Shop Information Management
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/info", "ShopManagementController@shopInfo");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/info", "ShopManagementController@updateShopInfo");

// Shop Orders Management
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/orders", "ShopOrderController@index");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/orders/view/{id}", "ShopOrderController@view");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/orders/update-status/{id}", "ShopOrderController@updateStatus");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/orders/search", "ShopOrderController@search");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/orders/export", "ShopOrderController@export");

// Shop Products Management
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/products", "ShopProductController@index");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/add", "ShopProductController@add");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/add", "ShopProductController@add");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/edit/{id}", "ShopProductController@edit");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/update/{id}", "ShopProductController@update");
$router->delete("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/delete/{id}", "ShopProductController@delete");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/toggle-status/{id}", "ShopProductController@toggleStatus");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/toggle-status", "ShopProductController@toggleStatus");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/products/delete-image/{id}", "ShopProductController@deleteImage");

// Shop Finance Management
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance", "ShopFinanceController@index");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/revenue-chart", "ShopFinanceController@getRevenueChartData");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/export-report", "ShopFinanceController@exportReport");

// Bank Account Management
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/bank-accounts", "ShopFinanceController@bankAccounts");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/bank-accounts", "ShopFinanceController@bankAccounts");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/add-bank-account", "ShopFinanceController@addBankAccount");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/bank-account/{id}", "ShopFinanceController@getBankAccount");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/update-bank-account/{id}", "ShopFinanceController@updateBankAccount");
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/delete-bank-account/{id}", "ShopFinanceController@deleteBankAccount");

// Payout Management
$router->post("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/request-payout", "ShopFinanceController@requestPayout");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/payout-history", "ShopFinanceController@payoutHistory");

// AJAX Endpoints for Shop Management
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/dashboard-stats", "ShopManagementController@getDashboardStats");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/orders", "ShopOrderController@getShopOrders");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/products", "ShopProductController@getShopProducts");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/shop/api/finance-stats", "ShopFinanceController@getFinanceStats");

?>