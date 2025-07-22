<?php
require_once ROOT_PATH . '/config/Database.php';

class HandleData extends Database
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    // Hàm thực thi trả về dữ liệu
    public function getData($sql)
    {
        $conn = $this->db->connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thực thi không trả về dữ liệu
    public function execData($sql)
    {
        $conn = $this->db->connectDB();
        $conn->query($sql);
    }
}

?>