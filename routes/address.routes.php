<?php

$router->get("https://electromart.online/public/api/get-provinces", "AddressController@getProvinces");
$router->get("https://electromart.online/public/api/get-provinces-by-id/{id}", "AddressController@getProvincesById");
$router->get("https://electromart.online/public/api/get-wards/{provinceId}", "AddressController@getWardsByProvinceId");

?>