<?php
$email = isset($_SESSION['user'][0]['Email']) ? $_SESSION['user'][0]['Email'] : null;
$shopName = 'Shop của tôi'; // Sẽ được cập nhật từ database
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'ElectroMart - Quản lý Shop'; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://electromart-t8ou8.ondigitalocean.app/public/css/shop/shop-admin.css">
    <script src="https://kit.fontawesome.com/f6aadf5dfa.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <button id="toggleSidebar" class="mobile-menu-btn">
        <i class="fas fa-bars"></i>
    </button>
    <div class="shop-admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="logo">
                    <i class="fas fa-store"></i>
                    <h1>Shop Manager</h1>
                </div>
                <p class="subtitle">Xin chào <?php echo $email ?></p>
            </div>

            <nav class="sidebar-nav">
                <ul>
                    <li
                        class="nav-item <?php echo (isset($activeTab) && $activeTab === 'dashboard') ? 'active' : ''; ?>">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/dashboard" class="nav-link">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($activeTab) && $activeTab === 'info') ? 'active' : ''; ?>">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/info" class="nav-link">
                            <i class="fas fa-store"></i>
                            <span>Thông tin Shop</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($activeTab) && $activeTab === 'orders') ? 'active' : ''; ?>">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/orders" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Quản lý đơn hàng</span>
                        </a>
                    </li>
                    <li
                        class="nav-item <?php echo (isset($activeTab) && $activeTab === 'products') ? 'active' : ''; ?>">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/products" class="nav-link">
                            <i class="fas fa-box"></i>
                            <span>Quản lý sản phẩm</span>
                        </a>
                    </li>
                    <li class="nav-item <?php echo (isset($activeTab) && $activeTab === 'finance') ? 'active' : ''; ?>">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/finance" class="nav-link">
                            <i class="fas fa-dollar-sign"></i>
                            <span>Quản lý tài chính</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/home" class="nav-link">
                            <i class="fas fa-home"></i>
                            <span>Về trang chủ</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="https://electromart-t8ou8.ondigitalocean.app/public/account/signout" class="nav-link">
                            <i class="fas fa-sign-out-alt"></i>
                            <span>Đăng xuất</span>
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
                        <h2 class="page-title"><?php echo isset($pageTitle) ? $pageTitle : 'Dashboard'; ?></h2>
                        <p class="page-subtitle">
                            <?php echo isset($pageSubtitle) ? $pageSubtitle : 'Quản lý shop của bạn'; ?>
                        </p>
                    </div>
                    <div class="header-right">
                        <div class="user-info">
                            <span class="user-name"><?php echo $email; ?></span>
                            <div class="user-avatar">
                                <i class="fas fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="page-content"><?php // Content sẽ được include ở đây ?>