<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<section class="cart">
    <div class="container">
        <h2>Giỏ hàng của bạn</h2>
        
        <?php if (!empty($cartItems)): ?>
            <div class="cart-content">
                <div class="cart-items">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item" data-item-id="<?php echo $item['CartItemID']; ?>">
                            <div class="item-image">
                                <img src="<?php echo $item['ImageURL'] ?? '/public/images/no-image.jpg'; ?>" 
                                     alt="<?php echo htmlspecialchars($item['ProductName']); ?>">
                            </div>
                            
                            <div class="item-info">
                                <h3><?php echo htmlspecialchars($item['ProductName']); ?></h3>
                                <div class="item-price"><?php echo number_format($item['Price'], 0, ',', '.'); ?>đ</div>
                            </div>
                            
                            <div class="item-quantity">
                                <button class="quantity-btn minus" data-action="decrease">-</button>
                                <input type="number" class="quantity-input" value="<?php echo $item['Quantity']; ?>" min="1">
                                <button class="quantity-btn plus" data-action="increase">+</button>
                            </div>
                            
                            <div class="item-subtotal">
                                <?php echo number_format($item['Price'] * $item['Quantity'], 0, ',', '.'); ?>đ
                            </div>
                            
                            <div class="item-actions">
                                <button class="remove-btn" data-item-id="<?php echo $item['CartItemID']; ?>">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
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
                        
                        <div class="summary-row">
                            <span>Phí vận chuyển:</span>
                            <span class="shipping">30.000đ</span>
                        </div>
                        
                        <div class="summary-row total">
                            <span>Tổng cộng:</span>
                            <span class="total-amount"><?php echo number_format($total + 30000, 0, ',', '.'); ?>đ</span>
                        </div>
                        
                        <div class="checkout-actions">
                            <a href="/payment" class="checkout-btn">Thanh toán</a>
                            <a href="/" class="continue-shopping">Tiếp tục mua sắm</a>
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
                    <a href="/" class="shop-now-btn">Mua sắm ngay</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>