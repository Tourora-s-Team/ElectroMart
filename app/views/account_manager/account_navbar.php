<!-- Thành phần dùng chung -->
<link rel="stylesheet" href="https://electromart-t8ou8.ondigitalocean.app/public/css/account_manager/account_navbar.css">
<link rel="stylesheet" href="https://electromart-t8ou8.ondigitalocean.app/public/css/account_manager/account_info.css">

<?php require_once __DIR__ . "/../layouts/header.php"; ?>

<div id="toast-container"></div>
<?php if (!empty($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast("<?= addslashes($_SESSION['message']) ?>", '<?= $_SESSION['status_type'] ?>');
        });
    </script>
<?php endif;
unset($_SESSION['message']);
unset($_SESSION['status_type']); ?>

<section id="account-manager" class="dashboard">
    <!-- Nút mở menu (hiện trên mobile) -->
    <div class="toggle-btn-mobile">
        <button id="nav-toggle-btn" class="nav-toggle-btn" onclick="toggleNavMenu()">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Overlay (click để đóng menu) -->
    <div id="nav-overlay" class="nav-overlay" onclick="toggleNavMenu()"></div>

    <!-- Menu trượt dạng modal -->
    <nav class="navigation-button" id="nav-menu">
        <button class="nav-btn fontsize-16" data-action="info" onclick="goToAction(this)">
            <i class="far fa-user"></i>Thông tin tài khoản
        </button>
        <button class="nav-btn fontsize-16" data-action="order-history" onclick="goToAction(this)">
            <i class="fas fa-box"></i>Lịch sử mua hàng
        </button>
        <button class="nav-btn fontsize-16" data-action="receiver-info" onclick="goToAction(this)">
            <i class="fas fa-map-marker-alt"></i>Địa chỉ nhận hàng
        </button>
        <button class="nav-btn fontsize-16" data-action="security" onclick="goToAction(this)">
            <i class="fas fa-lock"></i>Bảo mật
        </button>
        <button class="nav-btn fontsize-16" data-action="wish-list" onclick="goToAction(this)">
            <i class="fas fa-heart"></i>Yêu thích
        </button>
        <button class="nav-btn fontsize-16" data-action="signout" onclick="goToAction(this)">
            <i class="fas fa-sign-out-alt"></i>Đăng xuất
        </button>
    </nav>
</section>


<script>
    function goToAction(button) {
        const action = button.dataset.action;
        const parts = window.location.pathname.split('/');
        const base = parts.slice(0, -1).join('/');
        const newUrl = base + '/' + action;
        window.location.href = newUrl;
    }

    function toggleNavMenu() {
        const navMenu = document.getElementById("nav-menu");
        const toggleBtn = document.getElementById("nav-toggle-btn");
        const overlay = document.getElementById("nav-overlay");

        // Toggle nav menu
        navMenu.classList.toggle("active");
        overlay.classList.toggle("active");

        // Toggle icon: bars ↔ times
        const icon = toggleBtn.querySelector("i");
        icon.classList.toggle("fa-bars");
        icon.classList.toggle("fa-times");
    }

    function adjustLayoutForMobile() {
        // Kiểm tra nếu là thiết bị di động
        const isMobile = window.innerWidth <= 468;
        const accountDetails = document.querySelector('.account-details form fieldset .grid-form');

        if (isMobile && accountDetails) {
            accountDetails.classList.remove('grid-form');
            accountDetails.classList.add('flex-row');
        }
    }

    // Gọi hàm khi trang tải xong
    window.addEventListener('DOMContentLoaded', adjustLayoutForMobile);

    // Gọi lại nếu cửa sổ thay đổi kích thước
    window.addEventListener('resize', adjustLayoutForMobile);

</script>
<script src="<?= $_ENV['SCRIPT_PATH'] . 'main.js' ?>"></script>
