<?php
$title = "ElectroMart - Quản lý người dùng";
$pageTitle = "Quản lý người dùng";
$pageSubtitle = "Quản lý người dùng trong hệ thống";
$activeTab = "user_manager";
include(__DIR__ . '/../layouts/admin_header.php');
?>
<div class="admin-user-manager">
    <div class="admin-container">
        <section class="filter-section">
            <form id="orderFilterForm" class="filter-form" method="GET"
                action="https://electromart-t8ou8.ondigitalocean.app/public/admin/user_manager">
                <div class="filter-grid">
                    <!-- Status Filter -->
                    <div class="filter-group">
                        <label for="statusFilter" class="filter-label">
                            <i class="fas fa-filter"></i>
                            Trạng thái
                        </label>
                        <select id="statusFilter" name="IsActive" class="filter-select">
                            <option value="">Tất cả trạng thái</option>
                            <option value="1" <?php echo (isset($_GET['IsActive']) && $_GET['IsActive'] === '1') ? 'selected' : ''; ?>>Còn hoạt động</option>
                            <option value="0" <?php echo (isset($_GET['IsActive']) && $_GET['IsActive'] === '0') ? 'selected' : ''; ?>>Đã khoá</option>
                        </select>
                    </div>

                    <!-- User ID Filter -->
                    <div class="filter-group">
                        <label for="userEmailFilter" class="filter-label">
                            <i class="fas fa-user"></i>
                            Email
                        </label>
                        <input type="text" id="userEmailFilter" name="Email" placeholder="Nhập Email..."
                            class="filter-input" value="<?php echo $_GET['Email'] ?? ''; ?>">
                    </div>
                    <!-- Role Filter -->
                    <div class="filter-group">
                        <label for="roleFilter" class="filter-label">
                            <i class="fas fa-user"></i>
                            Quyền
                        </label>
                        <input type="text" id="roleFilter" name="Role" placeholder="Nhập quyền tài khoản..."
                            class="filter-input" value="<?php echo $_GET['Role'] ?? ''; ?>">
                    </div>
                </div>

                <div class="filter-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Áp dụng bộ lọc
                    </button>
                </div>
            </form>
        </section>

        <section class="table-section">
            <div class="table-container">
                <div class="table-header">
                    <h3 class="table-title">
                        Danh sách người dùng (<span
                            id="userCount"><?php echo isset($users) ? count($users) : 0; ?></span> người
                        dùng)
                    </h3>
                </div>
                <div class="table-wrapper">
                    <table class="orders-table" id="ordersTable">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>Trạng thái</th>
                                <th>Quyền</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Password</th>
                                <th>Hành động</th>

                            </tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            <?php if (isset($users) && !empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr class="order-row" data-order-id="<?php echo htmlspecialchars($user['UserID']); ?>">
                                        <td class="order-id">
                                            <span class="font-medium"><?php echo htmlspecialchars($user['UserID']); ?></span>
                                        </td>
                                        <td class="order-status">
                                            <span class="status-badge status-<?php echo strtolower($user['IsActive']); ?>">
                                                <?php echo htmlspecialchars($user['IsActive']); ?>
                                            </span>
                                        </td>
                                        <td class="order-status">
                                            <span class="status-badge status-<?php echo strtolower($user['Role']); ?>">
                                                <?php echo htmlspecialchars($user['Role']); ?>
                                            </span>
                                        </td>
                                        <td class="order-status">
                                            <span class="status-badge status-<?php echo strtolower($user['Email']); ?>">
                                                <?php echo htmlspecialchars($user['Email']); ?>
                                            </span>
                                        </td>
                                        <td class="user-id">
                                            <span><?php echo ($user['Phonenumber']); ?></span>
                                        </td>
                                        <td class="password">
                                            <span><?php echo htmlspecialchars($user['Password']); ?></span>
                                        </td>
                                        <td>
                                            <?php if ($user['IsActive'] == 1): ?>
                                                <a style="color : red"
                                                    href="https://electromart-t8ou8.ondigitalocean.app/public/admin/users/deactivate?id=<?= $user['UserID'] ?>"
                                                    onclick="return confirm('Bạn có chắc muốn khóa tài khoản này?');">
                                                    Khóa
                                                </a>
                                            <?php else: ?>
                                                Đã khóa
                                            <?php endif; ?>
                                            <?php if ($user['IsActive'] == 0): ?>
                                                <a href="https://electromart-t8ou8.ondigitalocean.app/public/admin/users/open?id=<?= $user['UserID'] ?>"
                                                    onclick="return confirm('Bạn có chắc muốn mở khóa tài khoản này?');">
                                                    Mở Khóa
                                                </a>
                                            <?php endif; ?>
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
    </div>
</div>

<?php include(__DIR__ . '/../layouts/admin_footer.php'); ?>