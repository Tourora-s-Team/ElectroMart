<!-- Order Management -->
<div class="order-management">
    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <div class="filter-grid">
                <div class="filter-group">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Tất cả trạng thái</option>
                        <option value="Pending" <?php echo ($filters['status'] == 'Pending') ? 'selected' : ''; ?>>Chờ xử
                            lý</option>
                        <option value="Processing" <?php echo ($filters['status'] == 'Processing') ? 'selected' : ''; ?>>
                            Đang xử lý</option>
                        <option value="Shipped" <?php echo ($filters['status'] == 'Shipped') ? 'selected' : ''; ?>>Đã giao
                        </option>
                        <option value="Completed" <?php echo ($filters['status'] == 'Completed') ? 'selected' : ''; ?>>
                            Hoàn thành</option>
                        <option value="Cancelled" <?php echo ($filters['status'] == 'Cancelled') ? 'selected' : ''; ?>>Đã
                            hủy</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="fromDate" class="form-label">Từ ngày</label>
                    <input type="date" id="fromDate" name="fromDate" class="form-input"
                        value="<?php echo htmlspecialchars($filters['fromDate'] ?? ''); ?>">
                </div>

                <div class="filter-group">
                    <label for="toDate" class="form-label">Đến ngày</label>
                    <input type="date" id="toDate" name="toDate" class="form-input"
                        value="<?php echo htmlspecialchars($filters['toDate'] ?? ''); ?>">
                </div>

                <div class="filter-group">
                    <label for="orderSearch" class="form-label">Tìm kiếm đơn hàng</label>
                    <div style="display: flex; gap: 0.5rem;">
                        <input type="text" id="orderSearch" name="orderID" class="form-input"
                            placeholder="Nhập mã đơn hàng..."
                            value="<?php echo htmlspecialchars($filters['orderID'] ?? ''); ?>">
                        <button type="button" class="btn btn-primary" onclick="searchOrders()">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 1rem;">
                <button type="button" class="btn btn-outline" onclick="resetFilters()">
                    <i class="fas fa-undo"></i>
                    Đặt lại
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i>
                    Áp dụng bộ lọc
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_orders'] ?? 0); ?></h3>
                <p>Tổng đơn hàng</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_revenue'] ?? 0); ?>₫</h3>
                <p>Tổng doanh thu</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-yellow">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['completed_orders'] ?? 0); ?></h3>
                <p>Đơn hoàn thành</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-red">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['pending_orders'] ?? 0); ?></h3>
                <p>Đơn chờ xử lý</p>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Danh sách đơn hàng
                <span style="color: var(--text-secondary); font-weight: normal; font-size: 0.875rem;">
                    (<?php echo count($orders); ?> đơn hàng)
                </span>
            </h3>
            <div style="display: flex; gap: 0.5rem;">
                <button type="button" class="btn btn-outline btn-sm" onclick="exportData('orders')">
                    <i class="fas fa-download"></i>
                    Xuất dữ liệu
                </button>
            </div>
        </div>
        <div class="card-body" style="padding: 0;">
            <?php if (!empty($orders)): ?>
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Khách hàng</th>
                                <th>Ngày đặt</th>
                                <th>Sản phẩm</th>
                                <th>Trạng thái</th>
                                <th>Phí ship</th>
                                <th>Tổng tiền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td class="font-medium">#<?php echo $order['OrderID']; ?></td>
                                    <td>
                                        <div>
                                            <div class="font-medium"><?php echo htmlspecialchars($order['CustomerName']); ?>
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--text-secondary);">ID:
                                                <?php echo $order['UserID']; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div><?php echo date('d/m/Y', strtotime($order['OrderDate'])); ?></div>
                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                            <?php echo date('H:i', strtotime($order['OrderDate'])); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"
                                            title="<?php echo htmlspecialchars($order['ProductNames']); ?>">
                                            <?php echo htmlspecialchars($order['ProductNames']); ?>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge status-<?php echo strtolower($order['Status']); ?>">
                                            <?php echo $order['Status']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($order['ShippingFee']); ?>₫</td>
                                    <td class="font-medium"><?php echo number_format($order['TotalAmount']); ?>₫</td>
                                    <td>
                                        <div class="action-buttons">
                                            <button type="button" class="btn btn-outline btn-sm"
                                                onclick="viewOrderDetail(<?php echo $order['OrderID']; ?>)"
                                                title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <?php if (in_array($order['Status'], ['Pending', 'Processing'])): ?>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                    onclick="updateOrderStatus(<?php echo $order['OrderID']; ?>, '<?php echo $order['Status']; ?>')"
                                                    title="Cập nhật trạng thái">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Không tìm thấy đơn hàng</h3>
                    <p>Chưa có đơn hàng nào phù hợp với bộ lọc hiện tại</p>
                    <button type="button" class="btn btn-outline" onclick="resetFilters()">
                        Xem tất cả đơn hàng
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Order Status Update Modal -->
<div id="statusUpdateModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Cập nhật trạng thái đơn hàng</h3>
            <button type="button" class="modal-close" onclick="closeModal('statusUpdateModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="statusUpdateForm" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="newStatus" class="form-label">Trạng thái mới</label>
                    <select id="newStatus" name="status" class="form-select" required>
                        <option value="">Chọn trạng thái</option>
                        <option value="Processing">Đang xử lý</option>
                        <option value="Shipped">Đã giao hàng</option>
                        <option value="Completed">Hoàn thành</option>
                        <option value="Cancelled">Hủy đơn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="statusNote" class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea id="statusNote" name="note" class="form-textarea" rows="3"
                        placeholder="Thêm ghi chú về việc cập nhật trạng thái..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('statusUpdateModal')">
                    Hủy
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Cập nhật
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Order management specific functions
    let currentOrderId = null;

    function searchOrders() {
        const searchInput = document.getElementById('orderSearch');
        if (searchInput && searchInput.value.trim()) {
            window.location.href = `/electromart-o63e5.ondigitalocean.app/public/shop/orders/search?q=${encodeURIComponent(searchInput.value.trim())}`;
        }
    }

    function viewOrderDetail(orderId) {
        window.location.href = `/electromart-o63e5.ondigitalocean.app/public/shop/orders/view/${orderId}`;
    }

    function updateOrderStatus(orderId, currentStatus) {
        currentOrderId = orderId;

        // Set appropriate status options based on current status
        const statusSelect = document.getElementById('newStatus');
        const options = statusSelect.querySelectorAll('option');

        // Clear previous selections
        options.forEach(option => option.style.display = 'block');

        // Hide inappropriate options based on current status
        if (currentStatus === 'Pending') {
            statusSelect.querySelector('[value="Shipped"]').style.display = 'none';
            statusSelect.querySelector('[value="Completed"]').style.display = 'none';
        } else if (currentStatus === 'Processing') {
            statusSelect.querySelector('[value="Processing"]').style.display = 'none';
        } else if (currentStatus === 'Shipped') {
            statusSelect.querySelector('[value="Processing"]').style.display = 'none';
            statusSelect.querySelector('[value="Shipped"]').style.display = 'none';
        }

        // Update form action
        const form = document.getElementById('statusUpdateForm');
        form.action = `/electromart-o63e5.ondigitalocean.app/public/shop/orders/view/${orderId}`;

        openModal('statusUpdateModal');
    }

    function resetFilters() {
        window.location.href = '/electromart-o63e5.ondigitalocean.app/public/shop/orders';
    }

    // Auto-refresh orders every 2 minutes
    let refreshInterval;

    document.addEventListener('DOMContentLoaded', function () {
        // Start auto-refresh
        refreshInterval = setInterval(function () {
            refreshOrderList();
        }, 120000); // 2 minutes

        // Set default date range if not set
        setDefaultDateRange();
    });

    function refreshOrderList() {
        // Only refresh if no modals are open
        const openModal = document.querySelector('.modal[style*="flex"]');
        if (!openModal) {
            const currentUrl = window.location.href;
            fetch(currentUrl, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.text())
                .then(html => {
                    // Update the orders table
                    const parser = new DOMParser();
                    const newDoc = parser.parseFromString(html, 'text/html');
                    const newTable = newDoc.querySelector('.table-container');
                    const currentTable = document.querySelector('.table-container');

                    if (newTable && currentTable) {
                        currentTable.innerHTML = newTable.innerHTML;
                        showToast('Danh sách đơn hàng đã được cập nhật', 'success');
                    }
                })
                .catch(error => {
                    console.error('Error refreshing orders:', error);
                });
        }
    }

    function setDefaultDateRange() {
        const fromDate = document.getElementById('fromDate');
        const toDate = document.getElementById('toDate');

        if (fromDate && !fromDate.value) {
            const thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(thirtyDaysAgo.getDate() - 30);
            fromDate.value = thirtyDaysAgo.toISOString().split('T')[0];
        }

        if (toDate && !toDate.value) {
            const today = new Date();
            toDate.value = today.toISOString().split('T')[0];
        }
    }

    // Keyboard shortcuts
    document.addEventListener('keydown', function (e) {
        if (e.ctrlKey || e.metaKey) {
            switch (e.key) {
                case 'f':
                    e.preventDefault();
                    document.getElementById('orderSearch').focus();
                    break;
                case 'r':
                    e.preventDefault();
                    refreshOrderList();
                    break;
            }
        }
    });

    // Status update form handling
    document.getElementById('statusUpdateForm').addEventListener('submit', function (e) {
        const newStatus = document.getElementById('newStatus').value;
        if (!newStatus) {
            e.preventDefault();
            showToast('Vui lòng chọn trạng thái mới', 'error');
            return;
        }

        if (!confirm('Bạn có chắc chắn muốn cập nhật trạng thái đơn hàng này?')) {
            e.preventDefault();
            return;
        }
    });

    // Cleanup on page unload
    window.addEventListener('beforeunload', function () {
        if (refreshInterval) {
            clearInterval(refreshInterval);
        }
    });
</script>