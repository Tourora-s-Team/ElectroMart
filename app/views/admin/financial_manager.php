<link rel="stylesheet" href="/electromart-o63e5.ondigitalocean.app/public/css/admin/StyleFinancial.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/public/js/AdminJs/Financial.js" defer></script>
<div class="financial-management-page">
    <div class="page-header">
        <div class="header-actions">
            <div class="total-revenue">
                <i class="fas fa-dollar-sign"></i>
                Tổng doanh thu: <strong><?= number_format($totalRevenue ?? 0, 0, ',', '.') ?> VNĐ</strong>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" class="filter-form">
            <input type="hidden" name="" value="admin/financial">
            <div class="filter-group">
                <label for="month">Lọc theo tháng:</label>
                <select name="month" id="month" onchange="this.form.submit()">
                    <option value="">Tất cả các tháng</option>
                    <?php for ($i = 1; $i <= 12; $i++): ?>
                        <option value="<?= $i ?>" <?= ($_GET['month'] ?? '') == $i ? 'selected' : '' ?>>
                            Tháng <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="filter-group">
                <label for="year">Lọc theo năm:</label>
                <select name="year" id="year" onchange="this.form.submit()">
                    <?php foreach ($availableYears as $availableYear): ?>
                        <option value="<?= $availableYear ?>" <?= ($_GET['year'] ?? date('Y')) == $availableYear ? 'selected' : '' ?>>
                            Năm <?= $availableYear ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-">
                <select name="shop" onchange="this.form.submit()" class="filter-select">
                    <option value="">-- Chọn cửa hàng --</option>
                    <?php for ($i = 1; $i <= 10; $i++): ?>
                        <option value="<?= $i ?>" <?= (isset($_GET['shop']) && $_GET['shop'] == $i) ? 'selected' : '' ?>>
                            Cửa hàng <?= $i ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
        </form>
    </div>

    <!-- Revenue Data Table -->
    <div class="table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>ID báo cáo</th>
                    <th>ID shop</th>
                    <th>Doanh thu</th>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Ngân hàng</th>
                    <th>STK</th>
                    <th>Chủ TK</th>
                    <th>Trạng thái TK</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($revenueData as $report): ?>
                    <tr>
                        <td><?= htmlspecialchars($report['ReportID']) ?></td>
                        <td><?= htmlspecialchars($report['ShopID']) ?></td>
                        <td><?= number_format($report['Revenue']) ?> VNĐ</td>
                        <td><?= htmlspecialchars($report['Month']) ?></td>
                        <td><?= htmlspecialchars($report['Year']) ?></td>
                        <td><?= htmlspecialchars($report['BankName'] ?? '') ?></td>
                        <td><?= htmlspecialchars($report['AccountNumber'] ?? '') ?></td>
                        <td><?= htmlspecialchars($report['AccountHolder'] ?? '') ?></td>
                        <td><?= htmlspecialchars($report['Status'] ?? '') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>

    <!-- Summary Statistics -->
    <div class="summary-stats">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-bar"></i>
            </div>
            <div class="stat-content">
                <h4>Tổng báo cáo</h4>
                <p class="stat-number"><?= count($revenueData) ?></p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="stat-content">
                <h4>Doanh thu trung bình</h4>
                <p class="stat-number">
                    <?= count($revenueData) > 0 ? number_format($totalRevenue / count($revenueData), 0, ',', '.') : 0 ?>
                    VNĐ
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>