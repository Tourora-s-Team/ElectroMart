<?php
require_once __DIR__ . "/./account_navbar.php";
?>

<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/wish_list.css' ?>">
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Danh sách yêu thích</h1>
    </div>

    <div class="product-grid">
        <?php if ($numOfProducts == 0): ?>
            <div class="no-information">
                <p>Bạn chưa có sản phẩm nào trong danh sách yêu thích.</p>
            </div>
        <?php else: ?>
            <?php foreach ($favoriteProducts as $product): ?>
                <div class="product-card">
                    <a href="/electromart/public/product-detail/<?= $product['ProductID'] ?>">
                        <div class="product-image">
                            <img src="<?= $product['ImageURL'] ?? '/public/images/no-image.jpg' ?>"
                                alt="<?= htmlspecialchars($product['ProductName']) ?>">
                        </div>
                        <div class="product-info">
                            <h3><?= htmlspecialchars($product['ProductName']) ?></h3>
                            <div class="product-brand"><?= htmlspecialchars($product['Brand']) ?></div>
                            <div class="product-price"><?= number_format($product['Price'], 0, ',', '.') ?>đ</div>
                            <div class="product-rating">
                                <div class="stars">
                                    <?php for ($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?= $i <= $product['RatingProduct'] ? 'active' : '' ?>"></i>
                                    <?php endfor; ?>
                                </div>
                                <span class="rating-text">(<?= $product['RatingProduct'] ?>)</span>
                            </div>
                            <div class="product-stock">
                                Còn lại: <?= $product['StockQuantity'] ?> sản phẩm
                            </div>
                        </div>
                    </a>
                    <form action="/electromart/public/account/wish-list-remove/<?= $product['ProductID'] ?>" method="POST"
                        class="remove-from-wishlist-form">
                        <button type="button" class="remove-from-wishlist-btn"><i class="fas fa-heart"></i></button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
</div>

<script>
    document.querySelectorAll('.remove-from-wishlist-btn').forEach(btn => {
        // Hover: khi di chuột vào button
        btn.addEventListener('mouseenter', function () {
            this.innerHTML = '<i class="fas fa-heart-broken"></i>';
        });

        // Khi di chuột ra thì khôi phục lại icon cũ
        btn.addEventListener('mouseleave', function () {
            this.innerHTML = '<i class="fas fa-heart"></i>';
        });

        btn.addEventListener('click', function (event) {
            event.preventDefault(); // Ngăn chặn hành động mặc định của nút
            const form = this.closest('.remove-from-wishlist-form');
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi danh sách yêu thích?')) {
                form.submit(); // Gửi form nếu người dùng xác nhận
            }
        });
    });
</script>
<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>