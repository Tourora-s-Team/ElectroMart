<?php
require_once ROOT_PATH . '/app/models/Customer.php';

if (!empty($_SESSION)) {
    $fullName = $_SESSION['customer'][0]['FullName'];
}

?>
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
                    <?php if (empty($_SESSION['user'][0]['UserID'])): ?>
                        <a href="public/account/signin" class="login-btn">Đăng nhập</a>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['user'][0]['UserID'])): ?>
                        <!-- drop down Profile -->
                        <div class="user-menu">
                            <div class="user-name" onclick="toggleDropdown()"><i class="fa-solid fa-user"></i>
                                <?php echo $fullName; ?> ▼</div>
                            <div class="dropdown" id="userDropdown">
                                <a id="info" href="public/account/info">Thông tin cá nhân</a>
                                <a id="seller" href="/orders">Kênh người bán</a>
                                <a id="sign_out" href="public/account/signout">Đăng xuất</a>
                            </div>
                        </div>
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

        <script>
            function toggleDropdown() {
                var dropdown = document.getElementById("userDropdown");
                dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
            }

            // Tắt dropdown nếu click ra ngoài
            window.onclick = function (event) {
                if (!event.target.closest('.user-menu')) {
                    document.getElementById("userDropdown").style.display = "none";
                }
            }
        </script>