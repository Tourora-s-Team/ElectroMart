<?php include ROOT_PATH . '/app/views/layouts/header.php'; ?>

<section class="search-results">
    <div class="container">
        <div class="search-header">
            <h2>
                <?php if (!empty($keyword)): ?>
                    Kết quả tìm kiếm cho: "<?php echo htmlspecialchars($keyword); ?>"
                <?php else: ?>
                    Tất cả sản phẩm
                <?php endif; ?>
            </h2>
            
            <!-- <div class="search-meta">
                Tìm thấy <?php echo count($products); ?> sản phẩm
            </div> -->
        </div>
        
        <div class="search-filters">
            <div class="filter-group">
                <label>Sắp xếp:</label>
                <select id="sort-select">
                    <option value="newest">Mới nhất</option>
                    <option value="price-asc">Giá tăng dần</option>
                    <option value="price-desc">Giá giảm dần</option>
                    <option value="rating">Đánh giá cao</option>
                </select>
            </div>
        </div>
        
        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="/product/<?php echo $product['ProductID']; ?>">
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
                                <?php if (!empty($product['ShopName'])): ?>
                                    <div class="product-shop">
                                        <i class="fas fa-store"></i> <?php echo htmlspecialchars($product['ShopName']); ?>
                                    </div>
                                <?php endif; ?>
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
                    <div class="no-products-content">
                        <i class="fas fa-search"></i>
                        <h3>Không tìm thấy sản phẩm nào</h3>
                        <p>Thử tìm kiếm với từ khóa khác hoặc <a href="public">quay lại trang chủ</a></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>