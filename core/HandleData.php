<?php
require_once ROOT_PATH . '/config/Database.php';

class HandleData extends Database
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->connectDB();
    }

    // Hàm thực thi trả về dữ liệu
    public function getData($sql)
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thực thi INSERT, UPDATE, DELETE không tham số
    public function execData($sql)
    {
        $this->conn->query($sql);
    }

    // Hàm thực thi trả về dữ liệu với tham số
    public function getDataWithParams($sql, $params = [])
    {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm thực thi INSERT, UPDATE, DELETE với tham số. Trả về false nếu có lỗi xảy ra.
    public function execDataWithParams($sql, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($params);
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Hàm lấy ID cuối cùng được chèn ( tự tăng )
    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    // Gọi stored procedure có IN và OUT parameter
    public function callProcedureWithOutParam($procedureName, $inParams = [])
    {
        // Tạo placeholders cho IN parameters
        $placeholders = implode(',', array_fill(0, count($inParams), '?'));
        $sql = "CALL {$procedureName}($placeholders, @out_param)";

        // Gọi procedure
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($inParams);
        $stmt->closeCursor(); // 💡 Cần đóng cursor để MariaDB trả OUT param

        // Lấy giá trị OUT
        $select = $this->conn->query("SELECT @out_param AS result");
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row['result'] ?? null;
    }



}
