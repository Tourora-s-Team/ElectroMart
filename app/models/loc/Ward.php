<?php
require_once ROOT_PATH . '/core/LocHandleData.php';

class Ward {
    public function getAllWardByProvinceId($provinceId) {
        $locHandleData = new LocHandleData();
        $sql = "SELECT * FROM wards WHERE ProvinceID = ?";
        $wards = $locHandleData->getDataWithParams($sql, [$provinceId]);
        return $wards;
    }
}
?>