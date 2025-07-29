<?php
require_once ROOT_PATH . '/core/HandleData.php';

class Financial
{
    private $pdo;

    public function __construct()
    {
        $database = new Database();
        $this->pdo = $database->connectDB();
    }
    public function getBankByShopID($shopID)
    {
        $sql = "SELECT BankName, AccountNumber, AccountHolder, Status FROM BankAccount WHERE ShopID = :shopID";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':shopID' => $shopID]);
        return $stmt->fetch();
    }

    public function getRevenueByFilter($month = '', $year = '', $shopID = '')
    {
        $sql = "SELECT ReportID, ShopID, Revenue, Month, Year FROM FinancialReport";
        $conditions = [];
        $params = [];

        if (!empty($month)) {
            $conditions[] = "Month = :month";
            $params[':month'] = $month;
        }

        if (!empty($year)) {
            $conditions[] = "Year = :year";
            $params[':year'] = $year;
        }

        if (!empty($shopID)) {
            $conditions[] = "ShopID = :shopID";
            $params[':shopID'] = $shopID;
        }

        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $sql .= " ORDER BY Year DESC, Month DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $financials = $stmt->fetchAll();

        foreach ($financials as &$row) {
            $bankInfo = $this->getBankByShopID($row['ShopID']);
            $row = array_merge($row, $bankInfo ?? []);
        }
        return $financials;
    }

    public function getRevenueChartData($year = '')
    {
        $sql = "SELECT 
                    Month,
                    Year,
                    SUM(Revenue) as TotalRevenue
                FROM FinancialReport";

        $params = [];
        if (!empty($year)) {
            $sql .= " WHERE Year = :year";
            $params[':year'] = $year;
        }

        $sql .= " GROUP BY Year, Month ORDER BY Year, Month";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTotalRevenue($month = '', $year = '', $shopID = '')
    {
        $sql = "SELECT SUM(Revenue) as total_revenue FROM FinancialReport";

        $conditions = [];
        $params = [];

        if (!empty($month)) {
            $conditions[] = "Month = :month";
            $params[':month'] = $month;
        }

        if (!empty($year)) {
            $conditions[] = "Year = :year";
            $params[':year'] = $year;
        }

        if (!empty($shopID)) {
            $conditions[] = "ShopID = :shopID";
            $params[':shopID'] = $shopID;
        }
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total_revenue'] ?? 0;
    }

    public function getAvailableYears()
    {
        $sql = "SELECT DISTINCT Year FROM FinancialReport ORDER BY Year DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getMonthlyGrowth($year)
    {
        $sql = "SELECT 
                    Month,
                    Revenue,
                    LAG(Revenue) OVER (ORDER BY Month) as PrevRevenue
                FROM FinancialReport
                WHERE Year = :year 
                ORDER BY Month";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':year' => $year]);
        return $stmt->fetchAll();
    }
}
