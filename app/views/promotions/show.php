<?php
require_once ROOT_PATH . '/core/ImageHelper.php';
include ROOT_PATH . '/app/views/layouts/header.php';
?>

<div id="toast-container"></div>
<?php if (!empty($_SESSION['message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast("<?= addslashes($_SESSION['message']) ?>", '<?= $_SESSION['status_type'] ?>');
        });
    </script>
<?php endif;
unset($_SESSION['message']);
unset($_SESSION['status_type']); ?>

<section class="promotion-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="https://electromart.online/public/">Trang chủ</a>
            <span>/</span>
            <a href="https://electromart.online/public/promotions">Khuyến mãi</a>
            <span>/</span>
            <span><?= htmlspecialchars($promotion['Title']) ?></span>
        </div>

        <div class="promotion-hero">
            <div class="promotion-info">
                <div class="discount-badge">
                    <span>Giảm <?= $promotion['DiscountPercent'] ?>%</span>
                </div>
                <h1><?= htmlspecialchars($promotion['Title']) ?></h1>
                <p><?= htmlspecialchars($promotion['Description']) ?></p>

                <div class="promotion-validity">
                    <div class="validity-item">
                        <i class="fas fa-calendar-check"></i>
                        <span>Bắt đầu: <?= date('d/m/Y H:i', strtotime($promotion['StartDate'])) ?></span>
                    </div>
                    <div class="validity-item">
                        <i class="fas fa-calendar-times"></i>
                        <span>Kết thúc: <?= date('d/m/Y H:i', strtotime($promotion['EndDate'])) ?></span>
                    </div>
                </div>

                <div class="countdown-timer" id="countdown">
                    <div class="time-unit">
                        <span class="number" id="days">00</span>
                        <span class="label">Ngày</span>
                    </div>
                    <div class="time-unit">
                        <span class="number" id="hours">00</span>
                        <span class="label">Giờ</span>
                    </div>
                    <div class="time-unit">
                        <span class="number" id="minutes">00</span>
                        <span class="label">Phút</span>
                    </div>
                    <div class="time-unit">
                        <span class="number" id="seconds">00</span>
                        <span class="label">Giây</span>
                    </div>
                </div>
            </div>

            <div class="promotion-image">
                <img src="<?php echo ImageHelper::getImageUrlWithFallback($promotion['ImageURL'] ?? '/public/images/default-promotion.jpg'); ?>"
                    alt="<?php echo htmlspecialchars($promotion['Title']); ?>">
            </div>
        </div>
    </div>
</section>

<section class="promotion-products">
    <div class="container">
        <div class="section-header">
            <h2>Sản phẩm khuyến mãi</h2>
            <p>Tận dụng cơ hội để sở hữu những sản phẩm chất lượng với giá ưu đãi</p>
        </div>

        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="discount-label">
                            -<?= $promotion['DiscountPercent'] ?>%
                        </div>

                        <a href="https://electromart.online/public/product-detail/<?= $product['ProductID'] ?>">
                            <div class="product-image">
                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                                    alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                            </div>

                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                <div class="product-brand"><?php echo htmlspecialchars($product['Brand']); ?></div>

                                <div class="price-section">
                                    <div class="original-price"><?php echo number_format($product['Price'], 0, ',', '.'); ?>đ
                                    </div>
                                    <div class="discounted-price">
                                        <?php echo number_format($product['DiscountedPrice'], 0, ',', '.'); ?>đ
                                    </div>
                                    <div class="savings">Tiết kiệm:
                                        <?php echo number_format($product['Price'] - $product['DiscountedPrice'], 0, ',', '.'); ?>đ
                                    </div>
                                </div>

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

                        <form action="https://electromart.online/public/cart/add" method="POST" class="add-to-cart-form">
                            <div class="product-actions">
                                <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="add-to-cart-btn">
                                    <i class="fas fa-shopping-cart"></i> Mua ngay
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
                    <i class="fas fa-box-open"></i>
                    <p>Chưa có sản phẩm nào trong chương trình khuyến mãi này.</p>
                    <a href="https://electromart.online/public/promotions" class="btn btn-primary">Xem
                        khuyến mãi khác</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<script>
    function addToWishList(productId) {
        const btn = document.querySelector(`.add-to-wishlist-btn[data-id='${productId}']`);
        btn.disabled = true;
        fetch(`https://electromart.online/public/account/wish-list-add/${productId}`, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (response.ok) {
                    btn.disabled = false;
                    showToast("Đã thêm vào danh sách yêu thích.", "success");
                } else {
                    showToast("Sản phẩm đã có trong danh sách yêu thích.", "error");
                }
            })
            .catch(error => {
                showToast("Lỗi khi gửi yêu cầu", "error");
                console.error('Lỗi:', error);
            });
    }

    // Countdown timer
    function startCountdown() {
        const endDate = new Date('<?= $promotion['EndDate'] ?>').getTime();

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = endDate - now;

            if (distance < 0) {
                document.getElementById('countdown').innerHTML = '<div class="expired">Khuyến mãi đã kết thúc</div>';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            document.getElementById('days').textContent = days.toString().padStart(2, '0');
            document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
            document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
            document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    }

    document.addEventListener('DOMContentLoaded', startCountdown);
</script>

<style>
    /* Styles for promotion detail page */
    .promotion-header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
        color: white;
        padding: 40px 0 60px;
    }

    .breadcrumb {
        margin-bottom: 30px;
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
    }

    .breadcrumb a:hover {
        color: white;
    }

    .breadcrumb span {
        margin: 0 10px;
        color: rgba(255, 255, 255, 0.6);
    }

    .promotion-hero {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 40px;
        align-items: center;
    }

    .discount-badge {
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 10px 20px;
        border-radius: 25px;
        font-weight: bold;
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .promotion-info h1 {
        font-size: 2.5rem;
        margin-bottom: 15px;
        line-height: 1.2;
    }

    .promotion-info p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 25px;
        line-height: 1.6;
    }

    .promotion-validity {
        margin-bottom: 30px;
    }

    .validity-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .validity-item i {
        width: 16px;
    }

    .countdown-timer {
        display: flex;
        gap: 20px;
        margin-top: 20px;
    }

    .time-unit {
        text-align: center;
        background: rgba(255, 255, 255, 0.2);
        padding: 15px;
        border-radius: 10px;
        min-width: 60px;
    }

    .time-unit .number {
        display: block;
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 5px;
    }

    .time-unit .label {
        font-size: 0.8rem;
        opacity: 0.8;
    }

    .promotion-image {
        text-align: center;
    }

    .promotion-image img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .promotion-products {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .section-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .section-header h2 {
        font-size: 2rem;
        color: #333;
        margin-bottom: 10px;
    }

    .section-header p {
        color: #666;
        font-size: 1.1rem;
    }

    .product-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
    }

    .product-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .discount-label {
        position: absolute;
        top: 15px;
        left: 15px;
        background: #e74c3c;
        color: white;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: bold;
        z-index: 2;
    }

    .product-image {
        height: 200px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .product-info {
        padding: 20px;
    }

    .product-info h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }

    .product-brand {
        color: #666;
        font-size: 0.9rem;
        margin-bottom: 15px;
    }

    .price-section {
        margin-bottom: 15px;
    }

    .original-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.9rem;
        margin-bottom: 5px;
    }

    .discounted-price {
        font-size: 1.3rem;
        font-weight: 700;
        color: #e74c3c;
        margin-bottom: 5px;
    }

    .savings {
        font-size: 0.85rem;
        color: #28a745;
        font-weight: 600;
    }

    .product-rating {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    .stars {
        display: flex;
        gap: 2px;
    }

    .stars i {
        color: #ddd;
        font-size: 0.9rem;
    }

    .stars i.active {
        color: #ffc107;
    }

    .rating-text {
        font-size: 0.85rem;
        color: #666;
    }

    .product-stock {
        font-size: 0.85rem;
        color: #28a745;
        margin-bottom: 15px;
    }

    .product-actions {
        display: flex;
        gap: 10px;
        padding: 0 20px 20px;
    }

    .add-to-cart-btn {
        flex: 1;
        background: #e74c3c;
        color: white;
        border: none;
        padding: 12px;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.3s;
    }

    .add-to-cart-btn:hover {
        background: #c0392b;
    }

    .add-to-wishlist-btn {
        background: #f8f9fa;
        color: #666;
        border: 1px solid #ddd;
        padding: 12px;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s;
    }

    .add-to-wishlist-btn:hover {
        background: #e74c3c;
        color: white;
        border-color: #e74c3c;
    }

    .no-products {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-products i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }

    .no-products p {
        font-size: 1.1rem;
        margin-bottom: 20px;
    }

    .btn {
        display: inline-block;
        padding: 12px 24px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .expired {
        color: #e74c3c;
        font-weight: bold;
        font-size: 1.1rem;
        text-align: center;
        padding: 20px;
        background: rgba(231, 76, 60, 0.1);
        border-radius: 10px;
    }

    @media (max-width: 768px) {
        .promotion-hero {
            grid-template-columns: 1fr;
            gap: 30px;
        }

        .promotion-info h1 {
            font-size: 2rem;
        }

        .countdown-timer {
            gap: 10px;
        }

        .time-unit {
            padding: 10px;
            min-width: 50px;
        }

        .time-unit .number {
            font-size: 1.2rem;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
    }
</style>