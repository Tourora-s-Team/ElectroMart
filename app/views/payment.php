<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="/electromart/public/css/components/payment.css">

<div class="payment-container">
    <!-- Địa chỉ giao hàng -->
    <div class="address-box">
        <h3><i class="fa-solid fa-location-dot"></i> Địa chỉ nhận hàng</h3>
        <?php
        $defaultReceiver = null;
        foreach ($receivers as $receiver) {
            if ($receiver->getIsDefault()) {
                $defaultReceiver = $receiver;
                break;
            }
        }

        if ($defaultReceiver) { ?>
            <div class="address-grid">
                <div>
                    <p class="info">
                        <strong><?php echo $defaultReceiver->getReceiverName(); ?></strong>
                        <strong><?php echo $defaultReceiver->getContactNumber(); ?></strong>
                    </p>
                    <p class="address">
                        <?php echo $defaultReceiver->getAddressDetail(); ?>,
                        <?php echo $defaultReceiver->getWard(); ?>,
                        <?php echo $defaultReceiver->getCity(); ?>
                    </p>
                    <span class="default-label">Mặc định</span>
                </div>
                <button class="change-btn-payment" onclick="showAddressModal()">Thay đổi</button>
            </div>
        <?php } else { ?>
            <p>Vui lòng thêm địa chỉ nhận hàng</p>
        <?php } ?>
    </div>

    <!-- Sản phẩm -->
    <form method="post" action="/electromart/public/payment/order">
        <div class="products-section">
            <?php
            $currentShop = null;
            $totalAmount = 0;

            if (!empty($paymentData['items'])) {
                foreach ($paymentData['items'] as $idx => $product) {
                    if ($currentShop !== $product['ShopID']) {
                        if ($currentShop !== null) {
                            echo '</div>';
                        }
                        $currentShop = $product['ShopID'];
                        ?>
                        <div class="shop-section">
                            <div class="shop-header">
                                <span class="shop-name">
                                    <i class="fa-solid fa-store"></i>
                                    <?php echo $product['ShopName']; ?>
                                </span>
                            </div>
                            <?php
                    }
                    ?>
                        <div class="product-item">
                            <img src="<?php echo $product['ImageURL'] ?? '/public/images/no-image.jpg'; ?>"
                                alt="<?php echo $product['ProductName']; ?>" class="product-image">
                            <div class="product-details">
                                <h4><?php echo $product['ProductName']; ?></h4>
                                <p class="product-variation">
                                    Phân loại: <?php echo $product['Variation'] ?? 'Mặc định'; ?>
                                </p>
                            </div>
                            <div class="product-price">
                                <?php if (isset($product['OriginalPrice']) && $product['OriginalPrice'] > $product['Price']): ?>
                                    <p class="original-price">₫<?php echo number_format($product['OriginalPrice'], 0, ',', '.'); ?>
                                    </p>
                                <?php endif; ?>
                                <p class="final-price">₫<?php echo number_format($product['Price'], 0, ',', '.'); ?></p>
                                <p>x<?php echo $product['Quantity']; ?></p>
                            </div>
                        </div>
                        <!-- Hidden fields for each product -->
                        <input type="hidden" name="products[<?php echo $idx; ?>][ProductID]"
                            value="<?php echo isset($product['ProductID']) ? (int) $product['ProductID'] : (int) $product['product_id']; ?>">
                        <input type="hidden" name="products[<?php echo $idx; ?>][ShopID]"
                            value="<?php echo isset($product['ShopID']) ? (int) $product['ShopID'] : (isset($product['shop_id']) ? (int) $product['shop_id'] : 0); ?>">
                        <input type="hidden" name="products[<?php echo $idx; ?>][Quantity]"
                            value="<?php echo isset($product['Quantity']) ? (int) $product['Quantity'] : (isset($product['quantity']) ? (int) $product['quantity'] : 1); ?>">
                        <input type="hidden" name="products[<?php echo $idx; ?>][Price]"
                            value="<?php echo isset($product['Price']) ? (float) $product['Price'] : (isset($product['subtotal']) ? (float) $product['subtotal'] : 0); ?>">
                        <?php
                        $totalAmount += $product['Price'] * $product['Quantity'];
                }
                if ($currentShop !== null) {
                    echo '</div>';
                }
            } else {
                echo '<p class="no-products">Không có sản phẩm nào được chọn</p>';
            }
            ?>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="payment-method">
                <h3><i class="fa-solid fa-credit-card"></i> Phương thức thanh toán</h3>
                <div class="payment-options">
                    <label class="payment-option">
                        <input type="radio" name="paymentMethod" value="cod" checked>
                        <span style="margin-left: 10px;">Thanh toán khi nhận hàng (COD)</span>
                    </label>
                    <label class="payment-option">
                        <input type="radio" name="paymentMethod" value="bank">
                        <span style="margin-left: 10px;">Thanh toán VNPay</span>
                    </label>
                </div>
            </div>

            <!-- Tổng cộng -->
            <div class="order-summary">
                <div class="summary-row">
                    <span>Tổng tiền hàng:</span>
                    <span>₫<?= number_format($totalAmount, 0, ',', '.') ?></span>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển:</span>
                    <span>₫<?= number_format($shippingFee ?? 30000, 0, ',', '.') ?></span>
                </div>
                <div class="total-row">
                    <span>Tổng thanh toán:</span>
                    <span
                        class="total-amount">₫<?= number_format($totalAmount + ($shippingFee ?? 30000), 0, ',', '.') ?></span>
                </div>
            </div>

            <!-- Hidden fields for order -->
            <input type="hidden" name="totalAmount" value="<?= $totalAmount ?>">
            <input type="hidden" name="shippingFee" value="<?= isset($shippingFee) ? $shippingFee : 30000 ?>">
            <input type="hidden" name="receiverId"
                value="<?= isset($defaultReceiver) ? $defaultReceiver->getReceiverId() : '' ?>">

            <button class="place-order-btn" type="submit">Đặt hàng</button>
    </form>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>