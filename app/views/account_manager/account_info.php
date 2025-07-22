<!-- Thư viện định dạng ngày tháng -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php
    require_once __DIR__ . "/./dashboard.php";
?>
<div id="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Thông tin tài khoản</h1>
        <button class="subheader__btn-edit btn"><i class="fa-regular fa-pen-to-square"></i>Chỉnh sửa</button>
    </div>

    <div class="account-details">
        <form action="" method="post" class="container">
            <div class="grid-form">
                <div class="input-group ">
                    <label for="name">Họ và tên:</label>
                    <input type="text" id="name" name="name" value="<?= $customerData["FullName"] ?>">
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?= $userData["Email"] ?>">
                </div>
                <div class="input-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" value="<?= $userData["Phonenumber"] ?>">
                </div>
                <div class="input-group">
                    <label for="date-of-birth">Ngày sinh:</label>
                    <input type="text" id="date-of-birth" name="date-of-birth">
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary">Hủy</button>
                <button type="submit" class="btn btn-primary">Lưu</button>
            </div>
        </form>

        <div class="member-details flex-row">
            <p>Thành viên từ: <span id="member-since">01/01/2020</span></p>
            <p style="margin: 0 8px;">&bull;</p>
            <p>Hạng thành viên: <span id="member-loyalty">Vàng</span></p>
        </div>
    </div>
</div>

<script>
    flatpickr("#date-of-birth", {
        dateFormat: "d/m/Y", // định dạng hiển thị
        defaultDate: "<?= date('d-m-Y', strtotime($customerData['BirthDate'])) ?>" // giữ định dạng chuẩn d-m-Y
    });
</script>