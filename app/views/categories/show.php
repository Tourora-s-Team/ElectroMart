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

<section class="category-header">
    <div class="container">
        <div class="breadcrumb">
            <a href="/electromart/public/">Trang chủ</a>
            <span>/</span>
            <a href="/electromart/public/categories">Danh mục</a>
            <span>/</span>
            <span><?= htmlspecialchars($category['CategoryName']) ?></span>
        </div>
        <h1><?= htmlspecialchars($category['CategoryName']) ?></h1>
        <?php if (!empty($category['Description'])): ?>
            <p><?= htmlspecialchars($category['Description']) ?></p>
        <?php endif; ?>
        <div class="category-stats">
            <span class="product-count">
                <i class="fas fa-box"></i>
                <?= $totalProducts ?> sản phẩm
            </span>
        </div>
    </div>
</section>

<section class="category-products">
    <div class="container">
        <div class="section-header">
            <h2>Sản phẩm trong danh mục</h2>
            <div class="filter-options">
                <select id="sortProducts" class="form-select">
                    <option value="latest">Mới nhất</option>
                    <option value="price_asc">Giá: Thấp đến cao</option>
                    <option value="price_desc">Giá: Cao đến thấp</option>
                    <option value="rating">Đánh giá cao nhất</option>
                </select>
            </div>
        </div>

        <div class="product-grid">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <a href="/electromart/public/product-detail/<?= $product['ProductID'] ?>">
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
                    <i class="fas fa-box-open"></i>
                    <p>Chưa có sản phẩm nào trong danh mục này.</p>
                    <a href="/electromart/public/categories" class="btn btn-primary">Xem danh mục khác</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<script>
    // Sort functionality
    document.getElementById('sortProducts').addEventListener('change', function () {
        // Implement sorting logic here
        const sortValue = this.value;
        console.log('Sort by:', sortValue);
        // You can implement AJAX sorting here
    });
</script>

<style>
    .category-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 40px 0;
    }

    .breadcrumb {
        margin-bottom: 20px;
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

    .category-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .category-header p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 20px;
    }

    .category-stats {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .product-count {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, 0.2);
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 0.9rem;
    }

    .category-products {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .section-header h2 {
        font-size: 1.8rem;
        color: #333;
    }

    .filter-options select {
        padding: 8px 16px;
        border: 1px solid #ddd;
        border-radius: 6px;
        background: white;
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
    }

    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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
        margin-bottom: 10px;
    }

    .product-price {
        font-size: 1.2rem;
        font-weight: 700;
        color: #e74c3c;
        margin-bottom: 10px;
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

    @media (max-width: 768px) {
        .section-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }

        .category-header h1 {
            font-size: 2rem;
        }

        .product-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
    }
</style>