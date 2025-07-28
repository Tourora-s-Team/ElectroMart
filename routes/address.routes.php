<?php

$router->get("/electromart/public/api/get-provinces", "AddressController@getProvinces");
$router->get("/electromart/public/api/get-provinces-by-id/{id}", "AddressController@getProvincesById");
$router->get("/electromart/public/api/get-wards/{provinceId}", "AddressController@getWardsByProvinceId");

?>