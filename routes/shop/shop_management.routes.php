<?php
/**
 * Shop Management Routes
 * Routes for shop management functionality
 */

// Shop Dashboard
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop", "ShopManagementController@dashboard");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/dashboard", "ShopManagementController@dashboard");

// Shop Information Management
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/info", "ShopManagementController@shopInfo");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/info", "ShopManagementController@updateShopInfo");

// Shop Orders Management
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/orders", "ShopOrderController@index");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/orders/view/{id}", "ShopOrderController@view");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/orders/update-status/{id}", "ShopOrderController@updateStatus");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/orders/search", "ShopOrderController@search");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/orders/export", "ShopOrderController@export");

// Shop Products Management
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/products", "ShopProductController@index");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/products/add", "ShopProductController@add");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/products/add", "ShopProductController@add");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/products/edit/{id}", "ShopProductController@edit");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/products/update/{id}", "ShopProductController@update");
$router->delete("/electromart-o63e5.ondigitalocean.app/public/shop/products/delete/{id}", "ShopProductController@delete");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/products/toggle-status/{id}", "ShopProductController@toggleStatus");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/products/toggle-status", "ShopProductController@toggleStatus");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/products/delete-image/{id}", "ShopProductController@deleteImage");

// Shop Finance Management
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/finance", "ShopFinanceController@index");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/finance/revenue-chart", "ShopFinanceController@getRevenueChartData");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/finance/export-report", "ShopFinanceController@exportReport");

// Bank Account Management
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/finance/bank-accounts", "ShopFinanceController@bankAccounts");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/finance/bank-accounts", "ShopFinanceController@bankAccounts");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/finance/add-bank-account", "ShopFinanceController@addBankAccount");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/finance/bank-account/{id}", "ShopFinanceController@getBankAccount");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/finance/update-bank-account/{id}", "ShopFinanceController@updateBankAccount");
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/finance/delete-bank-account/{id}", "ShopFinanceController@deleteBankAccount");

// Payout Management
$router->post("/electromart-o63e5.ondigitalocean.app/public/shop/finance/request-payout", "ShopFinanceController@requestPayout");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/finance/payout-history", "ShopFinanceController@payoutHistory");

// AJAX Endpoints for Shop Management
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/api/dashboard-stats", "ShopManagementController@getDashboardStats");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/api/orders", "ShopOrderController@getShopOrders");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/api/products", "ShopProductController@getShopProducts");
$router->get("/electromart-o63e5.ondigitalocean.app/public/shop/api/finance-stats", "ShopFinanceController@getFinanceStats");

?>