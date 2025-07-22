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
                    <input type="text" id="name" name="name" value="John Doe">
                </div>
                <div class="input-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="john.doe@example.com">
                </div>
                <div class="input-group">
                    <label for="phone">Số điện thoại:</label>
                    <input type="tel" id="phone" name="phone" value="123456789">
                </div>
                <div class="input-group">
                    <label for="date-of-birth">Ngày sinh:</label>
                    <input type="date" id="date-of-birth" name="date-of-birth" value="1990-01-01">
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