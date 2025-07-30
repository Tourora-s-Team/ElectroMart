<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="/electromart/public/css/components/payment.css">


<body>

    <div class="checkout-container">

        <!-- Section 1: Địa chỉ giao hàng -->
        <section class="section">
            <?php foreach ($receivers as $receiver): ?>
                <div class="address-box">
                    <h3><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</h3>
                    <div class="address-grid">
                        <p class="info">
                            <strong><?= $receiver->getReceiverName() ?></strong>
                            <strong><?= $receiver->getContactNumber() ?></strong>
                        </p>
                        <p class="address">
                            <?= $receiver->getAddressDetail() ?>, <?= $receiver->getWard() ?>, <?= $receiver->getCity() ?>
                        </p>
                        <?php if ($receiver->getIsDefault()): ?>
                            <span class="default-label">Mặc định</span>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>
                        <button class="change-btn-payment">Thay đổi</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>




        <!-- Section 2: Sản phẩm -->
        <section class="section">
            <h2>Sản phẩm</h2>
            <div class="product-list">
                <div class="product-item">
                    <img src="img/product1.jpg" alt="Sản phẩm 1">
                    <div class="product-info">
                        <p><strong>Tên:</strong> Áo Thun Đen</p>
                        <p><strong>Size:</strong> L - <strong>Màu:</strong> Đen</p>
                        <p><strong>Số lượng:</strong> 2</p>
                        <p><strong>Giá:</strong> 150.000đ</p>
                    </div>
                </div>
                <!-- Thêm nhiều sản phẩm khác nếu có -->
            </div>
            <?php foreach ($product as $item): ?>
                <!-- tổng giá trị của tất cả sản phẩm trong giỏ hàng -->
                <?php $total += $item['Price'] * $item['Quantity']; ?>
                <div class="cart-item" data-item-id="<?php echo $item[0]['CartID']; ?>">
                    <input type="checkbox" form="checkout-form" name="selected_items[]"
                        value="<?= $item['ProductID'] . '_' . $item['Quantity'] . '_' . $total . '_' . $item['ShopID'] ?>"
                        class="item-checkbox">


                    <div class="item-image">
                        <a href="public/product-detail/<?= $item['ProductID'] ?>" class="item-link">
                            <img src="<?php echo $item['ImageURL'] ?? '/public/images/no-image.jpg'; ?>"
                                alt="<?php echo htmlspecialchars($item['ProductName']); ?>">
                        </a>
                    </div>

                    <div class="item-info">
                        <a href="public/product-detail/<?= $item['ProductID'] ?>" class="item-link">
                            <h3><?php echo htmlspecialchars($item['ProductName']); ?></h3>
                        </a>
                        <div class="item-price"><?php echo number_format($item['Price'], 0, ',', '.'); ?>đ</div>
                    </div>
                    <form id="form_update_quantity_<?php echo $item['ProductID']; ?>"
                        action="/electromart/public/cart/update" method="POST">
                        <input type="hidden" name="cart_id" value="<?php echo $item['CartID']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $item['ProductID']; ?>">
                        <div class="item-quantity">
                            <button type="button" class="quantity-btn minus" onclick="changeQuantity(this,-1)">-</button>
                            <input type="text" name="quantity" id="quantity_input" class="quantity-input"
                                value="<?php echo $item['Quantity']; ?>" min="1"
                                max="<?php echo $item['StockQuantity']; ?>">
                            <button type="button" class="quantity-btn plus" onclick="changeQuantity(this,1)">+</button>
                        </div>
                    </form>

                    <div class="item-subtotal">
                        <?php echo number_format($item['Price'] * $item['Quantity'], 0, ',', '.'); ?>đ
                    </div>

                    <button form="form_update_quantity_<?php echo $item['ProductID']; ?>" type="submit"
                        class="update-btn"><i class="fa-solid fa-pen"></i></button>
                </div>
            <?php endforeach; ?>

        </section>

        <!-- Section 3: Phương thức vận chuyển -->
        <section class="section">
            <h2>2. Phương thức vận chuyển</h2>
            <div class="shipping-box">
                <label><input type="radio" name="shipping" checked> Giao hàng tiết kiệm - 20.000đ (3-5 ngày)</label><br>
                <label><input type="radio" name="shipping"> Shopee Express - 35.000đ (1-2 ngày)</label>
                <textarea placeholder="Ghi chú cho người giao hàng..."></textarea>
            </div>
        </section>

        <!-- Section 4: Mã giảm giá -->
        <section class="section">
            <h2>4. Mã giảm giá / Shopee Xu</h2>
            <div class="voucher-box">
                <input type="text" placeholder="Nhập mã giảm giá...">
                <button>Áp dụng</button><br>
                <label><input type="checkbox"> Dùng 100 Xu (giảm 1.000đ)</label>
            </div>
        </section>

        <!-- Section 5: Phương thức thanh toán -->
        <section class="section">
            <h2>5. Phương thức thanh toán</h2>
            <div class="payment-box">
                <label><input type="radio" name="payment" checked> Thanh toán khi nhận hàng (COD)</label><br>
                <label><input type="radio" name="payment"> Thẻ tín dụng / ghi nợ</label><br>
                <label><input type="radio" name="payment"> Ví ShopeePay</label><br>
                <label><input type="radio" name="payment"> Internet Banking</label>
            </div>
        </section>

        <!-- Section 6: Tổng kết đơn hàng -->
        <section class="section">
            <h2>6. Tổng thanh toán</h2>
            <div class="summary-box">
                <p>Tạm tính: <span>300.000đ</span></p>
                <p>Phí vận chuyển: <span>20.000đ</span></p>
                <p>Giảm giá: <span>-5.000đ</span></p>
                <hr>
                <p><strong>Tổng cộng: <span class="total">315.000đ</span></strong></p>
                <button class="order-btn">Đặt hàng</button>
            </div>
        </section>

    </div>

</body>

</html>