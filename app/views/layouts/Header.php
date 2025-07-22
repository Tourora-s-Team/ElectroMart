<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title ?? 'ElectroMart'; ?></title>
    <link rel="stylesheet" href="/electromart/public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <base href="/electromart/">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a href="/">
                        <i class="fas fa-bolt"></i>
                        ElectroMart
                    </a>
                </div>

                <div class="search-box">
                    <form action="/search" method="GET">
                        <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                            value="<?php echo $_GET['q'] ?? ''; ?>">
                        <button type="submit"><i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="header-actions">
                    <a href="/cart" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                    <a href="/login" class="login-btn">Đăng nhập</a>
                </div>
            </div>

            <nav class="main-nav">
                <ul>
                    <li><a href="/">Trang chủ</a></li>
                    <li><a href="/search?q=">Tất cả sản phẩm</a></li>
                    <li><a href="/categories">Danh mục</a></li>
                    <li><a href="/deals">Khuyến mãi</a></li>
                    <li><a href="/about">Về chúng tôi</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="main-content">