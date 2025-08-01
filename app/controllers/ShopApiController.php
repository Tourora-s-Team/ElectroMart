<?php
require_once __DIR__ . '/BaseShopController.php';
require_once __DIR__ . '/../../core/HandleData.php';

class ShopApiController extends BaseShopController
{
    private $handleData;

    public function __construct()
    {
        parent::__construct();
        $this->handleData = new HandleData();
    }

    /**
     * Lấy danh sách thông báo của shop
     */
    public function getNotifications()
    {
        // Clear ALL output buffers to ensure clean JSON
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Disable error display for clean JSON
        ini_set('display_errors', 0);

        try {
            header('Content-Type: application/json');

            // Mock data - trong thực tế sẽ lấy từ database
            $notifications = [
                [
                    'id' => 1,
                    'title' => 'Đơn hàng mới',
                    'message' => 'Bạn có đơn hàng mới từ khách hàng Nguyễn Văn A',
                    'time' => '2 phút trước',
                    'is_read' => false,
                    'type' => 'order',
                    'icon' => 'fas fa-shopping-cart'
                ],
                [
                    'id' => 2,
                    'title' => 'Thanh toán thành công',
                    'message' => 'Đơn hàng #12345 đã được thanh toán thành công',
                    'time' => '15 phút trước',
                    'is_read' => false,
                    'type' => 'payment',
                    'icon' => 'fas fa-credit-card'
                ],
                [
                    'id' => 3,
                    'title' => 'Đánh giá mới',
                    'message' => 'Sản phẩm iPhone 15 nhận được đánh giá 5 sao',
                    'time' => '1 giờ trước',
                    'is_read' => true,
                    'type' => 'review',
                    'icon' => 'fas fa-star'
                ]
            ];

            // Đếm số thông báo chưa đọc
            $unreadCount = 0;
            foreach ($notifications as $notification) {
                if (!$notification['is_read']) {
                    $unreadCount++;
                }
            }

            $response = json_encode([
                'success' => true,
                'count' => $unreadCount,
                'notifications' => $notifications
            ]);

            echo $response;
            die();

        } catch (Exception $e) {
            // Clear any output in case of error
            while (ob_get_level()) {
                ob_end_clean();
            }

            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tải thông báo',
                'error' => $e->getMessage()
            ]);
            die();
        }
    }

    /**
     * Đánh dấu thông báo đã đọc
     */
    public function markNotificationRead()
    {
        // Clear ALL output buffers to ensure clean JSON
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Disable error display for clean JSON
        ini_set('display_errors', 0);

        try {
            header('Content-Type: application/json');

            $notificationId = $_POST['id'] ?? null;

            if (!$notificationId) {
                throw new Exception('ID thông báo không được cung cấp');
            }

            // Trong thực tế sẽ cập nhật database
            // UPDATE notifications SET is_read = 1 WHERE id = $notificationId AND shop_id = $this->shopID

            echo json_encode([
                'success' => true,
                'message' => 'Đã đánh dấu thông báo đã đọc'
            ]);
            die();

        } catch (Exception $e) {
            // Clear any output in case of error
            while (ob_get_level()) {
                ob_end_clean();
            }

            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật thông báo',
                'error' => $e->getMessage()
            ]);
            die();
        }
    }

    /**
     * Đánh dấu tất cả thông báo đã đọc
     */
    public function markAllNotificationsRead()
    {
        // Clear ALL output buffers to ensure clean JSON
        while (ob_get_level()) {
            ob_end_clean();
        }

        // Disable error display for clean JSON
        ini_set('display_errors', 0);

        try {
            header('Content-Type: application/json');

            // Trong thực tế sẽ cập nhật database
            // UPDATE notifications SET is_read = 1 WHERE shop_id = $this->shopID

            echo json_encode([
                'success' => true,
                'message' => 'Đã đánh dấu tất cả thông báo đã đọc'
            ]);
            die();

        } catch (Exception $e) {
            // Clear any output in case of error
            while (ob_get_level()) {
                ob_end_clean();
            }

            http_response_code(500);
            echo json_encode([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi cập nhật thông báo',
                'error' => $e->getMessage()
            ]);
            die();
        }
    }
}
