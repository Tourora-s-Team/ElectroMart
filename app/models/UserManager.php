<?php
require_once ROOT_PATH . '/core/HandleData.php';

class UserManager
{
    private $db;

    public function __construct()
    {
        $this->db = new HandleData();
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM Users";
        return $this->db->getDataWithParams($sql);
    }

    public function deactivateUser($userId)
    {
        $sql = "UPDATE Users SET IsActive = 0 WHERE UserID = :userId";
        return $this->db->execDataWithParams($sql, ['userId' => $userId]);
    }

    public function getUsersFiltered($role = '', $email = '', $isActive = '')
    {
        $sql = "SELECT * FROM Users WHERE 1=1";
        $params = [];

        if ($role !== '') {
            $sql .= " AND Role = :role";
            $params['role'] = $role;
        }

        if ($email !== '') {
            $sql .= " AND Email LIKE :email";
            $params['email'] = '%' . $email . '%';
        }

        if ($isActive !== '') {
            $sql .= " AND IsActive = :isActive";
            $params['isActive'] = $isActive;
        }

        $handleData = new HandleData();
        return $handleData->getDataWithParams($sql, $params);
    }
}
