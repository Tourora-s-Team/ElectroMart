<?php
require_once ROOT_PATH . '/app/controllers/AuthController.php';

abstract class BaseShopController
{
    protected $authController;
    protected $shopID;
    protected $userID;

    public function __construct()
    {
        $this->authController = new AuthController();
        $this->checkShopAccess();
    }
    protected function returnJson($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }


    private function checkShopAccess()
    {
        if (!$this->authController->authenticateShopRole()) {
            // Nếu là AJAX request, trả về JSON
            if ($this->isAjaxRequest()) {
                // Clear any existing output to ensure clean JSON
                if (ob_get_level()) {
                    ob_clean();
                }
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Access denied. Shop role required.', 'message' => 'Bạn không có quyền truy cập. Vui lòng đăng nhập với tài khoản shop.']);
                exit();
            }

            // Nếu là HTTP request thường, redirect
            header("Location: /electromart/public/account/signin");
            exit();
        }

        // Lấy ShopID và UserID từ session
        $this->userID = $_SESSION['user'][0]['UserID'];
        $this->shopID = $this->getShopIDByUserID($this->userID);

        if (!$this->shopID) {
            if ($this->isAjaxRequest()) {
                // Clear any existing output to ensure clean JSON
                if (ob_get_level()) {
                    ob_clean();
                }
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Shop not found for this user.', 'message' => 'Không tìm thấy shop cho tài khoản này.']);
                exit();
            }
            header("Location: /electromart/public/account/signin");
            exit();
        }
    }

    private function getShopIDByUserID($userID)
    {
        require_once ROOT_PATH . '/core/HandleData.php';
        $handleData = new HandleData();
        $sql = "SELECT ShopID FROM Shop WHERE UserID = :userID";
        $params = ['userID' => $userID];
        $result = $handleData->getDataWithParams($sql, $params);
        return $result ? $result[0]['ShopID'] : null;
    }

    protected function isAjaxRequest()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    // Method để load shop admin layout
    protected function loadShopView($viewName, $data = [])
    {
        // Get shop information for layout
        $shopInfo = $this->getShopInfo();

        // Add shop info to data
        $data['shopInfo'] = $shopInfo;

        // Add common layout data
        $data['breadcrumb'] = $data['breadcrumb'] ?? [];
        $data['notifications'] = $this->getNotifications();
        $data['totalNotifications'] = count(array_filter($data['notifications'], function ($n) {
            return !$n['is_read'];
        }));
        $data['orderNotifications'] = $this->getOrderNotificationCount();

        // Get the view content
        $viewPath = ROOT_PATH . "/app/views/shop/{$viewName}.php";
        if (!file_exists($viewPath)) {
            throw new Exception("View file not found: {$viewPath}");
        }

        // Start output buffering
        ob_start();
        extract($data);
        include $viewPath;
        $content = ob_get_clean();

        // Load the admin layout
        $layoutData = array_merge($data, ['content' => $content]);
        extract($layoutData);
        include ROOT_PATH . '/app/views/layouts/shop_admin.php';
    }

    /**
     * Get shop information
     */
    private function getShopInfo()
    {
        $shopID = $this->getShopIDByUserID($_SESSION['user'][0]['UserID']);
        if (!$shopID) {
            return [];
        }

        require_once ROOT_PATH . '/core/HandleData.php';
        $handleData = new HandleData();
        $sql = "SELECT s.*, u.FullName as OwnerName 
                FROM Shop s 
                LEFT JOIN Customer u ON s.UserID = u.UserID 
                WHERE s.ShopID = ?";

        $result = $handleData->getDataWithParams($sql, [$shopID]);
        return !empty($result) ? $result[0] : [];
    }

    /**
     * Get shop notifications
     */
    private function getNotifications()
    {
        // Mock notifications - in real implementation, fetch from database
        return [
            [
                'title' => 'Đơn hàng mới',
                'message' => 'Bạn có 3 đơn hàng mới cần xử lý',
                'time' => '5 phút trước',
                'icon' => 'fas fa-shopping-cart',
                'is_read' => false
            ],
            [
                'title' => 'Sản phẩm hết hàng',
                'message' => 'iPhone 14 Pro Max đã hết hàng',
                'time' => '1 giờ trước',
                'icon' => 'fas fa-exclamation-triangle',
                'is_read' => false
            ],
            [
                'title' => 'Doanh thu tăng',
                'message' => 'Doanh thu tháng này tăng 15%',
                'time' => '2 giờ trước',
                'icon' => 'fas fa-chart-line',
                'is_read' => true
            ]
        ];
    }

    /**
     * Get order notification count
     */
    private function getOrderNotificationCount()
    {
        $shopID = $this->getShopIDByUserID($_SESSION['user'][0]['UserID']);
        if (!$shopID) {
            return 0;
        }

        require_once ROOT_PATH . '/core/HandleData.php';
        $handleData = new HandleData();
        $sql = "SELECT COUNT(*) as count 
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                INNER JOIN Product p ON od.ProductID = p.ProductID 
                WHERE p.ShopID = ? AND o.Status = 'Pending'";

        $result = $handleData->getDataWithParams($sql, [$shopID]);
        return !empty($result) ? (int) $result[0]['count'] : 0;
    }

    // Method để load view thông thường
    protected function loadView($view, $data = [])
    {
        extract($data);
        $viewFile = ROOT_PATH . "/app/views/shop/{$view}.php";
        if (!file_exists($viewFile)) {
            $viewFile = ROOT_PATH . "/app/views/{$view}.php";
        }
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("Không tìm thấy File: {$view}");
        }
    }
}
