<?php require_once ROOT_PATH . '/core/ImageHelper.php'; ?>
<!-- Finance Management -->
<div class="finance-management">
    <!-- Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">Quản lý tài chính</h1>
            <p class="page-description">Theo dõi doanh thu và quản lý tài khoản ngân hàng</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn btn-outline" onclick="exportFinanceReport()">
                <i class="fas fa-download"></i>
                Xuất báo cáo
            </button>
            <button type="button" class="btn btn-primary" onclick="openBankAccountModal()">
                <i class="fas fa-plus"></i>
                Thêm tài khoản ngân hàng
            </button>
        </div>
    </div>

    <!-- Finance Overview -->
    <div class="stats-grid" style="margin-bottom: 2rem;">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--success-color);">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="stat-info">
                <h4><?php echo number_format($stats['total_revenue'] ?? 0); ?>₫</h4>
                <p>Tổng doanh thu</p>
                <div class="stat-change stat-change-positive">
                    <i class="fas fa-arrow-up"></i>
                    +<?php echo $stats['revenue_growth'] ?? 0; ?>% so với tháng trước
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--primary-color);">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <h4><?php echo number_format($stats['monthly_revenue'] ?? 0); ?>₫</h4>
                <p>Doanh thu tháng này</p>
                <div class="stat-change stat-change-positive">
                    <i class="fas fa-arrow-up"></i>
                    +<?php echo $stats['monthly_growth'] ?? 0; ?>% so với tháng trước
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--warning-color);">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="stat-info">
                <h4><?php echo $stats['total_orders'] ?? 0; ?></h4>
                <p>Tổng đơn hàng</p>
                <div class="stat-change stat-change-positive">
                    <i class="fas fa-arrow-up"></i>
                    +<?php echo $stats['orders_growth'] ?? 0; ?>% so với tháng trước
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--info-color);">
                <i class="fas fa-calculator"></i>
            </div>
            <div class="stat-info">
                <h4><?php echo number_format($stats['avg_order_value'] ?? 0); ?>₫</h4>
                <p>Giá trị đơn hàng TB</p>
                <div class="stat-change stat-change-neutral">
                    <i class="fas fa-minus"></i>
                    <?php echo $stats['aov_growth'] ?? 0; ?>% so với tháng trước
                </div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Revenue Analytics -->
        <div>
            <!-- Revenue Chart -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">Biểu đồ doanh thu</h3>
                    <div class="card-actions">
                        <select id="chartPeriod" class="form-select" style="width: auto;"
                            onchange="updateRevenueChart()">
                            <option value="7">7 ngày qua</option>
                            <option value="30" selected>30 ngày qua</option>
                            <option value="90">3 tháng qua</option>
                            <option value="365">12 tháng qua</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" width="800" height="400"></canvas>
                </div>
            </div>

            <!-- Product Performance -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sản phẩm bán chạy</h3>
                    <div class="card-actions">
                        <button type="button" class="btn btn-outline btn-sm" onclick="viewAllProducts()">
                            Xem tất cả
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($topProducts)): ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Sản phẩm</th>
                                        <th>Đã bán</th>
                                        <th>Doanh thu</th>
                                        <th>% tổng DT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topProducts as $index => $product): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                                    <div style="width: 40px; height: 40px; flex-shrink: 0;">
                                                        <?php if (!empty($product['ImageURL'])): ?>
                                                            <img src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                                                                alt="<?php echo htmlspecialchars($product['ProductName']); ?>"
                                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.25rem;">
                                                        <?php else: ?>
                                                            <div
                                                                style="width: 100%; height: 100%; background-color: var(--background-color); border-radius: 0.25rem; display: flex; align-items: center; justify-content: center;">
                                                                <i class="fas fa-image"
                                                                    style="color: var(--text-light); font-size: 0.75rem;"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium" style="font-size: 0.875rem;">
                                                            <?php echo htmlspecialchars($product['ProductName']); ?>
                                                        </div>
                                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                                            <?php echo htmlspecialchars($product['Brand']); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="font-medium"><?php echo $product['QuantitySold']; ?></td>
                                            <td class="font-medium"><?php echo number_format($product['Revenue']); ?>₫</td>
                                            <td>
                                                <span class="badge" style="background-color: var(--primary-color);">
                                                    <?php echo number_format($product['RevenuePercentage'], 1); ?>%
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-chart-bar"></i>
                            <h3>Chưa có dữ liệu</h3>
                            <p>Chưa có sản phẩm nào được bán</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Quick Actions -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">Thao tác nhanh</h3>
                </div>
                <div class="card-body">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <button type="button" class="btn btn-outline" onclick="openPayoutModal()">
                            <i class="fas fa-money-bill-wave"></i>
                            Rút tiền
                        </button>
                        <button type="button" class="btn btn-outline" onclick="viewTransactionHistory()">
                            <i class="fas fa-history"></i>
                            Lịch sử giao dịch
                        </button>
                        <button type="button" class="btn btn-outline" onclick="viewTaxReports()">
                            <i class="fas fa-file-invoice"></i>
                            Báo cáo thuế
                        </button>
                        <button type="button" class="btn btn-outline" onclick="openBankAccountModal()">
                            <i class="fas fa-university"></i>
                            Quản lý TK ngân hàng
                        </button>
                    </div>
                </div>
            </div>

            <!-- Bank Accounts -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tài khoản ngân hàng</h3>
                    <button type="button" class="btn btn-outline btn-sm" onclick="openBankAccountModal()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <div class="card-body">
                    <?php if (!empty($bankAccounts)): ?>
                        <div style="display: flex; flex-direction: column; gap: 1rem;">
                            <?php foreach ($bankAccounts as $account): ?>
                                <div class="bank-account-item">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div class="bank-icon">
                                            <i class="fas fa-university"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <div class="font-medium"><?php echo htmlspecialchars($account['BankName']); ?></div>
                                            <div style="font-size: 0.875rem; color: var(--text-secondary);">
                                                **** **** **** <?php echo substr($account['AccountNumber'], -4); ?>
                                            </div>
                                            <div style="font-size: 0.75rem; color: var(--text-light);">
                                                <?php echo htmlspecialchars($account['AccountHolder']); ?>
                                            </div>
                                        </div>
                                        <div style="display: flex; gap: 0.25rem;">
                                            <?php if ($account['IsDefault']): ?>
                                                <span class="badge"
                                                    style="background-color: var(--success-color); font-size: 0.75rem;">
                                                    Mặc định
                                                </span>
                                            <?php endif; ?>
                                            <button type="button" class="btn btn-outline btn-sm"
                                                onclick="editBankAccount(<?php echo $account['BankAccountID']; ?>)">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteBankAccount(<?php echo $account['BankAccountID']; ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-university"></i>
                            <h3>Chưa có tài khoản ngân hàng</h3>
                            <p>Thêm tài khoản ngân hàng để nhận thanh toán</p>
                            <button type="button" class="btn btn-primary btn-sm" onclick="openBankAccountModal()">
                                <i class="fas fa-plus"></i>
                                Thêm tài khoản
                            </button>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bank Account Modal -->
<div id="bankAccountModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="bankAccountModalTitle">Thêm tài khoản ngân hàng</h3>
            <button type="button" class="modal-close" onclick="closeModal('bankAccountModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="bankAccountForm" method="POST">
            <input type="hidden" id="bankAccountId" name="bank_account_id" value="">
            <div class="modal-body">
                <div class="form-group">
                    <label for="bankName" class="form-label">Tên ngân hàng *</label>
                    <select id="bankName" name="bank_name" class="form-select" required>
                        <option value="">Chọn ngân hàng</option>
                        <option value="Vietcombank">Vietcombank</option>
                        <option value="VietinBank">VietinBank</option>
                        <option value="BIDV">BIDV</option>
                        <option value="Agribank">Agribank</option>
                        <option value="Techcombank">Techcombank</option>
                        <option value="MB Bank">MB Bank</option>
                        <option value="ACB">ACB</option>
                        <option value="VPBank">VPBank</option>
                        <option value="Sacombank">Sacombank</option>
                        <option value="SHB">SHB</option>
                        <option value="TPBank">TPBank</option>
                        <option value="VIB">VIB</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="accountNumber" class="form-label">Số tài khoản *</label>
                    <input type="text" id="accountNumber" name="account_number" class="form-input"
                        placeholder="Nhập số tài khoản" required>
                </div>

                <div class="form-group">
                    <label for="accountHolderName" class="form-label">Tên chủ tài khoản *</label>
                    <input type="text" id="accountHolderName" name="account_holder_name" class="form-input"
                        placeholder="Nhập tên chủ tài khoản" required>
                </div>

                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" id="isDefault" name="is_default" value="1">
                        <span class="checkmark"></span>
                        Đặt làm tài khoản mặc định
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('bankAccountModal')">
                    Hủy
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span id="bankAccountSubmitText">Thêm tài khoản</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payout Modal -->
<div id="payoutModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Yêu cầu rút tiền</h3>
            <button type="button" class="modal-close" onclick="closeModal('payoutModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="payoutForm" method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label">Số dư khả dụng</label>
                    <div
                        style="padding: 1rem; background-color: var(--success-color); color: white; border-radius: 0.5rem; font-size: 1.25rem; font-weight: 600; text-align: center;">
                        <?php echo number_format($stats['available_balance'] ?? 0); ?>₫
                    </div>
                </div>

                <div class="form-group">
                    <label for="payoutAmount" class="form-label">Số tiền rút *</label>
                    <input type="number" id="payoutAmount" name="amount" class="form-input" min="50000"
                        max="<?php echo $stats['available_balance'] ?? 0; ?>" placeholder="Nhập số tiền muốn rút"
                        required>
                    <div class="form-help">
                        Số tiền tối thiểu: 50,000₫
                    </div>
                </div>

                <div class="form-group">
                    <label for="payoutBankAccount" class="form-label">Tài khoản nhận tiền *</label>
                    <select id="payoutBankAccount" name="bank_account_id" class="form-select" required>
                        <option value="">Chọn tài khoản ngân hàng</option>
                        <?php if (!empty($bankAccounts)): ?>
                            <?php foreach ($bankAccounts as $account): ?>
                                <option value="<?php echo $account['BankAccountID']; ?>" <?php echo $account['IsDefault'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($account['BankName']); ?> -
                                    **** **** **** <?php echo substr($account['AccountNumber'], -4); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="payoutNote" class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea id="payoutNote" name="note" class="form-textarea" rows="3"
                        placeholder="Thêm ghi chú về yêu cầu rút tiền..."></textarea>
                </div>

                <div
                    style="padding: 1rem; background-color: var(--warning-color); border-radius: 0.5rem; margin-top: 1rem;">
                    <div
                        style="display: flex; align-items: center; gap: 0.5rem; color: white; font-weight: 600; margin-bottom: 0.5rem;">
                        <i class="fas fa-info-circle"></i>
                        Lưu ý quan trọng
                    </div>
                    <ul style="color: white; font-size: 0.875rem; margin: 0; padding-left: 1.5rem;">
                        <li>Yêu cầu rút tiền sẽ được xử lý trong vòng 1-3 ngày làm việc</li>
                        <li>Phí giao dịch: 11,000₫ (áp dụng cho mỗi lần rút tiền)</li>
                        <li>Số tiền tối thiểu: 50,000₫</li>
                    </ul>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('payoutModal')">
                    Hủy
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    Gửi yêu cầu
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let revenueChart;

    // Initialize Revenue Chart
    function initRevenueChart() {
        const ctx = document.getElementById('revenueChart').getContext('2d');

        // Get chart data
        fetch('/electromart/public/shop/finance/revenue-chart?period=30')
            .then(response => response.json())
            .then(data => {
                revenueChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels || [],
                        datasets: [{
                            label: 'Doanh thu',
                            data: data.values || [],
                            borderColor: 'var(--primary-color)',
                            backgroundColor: 'var(--primary-color)',
                            borderWidth: 3,
                            fill: false,
                            tension: 0.4,
                            pointBackgroundColor: 'var(--primary-color)',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2,
                            pointRadius: 5,
                            pointHoverRadius: 7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                backgroundColor: 'rgba(0,0,0,0.8)',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                borderColor: 'var(--primary-color)',
                                borderWidth: 1,
                                callbacks: {
                                    label: function(context) {
                                        return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + '₫';
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: false
                                },
                                ticks: {
                                    color: 'var(--text-secondary)'
                                }
                            },
                            y: {
                                grid: {
                                    color: 'rgba(0,0,0,0.1)'
                                },
                                ticks: {
                                    color: 'var(--text-secondary)',
                                    callback: function(value) {
                                        return new Intl.NumberFormat('vi-VN', {
                                            notation: 'compact',
                                            compactDisplay: 'short'
                                        }).format(value) + '₫';
                                    }
                                }
                            }
                        },
                        interaction: {
                            mode: 'nearest',
                            axis: 'x',
                            intersect: false
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading chart data:', error);
            });
    }

    function updateRevenueChart() {
        const period = document.getElementById('chartPeriod').value;

        fetch(`/electromart/public/shop/finance/revenue-chart?period=${period}`)
            .then(response => response.json())
            .then(data => {
                revenueChart.data.labels = data.labels || [];
                revenueChart.data.datasets[0].data = data.values || [];
                revenueChart.update();
            })
            .catch(error => {
                console.error('Error updating chart:', error);
            });
    }

    function openBankAccountModal() {
        document.getElementById('bankAccountModalTitle').textContent = 'Thêm tài khoản ngân hàng';
        document.getElementById('bankAccountSubmitText').textContent = 'Thêm tài khoản';
        document.getElementById('bankAccountForm').reset();
        document.getElementById('bankAccountId').value = '';
        openModal('bankAccountModal');
    }

    function editBankAccount(accountId) {
        // Load account data
        fetch(`/electromart/public/shop/finance/bank-account/${accountId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success && data.account) {
                    const account = data.account;

                    document.getElementById('bankAccountModalTitle').textContent = 'Chỉnh sửa tài khoản ngân hàng';
                    document.getElementById('bankAccountSubmitText').textContent = 'Cập nhật tài khoản';
                    document.getElementById('bankAccountId').value = account.BankAccountID;
                    document.getElementById('bankName').value = account.BankName;
                    document.getElementById('accountNumber').value = account.AccountNumber;
                    document.getElementById('accountHolderName').value = account.AccountHolder;
                    document.getElementById('branchName').value = account.BranchName || '';
                    document.getElementById('isDefault').checked = account.IsDefault == 1;

                    openModal('bankAccountModal');
                } else {
                    showToast('Không thể tải thông tin tài khoản', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra', 'error');
            });
    }

    function deleteBankAccount(accountId) {
        if (confirm('Bạn có chắc chắn muốn xóa tài khoản ngân hàng này?')) {
            fetch(`/electromart/public/shop/finance/delete-bank-account/${accountId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {

                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Không thể xóa tài khoản', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra', 'error');
                });
        }
    }

    function openPayoutModal() {
        openModal('payoutModal');
    }

    function exportFinanceReport() {
        showToast('Chức năng xuất báo cáo sẽ được phát triển trong phiên bản tới', 'info');
    }

    function viewAllProducts() {
        window.location.href = '/electromart/public/shop/products';
    }

    function viewTransactionHistory() {
        showToast('Chức năng lịch sử giao dịch sẽ được phát triển trong phiên bản tới', 'info');
    }

    function viewTaxReports() {
        showToast('Chức năng báo cáo thuế sẽ được phát triển trong phiên bản tới', 'info');
    }

    // Form submissions
    document.getElementById('bankAccountForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const accountId = document.getElementById('bankAccountId').value;
        const url = accountId ?
            `/electromart/public/shop/finance/update-bank-account/${accountId}` :
            '/electromart/public/shop/finance/add-bank-account';

        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        submitBtn.disabled = true;

        fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('bankAccountModal');
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    });

    document.getElementById('payoutForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const amount = parseInt(document.getElementById('payoutAmount').value);
        const availableBalance = <?php echo $stats['available_balance'] ?? 0; ?>;

        if (amount < 50000) {
            showToast('Số tiền rút tối thiểu là 50,000₫', 'warning');
            return;
        }

        if (amount > availableBalance) {
            showToast('Số tiền rút không được vượt quá số dư khả dụng', 'warning');
            return;
        }

        const formData = new FormData(this);

        // Show loading
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        submitBtn.disabled = true;

        fetch('/electromart/public/shop/finance/request-payout', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    closeModal('payoutModal');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    });

    // Initialize chart when page loads
    document.addEventListener('DOMContentLoaded', function() {
        initRevenueChart();
    });
</script>

<style>
    /* Finance specific styles */
    .stat-change {
        display: flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        margin-top: 0.5rem;
    }

    .stat-change-positive {
        color: var(--success-color);
    }

    .stat-change-negative {
        color: var(--danger-color);
    }

    .stat-change-neutral {
        color: var(--text-secondary);
    }

    .bank-account-item {
        padding: 1rem;
        border: 1px solid var(--border-color);
        border-radius: 0.5rem;
        transition: all 0.2s ease;
    }

    .bank-account-item:hover {
        border-color: var(--primary-color);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .bank-icon {
        width: 40px;
        height: 40px;
        background-color: var(--primary-color);
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.125rem;
    }

    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    /* Chart container */
    #revenueChart {
        max-height: 400px;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .finance-management>div:last-child {
            grid-template-columns: 1fr !important;
        }
    }

    @media (max-width: 768px) {
        .content-header {
            flex-direction: column;
            gap: 1rem;
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .modal-content {
            margin: 1rem;
            max-width: calc(100vw - 2rem);
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .header-actions {
            flex-direction: column;
        }
    }
</style>