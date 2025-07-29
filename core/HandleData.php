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

    // Hàm thực thi INSERT, UPDATE, DELETE không tham số
    public function execData($sql)
    {
        $conn = $this->db->connectDB();
        $conn->query($sql);
    }

    // Hàm thực thi trả về dữ liệu với tham số
    public function getDataWithParams($sql, $params = [])
    {
        $conn = $this->db->connectDB();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thực thi INSERT, UPDATE, DELETE với tham số. Trả về false nếu có lỗi xảy ra.
    public function execDataWithParams($sql, $params = [])
    {
        try {
            $conn = $this->db->connectDB();
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Hàm lấy ID cuối cùng được chèn ( tự tăng )
    public function getLastInsertId()
    {
        $conn = $this->db->connectDB();
        return $conn->lastInsertId();
    }
}
