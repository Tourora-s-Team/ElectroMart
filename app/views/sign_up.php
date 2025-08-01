<link rel="stylesheet" href="https://electromart-t8ou8.ondigitalocean.app/public/css/auth.css">
<!-- Thư viện định dạng ngày tháng -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <div id="toast-container"></div>
        <?php if (!empty($_SESSION['signup_error'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showToast("<?= addslashes($_SESSION['signup_error']) ?>", 'error');
                });
            </script>
        <?php endif;
        unset($_SESSION['signup_error']); ?>

        <?php if (!empty($_SESSION['verification_error'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showToast("<?= addslashes($_SESSION['verification_error']) ?>", 'error');
                });
            </script>
        <?php endif;
        unset($_SESSION['verification_error']); ?>
        <!-- Register Form -->
        <div class="auth-container" id="registerForm">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Đăng ký</h2>
                    <p>Tạo tài khoản mới để mua sắm tại ElectroMart</p>
                </div>

                <form action="https://electromart-t8ou8.ondigitalocean.app/public/account/signup" method="POST"
                    class="auth-form">
                    <div class="form-group">
                        <label for="registerName">Họ và tên *</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" id="registerName" name="registerName" placeholder="Nhập họ và tên"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registerEmail">Email *</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-envelope"></i></span>
                            <input type="email" id="registerEmail" name="registerEmail" placeholder="Nhập email"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registerPhone">Số điện thoại *</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-phone"></i></span>
                            <input type="tel" id="registerPhone" name="registerPhone" placeholder="Nhập số điện thoại"
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registerBirthdate">Ngày sinh</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-cake-candles"></i></span>
                            <input type="text" placeholder="dd/mm/yyyy" id="registerBirthdate" name="registerBirthdate">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="registerPassword">Mật khẩu *</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="registerPassword" name="registerPassword"
                                placeholder="Nhập mật khẩu" required>
                            <button type="button" class="password-toggle"
                                onclick="togglePassword('registerPassword')"><i class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="confirmPassword">Xác nhận mật khẩu *</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="confirmPassword" placeholder="Nhập lại mật khẩu" required>
                            <button type="button" class="password-toggle" onclick="togglePassword('confirmPassword')"><i
                                    class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input id="registerAgree" type="checkbox" name="registerAgree">
                            <span class="checkmark"></span>
                            Tôi đồng ý với <a href="#">Điều khoản sử dụng</a> và <a href="#">Chính sách bảo mật</a>
                        </label>
                    </div>

                    <button type="submit" class="btn-primary">Đăng ký tài khoản</button>
                </form>

                <div class="auth-footer">
                    <p>Đã có tài khoản? <a href="#" onclick="showLogin()">Đăng nhập ngay</a></p>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
<script>
    flatpickr("#registerBirthdate", {
        dateFormat: "d/m/Y", // định dạng hiển thị
    });
</script>
<script src="<?= $_ENV['SCRIPT_PATH'] . 'main.js' ?>"></script>
<script src="<?= $_ENV['SCRIPT_PATH'] . 'auth.js' ?>"></script>