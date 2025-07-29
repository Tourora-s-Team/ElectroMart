<?php
$router->get('/electromart/public/admin/products', 'AdminProductsController@index');
$router->post('/electromart/public/admin/products/update', 'AdminProductsController@update');
$router->post('/electromart/public/admin/products/delete/{id}', 'AdminProductsController@delete');
$router->post('/electromart/public/admin/products/add', 'AdminProductsController@add');
$router->post('/electromart/public/admin/products/save', 'AdminProductsController@save');
$router->get('/electromart/public/admin/products/export-txt', 'AdminProductsController@exportTxt');
$router->post('/electromart/public/admin/products/lock', 'AdminProductsController@lockProduct');
