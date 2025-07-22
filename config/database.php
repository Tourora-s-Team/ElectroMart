<?php
    class Database {
        private $servername = $_ENV['DB_HOST'];
        private $username = $_ENV['DB_USER'];
        private $password = $_ENV['DB_PASS'];
        private $dbname = $_ENV['DB_NAME'];

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

?>