<?php
require_once(__DIR__ . '/../models/UserManager.php');
require_once ROOT_PATH . '/app/controllers/BaseAdminController.php';

class AdminUserController extends BaseAdminController
{
    private $userManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
    }
    public function index()
    {
        $role = isset($_GET['Role']) ? $_GET['Role'] : '';
        $email = isset($_GET['Email']) ? $_GET['Email'] : '';
        $isActive = isset($_GET['IsActive']) ? $_GET['IsActive'] : '';
        // Gọi hàm có thể lọc theo nhiều tiêu chí
        $users = $this->userManager->getUsersFiltered($role, $email, $isActive);

        require_once __DIR__ . '/../views/admin/user_manager.php';
    }
    public function deactivate()
    {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $this->userManager->deactivateUser($userId);
        }
        header("Location: /electromart/public/admin/user_manager");
        exit;
    }
}
