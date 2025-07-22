<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/dashboard.css' ?>">
<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/account_info.css' ?>">
<section class="account_nav">
    <div class="left-container">
        <a href="/electromart/public/index.php">
            <img src="<?= $_ENV['IMG_PATH'] . 'logo_electro_mart.png' ?>" alt="ElectricMart Logo" class="logo">
        </a>
        <div>
            <h1>Quản lý tài khoản</h1>
            <p class="fontsize-16">ElectroMart - Linh kiện, thiết bị điện tử chất lượng cao.</p>
        </div>
    </div>

    <div class="right-container">
        <div>
            <p class="customer-name">Customer Name</p>
            <p class="loyalty-point">0 Points</p>
        </div>
        <img src="<?= $_ENV['IMG_PATH'] . 'avatar_default.png' ?>" alt="Avatar" class="avatar">
    </div>
</section>

<section id="account-manager" class="dashboard">
    <nav class="navigation-left">
        
        <button class="nav-left-btn fontsize-16" onclick="toggleActive(this)"><i class="far fa-user"></i>Thông tin tài khoản</button>
        <button class="nav-left-btn fontsize-16" onclick="toggleActive(this)"><i class="fas fa-box"></i>Lịch sử mua hàng</button>
        <button class="nav-left-btn fontsize-16" onclick="toggleActive(this)"><i class="fas fa-map-marker-alt"></i></i>Địa chỉ giao hàng</button>
        <button class="nav-left-btn fontsize-16" onclick="toggleActive(this)"><i class="fas fa-lock"></i>Bảo mật</button>
        <button class="nav-left-btn fontsize-16" onclick="toggleActive(this)"><i class="fas fa-heart"></i>Yêu thích</button>
        <button class="nav-left-btn fontsize-16" onclick="toggleActive(this)"><i class="fas fa-sign-out-alt"></i>Đăng xuất</button>
    
    </nav>
    <section class="main-content dashboard-header">
        <?php 
        
        ?>
    </section>

</section>

<script>
function toggleActive(el) {
    // Bỏ active khỏi tất cả button
    const buttons = document.querySelectorAll('.nav-left-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // Thêm active cho button đang click
    el.classList.add('active');
}
</script>