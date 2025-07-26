<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'ElectroMart'; ?></title>
    <link rel="stylesheet" href="/electromart/public/css/base.css">
    <link rel="stylesheet" href="/electromart/public/css/components/header.css">
    <link rel="stylesheet" href="/electromart/public/css/components/footer.css">
    <link rel="stylesheet" href="/electromart/public/css/components/home.css">
    <link rel="stylesheet" href="/electromart/public/css/components/cart.css">
    <link rel="stylesheet" href="/electromart/public/css/components/search.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="/electromart/public/js/main.js" defer></script>
    <base href="/electromart/">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="public">
                        <i class="fas fa-bolt"></i>
                        ElectroMart
                    </a>
                </div>

                <div class="search-box">
                    <form action="public/search" method="GET">
                        <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                            value="<?php echo $_GET['q'] ?? ''; ?>">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="header-actions">
                    <a href="public/cart" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                    <!-- Hiển thị tên người dùng -->
                    <?php
                    require_once ROOT_PATH . '/app/models/Customer.php';
                    $fullName = 'Khách hàng';

                    if (!empty($_SESSION['user'][0]['UserID'])) {
                        $customerModel = new Customer();
                        $res = $customerModel->getCustomerById($_SESSION['user'][0]['UserID']);

                        if (!empty($res) && isset($res[0]['FullName'])) {
                            $fullName = $res[0]['FullName'];
                        }
                    }
                    ?>
                    <a href="public/account/info" class="profile-btn">
                        <i class="fas fa-user"></i>
                        <?php echo $fullName; ?>

                    </a>
                    <!-- Hiển thị nút đăng nhập hoặc đăng xuất -->
                    <?php if (!empty($_SESSION['user'][0]['UserID'])): ?>
                        <a href="public/account/signout" class="login-btn">Đăng xuất</a>
                    <?php endif; ?>
                    <?php if (empty($_SESSION['user'][0]['UserID'])): ?>
                        <a href="public/account/signin" class="login-btn">Đăng nhập</a>
                    <?php endif; ?>

                </div>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="public">Trang chủ</a></li>
                    <li><a href="public/search">Tất cả sản phẩm</a></li>
                    <li><a href="public/categories">Danh mục</a></li>
                    <li><a href="public/deals">Khuyến mãi</a></li>
                    <li><a href="public/about">Về chúng tôi</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">