<?php
$title = "ElectroMart - Quản lý đơn hàng";
$pageTitle = "Quản lý đơn hàng";
$pageSubtitle = "Quản lý và theo dõi đơn hàng của bạn";
$activeTab = "orders";
$todayOrderCount = isset($orders) ? count($orders) : 0;

include 'layouts/Header1.php';
?>

<!-- Filter Section -->
<section class="filter-section">
    <form id="orderFilterForm" class="filter-form" method="GET" action="/orders">
        <div class="filter-grid">
            <!-- Status Filter -->
            <div class="filter-group">
                <label for="statusFilter" class="filter-label">
                    <i class="fas fa-filter"></i>
                    Trạng thái
                </label>
                <select id="statusFilter" name="status" class="filter-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Pending" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Pending') ? 'selected' : ''; ?>>Chờ xử lý</option>
                    <option value="Processing" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Processing') ? 'selected' : ''; ?>>Đang xử lý</option>
                    <option value="Completed" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Completed') ? 'selected' : ''; ?>>Hoàn thành</option>
                    <option value="Cancelled" <?php echo (isset($_GET['status']) && $_GET['status'] === 'Cancelled') ? 'selected' : ''; ?>>Đã hủy</option>
                </select>
            </div>

            <!-- From Date -->
            <div class="filter-group">
                <label for="fromDate" class="filter-label">
                    <i class="fas fa-calendar"></i>
                    Từ ngày
                </label>
                <input type="date" id="fromDate" name="fromDate" class="filter-input" value="<?php echo $_GET['fromDate'] ?? ''; ?>">
            </div>

            <!-- To Date -->
            <div class="filter-group">
                <label for="toDate" class="filter-label">
                    <i class="fas fa-calendar"></i>
                    Đến ngày
                </label>
                <input type="date" id="toDate" name="toDate" class="filter-input" value="<?php echo $_GET['toDate'] ?? ''; ?>">
            </div>

            <!-- User ID Filter -->
            <div class="filter-group">
                <label for="userIdFilter" class="filter-label">
                    <i class="fas fa-user"></i>
                    User ID
                </label>
                <input type="text" id="userIdFilter" name="userID" placeholder="Nhập User ID..." class="filter-input" value="<?php echo $_GET['userID'] ?? ''; ?>">
            </div>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i>
                Áp dụng bộ lọc
            </button>
            
            <button type="button" class="btn btn-success" onclick="openAddOrderModal()">
                <i class="fas fa-plus"></i>
                Thêm đơn hàng mới
            </button>
        </div>
    </form>
</section>

<!-- Orders Table -->
<section class="table-section">
    <div class="table-container">
        <div class="table-header">
            <h3 class="table-title">
                Danh sách đơn hàng (<span id="orderCount"><?php echo isset($orders) ? count($orders) : 0; ?></span> đơn hàng)
            </h3>
        </div>
        
        <div class="table-wrapper">
            <table class="orders-table" id="ordersTable">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt</th>
                        <th>Trạng thái</th>
                        <th>Phí ship</th>
                        <th>Tổng tiền</th>
                        <th>User ID</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody id="ordersTableBody">
                    <?php if (isset($orders) && !empty($orders)): ?>
                        <?php foreach ($orders as $order): ?>
                            <tr class="order-row" data-order-id="<?php echo htmlspecialchars($order['OrderID']); ?>">
                                <td class="order-id">
                                    <span class="font-medium"><?php echo htmlspecialchars($order['OrderID']); ?></span>
                                </td>
                                <td class="order-date">
                                    <span class="timestamp" data-date="<?php echo $order['OrderDate']; ?>">
                                        <?php echo date('d/m/Y', strtotime($order['OrderDate'])); ?>
                                    </span>
                                </td>
                                <td class="order-status">
                                    <span class="status-badge status-<?php echo strtolower($order['Status']); ?>">
                                        <?php echo htmlspecialchars($order['Status']); ?>
                                    </span>
                                </td>
                                <td class="shipping-fee">
                                    <span class="currency"><?php echo number_format($order['ShippingFee'], 0, ',', '.'); ?> ₫</span>
                                </td>
                                <td class="total-amount">
                                    <span class="currency font-semibold"><?php echo number_format($order['TotalAmount'], 0, ',', '.'); ?> ₫</span>
                                </td>
                                <td class="user-id">
                                    <span><?php echo htmlspecialchars($order['UserID']); ?></span>
                                </td>
                                <td class="actions">
                                    <div class="action-buttons">
                                        <button class="btn-icon btn-view" onclick="viewOrder('<?php echo $order['OrderID']; ?>')" data-tooltip="Xem chi tiết">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn-icon btn-edit" onclick="editOrder('<?php echo $order['OrderID']; ?>')" data-tooltip="Chỉnh sửa">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn-icon btn-delete" onclick="deleteOrder('<?php echo $order['OrderID']; ?>')" data-tooltip="Xóa">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="no-data">
                            <td colspan="7" class="text-center">
                                <div class="no-data-content">
                                    <i class="fas fa-shopping-cart no-data-icon"></i>
                                    <p class="no-data-text">Không tìm thấy đơn hàng nào</p>
                                    <p class="no-data-subtext">Thử điều chỉnh bộ lọc để xem thêm kết quả</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- Summary Stats -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Tổng đơn hàng</p>
                <p class="stat-value" id="totalOrders"><?php echo isset($orders) ? count($orders) : 0; ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Tổng doanh thu</p>
                <p class="stat-value" id="totalRevenue">
                    <?php 
                    $totalRevenue = 0;
                    if (isset($orders)) {
                        foreach ($orders as $order) {
                            $totalRevenue += $order['TotalAmount'];
                        }
                    }
                    echo number_format($totalRevenue, 0, ',', '.') . ' ₫';
                    ?>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-orange">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Đơn hoàn thành</p>
                <p class="stat-value" id="completedOrders">
                    <?php 
                    $completedCount = 0;
                    if (isset($orders)) {
                        foreach ($orders as $order) {
                            if ($order['Status'] === 'Completed') {
                                $completedCount++;
                            }
                        }
                    }
                    echo $completedCount;
                    ?>
                </p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-yellow">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <p class="stat-label">Đơn chờ xử lý</p>
                <p class="stat-value" id="pendingOrders">
                    <?php 
                    $pendingCount = 0;
                    if (isset($orders)) {
                        foreach ($orders as $order) {
                            if ($order['Status'] === 'Pending' || $order['Status'] === 'Processing') {
                                $pendingCount++;
                            }
                        }
                    }
                    echo $pendingCount;
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Add Order Modal (placeholder for future implementation) -->
<div id="addOrderModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Thêm đơn hàng mới</h3>
            <button class="modal-close" onclick="closeAddOrderModal()">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <p>Chức năng thêm đơn hàng sẽ được triển khai trong phiên bản tiếp theo.</p>
        </div>
    </div>
</div>

<script src="https://electromart-t8ou8.ondigitalocean.app/public/js/orders.js"></script>

<?php include 'layouts/Footer1.php'; ?>