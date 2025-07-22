<?php
class Database
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "electromart";

    function connectDB()
    {
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