<?php
$router->get('https://electromart.online/public/admin/products', 'AdminProductsController@index');
$router->post('https://electromart.online/public/admin/products/update', 'AdminProductsController@update');
$router->post('https://electromart.online/public/admin/products/delete/{id}', 'AdminProductsController@delete');
$router->post('https://electromart.online/public/admin/products/add', 'AdminProductsController@add');
$router->post('https://electromart.online/public/admin/products/save', 'AdminProductsController@save');
$router->get('https://electromart.online/public/admin/products/export-txt', 'AdminProductsController@exportTxt');
$router->post('https://electromart.online/public/admin/products/lock', 'AdminProductsController@lockProduct');
$router->post('https://electromart.online/public/admin/products/toggle-status/{id}', 'AdminProductsController@toggleStatus');
