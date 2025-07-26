<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<link rel="stylesheet" href="/public/css/components/shopdetail.css">

<section class="shop-detail">
    <div class="container">
        <!-- Shop Header -->
        <div class="shop-header">
            <div class="shop-banner">
                <div class="shop-info-main">
                    <div class="shop-avatar">
                        <i class="fas fa-store"></i>
                    </div>
                    <div class="shop-details">
                        <h1 class="shop-name"><?php echo htmlspecialchars($shop['ShopName']); ?></h1>
                        <p class="shop-description"><?php echo htmlspecialchars($shop['Description']); ?></p>
                        <div class="shop-contact">
                            <span><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($shop['Email']); ?></span>
                            <span><i class="fas fa-phone"></i>
                                <?php echo htmlspecialchars($shop['PhoneNumber']); ?></span>
                        </div>
                        <div class="shop-address">
                            <i class="fas fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($shop['Address']); ?>
                        </div>
                    </div>
                </div>

                <div class="shop-stats">
                    <div class="stat-item">
                        <div class="stat-number"><?php echo count($products); ?></div>
                        <div class="stat-label">Sản phẩm</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">4.8</div>
                        <div class="stat-label">Đánh giá</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo rand(500, 2000); ?></div>
                        <div class="stat-label">Người theo dõi</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number"><?php echo date('Y', strtotime($shop['CreateAt'])); ?></div>
                        <div class="stat-label">Tham gia</div>
                    </div>
                </div>

                <div class="shop-actions">
                    <button class="btn btn-follow">
                        <i class="fas fa-plus"></i>
                        Theo dõi
                    </button>
                    <button class="btn btn-chat">
                        <i class="fas fa-comments"></i>
                        Chat ngay
                    </button>
                </div>
            </div>
        </div>

        <!-- Shop Navigation -->
        <div class="shop-nav">
            <div class="nav-tabs">
                <a href="#products" class="nav-tab active">Tất cả sản phẩm</a>
                <a href="#promotions" class="nav-tab">Khuyến mãi</a>
                <a href="#about" class="nav-tab">Giới thiệu</a>
            </div>
        </div>

        <!-- Shop Content -->
        <div class="shop-content">
            <!-- Products Section -->
            <div id="products" class="content-section active">
                <div class="section-header">
                    <h2>Tất cả sản phẩm (<?php echo count($products); ?>)</h2>
                    <div class="product-filters">
                        <select class="filter-select">
                            <option value="newest">Mới nhất</option>
                            <option value="price-asc">Giá thấp đến cao</option>
                            <option value="price-desc">Giá cao đến thấp</option>
                            <option value="best-selling">Bán chạy</option>
                        </select>
                    </div>
                </div>

                <?php if (!empty($products)): ?>
                    <div class="products-grid">
                        <?php foreach ($products as $product): ?>
                            <div class="product-card">
                                <a href="/product/<?php echo $product['ProductID']; ?>">
                                    <div class="product-image">
                                        <img src="<?php echo $product['ImageURL'] ?? '/public/images/no-image.jpg'; ?>"
                                            alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                                        <?php if ($product['StockQuantity'] <= 5): ?>
                                            <span class="stock-badge">Sắp hết</span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="product-info">
                                        <h3 class="product-name"><?php echo htmlspecialchars($product['ProductName']); ?></h3>
                                        <div class="product-price">
                                            <span
                                                class="current-price"><?php echo number_format($product['Price'], 0, ',', '.'); ?>đ</span>
                                            <span
                                                class="original-price"><?php echo number_format($product['Price'] * 1.2, 0, ',', '.'); ?>đ</span>
                                        </div>
                                        <div class="product-meta">
                                            <div class="product-rating">
                                                <div class="stars">
                                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                                        <i
                                                            class="fas fa-star <?php echo $i <= $product['Rating'] ? 'active' : ''; ?>"></i>
                                                    <?php endfor; ?>
                                                </div>
                                                <span class="rating-text"><?php echo $product['Rating']; ?></span>
                                            </div>
                                            <span class="sold-count">Đã bán <?php echo rand(10, 500); ?></span>
                                        </div>
                                        <div class="product-stock">
                                            Còn lại: <?php echo $product['StockQuantity']; ?> sản phẩm
                                        </div>
                                    </div>
                                </a>

                                <div class="product-actions">
                                    <button class="btn btn-cart" onclick="addToCart(<?php echo $product['ProductID']; ?>)">
                                        <i class="fas fa-shopping-cart"></i>
                                    </button>
                                    <a href="/product/<?php echo $product['ProductID']; ?>" class="btn btn-detail">
                                        Xem chi tiết
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-products">
                        <div class="no-products-content">
                            <i class="fas fa-box-open"></i>
                            <h3>Chưa có sản phẩm nào</h3>
                            <p>Shop này chưa có sản phẩm để hiển thị</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Promotions Section -->
            <div id="promotions" class="content-section">
                <div class="section-header">
                    <h2>Khuyến mãi hiện có</h2>
                </div>

                <?php if (!empty($promotions)): ?>
                    <div class="promotions-grid">
                        <?php foreach ($promotions as $promotion): ?>
                            <div class="promotion-card">
                                <div class="promotion-header">
                                    <div class="promotion-icon">
                                        <i class="fas fa-gift"></i>
                                    </div>
                                    <div class="promotion-info">
                                        <h3><?php echo htmlspecialchars($promotion['PromotionName']); ?></h3>
                                        <div class="promotion-value">
                                            Giảm <?php echo number_format($promotion['DiscountValue'], 0, ',', '.'); ?>đ
                                        </div>
                                    </div>
                                </div>

                                <div class="promotion-details">
                                    <div class="promotion-period">
                                        <i class="fas fa-calendar"></i>
                                        <?php echo date('d/m/Y', strtotime($promotion['StartDate'])); ?> -
                                        <?php echo date('d/m/Y', strtotime($promotion['EndDate'])); ?>
                                    </div>
                                    <div class="promotion-status">
                                        <span class="status-badge <?php echo strtolower($promotion['Status']); ?>">
                                            <?php echo $promotion['Status']; ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="no-promotions">
                        <div class="no-promotions-content">
                            <i class="fas fa-percentage"></i>
                            <h3>Chưa có khuyến mãi nào</h3>
                            <p>Shop này hiện tại chưa có chương trình khuyến mãi</p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- About Section -->
            <div id="about" class="content-section">
                <div class="section-header">
                    <h2>Giới thiệu về shop</h2>
                </div>

                <div class="about-content">
                    <div class="about-info">
                        <h3>Thông tin chi tiết</h3>
                        <div class="info-grid">
                            <div class="info-item">
                                <label>Tên shop:</label>
                                <span><?php echo htmlspecialchars($shop['ShopName']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Email:</label>
                                <span><?php echo htmlspecialchars($shop['Email']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Số điện thoại:</label>
                                <span><?php echo htmlspecialchars($shop['PhoneNumber']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Địa chỉ:</label>
                                <span><?php echo htmlspecialchars($shop['Address']); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Ngày tham gia:</label>
                                <span><?php echo date('d/m/Y', strtotime($shop['CreateAt'])); ?></span>
                            </div>
                            <div class="info-item">
                                <label>Trạng thái:</label>
                                <span class="status-badge <?php echo $shop['Status'] ? 'active' : 'inactive'; ?>">
                                    <?php echo $shop['Status'] ? 'Đang hoạt động' : 'Tạm ngưng'; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="about-description">
                        <h3>Mô tả</h3>
                        <p><?php echo nl2br(htmlspecialchars($shop['Description'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Tab navigation
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all tabs and sections
            document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.content-section').forEach(s => s.classList.remove('active'));

            // Add active class to clicked tab
            this.classList.add('active');

            // Show corresponding section
            const targetId = this.getAttribute('href').substring(1);
            document.getElementById(targetId).classList.add('active');
        });
    });

    // Add to cart function
    function addToCart(productId) {
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', 1);

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

    // Product filtering
    document.querySelector('.filter-select').addEventListener('change', function () {
        const sortType = this.value;
        const productGrid = document.querySelector('.products-grid');
        const products = Array.from(productGrid.querySelectorAll('.product-card'));

        products.sort((a, b) => {
            switch (sortType) {
                case 'price-asc':
                    return getPrice(a) - getPrice(b);
                case 'price-desc':
                    return getPrice(b) - getPrice(a);
                case 'best-selling':
                    return getSoldCount(b) - getSoldCount(a);
                default:
                    return 0;
            }
        });

        // Re-append sorted products
        products.forEach(product => productGrid.appendChild(product));
    });

    function getPrice(productCard) {
        const priceText = productCard.querySelector('.current-price').textContent;
        return parseFloat(priceText.replace(/[^\d]/g, ''));
    }

    function getSoldCount(productCard) {
        const soldText = productCard.querySelector('.sold-count').textContent;
        return parseInt(soldText.replace(/[^\d]/g, ''));
    }
</script>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>