<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Linh kiện điện tử chất lượng cao </h1>
            <p>Khám phá hàng ngàn sản phẩm từ các thương hiệu uy tín</p>
            <a href="#product-section" class="cta-btn">Mua sắm ngay</a>
        </div>
    </div>
</section>

<section class="featured-products" id="product-section">
    <div class="container">
        <h2>Sản phẩm nổi bật</h2>

        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <!-- Vòng lặp mảng hiển thị sản phẩm và ảnh Thumb -->
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <!-- Thêm đường dẫn thẻ <a> đến trang chi tiết sản phẩm -->
                        <a href="public/product-detail/<?= $product['ProductID'] ?>">
                            <div class="product-image">
                                <img src="<?php echo $product['ImageURL'] ?? '/public/images/no-image.jpg'; ?>"
                                    alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                            </div>

                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                <div class="product-brand"><?php echo htmlspecialchars($product['Brand']); ?></div>
                                <div class="product-price"><?php echo number_format($product['Price'], 0, ',', '.'); ?>đ</div>
                                <!-- <div class="product-rating">
                                    <div class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $product['Rating'] ? 'active' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="rating-text">(<?php echo $product['Rating']; ?>)</span>
                                </div> -->
                                <div class="product-stock">
                                    Còn lại: <?php echo $product['StockQuantity']; ?> sản phẩm
                                </div>
                            </div>
                        </a>

                        <div class="product-actions">
                            <button class="add-to-cart-btn" data-product-id="<?php echo $product['ProductID']; ?>">
                                <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-products">
                    <p>Không có sản phẩm nào để hiển thị.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <i class="fas fa-shipping-fast"></i>
                <h3>Giao hàng nhanh</h3>
                <p>Giao hàng trong 24h tại TP.HCM</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-shield-alt"></i>
                <h3>Bảo hành uy tín</h3>
                <p>Bảo hành chính hãng lên đến 24 tháng</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-headset"></i>
                <h3>Hỗ trợ 24/7</h3>
                <p>Đội ngũ kỹ thuật hỗ trợ tư vấn</p>
            </div>

            <div class="feature-item">
                <i class="fas fa-medal"></i>
                <h3>Chất lượng đảm bảo</h3>
                <p>Sản phẩm chính hãng 100%</p>
            </div>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<script>
    // Thêm hiệu ứng cuộn mượt mà khi nhấn vào nút "Mua sắm ngay"
    document.querySelector('.cta-btn').addEventListener('click', function (e) {
        e.preventDefault(); // Ngừng hành động mặc định của liên kết

        // Cuộn mượt mà tới section với id="product-section"
        document.querySelector('#product-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
</script>