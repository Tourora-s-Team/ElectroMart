<?php
require_once ROOT_PATH . '/app/models/FinancialManager.php';
require_once ROOT_PATH . '/app/controllers/BaseAdminController.php';

class AdminFinancialController extends BaseAdminController
{
    private $financialModel;

    public function __construct()
    {
        parent::__construct(); // Kiểm tra quyền admin
        $this->financialModel = new Financial();
    }

    public function index()
    {
        $month = $_GET['month'] ?? '';
        $year = $_GET['year'] ?? date('Y');
        $shopID = $_GET['shop'] ?? '';

        $revenueData = $this->financialModel->getRevenueByFilter($month, $year, $shopID);
        $chartData = $this->financialModel->getRevenueChartData($year);
        $totalRevenue = $this->financialModel->getTotalRevenue($month, $year, $shopID);
        $availableYears = $this->financialModel->getAvailableYears();

        $this->loadAdminView('../app/views/admin/FinancialFE.php', [
            'revenueData' => $revenueData,
            'chartData' => $chartData,
            'totalRevenue' => $totalRevenue,
            'availableYears' => $availableYears,
            'pageTitle' => "Quản lý tài chính ",
            'currentPage' => 'financial',
            'activeTab' => 'finance',
            'pageSubtitle' => ' Quản lý và theo dõi doanh thu của bạn',
            'title' => "ElectroMart - Quản lý tài chính"
        ]);
    }


    public function getChartData()
    {
        $year = $_GET['year'] ?? date('Y');
        $chartData = $this->financialModel->getRevenueChartData($year);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($chartData);
        exit;
    }

    public function getMonthlyData()
    {
        $month = $_GET['month'] ?? '';
        $year = $_GET['year'] ?? date('Y');

        $data = $this->financialModel->getRevenueByFilter($month, $year);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }
}
