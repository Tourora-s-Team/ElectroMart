<?php
$router->get('/electromart-o63e5.ondigitalocean.app/public/admin/products', 'AdminProductsController@index');
$router->post('/electromart-o63e5.ondigitalocean.app/public/admin/products/update', 'AdminProductsController@update');
$router->post('/electromart-o63e5.ondigitalocean.app/public/admin/products/delete/{id}', 'AdminProductsController@delete');
$router->post('/electromart-o63e5.ondigitalocean.app/public/admin/products/add', 'AdminProductsController@add');
$router->post('/electromart-o63e5.ondigitalocean.app/public/admin/products/save', 'AdminProductsController@save');
$router->get('/electromart-o63e5.ondigitalocean.app/public/admin/products/export-txt', 'AdminProductsController@exportTxt');
$router->post('/electromart-o63e5.ondigitalocean.app/public/admin/products/lock', 'AdminProductsController@lockProduct');
