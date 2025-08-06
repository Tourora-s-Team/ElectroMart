<?php
require_once __DIR__ . "/./account_navbar.php";
?>
<link rel="stylesheet" href="<?= getenv('STYLE_PATH') . 'account_manager/security.css' ?>">
<!-- File css: account_info.css -->
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Cài đặt bảo mật</h1>
    </div>
    <div class="account-details">
        <form id="form-change-password"
            action="https://electromart-t8ou8.ondigitalocean.app/public/account/change-password" method="post"
            class="security-form">
            <input type="text" id="UserId" name="UserId" value="<?= $_SESSION['user'][0]['UserID'] ?>" hidden>
            <div class="form-group">
                <div class="input-wrapper">
                    <label for="current-pass">Mật khẩu hiện tại:</label>
                    <input type="password" id="current-pass" name="current_password" value="">
                    <button type="button" class="password-toggle" onclick="togglePassword('current-pass')"><i
                            class="fa-solid fa-eye"></i></button>
                </div>
            </div>
            <div class="form-group">
                <div class="input-wrapper">
                    <label for="new-pas">Mật khẩu mới:</label>
                    <input type="password" id="new-pas" name="new_password" value="">
                    <button type="button" class="password-toggle" onclick="togglePassword('new-pas')"><i
                            class="fa-solid fa-eye"></i></button>
                    <p id="password-strength-msg" style="color: red;"></p>
                </div>
            </div>

            <div class="form-group">
                <div class="input-wrapper">
                    <label for="confirm-pass">Xác nhận mật khẩu mới:</label>
                    <input type="password" id="confirm-pass" name="confirm_password" value="">
                    <button type="button" class="password-toggle" onclick="togglePassword('confirm-pass')"><i
                            class="fa-solid fa-eye"></i></button>
                </div>
            </div>

            <div class="display-right">
                <button type="button" id="cancel-btn" class="btn-account btn-secondary">Hủy</button>
                <button type="button" id="change-password-btn" class="btn-account btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<script>
    const submitButton = document.getElementById("change-password-btn");
    submitButton.addEventListener('click', function (e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút submit

        const curPassword = document.getElementById('current-pass').value;
        const newPassword = document.getElementById('new-pas').value;
        const confirmPassword = document.getElementById('confirm-pass').value;

        if (!curPassword || !newPassword || !confirmPassword) {
            showToast("Vui lòng điền đầy đủ thông tin.", 'error');
            return;
        }

        const passwordStrength = checkPasswordStrength(newPassword);
        if (passwordStrength.strength == 0) {
            showToast(passwordStrength.message, 'error');
            return;
        }

        if (newPassword !== confirmPassword) {
            showToast("Mật khẩu mới và xác nhận mật khẩu không khớp.", 'error');
            return;
        }

        const form = document.getElementById('form-change-password');
        form.submit();
    });

    document.getElementById("cancel-btn").addEventListener("click", function () {
        document.getElementById('current-pass').value = '';
        document.getElementById('new-pas').value = '';
        document.getElementById('confirm-pass').value = '';
    });

    /*
    1. Tối thiểu 8 ký tự
    2. Có chữ thường
    3. Có chữ in hoa
    4. Có chữ số
    5. Có ký tự đặc biệt (!@#$%^&*, v.v.)
    */
    // Hàm kiểm tra tính hợp lệ của mật khẩu
    function checkPasswordStrength(password) {
        const minLength = 8;
        const hasLowercase = /[a-z]/.test(password);
        const hasUppercase = /[A-Z]/.test(password);
        const hasDigit = /\d/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        const criteriaMet = [hasLowercase, hasUppercase, hasDigit, hasSpecialChar].filter(Boolean).length;

        if (password.length < minLength) {
            return { strength: 0, message: 'Mật khẩu phải có ít nhất 8 ký tự.' };
        }

        switch (criteriaMet) {
            case 4:
                return { strength: 1, message: 'Mật khẩu mạnh.' };
            case 3:
                return { strength: 0.5, message: 'Mật khẩu trung bình, bạn nên đảm bảo có chữ thường, chữ hoa, số và ký tự đặc biệt trong mật khẩu.' };
            default:
                return { strength: 0, message: 'Mật khẩu quá yếu, cần bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.' };
        }
    }
    // Hàm hiển thị thông báo
    document.getElementById('new-pas').addEventListener('input', function () {
        const result = checkPasswordStrength(this.value);
        const msgEl = document.getElementById('password-strength-msg');
        msgEl.innerText = result.message;
        msgEl.style.color = result.strength === 1 ? 'green' : (result.strength === 0.5 ? 'orange' : 'red');
    });

</script>


<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>