<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'ElectroMart - Quản lý bán hàng'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/electromart/public/css/admin/StyleOrders.css">
    <script src="https://kit.fontawesome.com/f6aadf5dfa.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-bolt"></i>
                    <h1>ElectroMart</h1>
                </div>
                <p class="subtitle">Xin chào <?php $tenngdung ?></p> <!-- Sau này cập nhật sau $tenngdung -->
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li class="nav-item <?php echo (isset($activeTab) && $activeTab === 'orders') ? 'active' : ''; ?>">
                        <a href="/electromart/public/admin/orders" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Quản lý đơn hàng</span>
                        </a>
                    </li>
                    <li
                        class="nav-item <?php echo (isset($activeTab) && $activeTab === 'products') ? 'active' : ''; ?>">
                        <a href="/electromart/public/admin/products" class="nav-link">
                            <i class="fas fa-box"></i>
                            <span>Quản lý sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($activeTab) && $activeTab === 'finance') ? 'active' : ''; ?>">
                        <a href="/electromart/public/admin/finance" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Quản lý tài chính</span>
                        </a>
                    </li>
                    <li
                        class="nav-item <?php echo (isset($activeTab) && $activeTab === 'dashboard') ? 'active' : ''; ?>">
                        <a href="/dashboard" class="nav-link">
                            <i class="fas fa-chart-bar"></i>
                            <span>Phân tích dữ liệu</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="content-header">
                <div class="header-content">
                    <div class="header-left">
                        <h2 class="page-title"><?php echo isset($pageTitle) ? $pageTitle : 'Quản lý đơn hàng'; ?></h2>
                        <p class="page-subtitle">
                            <?php echo isset($pageSubtitle) ? $pageSubtitle : 'Quản lý và theo dõi đơn hàng của bạn'; ?>
                        </p>
                    </div>
                    <?php if (isset($activeTab) && $activeTab === 'orders'): ?>
                            <div class="header-right">
                                <div class="stats-summary">
                                    <p class="stats-label">Tổng đơn hàng hôm nay</p>
                                    <p class="stats-value" id="todayOrderCount">
                                        <?php echo isset($todayOrderCount) ? $todayOrderCount : '0'; ?></p>
                                </div>
                            </div>
                        </div>
                <?php endif; ?>
            </header>