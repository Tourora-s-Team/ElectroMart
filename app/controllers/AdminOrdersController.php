<?php
require_once ROOT_PATH . '/app/models/Orders.php';

class AdminOrdersController
{
    private $orderModel;

    public function __construct()
    {
        $this->orderModel = new Orders();
    }

    public function index()
    {
        $filters = [
            'status' => $_GET['status'] ?? '',
            'fromDate' => $_GET['fromDate'] ?? '',
            'toDate' => $_GET['toDate'] ?? '',
            'userID' => $_GET['userID'] ?? ''
        ];

        $orders = $this->orderModel->getAllOrders($filters);
        $stats = $this->orderModel->getOrderStats($filters);
        $this->loadView('OrdersFE', [
            'orders' => $orders,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }

    public function view($orderId)
    {
        $order = $this->orderModel->getOrderById($orderId);
        if (!$order) {
            throw new Exception("Không tìm thấy đơn hàng với ID");
        }
        $this->loadView('order_detail', ['order' => $order]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = $_POST;
            $errors = $this->orderModel->validateOrderData($data);

            if (!empty($errors)) {
                throw new Exception(implode(', ', $errors));
            }

            $data['OrderID'] = $this->generateOrderId();
            $data['OrderDate'] = date('Y-m-d H:i:s');

            $this->orderModel->createOrder($data);

            header('Location: /orders?success=created');
            exit;
        } else {
            $this->loadView('order_create');
        }
    }


    public function getTodayOrderCount()
    {
        try {
            $todayOrders = $this->orderModel->getTodayOrders();
            return count($todayOrders);
        } catch (Exception $e) {
            return 0;
        }
    }

    public function loadView($view, $data = [])
    {
        extract($data);
        $viewFile = ROOT_PATH . "/app/views/admin/{$view}.php";
        if (!file_exists($viewFile)) {
            $viewFile = ROOT_PATH . "/app/views/{$view}.php";
        }
        if (file_exists($viewFile)) {
            include $viewFile;
        } else {
            throw new Exception("Không tìm thấy File: {$view}");
        }
    }

    private function generateOrderId()
    {
        return 'ORD' . time() . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    }
}
