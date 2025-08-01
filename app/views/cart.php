<?php
require_once ROOT_PATH . '/core/ImageHelper.php';
include ROOT_PATH . '/app/views/layouts/header.php';
?>

<section class="cart">
    <div class="container">
        <h2>Giỏ hàng của bạn </h2>
        <?php if (!empty($cartItems)): ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php $total = 0; ?>
                    <?php foreach ($cartItems as $item): ?>
                        <!-- tổng giá trị của tất cả sản phẩm trong giỏ hàng -->
                        <?php $total += $item['Price'] * $item['Quantity']; ?>
                        <div class="cart-item" data-item-id="<?php echo $item[0]['CartID']; ?>"
                            data-product-id="<?= $item['ProductID']; ?>" data-price="<?= $item['Price']; ?>"
                            data-shop-id="<?= $item['ShopID']; ?>" data-shop-name="<?= $item['ShopName']; ?>"
                            data-image-url="<?= $item['ImageURL']; ?>">
                            <input type="checkbox" class="item-checkbox">
                            <input type="hidden" name="quantity" class="quantity-input"
                                value="<?php echo $item['Quantity']; ?>">

                            <div class="item-image">
                                <a href="public/product-detail/<?= $item['ProductID'] ?>" class="item-link">
                                    <img src="<?php echo ImageHelper::getImageUrlWithFallback($item['ImageURL']); ?>"
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
                                    <button type="button" class="quantity-btn minus"
                                        onclick="changeQuantity(this,-1)">-</button>
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

                            <form action="/electromart/public/cart/remove" method="POST">
                                <div class="item-actions">
                                    <input type="hidden" name="cart_id" value="<?php echo $item['CartID']; ?>">
                                    <input type="hidden" name="product_id" value="<?php echo $item['ProductID']; ?>">
                                    <button type="submit" class="remove-btn">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </form>

                        </div>

                    <?php endforeach; ?>
                </div>

                <div class="cart-summary">
                    <div class="summary-card">
                        <h3>Tóm tắt đơn hàng</h3>

                        <div class="summary-row">
                            <span>Tạm tính:</span>
                            <span class="subtotal"><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                        </div>

                        <!-- <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span class="shipping">30.000đ</span>
                        </div> -->

                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span class="total-amount"><?php echo number_format($total, 0, ',', '.'); ?>đ</span>
                        </div>

                        <div class="checkout-actions">
                            <button type="submit" class="checkout-btn">Thanh toán</button>
                            <a href="public" class="continue-shopping">Tiếp tục mua sắm</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="empty-cart">
                <div class="empty-cart-content">
                    <i class="fas fa-shopping-cart"></i>
                    <h3>Giỏ hàng trống</h3>
                    <p>Thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                    <a href="public" class="shop-now-btn">Mua sắm ngay</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<script>
    function changeQuantity(button, delta) {
        const quantityInput = button.closest('.item-quantity').querySelector('.quantity-input'); //Từ nút bạn click, tìm tới <div> .item-quantity chứa nó, sau đó tìm ô nhập số lượng (input) bên trong khối đó.
        const currentValue = parseInt(quantityInput.value) || 1;
        const minValue = parseInt(quantityInput.min) || 1;
        const maxValue = parseInt(quantityInput.max);
        const newValue = currentValue + delta;

        if (newValue >= minValue && newValue <= maxValue) {
            quantityInput.value = newValue;
        }
    }

    document.querySelector('.checkout-btn').addEventListener('click', function (e) {
        e.preventDefault(); // không submit form mặc định

        const selectedItems = [];
        let total = 0;

        document.querySelectorAll('.cart-item').forEach(item => {
            const checkbox = item.querySelector('.item-checkbox');
            if (checkbox.checked) {
                const images = item.dataset.imageUrl;
                const productId = item.dataset.productId;
                const shopId = item.dataset.shopId;
                const shopName = item.dataset.shopName;
                const price = parseFloat(item.dataset.price);
                const quantityInput = item.querySelector('.quantity-input');
                const quantity = parseInt(quantityInput.value);

                const subtotal = price * quantity;
                total += subtotal;

                selectedItems.push({
                    image: images,
                    shop_name: shopName,
                    shop_id: shopId,
                    product_id: productId,
                    quantity: quantity,
                    subtotal: subtotal
                });
            }
        });
        console.log({
            items: selectedItems,
            total: total
        });
        // Gửi dữ liệu qua fetch tới server (payment.php)
        fetch('/electromart/public/payment', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                items: selectedItems,
                total: total
            })
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status === 'success') {
                    window.location.href = '/electromart/public/payment';
                }
            })
            .catch(error => {
                console.error('Lỗi khi gửi dữ liệu thanh toán:', error);
            });
    });
</script>


<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>