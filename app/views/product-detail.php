<?php
require_once ROOT_PATH . '/core/ImageHelper.php';
include ROOT_PATH . '/app/views/layouts/header.php';
?>

<link rel="stylesheet" href="https://electromart-t8ou8.ondigitalocean.app/public/css/components/productdetail.css">

<section class="product-detail">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="public">Trang chủ</a>
            <span class="separator">></span>
            <a
                href="/search?category=<?php echo $product['CategoryID']; ?>"><?php echo htmlspecialchars($product['CategoryName'] ?? 'Danh mục'); ?></a>
            <span class="separator">></span>
            <span class="current"><?php echo htmlspecialchars($product['ProductName']); ?></span>
        </nav>

        <div class="product-main">
            <!-- Product Images -->
            <div class="product-images">
                <div class="main-image">
                    <img id="mainImage" src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                        alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                </div>

                <?php if (!empty($images)): ?>
                    <div class="thumbnail-images">
                        <?php foreach ($images as $index => $image): ?>
                            <div class="thumbnail <?php echo $index === 0 ? 'active' : ''; ?>"
                                onclick="changeMainImage('<?php echo ImageHelper::getImageUrl($image['ImageURL']); ?>', this)">
                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($image['ImageURL']); ?>"
                                    alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="product-info">
                <h1 class="product-title"><?php echo htmlspecialchars($product['ProductName']); ?></h1>

                <div class="product-rating">
                    <div class="stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <i
                                class="fas fa-star <?php echo $i <= round($product['RatingProduct'], 1) ? 'active' : ''; ?>"></i>
                        <?php endfor; ?>
                    </div>
                    <span
                        class="rating-text"><?php echo htmlspecialchars(round($product['RatingProduct'], 1)); ?></span>
                    <span class="review-count">(<?php echo htmlspecialchars($reviewCount); ?> đánh giá)</span>
                    <span class="sold-count">Đã bán: <?php echo htmlspecialchars($product['StockQuantity']); ?></span>
                </div>

                <div class="product-price">
                    <span class="current-price"><?php echo number_format($product['Price'], 0, ',', '.'); ?>đ</span>
                    <span
                        class="original-price"><?php echo number_format($product['Price'] * 1.2, 0, ',', '.'); ?>đ</span>
                    <span class="discount-badge">-17%</span>
                </div>

                <div class="product-vouchers">
                    <h4>Mã giảm giá của Shop</h4>
                    <div class="voucher-list">
                        <span class="voucher-item">Giảm 50k</span>
                        <span class="voucher-item">Giảm 100k</span>
                        <span class="voucher-item">Freeship</span>
                    </div>
                </div>

                <div class="product-options">
                    <div class="option-group">
                        <label>Số lượng:</label>
                        <div class="quantity-selector">
                            <button type="button" class="qty-btn minus" onclick="changeQuantity(-1)">-</button>
                            <input type="text" id="quantity" value="1" min="1"
                                max="<?php echo $product['StockQuantity']; ?>">
                            <button type="button" class="qty-btn plus" onclick="changeQuantity(1)">+</button>
                        </div>
                        <span class="stock-info"><?php echo $product['StockQuantity']; ?> sản phẩm có sẵn</span>
                    </div>
                </div>

                <div class="product-actions">
                    <form id="addToCartForm" action="https://electromart-t8ou8.ondigitalocean.app/public/cart/add"
                        method="POST">
                        <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
                        <input type="hidden" name="quantity" id="hidden_quantity">
                        <button type="submit" class="btn btn-cart">

                            <i class="fas fa-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </form>
                    <form action="https://electromart-t8ou8.ondigitalocean.app/public/cart/add" method="POST">
                        <button class="btn btn-buy-now">
                            Mua ngay
                        </button>
                    </form>
                </div>
                <script>
                    const form = document.getElementById('addToCartForm');
                    const quantityInput = document.getElementById('quantity');
                    const hiddenQuantity = document.getElementById('hidden_quantity');

                    form.addEventListener('submit', function (e) {
                        hiddenQuantity.value = quantityInput.value;
                    });
                </script>

                <div class="product-policies">
                    <div class="policy-item">
                        <i class="fas fa-shield-alt"></i>
                        <div>
                            <strong>Chính sách trả hàng</strong>
                            <p>Trả hàng 15 ngày</p>
                        </div>
                    </div>
                    <div class="policy-item">
                        <i class="fas fa-truck"></i>
                        <div>
                            <strong>Vận chuyển</strong>
                            <p>Miễn phí vận chuyển</p>
                        </div>
                    </div>
                    <div class="policy-item">
                        <i class="fas fa-medal"></i>
                        <div>
                            <strong>Chính hãng</strong>
                            <p>Đảm bảo chính hãng</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shop Info -->
            <div class="shop-info">
                <div class="shop-header">
                    <div class="shop-avatar">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="shop-details">
                        <h3><?php echo htmlspecialchars($product['ShopName']); ?></h3>
                        <p>Online 2 giờ trước</p>
                    </div>
                </div>

                <div class="shop-stats">
                    <div class="stat-item">
                        <span class="stat-label">Đánh giá</span>
                        <span class="stat-value">4.8</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Sản phẩm</span>
                        <span class="stat-value"><?php echo rand(50, 200); ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Tham gia</span>
                        <span class="stat-value">2 năm trước</span>
                    </div>
                </div>

                <div class="shop-actions">
                    <button class="btn btn-outline">
                        <i class="fas fa-comments"></i>
                        Chat ngay
                    </button>
                    <a href="public/shop-detail/<?php echo $product['ShopID']; ?>" class="btn btn-outline">
                        <i class="fas fa-store"></i>
                        Xem shop
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Description -->
        <div class="product-description">
            <h2>Mô tả sản phẩm</h2>
            <div class="description-content">
                <?php echo nl2br(htmlspecialchars($product['Description'] ?? 'Chưa có mô tả chi tiết.')); ?>
            </div>
        </div>

        <!-- Product Reviews -->
        <div class="product-reviews">
            <h2>Đánh giá sản phẩm</h2>

            <div class="review-summary">
                <div class="rating-overview">
                    <div class="rating-score">
                        <span class="score"><?php echo htmlspecialchars(round($product['RatingProduct'], 1)); ?></span>
                        <div class="stars">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                                <i
                                    class="fas fa-star <?php echo $i <= round($product['RatingProduct'], 1) ? 'active' : ''; ?>"></i>
                            <?php endfor; ?>
                        </div>
                    </div>
                    <div class="rating-stats">
                        <div class="stat-bar">
                            <span>5 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 70%"></div>
                            </div>
                            <span>70%</span>
                        </div>
                        <div class="stat-bar">
                            <span>4 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 20%"></div>
                            </div>
                            <span>20%</span>
                        </div>
                        <div class="stat-bar">
                            <span>3 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 7%"></div>
                            </div>
                            <span>7%</span>
                        </div>
                        <div class="stat-bar">
                            <span>2 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 2%"></div>
                            </div>
                            <span>2%</span>
                        </div>
                        <div class="stat-bar">
                            <span>1 sao</span>
                            <div class="bar">
                                <div class="fill" style="width: 1%"></div>
                            </div>
                            <span>1%</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="review-list">
                <?php if (!empty($reviewComment)): ?>
                    <?php foreach ($reviewComment as $review): ?>
                        <div class="review-item">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="reviewer-details">
                                    <h4><?php echo $review['FullName'] ?></h4>
                                    <div class="review-rating stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i class="fas fa-star <?php echo $i <= $review['Rating'] ? 'active' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span
                                        class="review-date"><?php echo date('d/m/Y', strtotime($review['CreateAt'])); ?></span>
                                </div>
                            </div>
                            <div class="review-content">
                                <p><?php echo htmlspecialchars($review['Comment']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-reviews">Chưa có đánh giá nào cho sản phẩm này.</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- thêm đánh giá -->
        <form action="https://electromart-t8ou8.ondigitalocean.app/public/product-detail/review" method="POST"
            class="review-form product-reviews ">
            <h2 class="review-form__title ">Gửi đánh giá của bạn</h2>
            <!-- Chọn sao -->
            <div class="review-form__group">
                <label for="rating" class="review-form__label">Số sao:</label>
                <div class="review-rating stars" id="star-rating">
                    <?php for ($i = 1; $i <= 5; $i++): ?>
                        <i class="fas fa-star" data-value="<?php echo $i; ?>"></i>
                    <?php endfor; ?>
                </div>
                <!-- lấy số sao để đánh giá -->
                <input type="hidden" name="rating" id="rating-value" value="">
            </div>

            <!-- Nhận xét -->
            <div class="review-form__group">
                <label for="comment" class="review-form__label">Nhận xét:</label>
                <textarea name="comment" id="comment" class="review-form__textarea"
                    placeholder="Viết cảm nghĩ của bạn về sản phẩm..." required></textarea>
            </div>

            <!-- ID sản phẩm -->
            <input type="hidden" name="product_id" value="<?php echo $product['ProductID']; ?>">
            <!-- lấy ID shop -->
            <input type="hidden" name="shop_id" value="<?php echo $product['ShopID']; ?>">
            <!-- Nút gửi -->
            <button type="submit" class="review-form__submit">Gửi đánh giá</button>
        </form>

        <!-- Related Products -->
        <input type="hidden" name="category_id" value="<?php echo $product['CategoryID']; ?>">

        <div class="related-products">
            <h2>Sản phẩm liên quan</h2>
            <div class="product-grid">
                <?php foreach ($productRelated as $relatedProduct): ?>
                    <div class="product-card">
                        <a href="public/product-detail/<?php echo $relatedProduct['ProductID']; ?>">
                            <div class="product-image">
                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($relatedProduct['ImageURL']); ?>"
                                    alt="<?php echo htmlspecialchars($relatedProduct['ProductName']); ?>">
                            </div>
                            <div class="product-info">
                                <h3><?php echo htmlspecialchars($relatedProduct['ProductName']); ?></h3>
                                <div class="product-price">
                                    <?php echo number_format($relatedProduct['Price'], 0, ',', '.'); ?>đ
                                </div>
                                <div class="product-rating">
                                    <div class="stars">
                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                            <i
                                                class="fas fa-star <?php echo $i <= $relatedProduct['RatingProduct'] ? 'active' : ''; ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="rating-text">(<?php echo $relatedProduct['RatingProduct']; ?>)</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</section>

<script>
    // Xử lý đánh giá chọn sao
    const stars = document.querySelectorAll('#star-rating i');
    const ratingInput = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));
            ratingInput.value = value;

            // Xử lý làm sáng sao đã chọn
            stars.forEach(s => {
                if (parseInt(s.getAttribute('data-value')) <= value) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });

    function changeMainImage(imageUrl, thumbnail) {
        document.getElementById('mainImage').src = imageUrl;

        // Remove active class from all thumbnails
        document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));

        // Add active class to clicked thumbnail
        thumbnail.classList.add('active');
    }

    function changeQuantity(delta) {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        const maxValue = parseInt(quantityInput.max);
        const newValue = currentValue + delta;

        if (newValue >= 1 && newValue <= maxValue) {
            quantityInput.value = newValue;
        }
    }

    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;

        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);

        fetch('/cart/add', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                    updateCartCount();
                } else {
                    showNotification(data.message || 'Có lỗi xảy ra!', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Có lỗi xảy ra!', 'error');
            });
    }
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>