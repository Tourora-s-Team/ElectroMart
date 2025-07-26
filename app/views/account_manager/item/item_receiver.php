<!-- <style>
    .receiver-item {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        position: relative;
        min-height: 150px;

    }

    .receiver-info {
        line-height: 40px;
    }

    .default-address {
        background-color: #DCFCE7;
        color: #4C926B;
        border-radius: 16px;
        padding: 6px;
        font-size: 10px;
        font-weight: 450;
    }

    .button-edit {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .button-edit button {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 1.2rem;
        background-color: white;
    }

    .button-edit button:hover {
        cursor: pointer;
        background-color: rgb(230, 232, 234);
    }

</style>
<div class="receiver-item">
    <p>Địa chỉ nhà &nbsp&nbsp<span class="default-address">Mặc định</span> </p>

    <p class="receiver-info">123, Lê Lợi, Quận 1, TP. HCM 700000</p>
    <p class="receiver-info">Người nhận: </p>
    <p class="receiver-info">SĐT: </p>

    <div class="button-edit">
        <button type="submit">✏️</button>
    </div>

    <a class="set-default-address" href="">Đặt làm địa chỉ mặc định</a>
</div>

<script>
    var hideClass = document.getElementsByClassName("default-addrees");

</script> -->
<style>
    .receiver-item {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        position: relative;
        min-height: 150px;
        margin-bottom: 20px;
    }

    .receiver-info {
        line-height: 40px;
    }

    .default-address {
        background-color: #DCFCE7;
        color: #4C926B;
        border-radius: 16px;
        padding: 6px;
        font-size: 10px;
        font-weight: 450;
    }

    .button-edit {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .button-edit button {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 1.2rem;
        background-color: white;
    }

    .button-edit button:hover {
        cursor: pointer;
        background-color: rgb(230, 232, 234);
    }

    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 100vw;
        background-color: rgba(0, 0, 0, 0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 999;
    }

    .modal {
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        width: 400px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        animation: slideDown 0.3s ease;
        position: relative;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal input {
        display: block;
        width: 100%;
        margin-bottom: 12px;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ccc;
    }

    .modal-title {
        margin-bottom: 20px;
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }

    .form-actions button {
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
    }

    .save-btn {
        background-color: #007BFF;
        color: white;
    }

    .delete-btn {
        background-color: #dc2626;
        color: white;
    }

    .close-btn {
        position: absolute;
        top: 10px;
        right: 14px;
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #666;
    }

</style>

<!-- Thông tin địa chỉ -->
<div class="receiver-item">
    <p>Địa chỉ nhà &nbsp;&nbsp;<span class="default-address">Mặc định</span></p>
    <p class="receiver-info">123, Lê Lợi, Quận 1, TP. HCM 700000</p>
    <p class="receiver-info">Người nhận: Nguyễn Văn A</p>
    <p class="receiver-info">SĐT: 0909123456</p>

    <div class="button-edit">
        <button type="button" onclick="openEditModal()"><i class="fa-solid fa-pen-to-square" style="color: #007BFF"></i></button>
    </div>

    <a class="set-default-address" href="#">Đặt làm địa chỉ mặc định</a>
</div>

<!-- Modal sửa thông tin -->
<div class="modal-overlay" id="editModal">
    <div class="modal">
        <button class="close-btn" onclick="closeEditModal()">×</button>
        <h3>Chỉnh sửa địa chỉ</h3>
        <input type="text" id="edit-address" value="123, Lê Lợi, Quận 1, TP. HCM 700000">
        <input type="text" id="edit-receiver" value="Nguyễn Văn A">
        <input type="text" id="edit-phone" value="0909123456">

        <div class="form-actions">
            <button class="delete-btn" onclick="closeEditModal()">Xóa</button>
            <button class="save-btn">Lưu</button>
        </div>
    </div>
</div>

<!-- Modal thêm -->
<div class="modal-overlay" id="addModal">
    <div class="modal">
        <button class="close-btn" onclick="closeAddModal()">×</button>
        <h3 class="modal-title">Thêm địa chỉ mới</h3>
        <input type="text" id="new-address" placeholder="Địa chỉ">
        <input type="text" id="new-receiver" placeholder="Người nhận">
        <input type="text" id="new-phone" placeholder="SĐT">

        <div class="form-actions">
            <button class="save-btn">Lưu</button>
            <button class="delete-btn" onclick="closeAddModal()">Hủy</button>
        </div>
    </div>
</div>

<script>
    function openEditModal() {
        document.getElementById("editModal").style.display = "flex";
    }

    function closeEditModal() {
        document.getElementById("editModal").style.display = "none";
    }

    function openAddModal() {
        document.getElementById("addModal").style.display = "flex";
    }

    function closeAddModal() {
        document.getElementById("addModal").style.display = "none";
    }
</script>
