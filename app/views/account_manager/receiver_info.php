<?php
require_once __DIR__ . "/./account_navbar.php";
?>
<link rel="stylesheet" href="https://electromart.online/public/css/account_manager/receiver_info.css">

<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Địa chỉ giao hàng</h1>
        <button id="new-address-btn" class="subheader__btn-edit btn-account" onclick="openAddModal()"><i
                class="fa-regular fa-pen-to-square"></i>Thêm địa chỉ mới</button>
    </div>
    <?php if ($receiverList == null): ?>
        <div class="list">
            <div class="no-information">
                <p>Bạn chưa có địa chỉ giao hàng nào.</p>
            </div>
        </div>
    <?php endif; ?>
    <div id="receiver-list">
        <?php
        if ($receiverList != null) {
            foreach ($receiverList as $receiver) {
                include __DIR__ . "/./item/item_receiver.php";
            }
        }
        ?>
    </div>

    <!-- Modal sửa thông tin -->
    <div class="modal-overlay" id="editModal">
        <div class="modal">
            <button class="close-btn" onclick="closeEditModal(); loadProvinces()">X</button>
            <form action="https://electromart.online/public/account/update-receiver" method="POST">
                <h3>Chỉnh sửa địa chỉ</h3>
                <!-- Gửi kèm dữ liệu ReceiverID khi gửi form -->
                <input type="hidden" name="ReceiverID" value="">

                <!-- Tỉnh/Thành phố -->
                <label for="edit-city">Tỉnh / Thành phố</label>
                <input list="province-options" id="edit-city" name="City" placeholder="Nhập tỉnh/thành phố">
                <datalist id="province-options">
                    <!-- Tỉnh sẽ được thêm bằng JS -->
                </datalist>

                <!-- Phường/Xã -->
                <label for="edit-ward">Phường / Xã</label>
                <input list="ward-options" id="edit-ward" name="Ward" placeholder="Nhập phường/xã">
                <datalist id="ward-options">
                    <!-- Phường sẽ được thêm bằng JS -->
                </datalist>

                <!-- Tên đường -->
                <label for="edit-street">Tên đường</label>
                <input type="text" id="edit-street" name="Street" placeholder="VD: Lê Lợi">

                <!-- Địa chỉ chi tiết -->
                <label for="edit-detail">Địa chỉ chi tiết</label>
                <input type="text" id="edit-detail" name="AddressDetail"
                    placeholder="Số nhà, tầng, block, ghi chú thêm...">

                <!-- Tên người nhận -->
                <label for="edit-receiver">Người nhận</label>
                <input type="text" id="edit-receiver" name="ReceiverName" value="">

                <!-- Số điện thoại -->
                <label for="edit-phone">Số điện thoại</label>
                <input type="text" id="edit-phone" name="ContactNumber" value="">
            </form>

            <!-- Nút hành động -->
            <div class="form-actions">
                <button id="delete-receiver-btn" class="delete-btn" onclick="closeEditModal()">Xóa địa chỉ</button>
                <button id="update-receiver-btn" class="save-btn">Cập nhật</button>
            </div>

        </div>
    </div>

    <!-- Modal thêm địa chỉ mới -->
    <div class="modal-overlay" id="addModal">
        <div class="modal">
            <button class="close-btn" onclick="closeAddModal(); loadProvinces()">X</button>
            <h3>Thêm địa chỉ mới</h3>
            <form action="https://electromart.online/public/account/add-receiver" method="POST">
                <!-- Tỉnh/Thành phố -->
                <label for="add-city">Tỉnh / Thành phố</label>
                <input list="province-options" id="add-city" name="City" placeholder="Nhập tỉnh/thành phố">
                <datalist id="province-options">
                    <!-- Tỉnh sẽ được thêm bằng JS -->
                </datalist>

                <!-- Phường/Xã -->
                <label for="add-ward">Phường / Xã</label>
                <input list="ward-options" id="add-ward" name="Ward" placeholder="Nhập phường/xã">
                <datalist id="ward-options">
                    <!-- Phường sẽ được thêm bằng JS -->
                </datalist>

                <!-- Tên đường -->
                <label for="add-street">Tên đường</label>
                <input type="text" id="add-street" name="Street" placeholder="VD: Lê Lợi">

                <!-- Địa chỉ chi tiết -->
                <label for="add-detail">Địa chỉ chi tiết</label>
                <input type="text" id="add-detail" name="AddressDetail"
                    placeholder="Số nhà, tầng, block, ghi chú thêm...">

                <!-- Tên người nhận -->
                <label for="add-receiver">Người nhận</label>
                <input type="text" id="add-receiver" name="ReceiverName" value="">

                <!-- Số điện thoại -->
                <label for="add-phone">Số điện thoại</label>
                <input type="text" id="add-phone" name="ContactNumber" value="">
            </form>

            <!-- Nút hành động -->
            <div class="form-actions">
                <button id="delete-receiver-btn" class="delete-btn" onclick="closeAddModal()">Hủy</button>
                <button id="save-receiver-btn" class="save-btn">Lưu</button>
            </div>

        </div>
    </div>
</div>

<script>
    // Lưu lại ID người nhận đang được chỉnh sửa
    let currentReceiverId = null;
    const provinceData = [];

    function openAddModal() {
        document.getElementById("addModal").style.display = "flex";
    }

    function closeAddModal() {
        document.getElementById("addModal").style.display = "none";
    }

    function openEditModal(button) {
        const receiverItem = button.closest(".receiver-item");
        const receiverId = receiverItem.id;

        // Gán vào input hidden trong form
        const inputHidden = document.querySelector("#editModal input[name='ReceiverID']");
        inputHidden.value = receiverId;
        currentReceiverId = receiverId;

        fetch(`https://electromart.online/public/account/get-receiver/${receiverId}`)
            .then(res => res.json())
            .then(data => {
                document.getElementById("edit-city").value = data.City;
                document.getElementById("edit-ward").value = data.Ward;
                document.getElementById("edit-street").value = data.Street;
                document.getElementById("edit-detail").value = data.AddressDetail;
                document.getElementById("edit-receiver").value = data.ReceiverName;
                document.getElementById("edit-phone").value = data.ContactNumber;
            })
            .catch(err => {
                alert("Lỗi khi tải dữ liệu người nhận.");
            });
        // Hiển thị modal
        document.getElementById("editModal").style.display = "flex";
    }

    function closeEditModal() {
        document.getElementById("editModal").style.display = "none";
    }
    // Gửi form khi nhấn nút cập nhật
    document.getElementById("update-receiver-btn").addEventListener("click", function (event) {
        event.preventDefault();
        const form = document.querySelector("#editModal form");
        form.submit();
    });

    // Gửi
    document.getElementById("save-receiver-btn").addEventListener("click", function (event) {
        event.preventDefault();
        const form = document.querySelector("#addModal form");
        form.submit();
    });
    // Xóa địa chỉ 
    document.getElementById("delete-receiver-btn").addEventListener("click", function (event) {
        event.preventDefault();

        if (!currentReceiverId) {
            alert("Không tìm thấy ID người nhận để xóa.");
            return;
        }

        if (!confirm("Bạn có chắc muốn xóa địa chỉ này không?")) return;

        fetch(`https://electromart.online/public/account/delete-receiver/${currentReceiverId}`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json"
            }
        })
            .then(res => {
                if (!res.ok) throw new Error("Lỗi khi xóa người nhận");
                return res.json();
            })
            .then(data => {
                // Ẩn modal
                closeEditModal();

                // Xóa phần tử khỏi DOM nếu cần
                const item = document.getElementById(currentReceiverId);
                if (item) item.remove();

                // Hiển thị thông báo
                showToast("Xóa địa chỉ thành công", "success");
            })
            .catch(err => {
                console.error(err);
                showToast("Đã xảy ra lỗi khi xóa địa chỉ", "error");
            });
    });

    // Load tỉnh/thành phố
    document.addEventListener("DOMContentLoaded", function () {
        fetch('https://electromart.online/public/api/get-provinces/')
            .then(response => response.json())
            .then(data => {
                provinceData.push(...data);
                loadProvinces();
            })
            .catch(error => {
                console.error("Lỗi khi tải tỉnh/thành:", error);
            });
    });

    function loadProvinces() {
        const datalist = document.getElementById("province-options");
        datalist.innerHTML = "";
        provinceData.forEach(province => {
            const option = document.createElement("option");
            option.value = province.Name;
            option.setAttribute("data-id", province.Id);
            datalist.appendChild(option);
        });

        // Gán sự kiện sau khi load xong dữ liệu tỉnh
        document.getElementById("edit-city").addEventListener("change", () => {
            loadWards("edit-city", "ward-options");
        });

        document.getElementById("add-city").addEventListener("change", () => {
            loadWards("add-city", "ward-options");
        });
    }
    function loadWards(cityInputId, wardListId) {
        const cityInput = document.getElementById(cityInputId);
        const wardList = document.getElementById(wardListId);

        const inputValue = cityInput.value;
        const matched = provinceData.find(item => item.Name === inputValue);

        if (!matched) {
            console.warn("Không tìm thấy tỉnh/thành phù hợp.");
            return;
        }

        const provinceId = matched.Id;

        fetch("https://electromart.online/public/api/get-wards/" + provinceId)
            .then(response => {
                if (!response.ok) throw new Error('Lỗi khi gọi API phường/xã');
                return response.json();
            })
            .then(data => {
                wardList.innerHTML = "";
                data.forEach(ward => {
                    const option = document.createElement("option");
                    option.value = ward.Name;
                    wardList.appendChild(option);
                });
            })
            .catch(error => {
                console.error("Lỗi khi load danh sách phường/xã:", error);
            });
    }
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>