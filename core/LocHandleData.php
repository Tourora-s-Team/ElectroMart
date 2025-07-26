<?php
require_once ROOT_PATH . '/config/LocDatabase.php';

class LocHandleData extends LocDatabase
{
    private $db;

    public function __construct()
    {
        $this->db = new LocDatabase();
    }

    // Hàm thực thi trả về dữ liệu
    public function getData($sql)
    {
        $conn = $this->db->connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thực thi trả về dữ liệu với tham số
    public function getDataWithParams($sql, $params = [])
    {
        $conn = $this->db->connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}

?>
?>