<!-- Thành phần dùng chung của các trang trong account_manager -->
<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/account_navbar.css' ?>">
<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/account_info.css' ?>">

<section class="account_nav">
    <div class="left-container">
        <a href="/electromart/public/">
            <img src="<?= $_ENV['IMG_PATH'] . 'logo_electro_mart.png' ?>" alt="ElectricMart Logo" class="logo">
        </a>
        <div>
            <h1>Quản lý tài khoản</h1>
            <p class="fontsize-16">ElectroMart - Linh kiện, thiết bị điện tử chất lượng cao.</p>
        </div>
    </div>

    <div class="right-container">
        <div>
            <p class="customer-name"><?= $customerData[0]["FullName"] ?></p>
            <p class="loyalty-point"><?= $customerData[0]["LoyaltyPoint"] ?> Points</p>
        </div>
        <img src="<?= $_ENV['IMG_PATH'] . 'avatar_default.png' ?>" alt="Avatar" class="avatar">
    </div>
</section>

<section id="account-manager" class="dashboard">
    <nav class="navigation-button">
        <button class="nav-btn fontsize-16" data-action="info" onclick="toggleActive(this); goToAction(this)"><i
                class="far fa-user"></i>Thông tin tài khoản</button>
        <button class="nav-btn fontsize-16" data-action="order-history"
            onclick="toggleActive(this); goToAction(this)"><i class="fas fa-box"></i>Lịch sử mua hàng</button>
        <button class="nav-btn fontsize-16" data-action="shipping-address"
            onclick="toggleActive(this); goToAction(this)"><i class="fas fa-map-marker-alt"></i>Địa chỉ giao
            hàng</button>
        <button class="nav-btn fontsize-16" data-action="security" onclick="toggleActive(this); goToAction(this)"><i
                class="fas fa-lock"></i>Bảo
            mật</button>
        <button class="nav-btn fontsize-16" data-action="favorites" onclick="toggleActive(this); goToAction(this)"><i
                class="fas fa-heart"></i>Yêu
            thích</button>
        <button class="nav-btn fontsize-16" data-action="signout" onclick="toggleActive(this); goToAction(this)"><i
                class="fas fa-sign-out-alt"></i>Đăng
            xuất</button>
    </nav>
</section>
<div id="toast-container"></div>
<script>
    function toggleActive(el) {
        // Bỏ active khỏi tất cả button
        const buttons = document.querySelectorAll('.nav-btn');
        buttons.forEach(btn => btn.classList.remove('active'));

        // Thêm active cho button đang click
        el.classList.add('active');
    }
    function goToAction(button) {
        // Lấy url từ data-action của button sau đó thêm vào đường dẫn mới để chuyển hướng trang
        const action = button.dataset.action;
        const parts = window.location.pathname.split('/');

        // Lấy tất cả các phần tử ngoại trừ phần tử cuối cùng của url hiện tại
        const base = parts.slice(0, -1).join('/');

        const newUrl = base + '/' + action;
        window.location.href = newUrl;
    }

</script>