<?php

require_once ROOT_PATH . '/core/HandleData.php';

class Orders extends HandleData
{
    private $table = 'Orders';
    private $db;
    public function __construct()
    {
        parent::__construct();
    }

    // Get all orders with optional filters
    public function getAllOrders($filters = [])
    {
        try {
            $sql = "SELECT OrderID, OrderDate, Status, ShippingFee, TotalAmount, UserID FROM {$this->table} WHERE 1=1";

            // Apply filters
            if (!empty($filters['status'])) {
                $sql .= " AND Status = '{$filters['status']}'";
            }

            if (!empty($filters['fromDate'])) {
                $sql .= " AND DATE(OrderDate) >= '{$filters['fromDate']}'";
            }

            if (!empty($filters['toDate'])) {
                $sql .= " AND DATE(OrderDate) <= '{$filters['toDate']}'";
            }

            if (!empty($filters['userID'])) {
                $sql .= " AND UserID LIKE '%{$filters['userID']}%'";
            }

            $sql .= " ORDER BY OrderDate DESC"; // hiệu quả với thực tiễn hơn

            // hoặc ORDER BY ORDERID ASC

            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error fetching orders: " . $e->getMessage());
        }
    }

    // Get single order by ID
    public function getOrderById($orderId)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE OrderID = '$orderId'";
            $result = $this->getDataWithParams($sql);

            return !empty($result) ? $result[0] : null;
        } catch (Exception $e) {
            throw new Exception("Error fetching order: " . $e->getMessage());
        }
    }
    public function update($orderID, $status, $shippingFee, $totalAmount)
    {
        $sql = "UPDATE orders 
                SET Status = :status, ShippingFee = :shippingFee, TotalAmount = :totalAmount 
                WHERE OrderID = :orderID";
        $params = [
            ':status' => $status,
            ':shippingFee' => $shippingFee,
            ':totalAmount' => $totalAmount,
            ':orderID' => $orderID
        ];
        return $this->db->write($sql, $params);
    }


    public function delete($orderID)
    {
        $sql = "DELETE FROM orders WHERE OrderID = :orderID";
        $params = [':orderID' => $orderID];
        return $this->db->write($sql, $params);
    }

    // Create new order
    public function createOrder($data)
    {
        try {
            $sql = "INSERT INTO {$this->table} (OrderID, OrderDate, Status, ShippingFee, TotalAmount, UserID) 
                    VALUES ('{$data['OrderID']}', '{$data['OrderDate']}', '{$data['Status']}', 
                            {$data['ShippingFee']}, {$data['TotalAmount']}, '{$data['UserID']}')";

            $this->write($sql);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error creating order: " . $e->getMessage());
        }
    }

    // Update existing order
    public function updateOrder($orderId, $data)
    {
        try {
            $updateFields = [];

            if (isset($data['Status'])) {
                $updateFields[] = "Status = '{$data['Status']}'";
            }

            if (isset($data['ShippingFee'])) {
                $updateFields[] = "ShippingFee = {$data['ShippingFee']}";
            }

            if (isset($data['TotalAmount'])) {
                $updateFields[] = "TotalAmount = {$data['TotalAmount']}";
            }

            if (empty($updateFields)) {
                throw new Exception("No valid fields to update");
            }

            $sql = "UPDATE {$this->table} SET " . implode(', ', $updateFields) . " WHERE OrderID = '$orderId'";

            $this->write($sql);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error updating order: " . $e->getMessage());
        }
    }

    // Delete order
    public function deleteOrder($orderId)
    {
        try {
            $sql = "DELETE FROM {$this->table} WHERE OrderID = '$orderId'";
            $this->write($sql);
            return true;
        } catch (Exception $e) {
            throw new Exception("Error deleting order: " . $e->getMessage());
        }
    }

    // Get orders by status
    public function getOrdersByStatus($status)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE Status = '$status' ORDER BY OrderDate DESC";
            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error fetching orders by status: " . $e->getMessage());
        }
    }

    // Get orders by user ID
    public function getOrdersByUserId($userId)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE UserID = '$userId' ORDER BY OrderDate DESC";
            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error fetching orders by user ID: " . $e->getMessage());
        }
    }

    // Get orders by date range
    public function getOrdersByDateRange($fromDate, $toDate)
    {
        try {
            $sql = "SELECT * FROM {$this->table} WHERE DATE(OrderDate) BETWEEN '$fromDate' AND '$toDate' ORDER BY OrderDate DESC";
            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error fetching orders by date range: " . $e->getMessage());
        }
    }

    // Get order statistics
    public function getOrderStats($filters = [])
    {
        try {
            $orders = $this->getAllOrders($filters);

            $stats = [
                'totalOrders' => count($orders),
                'totalRevenue' => 0,
                'totalShippingFees' => 0,
                'statusCounts' => [
                    'Pending' => 0,
                    'Processing' => 0,
                    'Completed' => 0,
                    'Cancelled' => 0
                ],
                'averageOrderValue' => 0
            ];

            foreach ($orders as $order) {
                $stats['totalRevenue'] += $order['TotalAmount'];
                $stats['totalShippingFees'] += $order['ShippingFee'];

                if (isset($stats['statusCounts'][$order['Status']])) {
                    $stats['statusCounts'][$order['Status']]++;
                }
            }

            // Calculate average order value
            if ($stats['totalOrders'] > 0) {
                $stats['averageOrderValue'] = $stats['totalRevenue'] / $stats['totalOrders'];
            }

            return $stats;
        } catch (Exception $e) {
            throw new Exception("Error calculating order statistics: " . $e->getMessage());
        }
    }

    // Get today's orders
    public function getTodayOrders()
    {
        try {
            $today = date('Y-m-d');
            $sql = "SELECT * FROM {$this->table} WHERE DATE(OrderDate) = '$today' ORDER BY OrderDate DESC";
            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error fetching today's orders: " . $e->getMessage());
        }
    }

    // Get recent orders (last N orders)
    public function getRecentOrders($limit = 10)
    {
        try {
            $sql = "SELECT * FROM {$this->table} ORDER BY OrderDate DESC LIMIT $limit";
            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error fetching recent orders: " . $e->getMessage());
        }
    }

    // Search orders
    public function searchOrders($searchTerm)
    {
        try {
            $sql = "SELECT * FROM {$this->table} 
                    WHERE OrderID LIKE '%$searchTerm%' 
                    OR UserID LIKE '%$searchTerm%' 
                    OR Status LIKE '%$searchTerm%' 
                    ORDER BY OrderDate DESC";

            return $this->getDataWithParams($sql);
        } catch (Exception $e) {
            throw new Exception("Error searching orders: " . $e->getMessage());
        }
    }

    // Check if order exists
    public function orderExists($orderId)
    {
        try {
            $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE OrderID = '$orderId'";
            $result = $this->getDataWithParams($sql);

            return $result[0]['count'] > 0;
        } catch (Exception $e) {
            return false;
        }
    }

    // Get order count by status
    public function getOrderCountByStatus()
    {
        try {
            $sql = "SELECT Status, COUNT(*) as count FROM {$this->table} GROUP BY Status";
            $result = $this->getDataWithParams($sql);

            $counts = [];
            foreach ($result as $row) {
                $counts[$row['Status']] = $row['count'];
            }

            return $counts;
        } catch (Exception $e) {
            throw new Exception("Error getting order count by status: " . $e->getMessage());
        }
    }

    // Get monthly order statistics
    public function getMonthlyStats($year = null)
    {
        try {
            if ($year === null) {
                $year = date('Y');
            }

            $sql = "SELECT 
                        MONTH(OrderDate) as month,
                        COUNT(*) as order_count,
                        SUM(TotalAmount) as total_revenue,
                        SUM(ShippingFee) as total_shipping
                    FROM {$this->table} 
                    WHERE YEAR(OrderDate) = $year 
                    GROUP BY MONTH(OrderDate) 
                    ORDER BY month";

            return $this->read($sql);
        } catch (Exception $e) {
            throw new Exception("Error getting monthly statistics: " . $e->getMessage());
        }
    }

    // Validate order data
    public function validateOrderData($data, $isUpdate = false)
    {
        $errors = [];

        // Required fields for new orders
        if (!$isUpdate) {
            $requiredFields = ['UserID', 'TotalAmount', 'ShippingFee'];

            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || empty($data[$field])) {
                    $errors[] = "Field {$field} is required";
                }
            }
        }

        // Validate numeric fields
        if (isset($data['TotalAmount']) && (!is_numeric($data['TotalAmount']) || $data['TotalAmount'] < 0)) {
            $errors[] = "Total amount must be a positive number";
        }

        if (isset($data['ShippingFee']) && (!is_numeric($data['ShippingFee']) || $data['ShippingFee'] < 0)) {
            $errors[] = "Shipping fee must be a positive number";
        }

        // Validate status
        if (isset($data['Status'])) {
            $validStatuses = ['Pending', 'Processing', 'Completed', 'Cancelled'];
            if (!in_array($data['Status'], $validStatuses)) {
                $errors[] = "Invalid status value";
            }
        }

        // Validate UserID format
        if (isset($data['UserID']) && !preg_match('/^USER\d+$/', $data['UserID'])) {
            $errors[] = "Invalid UserID format";
        }

        return $errors;
    }
}
