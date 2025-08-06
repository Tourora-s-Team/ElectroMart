<?php
class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    private $port;

    // Biến static lưu kết nối duy nhất
    private static $connection = null;

    public function __construct()
    {
        $this->servername = $_ENV['DB_HOST'] ?? 'localhost';
        $this->username = $_ENV['DB_USER'] ?? 'root';
        $this->password = $_ENV['DB_PASS'] ?? '';
        $this->dbname = $_ENV['DB_NAME'] ?? 'electromart';
        $this->port = 25060;
    }

    protected function connectDB()
    {
        // Nếu đã có kết nối thì dùng lại
        if (self::$connection !== null) {
            return self::$connection;
        }

        try {
            $conn = new PDO(
                "mysql:host={$this->servername};port={$this->port};dbname={$this->dbname};charset=utf8",
                $this->username,
                $this->password,
                [
                    PDO::MYSQL_ATTR_SSL_CA => __DIR__ . "/ca-certificate.crt",
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );

            // Lưu lại kết nối vào biến static
            self::$connection = $conn;

            return $conn;
        } catch (PDOException $e) {
            echo "Error: Không thể kết nối CSDL: " . $e->getMessage();
            exit;
        }
    }
}
