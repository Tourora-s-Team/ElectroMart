<?php
require_once ROOT_PATH . '/app/controllers/BaseShopController.php';
require_once ROOT_PATH . '/app/models/Shop.php';

class ShopManagementController extends BaseShopController
{
    private $shopModel;

    public function __construct()
    {
        parent::__construct();
        $this->shopModel = new Shop();
    }

    // Hiển thị dashboard chính của shop
    public function dashboard()
    {
        // Thống kê tổng quan
        $stats = $this->getDashboardStats();
        $recentOrders = $this->getRecentOrders(5);
        $popularProducts = $this->getPopularProducts(5);

        $this->loadShopView('dashboard', [
            'stats' => $stats,
            'recentOrders' => $recentOrders,
            'popularProducts' => $popularProducts,
            'title' => 'Dashboard - Quản lý Shop',
            'currentPage' => 'dashboard',
            'breadcrumb' => [
                ['text' => 'Dashboard']
            ]
        ]);
    }

    // Hiển thị và cập nhật thông tin shop
    public function shopInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateShopInfo();
        }

        $shopInfo = $this->shopModel->getShopById($this->shopID);
        $this->loadShopView('shop_info', [
            'shop' => $shopInfo,
            'title' => 'Thông tin Shop - Quản lý Shop',
            'currentPage' => 'shop-info',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop/dashboard'],
                ['text' => 'Thông tin Shop']
            ]
        ]);
    }

    public function updateShopInfo()
    {
        $data = [
            'ShopID' => $this->shopID,
            'ShopName' => $_POST['ShopName'] ?? '',
            'Email' => $_POST['Email'] ?? '',
            'PhoneNumber' => $_POST['PhoneNumber'] ?? '',
            'Address' => $_POST['Address'] ?? '',
            'Description' => $_POST['Description'] ?? ''
        ];

        $result = $this->shopModel->updateShopInfo($data);

        if ($result) {
            $_SESSION['success_message'] = 'Cập nhật thông tin shop thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật thông tin shop.';
        }

        header("Location: https://electromart-t8ou8.ondigitalocean.app/public/shop/info");
        exit();
    }

    public function getDashboardStats()
    {
        require_once ROOT_PATH . '/core/HandleData.php';
        $handleData = new HandleData();

        // Tổng số đơn hàng
        $sql = "SELECT COUNT(*) as total_orders FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = ?";
        $totalOrders = $handleData->getDataWithParams($sql, [$this->shopID])[0]['total_orders'];

        // Doanh thu tháng này
        $sql = "SELECT COALESCE(SUM(od.Quantity * od.UnitPrice), 0) as monthly_revenue 
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = ? 
                AND MONTH(o.OrderDate) = MONTH(CURRENT_DATE()) 
                AND YEAR(o.OrderDate) = YEAR(CURRENT_DATE())";
        $monthlyRevenue = $handleData->getDataWithParams($sql, [$this->shopID])[0]['monthly_revenue'];

        // Tổng số sản phẩm
        $sql = "SELECT COUNT(*) as total_products FROM Product WHERE ShopID = ? AND IsActive = 1";
        $totalProducts = $handleData->getDataWithParams($sql, [$this->shopID])[0]['total_products'];

        // Đơn hàng đang xử lý
        $sql = "SELECT COUNT(*) as pending_orders FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = ? 
                AND o.Status IN ('Pending', 'Processing')";
        $pendingOrders = $handleData->getDataWithParams($sql, [$this->shopID])[0]['pending_orders'];

        return [
            'total_orders' => $totalOrders,
            'monthly_revenue' => $monthlyRevenue,
            'total_products' => $totalProducts,
            'pending_orders' => $pendingOrders
        ];
    }

    private function getRecentOrders($limit = 5)
    {
        require_once ROOT_PATH . '/core/HandleData.php';
        $handleData = new HandleData();

        $sql = "SELECT DISTINCT o.OrderID, o.OrderDate, o.Status, o.TotalAmount, 
                       cu.FullName as CustomerName
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                INNER JOIN Customer cu ON o.UserID = cu.UserID
                WHERE od.ShopID = ? 
                ORDER BY o.OrderDate DESC 
                LIMIT " . (int) $limit;

        return $handleData->getDataWithParams($sql, [$this->shopID]);
    }

    private function getPopularProducts($limit = 5)
    {
        require_once ROOT_PATH . '/core/HandleData.php';
        $handleData = new HandleData();

        $sql = "SELECT p.ProductID, p.ProductName, p.Price, 
                       COALESCE(SUM(od.Quantity), 0) as total_sold,
                       pi.ImageURL
                FROM Product p 
                LEFT JOIN OrderDetail od ON p.ProductID = od.ProductID AND p.ShopID = od.ShopID
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND p.ShopID = pi.ShopID AND pi.IsThumbnail = 1
                WHERE p.ShopID = ? AND p.IsActive = 1
                GROUP BY p.ProductID, p.ProductName, p.Price, pi.ImageURL
                ORDER BY total_sold DESC 
                LIMIT " . (int) $limit;

        return $handleData->getDataWithParams($sql, [$this->shopID]);
    }
}
