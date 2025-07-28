<?php
require_once ROOT_PATH . '/core/LocHandleData.php';
class Province
{
    public $Id;
    public $Name;
    public $Slug;
    public $Type;
    public $NameWithType;

    private $locHandleData;


    // Hàm khởi tạo Province với ID
    // Nếu ID không được cung cấp, Province sẽ được khởi tạo với dữ liệu rỗng
    // Nếu ID được cung cấp, Province sẽ được khởi tạo với dữ liệu từ cơ sở dữ liệu
    public function __construct($Id = null)
    {
        $this->locHandleData = new LocHandleData();
        if ($Id !== null) {
            $sql = "SELECT * FROM provinces WHERE Id = :id";
            $params = [':id' => $Id];
            $data = $this->locHandleData->getDataWithParams($sql, $params);

            if (!empty($data)) {
                $province = $data[0]; // vì fetchAll trả về mảng nhiều dòng
                $this->Id = $province['Id'];
                $this->Name = $province['Name'];
                $this->Slug = $province['Slug'];
                $this->Type = $province['Type'];
                $this->NameWithType = $province['NameWithType'];
            }
        }
    }

    // Hàm trả về ID và Name của tất cả các tỉnh/thành phố
    public function getAllProvinces()
    {
        $sql = "SELECT * FROM provinces";
        $provinceNames = $this->locHandleData->getData($sql);
        return $provinceNames;
    }

    public function getProvinceById($id)
    {
        $sql = "SELECT * FROM provinces WHERE Id = :id";
        $params = [':id' => $id];
        $provinceData = $this->locHandleData->getDataWithParams($sql, $params);
        
        if (!empty($provinceData)) {
            return $provinceData[0]; // Trả về tỉnh/thành phố đầu tiên
        }
        return null; // Nếu không tìm thấy, trả về null
    }

}
?>