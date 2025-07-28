<?php
require_once(__DIR__ . "/../models/loc/Province.php");
require_once(__DIR__ . "/../models/loc/Ward.php");
class AddressController
{
    private $provinceModel;
    private $wardModel;

    public function __construct()
    {
        $this->provinceModel = new Province();
        $this->wardModel = new Ward();
    }
    public function getProvinces()
    {
        ob_clean(); // Xóa output buffer
        
        header('Content-Type: application/json; charset=utf-8');
        
        $data = $this->provinceModel->getAllProvinces();
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function getProvincesById($id = null)
    {
        ob_clean(); // Xóa output buffer
        header('Content-Type: application/json; charset=utf-8');

        if (empty($id)) {
            echo json_encode([]);
            exit();
        }

        $data = $this->provinceModel->getProvinceById($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

    public function getWardsByProvinceId($provinceId = null)
    {
        ob_clean(); // Xóa output buffer
        header('Content-Type: application/json; charset=utf-8');

        if (empty($provinceId)) {
            echo json_encode([]);
            exit();
        }

        $data = $this->wardModel->getAllWardByProvinceId($provinceId);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit();
    }

}

?>