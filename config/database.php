<?php
    class Database {
        private $servername;
        private $username;
        private $password;
        private $dbname;

        public function __construct() {
        $this->servername = $_ENV['DB_HOST'] ?? 'localhost';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
        $this->dbname = $_ENV['DB_NAME'] ?? 'electromart';
    }

        function connectDB() {
            try {
                $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
                // Thiết lập chế độ báo lỗi
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (PDOException $e) {
                echo "Error: Không thể kết nối CSDL: " . $e->getMessage();
            }
        }

}
// Khai báo lớp Database

?>