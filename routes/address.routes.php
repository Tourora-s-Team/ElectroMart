<?php

$router->get("/electromart-o63e5.ondigitalocean.app/public/api/get-provinces", "AddressController@getProvinces");
$router->get("/electromart-o63e5.ondigitalocean.app/public/api/get-provinces-by-id/{id}", "AddressController@getProvincesById");
$router->get("/electromart-o63e5.ondigitalocean.app/public/api/get-wards/{provinceId}", "AddressController@getWardsByProvinceId");

?>