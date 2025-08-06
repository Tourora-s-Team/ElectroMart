<?php
require_once __DIR__ . "/./account_navbar.php";
?>
<link rel="stylesheet" href="<?= getenv('STYLE_PATH') . 'account_manager/order_history.css' ?>">
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Lịch sử mua hàng</h1>
    </div>
    <!-- File css: order_history.css -->
    <div class="history-list">
        <?php
        if (!$isEmptyOrders) {
            for ($i = 0; $i < $numOfOrders; $i++) {
                include __DIR__ . '/./item/item_history.php';
            }
        } else {
            echo '<div class="no-information"><p>Bạn chưa có đơn hàng nào.</p></div>';
        }
        ?>
    </div>

    <!-- Modal -->
    <div id="orderModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Chi tiết đơn hàng</h2>
                <span class="close" id="closeModalBtn">&times;</span>
            </div>

            <!-- Nội dung modal -->
            <div class="grid-2">
                <section>
                    <h3>Thông tin đơn hàng</h3>
                    <p><strong>Mã đơn hàng:</strong> </p>
                    <p><strong>Ngày đặt:</strong></p>
                    <p><strong>Trạng thái:</strong></p>
                </section>

                <section>
                    <h3>Phương thức thanh toán</h3>
                    <p></p>
                </section>

                <section>
                    <h3>Người nhận</h3>
                    <p><strong>Họ tên:</strong></p>
                    <p><strong>Số điện thoại:</strong></p>
                    <p><strong>Địa chỉ:</strong></p>
                </section>

                <section>
                    <h3>Shop</h3>
                    <p><strong>Tên shop:</strong></p>
                    <p><strong>Địa chỉ:</strong></p>
                </section>
                <section class="full-width product-list">
                    <h3>Sản phẩm</h3>
                    <div class="product-item">
                        <img src="" alt="" />
                        <div>
                            <p><strong></strong></p>
                            <p>Đơn giá:</p>
                        </div>
                    </div>

                    <div class="product-item">
                        <img src="" alt="" />
                        <div>
                            <p><strong>Tên sản phẩm</strong> x2</p>
                            <p>Đơn giá: </p>
                        </div>
                    </div>
                </section>

                <section class="full-width order-total">
                    <h3>Tổng tiền</h3>
                    <p>Tạm tính:</p>
                    <p>Phí ship:</p>
                    <p><strong>Tổng cộng:</strong></p>
                </section>
            </div>
            <div class="modal-footer">
                <button id="closeModalBtn2">Đóng</button>
            </div>
        </div>
    </div>

</div>
<!-- Script mở/đóng modal -->
<script>
    const orders = <?= json_encode($orders, JSON_UNESCAPED_UNICODE) ?>;
    const modal = document.getElementById("orderModal");
    const closeBtn = document.getElementById("closeModalBtn");
    const closeBtn2 = document.getElementById("closeModalBtn2");

    // Biến đổi thành object với OrderID làm key
    const orderMap = {};
    orders.forEach(order => {
        orderMap[order.OrderID] = order;
    });

    document.querySelectorAll(".openModalBtn").forEach(btn => {
        btn.addEventListener("click", () => {
            const orderId = btn.getAttribute("data-order-id");
            const orderData = orderMap[orderId];
            if (!orderData) return;

            // Gán thông tin đơn hàng
            modal.querySelector("section:nth-child(1) p:nth-child(2)").innerHTML = `<strong>Mã đơn hàng:</strong> ${orderData.OrderID}`;
            modal.querySelector("section:nth-child(1) p:nth-child(3)").innerHTML = `<strong>Ngày đặt:</strong> ${orderData.OrderDate}`;
            modal.querySelector("section:nth-child(1) p:nth-child(4)").innerHTML = `<strong>Trạng thái:</strong> <span class="status status--${orderData.Status}">${orderData.Status === 'Completed' ? 'Đã hoàn thành' : orderData.Status}</span>`;

            // Phương thức thanh toán
            modal.querySelector("section:nth-child(2) p").textContent = orderData.Payment?.PaymentMethod ?? 'Không xác định';

            // Thông tin người nhận
            const customer = orderData.Customer ?? {};
            modal.querySelector("section:nth-child(3) p:nth-child(2)").innerHTML = `<strong>Họ tên:</strong> ${customer.FullName ?? 'Không có'}`;
            modal.querySelector("section:nth-child(3) p:nth-child(3)").innerHTML = `<strong>Số điện thoại:</strong> 0987 654 321`; // Nếu có sẵn thì thay
            modal.querySelector("section:nth-child(3) p:nth-child(4)").innerHTML = `<strong>Địa chỉ:</strong> 123 Đường ABC, Quận 1, TP. HCM`; // Cập nhật nếu có

            // Thông tin shop (lấy từ sản phẩm đầu tiên)
            const firstProduct = orderData.ProductDetails?.[0];
            const shop = firstProduct?.Shop ?? {};
            modal.querySelector("section:nth-child(4) p:nth-child(2)").innerHTML = `<strong>Tên shop:</strong> ${shop.ShopName ?? 'Không có'}`;
            modal.querySelector("section:nth-child(4) p:nth-child(3)").innerHTML = `<strong>Địa chỉ:</strong> ${shop.Address ?? 'Không có'}`;

            // Danh sách sản phẩm
            var totalAmount = 0;
            const productList = modal.querySelector(".product-list");
            productList.innerHTML = `<h3>Sản phẩm</h3>`;
            orderData.ProductDetails?.forEach(product => {
                totalAmount += Number(product.UnitPrice) * Number(product.Quantity);
                productList.innerHTML += `
                    <div class="product-card">
                    <div class="product-image">
                        <img src="${product.Image}" alt="${product.ProductName}" />
                    </div>
                    <div class="product-info">
                        <div class="product-title">${product.ProductName}</div>
                        <div class="product-meta">
                            <div>Thương hiệu:<br><strong>${product.Brand ?? 'Không có'}</strong></div>
                        </div>
                    </div>
                    <div class="product-price">
                        <div class="product-quantity">Số lượng: ${product.Quantity}</div>
                        <div class="price">${Number(product.UnitPrice).toLocaleString('vi-VN')}đ</div>
                    </div>
                </div>
                `;
            });

            // Tổng tiền
            modal.querySelector(".order-total p:nth-child(2)").innerHTML = `Tạm tính: ${Number(totalAmount).toLocaleString('vi-VN')}đ`;
            modal.querySelector(".order-total p:nth-child(3)").innerHTML = `Phí ship: ${Number(orderData.ShippingFee ?? 0).toLocaleString('vi-VN')}đ`;
            modal.querySelector(".order-total p:nth-child(4)").innerHTML = `<strong>Tổng cộng:</strong> ${Number(orderData.TotalAmount ?? 0).toLocaleString('vi-VN')}đ`;

            modal.style.display = "block";
        });
    });

    closeBtn.onclick = closeBtn2.onclick = () => (modal.style.display = "none");
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    };
</script>




<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>