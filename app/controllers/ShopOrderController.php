<?php
require_once ROOT_PATH . '/app/controllers/BaseShopController.php';
require_once ROOT_PATH . '/app/models/OrdersManager.php';
require_once ROOT_PATH . '/app/models/ShopOrder.php';

class ShopOrderController extends BaseShopController
{
    private $orderModel;
    private $shopOrderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrdersManager();
        $this->shopOrderModel = new ShopOrder();
    }

    // Hiển thị danh sách đơn hàng của shop
    public function index()
    {
        $filters = [
            'status' => $_GET['status'] ?? '',
            'fromDate' => $_GET['fromDate'] ?? '',
            'toDate' => $_GET['toDate'] ?? '',
            'orderID' => $_GET['orderID'] ?? ''
        ];

        $orders = $this->shopOrderModel->getShopOrders($this->shopID, $filters);
        $stats = $this->shopOrderModel->getOrderStats($this->shopID, $filters);

        $this->loadShopView('orders', [
            'orders' => $orders,
            'stats' => $stats,
            'filters' => $filters,
            'title' => 'Quản lý đơn hàng',
            'currentPage' => 'orders',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop'],
                ['text' => 'Quản lý đơn hàng']
            ]
        ]);
    }

    // Xem chi tiết đơn hàng
    public function view($orderID)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->updateStatus($orderID);
        }

        $orderDetail = $this->shopOrderModel->getOrderDetail($orderID, $this->shopID);

        if (!$orderDetail || !$this->shopOrderModel->checkOrderBelongsToShop($orderID, $this->shopID)) {
            $_SESSION['error_message'] = 'Không tìm thấy đơn hàng hoặc bạn không có quyền truy cập.';
            header("Location: https://electromart-t8ou8.ondigitalocean.app/public/shop/orders");
            exit();
        }

        $this->loadShopView('order_detail', [
            'order' => $orderDetail,
            'title' => 'Chi tiết đơn hàng #' . $orderID,
            'currentPage' => 'orders',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop'],
                ['text' => 'Quản lý đơn hàng', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop/orders'],
                ['text' => 'Chi tiết đơn hàng #' . $orderID]
            ]
        ]);
    }

    // Tìm kiếm đơn hàng theo mã
    public function search()
    {
        $orderID = $_GET['q'] ?? '';
        if (empty($orderID)) {
            header("Location: https://electromart-t8ou8.ondigitalocean.app/public/shop/orders");
            exit();
        }

        $filters = [
            'orderID' => $orderID
        ];

        $orders = $this->shopOrderModel->getShopOrders($this->shopID, $filters);
        $stats = $this->shopOrderModel->getOrderStats($this->shopID, $filters);

        $this->loadShopView('orders', [
            'orders' => $orders,
            'stats' => $stats,
            'filters' => $filters,
            'title' => 'Kết quả tìm kiếm: ' . $orderID,
            'currentPage' => 'orders',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop'],
                ['text' => 'Quản lý đơn hàng', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop/orders'],
                ['text' => 'Kết quả tìm kiếm']
            ]
        ]);
    }

    // Cập nhật trạng thái đơn hàng
    public function updateStatus($orderID)
    {
        $newStatus = $_POST['status'] ?? '';

        if (empty($newStatus) || !$this->shopOrderModel->checkOrderBelongsToShop($orderID, $this->shopID)) {
            $_SESSION['error_message'] = 'Không thể cập nhật trạng thái đơn hàng.';
            return;
        }

        $result = $this->shopOrderModel->updateOrderStatus($orderID, $newStatus);

        if ($result) {
            $_SESSION['success_message'] = 'Cập nhật trạng thái đơn hàng thành công!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật trạng thái đơn hàng.';
        }
        header("Location: https://electromart-t8ou8.ondigitalocean.app/public/shop/orders");
        exit();
    }

}
