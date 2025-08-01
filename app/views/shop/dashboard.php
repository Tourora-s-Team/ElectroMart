<?php require_once ROOT_PATH . '/core/ImageHelper.php'; ?>
<!-- Dashboard -->
<div class="dashboard">
    <!-- Stats Overview -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon stat-icon-blue">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_orders']); ?></h3>
                <p>Tổng đơn hàng</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-green">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['monthly_revenue']); ?>₫</h3>
                <p>Doanh thu tháng này</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-yellow">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['total_products']); ?></h3>
                <p>Tổng sản phẩm</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon stat-icon-red">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stat-content">
                <h3><?php echo number_format($stats['pending_orders']); ?></h3>
                <p>Đơn hàng chờ xử lý</p>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; margin-top: 2rem;">
        <!-- Recent Orders -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Đơn hàng gần đây</h3>
                <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/orders" class="btn btn-outline btn-sm">
                    Xem tất cả
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($recentOrders)): ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Khách hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Trạng thái</th>
                                        <th>Tổng tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentOrders as $order): ?>
                                            <tr onclick="viewOrderDetail(<?php echo $order['OrderID']; ?>)" style="cursor: pointer;">
                                                <td class="font-medium">#<?php echo $order['OrderID']; ?></td>
                                                <td><?php echo htmlspecialchars($order['CustomerName']); ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($order['OrderDate'])); ?></td>
                                                <td>
                                                    <span class="status-badge status-<?php echo strtolower($order['Status']); ?>">
                                                        <?php echo $order['Status']; ?>
                                                    </span>
                                                </td>
                                                <td class="font-medium"><?php echo number_format($order['TotalAmount']); ?>₫</td>
                                            </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-shopping-cart"></i>
                            <h3>Chưa có đơn hàng</h3>
                            <p>Đơn hàng sẽ hiển thị ở đây khi có khách hàng đặt mua</p>
                        </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Popular Products -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sản phẩm bán chạy</h3>
                <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/products" class="btn btn-outline btn-sm">
                    Xem tất cả
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($popularProducts)): ?>
                        <div class="product-list">
                            <?php foreach ($popularProducts as $product): ?>
                                    <div class="product-item"
                                        style="display: flex; align-items: center; gap: 1rem; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color);">
                                        <div class="product-image" style="width: 50px; height: 50px; flex-shrink: 0;">
                                            <?php if (!empty($product['ImageURL'])): ?>
                                                    <img src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                                                        alt="<?php echo htmlspecialchars($product['ProductName']); ?>"
                                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--border-color);">
                                            <?php else: ?>
                                                    <div
                                                        style="width: 100%; height: 100%; background-color: var(--background-color); border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);">
                                                        <i class="fas fa-image" style="color: var(--text-light);"></i>
                                                    </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="product-info" style="flex: 1;">
                                            <h4
                                                style="font-size: 0.875rem; font-weight: 500; margin-bottom: 0.25rem; color: var(--text-primary);">
                                                <?php echo htmlspecialchars($product['ProductName']); ?>
                                            </h4>
                                            <p style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.25rem;">
                                                Giá: <?php echo number_format($product['Price']); ?>₫
                                            </p>
                                            <p style="font-size: 0.75rem; color: var(--success-color); font-weight: 500;">
                                                Đã bán: <?php echo number_format($product['total_sold']); ?>
                                            </p>
                                        </div>
                                    </div>
                            <?php endforeach; ?>
                        </div>
                <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-box"></i>
                            <h3>Chưa có sản phẩm bán chạy</h3>
                            <p>Dữ liệu sản phẩm bán chạy sẽ hiển thị ở đây</p>
                        </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3 class="card-title">Thao tác nhanh</h3>
        </div>
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/products/add" class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                    Thêm sản phẩm mới
                </a>

                <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/orders" class="btn btn-outline">
                    <i class="fas fa-eye"></i>
                    Xem đơn hàng
                </a>

                <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/finance" class="btn btn-outline">
                    <i class="fas fa-chart-line"></i>
                    Xem báo cáo
                </a>

                <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/info" class="btn btn-outline">
                    <i class="fas fa-edit"></i>
                    Cập nhật thông tin
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Specific dashboard functionality
    document.addEventListener('DOMContentLoaded', function () {
        // Auto refresh stats every 5 minutes
        setInterval(function () {
            refreshDashboardStats();
        }, 300000);
    });

    function refreshDashboardStats() {
        // Implementation for refreshing dashboard stats via AJAX
        fetch('https://electromart-t8ou8.ondigitalocean.app/public/shop/dashboard/refresh-stats')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateStatsDisplay(data.stats);
                }
            })
            .catch(error => {
                console.error('Error refreshing stats:', error);
            });
    }

    function updateStatsDisplay(stats) {
        // Update the stats display
        document.querySelector('.stat-card:nth-child(1) h3').textContent = formatNumber(stats.total_orders);
        document.querySelector('.stat-card:nth-child(2) h3').textContent = formatNumber(stats.monthly_revenue) + '₫';
        document.querySelector('.stat-card:nth-child(3) h3').textContent = formatNumber(stats.total_products);
        document.querySelector('.stat-card:nth-child(4) h3').textContent = formatNumber(stats.pending_orders);
    }

    function viewOrderDetail(orderId) {
        window.location.href = `https://electromart-t8ou8.ondigitalocean.app/public/shop/orders/view/${orderId}`;
    }
</script>