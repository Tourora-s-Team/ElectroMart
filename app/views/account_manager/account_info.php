<!-- Thư viện định dạng ngày tháng -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<?php
require_once __DIR__ . "/./account_navbar.php";
?>
<!-- File css: account_info.css -->
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Thông tin tài khoản</h1>
        <button id="edit-info-btn" class="subheader__btn-edit btn"><i class="fa-regular fa-pen-to-square"></i>Chỉnh
            sửa</button>
    </div>

    <div class="account-details">
        <form action="" method="post" class="container">
            <fieldset disabled>
                <div class="grid-form">
                    <div class="input-group ">
                        <label for="name">Họ và tên:</label>
                        <input type="text" id="name" name="name" value="<?= $customerData[0]["FullName"] ?>">
                    </div>

                    <div class="input-group">
                        <label for="gender">Giới tính:</label>

                        <select name="gender" id="gender">
                            <option value="M">Nam</option>
                            <option value="F">Nữ</option>
                            <option value="N/A">Khác</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?= $userData[0]["Email"] ?>">
                    </div>
                    <div class="input-group">
                        <label for="phone">Số điện thoại:</label>
                        <input type="tel" id="phone" name="phone" value="<?= $userData[0]["Phonenumber"] ?>">
                    </div>
                    <div class="input-group">
                        <label for="date-of-birth">Ngày sinh:</label>
                        <input type="text" id="date-of-birth" name="date-of-birth">
                    </div>
                </div>
            </fieldset>

            <div class="form-actions">
                <button type="submit" class="hidden btn" id="submit-info" class="btn btn-primary">Lưu</button>
            </div>
        </form>

        <div class="member-details flex-row">
            <p>Thành viên từ: <span id="member-since"><?= date('d/m/Y', strtotime($userData[0]["CreateAt"])) ?></span>
            </p>
            <p style="margin: 0 8px;">&bull;</p>

            <?php
            if ($customerData[0]["LoyaltyPoint"] >= 10000) {
                $loyaltyRank = 'Vàng';
            } elseif ($customerData[0]["LoyaltyPoint"] >= 5000) {
                $loyaltyRank = 'Bạc';
            } else {
                $loyaltyRank = 'Đồng';
            }

            ?>
            <p>Hạng thành viên: <span id="member-loyalty"><?= $loyaltyRank ?></span></p>
        </div>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<script>
    document.getElementById('gender').value = "<?= $customerData[0]['Gender'] ?>";

    flatpickr("#date-of-birth", {
        dateFormat: "d/m/Y", // định dạng hiển thị
        defaultDate: "<?= date('d-m-Y', strtotime($customerData[0]['BirthDate'])) ?>" // giữ định dạng chuẩn d-m-Y
    });


    const submitButton = document.getElementById('submit-info');
    document.getElementById('edit-info-btn').addEventListener('click', function () {
        const fieldset = document.querySelector('.account-details fieldset');
        fieldset.disabled = !fieldset.disabled; // Chuyển đổi trạng thái disabled

        if (submitButton.classList.contains("hidden")) {
            submitButton.classList.remove("hidden");
        }
        else {
            submitButton.classList.add("hidden");
        }
        this.innerHTML = fieldset.disabled ? "<i class='fa-regular fa-pen-to-square'></i>Chỉnh sửa" : "<i class='fa-solid fa-xmark'></i>Hủy";

        if (this.innerHTML.includes("Hủy")) {
            document.getElementById('cancel-edit-info').click();
        }
    });


</script>