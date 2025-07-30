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

    // Hàm thực thi có tham số (INSERT, UPDATE, DELETE)
    public function write($sql, $params = [])
    {
        $conn = $this->db->connectDB();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($params);
    }
    // Hàm lấy ID cuối cùng được chèn ( tự tăng )
    public function getLastInsertId()
    {
        $conn = $this->db->connectDB();
        return $conn->lastInsertId();
    }

    // Gọi stored procedure có IN và OUT parameter
    public function callProcedureWithOutParam($procedureName, $inParams = [])
    {
        $conn = $this->db->connectDB();

        // Tạo placeholders cho IN parameters
        $placeholders = implode(',', array_fill(0, count($inParams), '?'));
        $sql = "CALL {$procedureName}($placeholders, @out_param)";

        // Gọi procedure
        $stmt = $conn->prepare($sql);
        $stmt->execute($inParams);
        $stmt->closeCursor(); // 💡 Cần đóng cursor để MariaDB trả OUT param

        // Lấy giá trị OUT
        $select = $conn->query("SELECT @out_param AS result");
        $row = $select->fetch(PDO::FETCH_ASSOC);
        return $row['result'] ?? null;
    }



}

?>