<?php
    require_once __DIR__ . '/../config/Database.php';

    class HandleData extends Database {
        private $db;

        public function __construct() {
            $this->db = new Database();
        }

        // Hàm thực thi trả về dữ liệu
        public function getData($sql) {
            $conn = $this->db->connectDB();
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ?: [];
        }

        // Hàm thực thi không trả về dữ liệu
        public function execData($sql) {
            $conn = $this->db->connectDB();
            $conn->query($sql);
        }
    }

?>