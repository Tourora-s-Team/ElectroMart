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

    public function connectDB()
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

    // Hàm kết nối CSDL mặc định (dùng trong XAMPP).
    // function connectDB()
    // {
    //     $host = '127.0.0.1';        // hoặc 'localhost'
    //     $dbname = 'your_database';  // ← Thay bằng tên CSDL của bạn
    //     $username = 'root';         // ← Mặc định XAMPP dùng root
    //     $password = '';             // ← Mặc định XAMPP không có mật khẩu

    //     try {
    //         $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    //         $pdo = new PDO($dsn, $username, $password, [
    //             PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Bắt lỗi dạng exception
    //             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Trả về mảng kết quả dạng key => value
    //         ]);
    //         return $pdo;
    //     } catch (PDOException $e) {
    //         die("Kết nối CSDL thất bại: " . $e->getMessage());
    //     }
    // }

}
