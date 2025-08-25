<?php
require_once ROOT_PATH . '/core/ImageHelper.php';
include ROOT_PATH . '/app/views/layouts/header.php';
?>

<section class="hero">
    <div class="container">
        <div class="hero-content">
            <h1>Linh kiện điện tử chất lượng cao </h1>
            <p>Khám phá hàng ngàn sản phẩm từ các thương hiệu uy tín</p>
            <a href="#product-section" class="cta-btn">Mua sắm ngay</a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section">
    <div class="container">
        <h2>Danh mục sản phẩm</h2>
        <p>Khám phá các danh mục linh kiện điện tử đa dạng</p>

        <div class="categories-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <a href="/electromart/public/categories/<?= $category['CategoryID'] ?>">
                            <div class="category-image">
                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($category['ImageURL'] ?? '/public/images/default-category.jpg'); ?>"
                                    alt="<?php echo htmlspecialchars($category['CategoryName']); ?>">
                            </div>
                            <div class="category-info">
                                <h3><?php echo htmlspecialchars($category['CategoryName']); ?></h3>
                                <p class="product-count"><?php echo $category['product_count']; ?> sản phẩm</p>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="view-all-categories">
            <a href="/electromart/public/categories" class="btn btn-outline">Xem tất cả danh mục</a>
        </div>
    </div>
</section>

<!-- Promotions Section -->
<section class="promotions-section">
    <div class="container">
        <h2>Khuyến mãi hot</h2>
        <p>Đừng bỏ lỡ những ưu đãi hấp dẫn</p>

        <div class="promotions-grid">
            <?php if (!empty($promotions)): ?>
                <?php foreach ($promotions as $promotion): ?>
                    <div class="promotion-card">
                        <div class="promotion-badge">
                            <span>Giảm ngay <?= number_format($promotion['DiscountValue'], 0, ',', '.') ?>đ</span>

                        </div>

                        <div class="promotion-image">
                            <img src="<?php echo ImageHelper::getImageUrlWithFallback($promotion['ImageURL'] ?? '/public/images/default-promotion.jpg'); ?>"
                                alt="<?php echo htmlspecialchars($promotion['Title']); ?>">
                        </div>

                        <div class="promotion-content">
                            <h3><?= htmlspecialchars($promotion['PromotionName']) ?></h3>
                            <!-- <p><?= htmlspecialchars(substr($promotion['Description'], 0, 100)) ?>...</p> -->

                            <div class="promotion-dates">
                                <small>Đến: <?= date('d/m/Y', strtotime($promotion['EndDate'])) ?></small>
                            </div>

                            <a href="/electromart/public/promotions/<?= $promotion['PromotionID'] ?>" class="promotion-btn">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="view-all-promotions">
            <a href="/electromart/public/promotions" class="btn btn-primary">Xem tất cả khuyến mãi</a>
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
                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                                    alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                            </div>

                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                <div class="product-brand"><?php echo htmlspecialchars($product['Brand']); ?></div>
                                <div class="product-price"><?php echo number_format($product['Price'], 0, ',', '.'); ?>đ</div>
                                <div class="product-rating">
                                    <div class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i
                                                class="fas fa-star <?php echo $i <= $product['RatingProduct'] ? 'active' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="rating-text">(<?php echo $product['RatingProduct']; ?>)</span>
                                </div>
                                <div class="product-stock">
                                    Còn lại: <?php echo $product['StockQuantity']; ?> sản phẩm
                                </div>
                            </div>
                        </a>
                        <form action="/electromart/public/cart/add" method="POST" class="add-to-cart-form">

                            <div class="product-actions">
                                <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-to-cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                                </button>
                                <button type="button" class="add-to-wishlist-btn" title="Thêm vào danh sách yêu thích"
                                    data-id="<?= $product['ProductID'] ?>"
                                    onclick="addToWishList(<?php echo $product['ProductID']; ?>)">
                                    <i class="fas fa-heart"></i>
                                </button>
                            </div>

                        </form>
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

<style>
    /* Categories Section */
    .categories-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .categories-section h2 {
        font-size: 2.2rem;
        text-align: center;
        margin-bottom: 10px;
        color: #333;
    }

    .categories-section p {
        text-align: center;
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 40px;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .category-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .category-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .category-card a {
        text-decoration: none;
        color: inherit;
        display: block;
    }

    .category-image {
        height: 150px;
        overflow: hidden;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image img {
        transform: scale(1.1);
    }

    .category-info {
        padding: 20px;
        text-align: center;
    }

    .category-info h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .product-count {
        color: #666;
        font-size: 0.9rem;
    }

    .view-all-categories {
        text-align: center;
    }

    /* Promotions Section */
    .promotions-section {
        padding: 60px 0;
        background: white;
    }

    .promotions-section h2 {
        font-size: 2.2rem;
        text-align: center;
        margin-bottom: 10px;
        color: #333;
    }

    .promotions-section p {
        text-align: center;
        color: #666;
        font-size: 1.1rem;
        margin-bottom: 40px;
    }

    .promotions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .promotion-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .promotion-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .promotion-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: linear-gradient(135deg, #ff6b6b, #e74c3c);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.9rem;
        z-index: 2;
    }

    .promotion-image {
        height: 180px;
        overflow: hidden;
    }

    .promotion-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .promotion-card:hover .promotion-image img {
        transform: scale(1.05);
    }

    .promotion-content {
        padding: 25px;
    }

    .promotion-content h3 {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: #333;
    }

    .promotion-content p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .promotion-dates {
        margin-bottom: 20px;
    }

    .promotion-dates small {
        color: #999;
        font-size: 0.85rem;
    }

    .promotion-btn {
        display: inline-block;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 10px 20px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .promotion-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .view-all-promotions {
        text-align: center;
    }

    /* Button Styles */
    .btn {
        display: inline-block;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-outline {
        background: transparent;
        color: #667eea;
        border: 2px solid #667eea;
    }

    .btn-outline:hover {
        background: #667eea;
        color: white;
    }

    @media (max-width: 768px) {
        .categories-grid {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }

        .promotions-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .categories-section h2,
        .promotions-section h2 {
            font-size: 1.8rem;
        }
    }
</style>