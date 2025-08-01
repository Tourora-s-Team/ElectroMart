<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'Quản lý Shop'; ?> - ElectroMart</title>

    <!-- Favicon -->
    <link rel="shortcut icon" href="/electromart-o63e5.ondigitalocean.app/public/images/logo_electro_mart.png"
        type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/electromart-o63e5.ondigitalocean.app/public/fontawesome/css/all.min.css">

    <!-- Base CSS -->
    <link rel="stylesheet" href="/electromart-o63e5.ondigitalocean.app/public/css/base.css">

    <!-- Shop Admin CSS -->
    <link rel="stylesheet" href="/electromart-o63e5.ondigitalocean.app/public/css/shop/shop-admin.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Styles -->
    <style>
        /* Page specific overrides if needed */
        <?php if (isset($additionalCSS)): ?>
            <?php echo $additionalCSS; ?>
        <?php endif; ?>
    </style>
</head>

<body class="shop-admin-layout">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <!-- Shop Header -->
        <div class="sidebar-header">
            <div class="shop-info">
                <div class="shop-avatar">
                    <?php if (!empty($shopInfo['LogoURL'])): ?>
                        <img src="<?php echo htmlspecialchars($shopInfo['LogoURL']); ?>" alt="Shop Logo">
                    <?php else: ?>
                        <i class="fas fa-store"></i>
                    <?php endif; ?>
                </div>
                <div class="shop-details">
                    <h3 class="shop-name"><?php echo htmlspecialchars($shopInfo['ShopName'] ?? 'Shop của tôi'); ?></h3>
                    <p class="shop-owner"><?php echo htmlspecialchars($shopInfo['OwnerName'] ?? 'Chủ shop'); ?></p>
                </div>
            </div>
            <button type="button" class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/shop/dashboard"
                        class="nav-link <?php echo ($currentPage ?? '') === 'dashboard' ? 'active' : ''; ?>">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/shop/info"
                        class="nav-link <?php echo ($currentPage ?? '') === 'shop-info' ? 'active' : ''; ?>">
                        <i class="fas fa-store nav-icon"></i>
                        <span class="nav-text">Thông tin Shop</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/shop/orders"
                        class="nav-link <?php echo ($currentPage ?? '') === 'orders' ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart nav-icon"></i>
                        <span class="nav-text">Quản lý đơn hàng</span>
                        <?php if (!empty($orderNotifications)): ?>
                            <span class="nav-badge"><?php echo $orderNotifications; ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/shop/products"
                        class="nav-link <?php echo ($currentPage ?? '') === 'products' ? 'active' : ''; ?>">
                        <i class="fas fa-box nav-icon"></i>
                        <span class="nav-text">Quản lý sản phẩm</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/shop/finance"
                        class="nav-link <?php echo ($currentPage ?? '') === 'finance' ? 'active' : ''; ?>">
                        <i class="fas fa-chart-line nav-icon"></i>
                        <span class="nav-text">Quản lý tài chính</span>
                    </a>
                </li>

                <li class="nav-divider"></li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/" class="nav-link">
                        <i class="fas fa-home nav-icon"></i>
                        <span class="nav-text">Trang chủ</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/account/info" class="nav-link">
                        <i class="fas fa-user nav-icon"></i>
                        <span class="nav-text">Tài khoản</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/account/signout" class="nav-link">
                        <i class="fas fa-sign-out-alt nav-icon"></i>
                        <span class="nav-text">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="shop-status">
                <div class="status-indicator <?php echo ($shopInfo['IsActive'] ?? 1) ? 'active' : 'inactive'; ?>"></div>
                <span class="status-text">
                    <?php echo ($shopInfo['IsActive'] ?? 1) ? 'Shop đang hoạt động' : 'Shop tạm ngừng'; ?>
                </span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Header -->
        <header class="main-header">
            <div class="header-left">
                <button type="button" class="mobile-sidebar-toggle" id="mobileSidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="breadcrumb">
                    <?php if (!empty($breadcrumb)): ?>
                        <?php foreach ($breadcrumb as $index => $item): ?>
                            <?php if ($index > 0): ?>
                                <i class="fas fa-chevron-right breadcrumb-separator"></i>
                            <?php endif; ?>
                            <?php if ((isset($item['url']) || isset($item['link'])) && $index < count($breadcrumb) - 1): ?>
                                <a href="<?php echo htmlspecialchars($item['url'] ?? $item['link'] ?? ''); ?>"
                                    class="breadcrumb-link">
                                    <?php echo htmlspecialchars($item['text'] ?? $item['title'] ?? ''); ?>
                                </a>
                            <?php else: ?>
                                <span class="breadcrumb-current">
                                    <?php echo htmlspecialchars($item['text'] ?? $item['title'] ?? ''); ?>
                                </span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="header-right">
                <!-- Notifications -->
                <div class="header-item notification-dropdown">
                    <button type="button" class="header-btn" id="notificationToggle">
                        <i class="fas fa-bell"></i>
                        <?php if (!empty($totalNotifications)): ?>
                            <span class="notification-count"><?php echo $totalNotifications; ?></span>
                        <?php endif; ?>
                    </button>
                    <div class="dropdown-menu notification-menu" id="notificationMenu">
                        <div class="dropdown-header">
                            <h4>Thông báo</h4>
                            <button type="button" class="mark-all-read">Đánh dấu đã đọc</button>
                        </div>
                        <div class="notification-list">
                            <?php if (!empty($notifications)): ?>
                                <?php foreach ($notifications as $notification): ?>
                                    <div class="notification-item <?php echo $notification['is_read'] ? '' : 'unread'; ?>">
                                        <div class="notification-icon">
                                            <i class="<?php echo $notification['icon'] ?? 'fas fa-info-circle'; ?>"></i>
                                        </div>
                                        <div class="notification-content">
                                            <div class="notification-title">
                                                <?php echo htmlspecialchars($notification['title']); ?>
                                            </div>
                                            <div class="notification-message">
                                                <?php echo htmlspecialchars($notification['message']); ?>
                                            </div>
                                            <div class="notification-time"><?php echo $notification['time']; ?></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="empty-notifications">
                                    <i class="fas fa-bell-slash"></i>
                                    <p>Không có thông báo mới</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="dropdown-footer">
                            <a href="/electromart-o63e5.ondigitalocean.app/public/shop/notifications"
                                class="view-all-link">Xem tất cả</a>
                        </div>
                    </div>
                </div>

                <!-- User Profile -->
                <div class="header-item user-dropdown">
                    <button type="button" class="header-btn user-btn" id="userToggle">
                        <span
                            class="user-name"><?php echo htmlspecialchars($_SESSION['customer'][0]['FullName'] ?? 'User'); ?></span>
                        <div class="user-avatar">
                            <?php if (!empty($_SESSION['user'][0]['Avatar'])): ?>
                                <img src="<?php echo htmlspecialchars($_SESSION['user'][0]['Avatar']); ?>"
                                    alt="User Avatar">
                            <?php else: ?>
                                <i class="fas fa-user"></i>
                            <?php endif; ?>
                        </div>
                    </button>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <div class="page-content">
            <?php echo $content; ?>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="footer-content">
                <div class="footer-left">
                    <p>&copy; <?php echo date('Y'); ?> ElectroMart. Tất cả quyền được bảo lưu.</p>
                </div>
                <div class="footer-right">
                    <a href="/electromart-o63e5.ondigitalocean.app/public/terms" class="footer-link">Điều khoản</a>
                    <a href="/electromart-o63e5.ondigitalocean.app/public/privacy" class="footer-link">Quyền riêng
                        tư</a>
                    <a href="/electromart-o63e5.ondigitalocean.app/public/support" class="footer-link">Hỗ trợ</a>
                </div>
            </div>
        </footer>
    </main>

    <!-- Overlay for mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Toast Container -->
    <div id="toastContainer" class="toast-container"></div>

    <!-- Scripts -->
    <script src="/electromart-o63e5.ondigitalocean.app/public/js/shop/shop-admin.js"></script>

    <!-- Page specific scripts -->
    <?php if (isset($additionalJS)): ?>
        <script>
            <?php echo $additionalJS; ?>
        </script>
    <?php endif; ?>

    <!-- Custom Scripts -->
    <script>
        // Initialize shop admin functionality
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize shop admin system
            if (typeof initializeShopAdmin === 'function') {
                initializeShopAdmin();
            }

            // Auto-refresh notifications every 30 seconds
            setInterval(function () {
                if (typeof refreshNotifications === 'function') {
                    refreshNotifications();
                }
            }, 30000);

            // Page specific initialization
            if (typeof pageInit === 'function') {
                pageInit();
            }
        });

        // Refresh notifications function
        function refreshNotifications() {
            fetch('/electromart-o63e5.ondigitalocean.app/public/shop/api/notifications', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        if (response.status === 403) {
                            console.warn('Authentication required for notifications');
                            return null; // Don't throw error for authentication issues
                        }
                        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                    }
                    return response.text();
                })
                .then(text => {
                    if (text === null) return; // Skip if authentication failed

                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        console.error('Response is not valid JSON:', text);
                        throw new Error('Server trả về dữ liệu không hợp lệ. Vui lòng thử lại.');
                    }
                    return data;
                })
                .then(data => {
                    if (data && data.success) {
                        updateNotificationCount(data.count);
                        updateNotificationList(data.notifications);
                    }
                })
                .catch(error => {
                    console.error('Error refreshing notifications:', error);
                });
        }

        // Update notification count
        function updateNotificationCount(count) {
            const countElement = document.querySelector('.notification-count');
            if (count > 0) {
                if (countElement) {
                    countElement.textContent = count;
                    countElement.style.display = 'block';
                } else {
                    const bellIcon = document.querySelector('#notificationToggle');
                    const countSpan = document.createElement('span');
                    countSpan.className = 'notification-count';
                    countSpan.textContent = count;
                    bellIcon.appendChild(countSpan);
                }
            } else {
                if (countElement) {
                    countElement.style.display = 'none';
                }
            }
        }

        // Update notification list
        function updateNotificationList(notifications) {
            const notificationList = document.querySelector('.notification-list');
            if (notificationList && Array.isArray(notifications)) {
                if (notifications.length === 0) {
                    notificationList.innerHTML = `
                        <div class="empty-notifications">
                            <i class="fas fa-bell-slash"></i>
                            <p>Không có thông báo mới</p>
                        </div>
                    `;
                } else {
                    notificationList.innerHTML = notifications.map(notification => `
                        <div class="notification-item ${notification.is_read ? '' : 'unread'}">
                            <div class="notification-icon">
                                <i class="${notification.icon || 'fas fa-info-circle'}"></i>
                            </div>
                            <div class="notification-content">
                                <div class="notification-title">${escapeHtml(notification.title)}</div>
                                <div class="notification-message">${escapeHtml(notification.message)}</div>
                                <div class="notification-time">${notification.time}</div>
                            </div>
                        </div>
                    `).join('');
                }
            }
        }

        // Utility function to escape HTML
        function escapeHtml(unsafe) {
            return unsafe
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
</body>

</html>