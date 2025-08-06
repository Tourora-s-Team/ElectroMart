<?php
require_once ROOT_PATH . '/core/HandleData.php';

class ShopFinance
{
    private $handleData;

    public function __construct()
    {
        $this->handleData = new HandleData();
    }

    /**
     * Lấy dữ liệu doanh thu của shop
     */
    public function getShopRevenueData($shopID, $month = '', $year = '')
    {
        $sql = "SELECT 
                    DATE(o.OrderDate) as order_date,
                    COUNT(DISTINCT o.OrderID) as total_orders,
                    SUM(od.Quantity * od.UnitPrice) as total_revenue,
                    SUM(od.Quantity) as total_products_sold
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = :shopID 
                AND o.Status = 'Completed'";

        $params = ['shopID' => $shopID];

        if (!empty($month)) {
            $sql .= " AND MONTH(o.OrderDate) = :month";
            $params['month'] = $month;
        }

        if (!empty($year)) {
            $sql .= " AND YEAR(o.OrderDate) = :year";
            $params['year'] = $year;
        }

        $sql .= " GROUP BY DATE(o.OrderDate) ORDER BY DATE(o.OrderDate) DESC";

        return $this->handleData->getDataWithParams($sql, $params);
    }

    /**
     * Lấy dữ liệu biểu đồ doanh thu theo tháng
     */
    public function getRevenueChartData($shopID, $year)
    {
        $sql = "SELECT 
                    MONTH(o.OrderDate) as month,
                    SUM(od.Quantity * od.UnitPrice) as revenue
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = :shopID 
                AND YEAR(o.OrderDate) = :year 
                AND o.Status = 'Completed'
                GROUP BY MONTH(o.OrderDate) 
                ORDER BY MONTH(o.OrderDate)";

        $data = $this->handleData->getDataWithParams($sql, [
            'shopID' => $shopID,
            'year' => $year
        ]);

        // Tạo mảng 12 tháng với giá trị mặc định là 0
        $chartData = array_fill(1, 12, 0);

        foreach ($data as $row) {
            $chartData[$row['month']] = (float) $row['revenue'];
        }

        return array_values($chartData);
    }

    /**
     * Lấy tổng doanh thu
     */
    public function getTotalRevenue($shopID, $month = '', $year = '')
    {
        $sql = "SELECT COALESCE(SUM(od.Quantity * od.UnitPrice), 0) as total_revenue
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = :shopID 
                AND o.Status = 'Completed'";

        $params = ['shopID' => $shopID];

        if (!empty($month)) {
            $sql .= " AND MONTH(o.OrderDate) = :month";
            $params['month'] = $month;
        }

        if (!empty($year)) {
            $sql .= " AND YEAR(o.OrderDate) = :year";
            $params['year'] = $year;
        }

        $result = $this->handleData->getDataWithParams($sql, $params);
        return $result[0]['total_revenue'];
    }

    /**
     * Lấy danh sách năm có dữ liệu
     */
    public function getAvailableYears($shopID)
    {
        $sql = "SELECT DISTINCT YEAR(o.OrderDate) as year 
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = :shopID 
                ORDER BY year DESC";

        return $this->handleData->getDataWithParams($sql, ['shopID' => $shopID]);
    }

    /**
     * Lấy thống kê theo tháng
     */
    public function getMonthlyStats($shopID, $year)
    {
        $sql = "SELECT 
                    MONTH(o.OrderDate) as month,
                    COUNT(DISTINCT o.OrderID) as orders_count,
                    SUM(od.Quantity * od.UnitPrice) as revenue,
                    SUM(od.Quantity) as products_sold
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE od.ShopID = :shopID 
                AND YEAR(o.OrderDate) = :year 
                AND o.Status = 'Completed'
                GROUP BY MONTH(o.OrderDate) 
                ORDER BY MONTH(o.OrderDate)";

        return $this->handleData->getDataWithParams($sql, [
            'shopID' => $shopID,
            'year' => $year
        ]);
    }

    /**
     * Lấy danh sách tài khoản ngân hàng
     */
    public function getBankAccounts($shopID)
    {
        $sql = "SELECT * FROM BankAccount 
                WHERE ShopID = :shopID 
                ORDER BY IsDefault DESC, CreatedAt DESC";

        return $this->handleData->getDataWithParams($sql, ['shopID' => $shopID]);
    }

    /**
     * Thêm tài khoản ngân hàng
     */
    public function addBankAccount($data)
    {
        $sql = "INSERT INTO BankAccount (ShopID, BankName, AccountNumber, AccountHolder, IsDefault, CreatedAt, Status) 
                VALUES (:ShopID, :BankName, :AccountNumber, :AccountHolder, :IsDefault, :CreatedAt, :Status)";

        return $this->handleData->execDataWithParams($sql, $data);
    }

    /**
     * Cập nhật tài khoản ngân hàng
     */
    public function updateBankAccount($bankAccountID, $shopID, $data)
    {
        $sql = "UPDATE BankAccount 
        SET BankName = :BankName, AccountNumber = :AccountNumber, 
            AccountHolder = :AccountHolder, IsDefault = :IsDefault,
            CreatedAt = :CreatedAt,
            Status = :Status
        WHERE BankAccountID = :bankAccountID AND ShopID = :shopID";


        $params = array_merge($data, [
            'bankAccountID' => $bankAccountID,
            'shopID' => $shopID
        ]);
        var_dump($params);

        return $this->handleData->execDataWithParams($sql, $params);
    }

    /**
     * Xóa tài khoản ngân hàng
     */
    public function deleteBankAccount($bankAccountID, $shopID)
    {
        $sql = "DELETE FROM BankAccount 
                WHERE BankAccountID = :bankAccountID AND ShopID = :shopID";

        return $this->handleData->execDataWithParams($sql, [
            'bankAccountID' => $bankAccountID,
            'shopID' => $shopID
        ]);
    }

    /**
     * Đặt tài khoản mặc định
     */
    public function setDefaultBankAccount($bankAccountID, $shopID)
    {
        // Đặt tất cả tài khoản thành không mặc định
        $sql = "UPDATE BankAccount SET IsDefault = 0 WHERE ShopID = :shopID";
        $this->handleData->execDataWithParams($sql, ['shopID' => $shopID]);

        // Đặt tài khoản được chọn thành mặc định
        $sql = "UPDATE BankAccount SET IsDefault = 1 
                WHERE BankAccountID = :bankAccountID AND ShopID = :shopID";

        return $this->handleData->execDataWithParams($sql, [
            'bankAccountID' => $bankAccountID,
            'shopID' => $shopID
        ]);
    }

    /**
     * Đặt tất cả tài khoản thành không mặc định
     */
    public function resetDefaultBankAccounts($shopID)
    {
        $sql = "UPDATE BankAccount SET IsDefault = 0 WHERE ShopID = :shopID";
        return $this->handleData->execDataWithParams($sql, ['shopID' => $shopID]);
    }

    /**
     * Kiểm tra tài khoản ngân hàng có thuộc shop không
     */
    public function checkBankAccountBelongsToShop($bankAccountID, $shopID)
    {
        $sql = "SELECT COUNT(*) as count FROM BankAccount 
                WHERE BankAccountID = :bankAccountID AND ShopID = :shopID";

        $result = $this->handleData->getDataWithParams($sql, [
            'bankAccountID' => $bankAccountID,
            'shopID' => $shopID
        ]);

        return $result[0]['count'] > 0;
    }

    /**
     * Lấy danh sách sản phẩm bán chạy
     */
    public function getTopProducts($shopID, $month = '', $year = '', $limit = 10)
    {
        $sql = "SELECT 
                    p.ProductID,
                    p.ProductName,
                    pi.ImageURL,
                    p.Price,
                    p.Brand,
                    SUM(od.Quantity) as total_sold,
                    SUM(od.Quantity * od.UnitPrice) as total_revenue,
                    COUNT(DISTINCT o.OrderID) as total_orders
                FROM Product p
                INNER JOIN OrderDetail od ON p.ProductID = od.ProductID AND p.ShopID = od.ShopID
                INNER JOIN Orders o ON od.OrderID = o.OrderID
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND p.ShopID = pi.ShopID AND pi.IsThumbnail = 1
                WHERE od.ShopID = :shopID 
                AND o.Status = 'Completed'";

        $params = ['shopID' => $shopID];

        if (!empty($month)) {
            $sql .= " AND MONTH(o.OrderDate) = :month";
            $params['month'] = $month;
        }

        if (!empty($year)) {
            $sql .= " AND YEAR(o.OrderDate) = :year";
            $params['year'] = $year;
        }

        $sql .= " GROUP BY p.ProductID, p.ProductName, pi.ImageURL, p.Price, p.Brand
                  ORDER BY total_sold DESC, total_revenue DESC
                  LIMIT " . intval($limit);

        $results = $this->handleData->getDataWithParams($sql, $params);

        // Calculate total revenue for percentage calculation
        if (!empty($results)) {
            $totalRevenue = array_sum(array_column($results, 'total_revenue'));

            // Add percentage to each product
            foreach ($results as &$product) {
                $product['RevenuePercentage'] = $totalRevenue > 0 ?
                    ($product['total_revenue'] / $totalRevenue) * 100 : 0;
                $product['QuantitySold'] = $product['total_sold'];
                $product['Revenue'] = $product['total_revenue'];
            }
        }

        return $results;
    }

    /**
     * Lấy thống kê tổng quan tài chính
     */
    public function getFinanceStats($shopID, $month = '', $year = '')
    {
        $totalRevenue = $this->getTotalRevenue($shopID, $month, $year);
        // Get current period stats
        $currentSql = "SELECT 
            COUNT(DISTINCT o.OrderID) AS total_orders,
            SUM(od.Quantity * od.UnitPrice) AS total_revenue_month,
            AVG(od.Quantity * od.UnitPrice) AS avg_order_value,
            SUM(od.Quantity) AS total_products_sold
        FROM Orders o 
        INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
        WHERE od.ShopID = :shopID 
          AND o.Status = 'Completed'
          AND MONTH(o.OrderDate) = MONTH(CURDATE())
          AND YEAR(o.OrderDate) = YEAR(CURDATE())";

        $params = ['shopID' => $shopID];

        if (!empty($month)) {
            $currentSql .= " AND MONTH(o.OrderDate) = :month";
            $params['month'] = (int) $month;
        }

        if (!empty($year)) {
            $currentSql .= " AND YEAR(o.OrderDate) = :year";
            $params['year'] = (int) $year;
        }

        $currentStats = $this->handleData->getDataWithParams($currentSql, $params)[0] ?? [];

        // ❗ Tính kỳ trước
        $prevParams = ['shopID' => $shopID];
        $prevSql = $currentSql;

        if (!empty($month) && !empty($year)) {
            $prevMonth = $month - 1;
            $prevYear = $year;

            if ($prevMonth == 0) {
                $prevMonth = 12;
                $prevYear -= 1;
            }

            $prevSql = str_replace(":month", ":prev_month", $currentSql);
            $prevSql = str_replace(":year", ":prev_year", $prevSql);
            $prevParams['prev_month'] = $prevMonth;
            $prevParams['prev_year'] = $prevYear;
        } elseif (!empty($year)) {
            $prevParams['year'] = $year - 1;
            $prevSql = str_replace(":year", ":year", $currentSql);
        }

        $prevStats = $this->handleData->getDataWithParams($prevSql, $prevParams)[0] ?? [];

        // Helper để tính % tăng trưởng
        function calcGrowth($current, $previous)
        {
            if ($previous == 0 || $previous === null) {
                return null;
            }
            return round((($current - $previous) / $previous) * 100, 2);
        }

        $stats = [
            'total_revenue' => $totalRevenue ?? 0,
            'total_orders' => $currentStats['total_orders'] ?? 0,
            'avg_order_value' => $currentStats['avg_order_value'] ?? 0,
            'total_products_sold' => $currentStats['total_products_sold'] ?? 0,
            'monthly_revenue' => $currentStats['total_revenue_month'] ?? 0,

            // ✅ Growth calculations
            'revenue_growth' => calcGrowth($totalRevenue ?? 0, $prevStats['total_revenue'] ?? 0),
            'monthly_growth' => calcGrowth($currentStats['total_products_sold'] ?? 0, $prevStats['total_products_sold'] ?? 0),
            'orders_growth' => calcGrowth($currentStats['total_orders'] ?? 0, $prevStats['total_orders'] ?? 0),
            'aov_growth' => calcGrowth($currentStats['avg_order_value'] ?? 0, $prevStats['avg_order_value'] ?? 0),
        ];

        return $stats;
    }

}
