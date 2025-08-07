<link rel="stylesheet" href="https://electromart.online/public/css/auth.css">

<main class="main-content">
    <div class="container">
        <div id="toast-container"></div>
        <?php if (!empty($_SESSION['login_error'])): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    showToast("<?= addslashes($_SESSION['login_error']) ?>", 'error');
                });
            </script>
        <?php endif;
        unset($_SESSION['login_error']); ?>
        <!-- Sign in Form -->
        <div class="auth-container" id="loginForm">
            <div class="auth-card">
                <div class="auth-header">
                    <h2>Đăng nhập</h2>
                    <p>Chào mừng bạn quay trở lại ElectroMart</p>
                </div>

                <form action="https://electromart.online/public/account/signin" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="loginInfo">Email hoặc Số điện thoại</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-user"></i></span>
                            <input type="text" id="loginInfo" name="loginInfo"
                                placeholder="Nhập email hoặc số điện thoại" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="loginPassword">Mật khẩu</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" id="loginPassword" name="password" placeholder="Nhập mật khẩu"
                                required>
                            <button type="button" class="password-toggle" onclick="togglePassword('loginPassword')"><i
                                    class="fa-solid fa-eye"></i></button>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox-label">
                            <input type="checkbox">
                            <span class="checkmark"></span>
                            Ghi nhớ đăng nhập
                        </label>
                        <a href="#" class="forgot-password">Quên mật khẩu?</a>
                    </div>

                    <button type="submit" class="btn-primary">Đăng nhập</button>
                </form>

                <div class="auth-footer">
                    <p>Chưa có tài khoản? <a href="#" onclick="showRegister()">Đăng ký ngay</a></p>
                </div>

                <div class="divider">
                    <span>Hoặc đăng nhập với</span>
                </div>

                <div class="social-login">
                    <button class="btn-social"><i class="gg fa-brands fa-google"></i>Google</button>
                    <button class="btn-social"><i class="fb fa-brands fa-facebook"></i>Facebook</button>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
<script src="https://electromart.online/public/js/main.js"></script>
<script src="https://electromart.online/public/js/auth.js"></script>