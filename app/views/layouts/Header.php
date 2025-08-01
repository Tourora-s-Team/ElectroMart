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
    <link rel="stylesheet" href="/electromart/public/css/components/productdetail.css">
    <base href="/electromart/">
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="header-row1">
                    <div class="logo">
                        <a href="public">
                            <i class="fas fa-bolt"></i>
                            ElectroMart
                        </a>
                    </div>
                    <?php if (!empty($_SESSION['user'][0]['UserID'])): ?>
                        <div class="user-name user-menu" onclick="toggleDropdown()"><i class="fa-solid fa-user"></i>
                            <?php echo $fullName; ?> ▼
                            <div class="dropdown" id="userDropdown">
                                <a id="info" href="public/account/info">Thông tin cá nhân</a>
                                <a id="seller" href="public/shop">Kênh người bán</a>
                                <a id="sign_out" href="public/account/signout">Đăng xuất</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="public/account/signin" class="login-btn">Đăng nhập</a>
                    <?php endif; ?>
                </div>
                <div class="header-row2">
                    <button class="menu-toggle" onclick="toggleMainNav()">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="search-box">
                        <form action="public/search" method="GET">
                            <input type="text" name="q" placeholder="Tìm kiếm sản phẩm..."
                                value="<?php echo $_GET['q'] ?? ''; ?>">
                            <button type="submit"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                    <a href="public/cart" class="cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count">0</span>
                    </a>
                </div>
            </div>



            <nav class="main-nav">
                <ul>
                    <li><a href="public">Trang chủ</a></li>
                    <li><a href="public/search">Tất cả sản phẩm</a></li>
                    <li><a href="public/categories">Danh mục</a></li>
                    <li><a href="public/promotions">Khuyến mãi</a></li>
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
                    console.log("Dropdown closed");
                }
            }
            function toggleMainNav() {
                var nav = document.querySelector('.main-nav');
                nav.classList.toggle('open');
            }
            // Đóng menu khi click ngoài menu trên mobile
            window.addEventListener('click', function (e) {
                var nav = document.querySelector('.main-nav');
                var toggle = document.querySelector('.menu-toggle');
                if (nav.classList.contains('open') && !nav.contains(e.target) && !toggle.contains(e.target)) {
                    nav.classList.remove('open');
                }
            });
        </script>

    </main>
</body>