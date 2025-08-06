<?php
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/admin/products', 'AdminProductsController@index');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/update', 'AdminProductsController@update');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/delete/{id}', 'AdminProductsController@delete');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/add', 'AdminProductsController@add');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/save', 'AdminProductsController@save');
$router->get('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/export-txt', 'AdminProductsController@exportTxt');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/lock', 'AdminProductsController@lockProduct');
$router->post('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/toggle-status/{id}', 'AdminProductsController@toggleStatus');
