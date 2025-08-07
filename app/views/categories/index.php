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

<section class="page-header">
    <div class="container">
        <h1>Danh mục sản phẩm</h1>
        <p>Khám phá các danh mục sản phẩm đa dạng của chúng tôi</p>
    </div>
</section>

<section class="categories-section">
    <div class="container">
        <div class="categories-grid">
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $category): ?>
                    <div class="category-card">
                        <a href="https://electromart.online/public/categories/<?= $category['CategoryID'] ?>">
                            <div class="category-image">
                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($category['ImageURL'] ?? '/public/images/default-category.jpg'); ?>"
                                    alt="<?php echo htmlspecialchars($category['CategoryName']); ?>">
                            </div>
                            <div class="category-info">
                                <h3><?php echo htmlspecialchars($category['CategoryName']); ?></h3>
                                <p><?php echo htmlspecialchars($category['Description'] ?? ''); ?></p>
                                <div class="product-count">
                                    <i class="fas fa-box"></i>
                                    <?php echo $category['product_count']; ?> sản phẩm
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-categories">
                    <i class="fas fa-folder-open"></i>
                    <p>Chưa có danh mục nào được tạo.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<style>
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 60px 0;
        text-align: center;
    }

    .page-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .page-header p {
        font-size: 1.1rem;
        opacity: 0.9;
    }

    .categories-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .categories-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-top: 40px;
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
        height: 200px;
        overflow: hidden;
        position: relative;
    }

    .category-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .category-card:hover .category-image img {
        transform: scale(1.05);
    }

    .category-info {
        padding: 25px;
    }

    .category-info h3 {
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: #333;
    }

    .category-info p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 15px;
    }

    .product-count {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #007bff;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .product-count i {
        font-size: 0.85rem;
    }

    .no-categories {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        color: #666;
    }

    .no-categories i {
        font-size: 4rem;
        margin-bottom: 20px;
        color: #ddd;
    }

    .no-categories p {
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .categories-grid {
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .page-header h1 {
            font-size: 2rem;
        }
    }
</style>