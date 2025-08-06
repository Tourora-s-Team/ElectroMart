<?php
require_once ROOT_PATH . '/app/controllers/BaseShopController.php';
require_once ROOT_PATH . '/app/models/ShopFinance.php';

class ShopFinanceController extends BaseShopController
{
    private $financeModel;

    public function __construct()
    {
        parent::__construct();
        $this->financeModel = new ShopFinance();
    }

    // Hiển thị báo cáo tài chính
    public function index()
    {
        $month = $_GET['month'] ?? '';
        $year = $_GET['year'] ?? date('Y');

        $revenueData = $this->financeModel->getShopRevenueData($this->shopID, $month, $year);
        $chartData = $this->financeModel->getRevenueChartData($this->shopID, $year);
        $totalRevenue = $this->financeModel->getTotalRevenue($this->shopID, $month, $year);
        $availableYears = $this->financeModel->getAvailableYears($this->shopID);
        $monthlyStats = $this->financeModel->getMonthlyStats($this->shopID, $year);
        $topProducts = $this->financeModel->getTopProducts($this->shopID, $month, $year);
        $stats = $this->financeModel->getFinanceStats($this->shopID, $month, $year);
        $bankAccounts = $this->financeModel->getBankAccounts($this->shopID);

        $this->loadShopView('finance', [
            'revenueData' => $revenueData,
            'chartData' => $chartData,
            'totalRevenue' => $totalRevenue,
            'availableYears' => $availableYears,
            'monthlyStats' => $monthlyStats,
            'topProducts' => $topProducts,
            'stats' => $stats,
            'bankAccounts' => $bankAccounts,
            'filters' => [
                'month' => $month,
                'year' => $year
            ],
            'title' => 'Quản lý tài chính',
            'currentPage' => 'finance',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop'],
                ['text' => 'Quản lý tài chính']
            ]
        ]);
    }

    // Quản lý tài khoản ngân hàng
    public function bankAccounts()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';

            switch ($action) {
                case 'add':
                    $this->addBankAccount();
                    break;
                case 'update':
                    $this->updateBankAccount($_POST['bank_account_id']);
                    break;
                case 'delete':
                    $this->deleteBankAccount();
                    break;
                case 'set_default':
                    $this->setDefaultBankAccount();
                    break;
            }
        }

        $bankAccounts = $this->financeModel->getBankAccounts($this->shopID);
        $this->loadShopView('bank_accounts', [
            'bankAccounts' => $bankAccounts,
            'title' => 'Quản lý tài khoản ngân hàng',
            'currentPage' => 'finance',
            'breadcrumb' => [
                ['text' => 'Dashboard', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop'],
                ['text' => 'Quản lý tài chính', 'url' => 'https://electromart-t8ou8.ondigitalocean.app/public/shop/finance'],
                ['text' => 'Tài khoản ngân hàng']
            ]
        ]);
    }

    // API để lấy dữ liệu biểu đồ
    public function getChartData()
    {
        $year = $_GET['year'] ?? date('Y');
        $chartData = $this->financeModel->getRevenueChartData($this->shopID, $year);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($chartData);
        exit;
    }

    // API để lấy dữ liệu theo tháng
    public function getMonthlyData()
    {
        $month = $_GET['month'] ?? '';
        $year = $_GET['year'] ?? date('Y');

        $data = $this->financeModel->getShopRevenueData($this->shopID, $month, $year);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

    // Thêm tài khoản ngân hàng
    public function addBankAccount()
    {
        $data = [
            'ShopID' => $this->shopID,
            'BankName' => $_POST['bank_name'] ?? '',
            'AccountNumber' => $_POST['account_number'] ?? '',
            'AccountHolder' => $_POST['account_holder_name'] ?? '',
            'IsDefault' => isset($_POST['is_default']) ? 1 : 0,
            'CreatedAt' => date('Y-m-d H:i:s'),
            'Status' => 'Active'
        ];

        // Validate required fields
        if (empty($data['BankName']) || empty($data['AccountNumber']) || empty($data['AccountHolder'])) {
            $this->returnJson(['success' => false, 'message' => 'Vui lòng điền đầy đủ thông tin bắt buộc.']);
            return;
        }

        // Nếu là mặc định thì reset các tài khoản khác
        if ($data['IsDefault']) {
            $this->financeModel->resetDefaultBankAccounts($this->shopID);
        }

        $result = $this->financeModel->addBankAccount($data);

        if ($result) {
            $this->returnJson(['success' => true, 'message' => 'Thêm tài khoản ngân hàng thành công!']);
        } else {
            $this->returnJson(['success' => false, 'message' => 'Có lỗi xảy ra khi thêm tài khoản ngân hàng.']);
        }
    }



    // Cập nhật tài khoản ngân hàng
    public function updateBankAccount($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'BankName' => $_POST['bank_name'] ?? '',
                'AccountNumber' => $_POST['account_number'] ?? '',
                'AccountHolder' => $_POST['account_holder_name'] ?? '',
                'IsDefault' => isset($_POST['is_default']) ? 1 : 0,
                'CreatedAt' => date('Y-m-d H:i:s'),
                'Status' => 'Active',
                'bankAccountID' => $id,
                'shopID' => $this->shopID,
            ];

            $shopID = $this->shopID;

            $result = $this->financeModel->updateBankAccount($id, $shopID, $data);

            if ($result) {
                // Chuyển hướng thành công
                header("Location: https://electromart-t8ou8.ondigitalocean.app/public/shop/finance");
                $_SESSION['success_message'] = 'Cập nhật tài khoản ngân hàng thành công!';
                exit;
            } else {
                $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật tài khoản ngân hàng.';
            }
        }
    }




    // Xóa tài khoản ngân hàng
    public function deleteBankAccount($bankAccountID = null)
    {
        // Nếu dùng route kiểu /delete-bank-account/{id} thì lấy ID từ URL
        if ($bankAccountID === null) {
            // Hoặc nếu là POST, bạn có thể lấy từ $_POST nếu cần
            $bankAccountID = $_POST['BankAccountID'] ?? '';
        }

        if (empty($bankAccountID)) {
            return $this->respondJSON(false, 'Không tìm thấy tài khoản ngân hàng.');
        }

        if (!$this->financeModel->checkBankAccountBelongsToShop($bankAccountID, $this->shopID)) {
            return $this->respondJSON(false, 'Bạn không có quyền xóa tài khoản này.');
        }

        $result = $this->financeModel->deleteBankAccount($bankAccountID, $this->shopID);

        if ($result) {
            return $this->respondJSON(true, 'Xóa tài khoản ngân hàng thành công!');
        } else {
            return $this->respondJSON(false, 'Có lỗi xảy ra khi xóa tài khoản ngân hàng.');
        }
    }

    // Helper function
    private function respondJSON($success, $message)
    {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => $success,
            'message' => $message
        ]);
        exit();
    }



    // Đặt tài khoản mặc định
    public function setDefaultBankAccount()
    {
        $bankAccountID = $_POST['BankAccountID'] ?? '';

        if (empty($bankAccountID)) {
            $_SESSION['error_message'] = 'Không tìm thấy tài khoản ngân hàng.';
            return;
        }

        if (!$this->financeModel->checkBankAccountBelongsToShop($bankAccountID, $this->shopID)) {
            $_SESSION['error_message'] = 'Bạn không có quyền thao tác với tài khoản này.';
            return;
        }

        $result = $this->financeModel->setDefaultBankAccount($bankAccountID, $this->shopID);

        if ($result) {
            $_SESSION['success_message'] = 'Đã đặt làm tài khoản mặc định!';
        } else {
            $_SESSION['error_message'] = 'Có lỗi xảy ra khi cập nhật tài khoản mặc định.';
        }

        header("Location: https://electromart-t8ou8.ondigitalocean.app/public/shop/finance/bank-accounts");
        exit();
    }
}
