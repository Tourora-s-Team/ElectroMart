<?php
require_once __DIR__ . "/./account_navbar.php";
?>
<!-- File css: account_info.css -->
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Cài đặt bảo mật</h1>
    </div>
    <div class="account-details">
        <form action="" method="post" class="container">
            <div class="collunm-form">
                <div class="input-group ">
                    <label for="current-pass">Mật khẩu hiện tại:</label>
                    <input type="text" id="current-pass" name="current-pass" value="<?= $customerData[0]["FullName"] ?>">
                </div>
                <div class="input-group">
                    <label for="new-pas">Mật khẩu mới:</label>
                    <input type="new-pas" id="new-pas" name="new-pas" value="<?= $userData[0]["Email"] ?>">
                </div>
                <div class="input-group">
                    <label for="confirm-pass">Xác nhận mật khẩu mới:</label>
                    <input type="tel" id="confirm-pass" name="confirm-pass" value="<?= $userData[0]["Phonenumber"] ?>">
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>