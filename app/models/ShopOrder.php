<?php
require_once ROOT_PATH . '/core/HandleData.php';

class ShopOrder
{
    private $handleData;

    public function __construct()
    {
        $this->handleData = new HandleData();
    }

    /**
     * Lấy danh sách đơn hàng của shop
     */
    public function getShopOrders($shopID, $filters = [])
    {
        $sql = "SELECT DISTINCT o.OrderID, o.OrderDate, o.Status, o.ShippingFee, o.TotalAmount, 
                       cu.FullName as CustomerName, cu.UserID,
                       GROUP_CONCAT(p.ProductName SEPARATOR ', ') as ProductNames
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                INNER JOIN Customer cu ON o.UserID = cu.UserID
                INNER JOIN Product p ON od.ProductID = p.ProductID AND od.ShopID = p.ShopID
                WHERE od.ShopID = :shopID";

        $params = ['shopID' => $shopID];

        // Apply filters
        if (!empty($filters['status'])) {
            $sql .= " AND o.Status = :status";
            $params['status'] = $filters['status'];
        }

        if (!empty($filters['fromDate'])) {
            $sql .= " AND DATE(o.OrderDate) >= :fromDate";
            $params['fromDate'] = $filters['fromDate'];
        }

        if (!empty($filters['toDate'])) {
            $sql .= " AND DATE(o.OrderDate) <= :toDate";
            $params['toDate'] = $filters['toDate'];
        }

        if (!empty($filters['orderID'])) {
            $sql .= " AND o.OrderID LIKE :orderID";
            $params['orderID'] = '%' . $filters['orderID'] . '%';
        }

        $sql .= " GROUP BY o.OrderID, o.OrderDate, o.Status, o.ShippingFee, o.TotalAmount, cu.FullName, cu.UserID";
        $sql .= " ORDER BY o.OrderDate DESC";

        return $this->handleData->getDataWithParams($sql, $params);
    }

    /**
     * Lấy chi tiết đơn hàng
     */
    public function getOrderDetail($orderID, $shopID)
    {
        // Lấy thông tin đơn hàng
        $sql = "SELECT o.*, cu.FullName as CustomerName, cu.Gender, cu.BirthDate,
                       r.ReceiverName, r.ContactNumber, r.AddressDetail, r.Street, r.Ward, r.City, r.Country,
                       p.PaymentMethod, p.Amount as PaymentAmount, p.PaymentDate, p.Status as PaymentStatus, p.TransactionCode
                FROM Orders o 
                INNER JOIN Customer cu ON o.UserID = cu.UserID
                LEFT JOIN Receiver r ON o.UserID = r.UserID AND r.IsDefault = 1
                LEFT JOIN Payment p ON o.OrderID = p.OrderID
                WHERE o.OrderID = :orderID";

        $order = $this->handleData->getDataWithParams($sql, ['orderID' => $orderID]);
        if (empty($order)) {
            return null;
        }

        // Lấy chi tiết sản phẩm trong đơn hàng thuộc shop
        $sql = "SELECT od.*, p.ProductName, p.Description, p.Price, p.Brand,
                       pi.ImageURL
                FROM OrderDetail od 
                INNER JOIN Product p ON od.ProductID = p.ProductID AND od.ShopID = p.ShopID
                LEFT JOIN ProductImage pi ON p.ProductID = pi.ProductID AND p.ShopID = pi.ShopID AND pi.IsThumbnail = 1
                WHERE od.OrderID = :orderID AND od.ShopID = :shopID";

        $orderItems = $this->handleData->getDataWithParams($sql, [
            'orderID' => $orderID,
            'shopID' => $shopID
        ]);

        return [
            'order' => $order[0],
            'items' => $orderItems
        ];
    }

    /**
     * Kiểm tra đơn hàng có thuộc shop không
     */
    public function checkOrderBelongsToShop($orderID, $shopID)
    {
        $sql = "SELECT COUNT(*) as count FROM OrderDetail 
                WHERE OrderID = :orderID AND ShopID = :shopID";

        $result = $this->handleData->getDataWithParams($sql, [
            'orderID' => $orderID,
            'shopID' => $shopID
        ]);

        return $result[0]['count'] > 0;
    }

    /**
     * Lấy thống kê đơn hàng
     */
    public function getOrderStats($shopID, $filters = [])
    {
        $baseCondition = "od.ShopID = :shopID";
        $params = ['shopID' => $shopID];

        // Apply same filters as in getShopOrders
        $additionalConditions = [];
        if (!empty($filters['status'])) {
            $additionalConditions[] = "o.Status = :status";
            $params['status'] = $filters['status'];
        }
        if (!empty($filters['fromDate'])) {
            $additionalConditions[] = "DATE(o.OrderDate) >= :fromDate";
            $params['fromDate'] = $filters['fromDate'];
        }
        if (!empty($filters['toDate'])) {
            $additionalConditions[] = "DATE(o.OrderDate) <= :toDate";
            $params['toDate'] = $filters['toDate'];
        }
        if (!empty($filters['orderID'])) {
            $additionalConditions[] = "o.OrderID LIKE :orderID";
            $params['orderID'] = '%' . $filters['orderID'] . '%';
        }

        $whereClause = $baseCondition;
        if (!empty($additionalConditions)) {
            $whereClause .= " AND " . implode(" AND ", $additionalConditions);
        }

        $sql = "SELECT 
                    COUNT(DISTINCT o.OrderID) as total_orders,
                    COALESCE(SUM(od.Quantity * od.UnitPrice), 0) as total_revenue,
                    COUNT(DISTINCT CASE WHEN o.Status = 'Completed' THEN o.OrderID END) as completed_orders,
                    COUNT(DISTINCT CASE WHEN o.Status IN ('Pending', 'Processing') THEN o.OrderID END) as pending_orders
                FROM Orders o 
                INNER JOIN OrderDetail od ON o.OrderID = od.OrderID 
                WHERE {$whereClause}";

        return $this->handleData->getDataWithParams($sql, $params)[0];
    }

    /**
     * Cập nhật trạng thái đơn hàng
     */
    public function updateOrderStatus($orderID, $status)
    {
        $sql = "UPDATE Orders SET Status = :status WHERE OrderID = :orderID";

        return $this->handleData->execDataWithParams($sql, [
            'status' => $status,
            'orderID' => $orderID
        ]);
    }
}
