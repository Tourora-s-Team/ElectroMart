<?php

$router->get("https://electromart-t8ou8.ondigitalocean.app/public/api/get-provinces", "AddressController@getProvinces");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/api/get-provinces-by-id/{id}", "AddressController@getProvincesById");
$router->get("https://electromart-t8ou8.ondigitalocean.app/public/api/get-wards/{provinceId}", "AddressController@getWardsByProvinceId");

?>