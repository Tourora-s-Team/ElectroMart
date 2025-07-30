<?php
require_once ROOT_PATH . '/core/HandleData.php';
class Receiver
{
    private $ReceiverID;
    private $ReceiverName;
    private $ContactNumber;
    private $AddressDetail;
    private $Street;
    private $Ward;
    private $City;
    private $Country;
    private $IsDefault;
    private $Note;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->ReceiverID = $data['ReceiverID'] ?? null;
            $this->ReceiverName = $data['ReceiverName'] ?? null;
            $this->ContactNumber = $data['ContactNumber'] ?? null;
            $this->AddressDetail = $data['AddressDetail'] ?? null;
            $this->Street = $data['Street'] ?? null;
            $this->Ward = $data['Ward'] ?? null;
            $this->City = $data['City'] ?? null;
            $this->Country = $data['Country'] ?? null;
            $this->IsDefault = $data['IsDefault'] ?? null;
            $this->Note = $data['Note'] ?? null;
        }
    }

    public function getReceiverById($receiverId)
    {
        $db = new HandleData();
        $sql = "SELECT * FROM receiver WHERE ReceiverID = :receiverId";
        $params = [':receiverId' => $receiverId];
        $result = $db->getDataWithParams($sql, $params);

        if ($result) {
            return $result[0];
        } else {
            return null;
        }

    }

    // Hàm trả về danh sách các Receiver
    public static function getAllReceiversByUserId($userId)
    {
        $db = new HandleData();
        $sql = "SELECT * FROM receiver WHERE UserId = :userId";
        $params = [':userId' => $userId];
        $result = $db->getDataWithParams($sql, $params);

        $receivers = [];
        foreach ($result as $row) {
            $receivers[] = new Receiver($row);
        }
        return $receivers;
    }

    public function getReceiverID()
    {
        return $this->ReceiverID;
    }

    public function getReceiverName()
    {
        return $this->ReceiverName;
    }

    public function getContactNumber()
    {
        return $this->ContactNumber;
    }

    public function getAddressDetail()
    {
        return $this->AddressDetail;
    }

    public function getStreet()
    {
        return $this->Street;
    }

    public function getWard()
    {
        return $this->Ward;
    }

    public function getCity()
    {
        return $this->City;
    }

    public function getCountry()
    {
        return $this->Country;
    }

    public function getIsDefault()
    {
        return $this->IsDefault;
    }

    public function getNote()
    {
        return $this->Note;
    }



    public function updateReceiver($receiverId, $data)
    {
        $db = new HandleData();
        $sql = "UPDATE receiver SET ReceiverName = :receiverName, ContactNumber = :contactNumber, 
                AddressDetail = :addressDetail, Street = :street, Ward = :ward, City = :city, 
                Country = :country, isDefault = :isDefault, Note = :note WHERE ReceiverID = :receiverId AND UserID = :userId";
        $params = [
            ':receiverName' => $data['ReceiverName'],
            ':contactNumber' => $data['ContactNumber'],
            ':addressDetail' => $data['AddressDetail'],
            ':street' => $data['Street'],
            ':ward' => $data['Ward'],
            ':city' => $data['City'],
            ':country' => $data['Country'],
            ':isDefault' => $data['isDefault'],
            ':note' => $data['Note'],
            ':userId' => $data['UserId'],
            ':receiverId' => $receiverId
        ];
        return $db->execDataWithParams($sql, $params);
    }
    public function addReceiver($data)
    {
        $db = new HandleData();
        $sql = "INSERT INTO receiver (UserId, ReceiverName, ContactNumber, AddressDetail, Street, Ward, City, Country, isDefault, Note) 
                VALUES (:userId, :receiverName, :contactNumber, :addressDetail, :street, :ward, :city, :country, :isDefault, :note)";
        $params = [
            ':userId' => $data['UserId'],
            ':receiverName' => $data['ReceiverName'],
            ':contactNumber' => $data['ContactNumber'],
            ':addressDetail' => $data['AddressDetail'],
            ':street' => $data['Street'],
            ':ward' => $data['Ward'],
            ':city' => $data['City'],
            ':country' => $data['Country'],
            ':isDefault' => $data['isDefault'],
            ':note' => $data['Note']
        ];
        return $db->execDataWithParams($sql, $params);
    }
    public function deleteReceiverById($id)
    {
        $db = new HandleData();
        $sql = "DELETE FROM receiver WHERE ReceiverID = :id";
        $params = [':id' => $id];
        return $db->execDataWithParams($sql, $params);
    }

    public function setDefaultReceiver($UserId, $receiverId)
    {
        $db = new HandleData();
        // Đặt tất cả các địa chỉ của người dùng thành không phải mặc định
        $sql = "UPDATE receiver SET isDefault = 0 WHERE UserId = :userId";
        $params = [':userId' => $UserId];
        $db->execDataWithParams($sql, $params);

        // Đặt địa chỉ được chọn làm mặc định
        $sql = "UPDATE receiver SET isDefault = 1 WHERE ReceiverID = :receiverId AND UserId = :userId";
        $params = [':receiverId' => $receiverId, ':userId' => $UserId];
        return $db->execDataWithParams($sql, $params);
    }
}

?>