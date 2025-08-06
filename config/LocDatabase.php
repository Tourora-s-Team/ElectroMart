<?php
class LocDatabase
{
    private $servername;
    private $username;
    private $password;
    private $dbname;

    public function __construct()
    {
        $this->servername = getenv('DB_HOST');
        $this->username = getenv('DB_USER');
        $this->password = getenv('DB_PASS');
        $this->dbname = getenv('LOC_DB_NAME');
    }

    public function connectDB()
    {
        try {
            $conn = new PDO(
                "mysql:host=$this->servername;port=25060;dbname=$this->dbname;charset=utf8",
                $this->username,
                $this->password,
                [
                    PDO::MYSQL_ATTR_SSL_CA => __DIR__ . "/ca-certificate.crt", // đặt đúng đường dẫn
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                ]
            );
            return $conn;
        } catch (PDOException $e) {
            echo "Error: Không thể kết nối CSDL: " . $e->getMessage();
        }
    }

}
// Khai báo lớp Database

?>