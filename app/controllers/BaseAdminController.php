<?php
// filepath: c:\xampp\htdocs\ElectroMart\app\controllers\BaseAdminController.php
require_once ROOT_PATH . '/app/controllers/AuthController.php';

abstract class BaseAdminController
{
    protected $authController;

    public function __construct()
    {
        $this->authController = new AuthController();
        $this->checkAdminAccess();
    }

    private function checkAdminAccess()
    {
        if (!$this->authController->authenticateAdminRole()) {
            // Nếu là AJAX request, trả về JSON
            if ($this->isAjaxRequest()) {
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode(['error' => 'Access denied. Admin role required.']);
                exit();
            }

            // Nếu là HTTP request thường, redirect
            header("Location: https://electromart-t8ou8.ondigitalocean.app/public/account/signin");
            exit();
        }
    }

    private function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    // Method để load admin layout
    protected function loadAdminView($viewFile, $data = [])
    {
        extract($data);
        include '../app/views/layouts/AdminHeader.php';
        include $viewFile;
        include '../app/views/layouts/AdminFooter.php';
    }
}
