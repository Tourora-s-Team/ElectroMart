<?php require_once ROOT_PATH . '/core/ImageHelper.php'; ?>
<!-- Bank Accounts Management -->
<div class="bank-accounts-management">
    <!-- Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">Quản lý tài khoản ngân hàng</h1>
            <p class="page-description">Quản lý thông tin tài khoản ngân hàng nhận thanh toán</p>
        </div>
        <div class="header-actions">
            <button type="button" class="btn btn-primary" onclick="openAddBankAccountModal()">
                <i class="fas fa-plus"></i>
                Thêm tài khoản ngân hàng
            </button>
        </div>
    </div>

    <!-- Success/Error Messages -->
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            <?php echo $_SESSION['success_message'];
            unset($_SESSION['success_message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-error">
            <i class="fas fa-exclamation-triangle"></i>
            <?php echo $_SESSION['error_message'];
            unset($_SESSION['error_message']); ?>
        </div>
    <?php endif; ?>

    <!-- Bank Accounts List -->
    <div class="bank-accounts-grid">
        <?php if (!empty($bankAccounts)): ?>
            <?php foreach ($bankAccounts as $account): ?>
                <div class="bank-account-card <?php echo $account['IsDefault'] ? 'default' : ''; ?>">
                    <div class="card-header">
                        <div class="bank-info">
                            <h3><?php echo htmlspecialchars($account['BankName']); ?></h3>
                            <?php if ($account['IsDefault']): ?>
                                <span class="default-badge">
                                    <i class="fas fa-star"></i>
                                    Mặc định
                                </span>
                            <?php endif; ?>
                        </div>
                        <div class="card-actions">
                            <button type="button" class="btn btn-sm btn-outline"
                                onclick="editBankAccount(<?php echo htmlspecialchars(json_encode($account)); ?>)">
                                <i class="fas fa-edit"></i>
                            </button>
                            <?php if (!$account['IsDefault']): ?>
                                <button type="button" class="btn btn-sm btn-success"
                                    onclick="setDefaultBankAccount(<?php echo $account['BankAccountID']; ?>)">
                                    <i class="fas fa-star"></i>
                                </button>
                            <?php endif; ?>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="deleteBankAccount(<?php echo $account['BankAccountID']; ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="account-details">
                            <div class="detail-item">
                                <label>Số tài khoản:</label>
                                <span class="account-number"><?php echo htmlspecialchars($account['AccountNumber']); ?></span>
                            </div>
                            <div class="detail-item">
                                <label>Chủ tài khoản:</label>
                                <span><?php echo htmlspecialchars($account['AccountHolder']); ?></span>
                            </div>
                            <div class="detail-item">
                                <label>Trạng thái:</label>
                                <span class="status <?php echo strtolower($account['Status']); ?>">
                                    <?php echo htmlspecialchars($account['Status']); ?>
                                </span>
                            </div>
                            <div class="detail-item">
                                <label>Ngày tạo:</label>
                                <span><?php echo date('d/m/Y H:i', strtotime($account['CreatedAt'])); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-university"></i>
                </div>
                <h3>Chưa có tài khoản ngân hàng</h3>
                <p>Thêm tài khoản ngân hàng để nhận thanh toán từ khách hàng</p>
                <button type="button" class="btn btn-primary" onclick="openAddBankAccountModal()">
                    <i class="fas fa-plus"></i>
                    Thêm tài khoản đầu tiên
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Add/Edit Bank Account Modal -->
<div id="bankAccountModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 id="bankAccountModalTitle">Thêm tài khoản ngân hàng</h2>
            <button type="button" class="close" onclick="closeModal('bankAccountModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <form id="bankAccountForm" method="POST" action="/electromart/public/shop/finance/bank-accounts">
            <div class="modal-body">
                <input type="hidden" id="bankAccountAction" name="action" value="add">
                <input type="hidden" id="bankAccountID" name="BankAccountID" value="">

                <div class="form-grid">
                    <div class="form-group">
                        <label for="bankName">Tên ngân hàng <span class="required">*</span></label>
                        <select id="bankName" name="BankName" required>
                            <option value="">Chọn ngân hàng</option>
                            <option value="Vietcombank">Vietcombank</option>
                            <option value="VietinBank">VietinBank</option>
                            <option value="BIDV">BIDV</option>
                            <option value="ACB">ACB</option>
                            <option value="TPBank">TPBank</option>
                            <option value="VPBank">VPBank</option>
                            <option value="MB Bank">MB Bank</option>
                            <option value="Sacombank">Sacombank</option>
                            <option value="HSBC">HSBC</option>
                            <option value="OCB">OCB</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="accountNumber">Số tài khoản <span class="required">*</span></label>
                        <input type="text" id="accountNumber" name="AccountNumber" required
                            placeholder="Nhập số tài khoản">
                    </div>

                    <div class="form-group full-width">
                        <label for="accountHolder">Chủ tài khoản <span class="required">*</span></label>
                        <input type="text" id="accountHolder" name="AccountHolder" required
                            placeholder="Nhập tên chủ tài khoản">
                    </div>

                    <div class="form-group full-width">
                        <div class="checkbox-group">
                            <input type="checkbox" id="isDefault" name="IsDefault" value="1">
                            <label for="isDefault">Đặt làm tài khoản mặc định</label>
                        </div>
                    </div>
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

<style>
    .bank-accounts-management {
        padding: 1.5rem;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 1.875rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0 0 0.5rem 0;
    }

    .page-description {
        color: var(--text-light);
        margin: 0;
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 0.5rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .alert-success {
        background-color: #dcfce7;
        color: #166534;
        border: 1px solid #bbf7d0;
    }

    .alert-error {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .bank-accounts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
        gap: 1.5rem;
    }

    .bank-account-card {
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 0.75rem;
        overflow: hidden;
        transition: all 0.2s ease;
    }

    .bank-account-card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
    }

    .bank-account-card.default {
        border-color: #fbbf24;
        box-shadow: 0 0 0 2px rgba(251, 191, 36, 0.1);
    }

    .card-header {
        padding: 1.25rem;
        background: var(--background-light);
        border-bottom: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .bank-info h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-color);
        margin: 0 0 0.25rem 0;
    }

    .default-badge {
        background: #fbbf24;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    .card-actions {
        display: flex;
        gap: 0.5rem;
    }

    .card-body {
        padding: 1.25rem;
    }

    .account-details {
        display: grid;
        gap: 0.75rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .detail-item label {
        font-weight: 500;
        color: var(--text-light);
        font-size: 0.875rem;
    }

    .account-number {
        font-family: monospace;
        font-weight: 600;
        color: var(--primary-color);
    }

    .status {
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 500;
        text-transform: uppercase;
    }

    .status.active {
        background: #dcfce7;
        color: #166534;
    }

    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 2rem;
        background: white;
        border-radius: 0.75rem;
        border: 2px dashed var(--border-color);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--text-light);
        margin-bottom: 1.5rem;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        color: var(--text-color);
        margin: 0 0 0.5rem 0;
    }

    .empty-state p {
        color: var(--text-light);
        margin: 0 0 2rem 0;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .checkbox-group input[type="checkbox"] {
        width: 1rem;
        height: 1rem;
    }
</style>

<script>
    function openAddBankAccountModal() {
        document.getElementById('bankAccountModalTitle').textContent = 'Thêm tài khoản ngân hàng';
        document.getElementById('bankAccountAction').value = 'add';
        document.getElementById('bankAccountID').value = '';
        document.getElementById('bankAccountSubmitText').textContent = 'Thêm tài khoản';

        // Reset form
        document.getElementById('bankAccountForm').reset();

        openModal('bankAccountModal');
    }

    function editBankAccount(account) {
        document.getElementById('bankAccountModalTitle').textContent = 'Cập nhật tài khoản ngân hàng';
        document.getElementById('bankAccountAction').value = 'update';
        document.getElementById('bankAccountID').value = account.BankAccountID;
        document.getElementById('bankAccountSubmitText').textContent = 'Cập nhật';

        // Fill form with existing data
        document.getElementById('bankName').value = account.BankName;
        document.getElementById('accountNumber').value = account.AccountNumber;
        document.getElementById('accountHolder').value = account.AccountHolder;
        document.getElementById('isDefault').checked = account.IsDefault == 1;

        openModal('bankAccountModal');
    }

    function setDefaultBankAccount(bankAccountID) {
        if (confirm('Bạn có chắc chắn muốn đặt tài khoản này làm mặc định?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/electromart/public/shop/finance/bank-accounts';

            form.innerHTML = `
            <input type="hidden" name="action" value="set_default">
            <input type="hidden" name="BankAccountID" value="${bankAccountID}">
        `;

            document.body.appendChild(form);
            form.submit();
        }
    }

    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            if (event.target === modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        });
    }
</script>