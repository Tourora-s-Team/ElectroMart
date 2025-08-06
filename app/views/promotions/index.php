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
        <h1>Khuyến mãi</h1>
        <p>Khám phá các ưu đãi hấp dẫn dành cho bạn</p>
    </div>
</section>

<section class="promotions-section">
    <div class="container">
        <div class="promotions-grid">
            <?php if (!empty($promotions)): ?>
                <?php foreach ($promotions as $promotion): ?>
                    <div class="promotion-card">
                        <div class="promotion-badge">
                            <span>-<?= $promotion['DiscountPercent'] ?>%</span>
                        </div>

                        <div class="promotion-image">
                            <img src="<?php echo ImageHelper::getImageUrlWithFallback($promotion['ImageURL'] ?? '/public/images/default-promotion.jpg'); ?>"
                                alt="<?php echo htmlspecialchars($promotion['Title']); ?>">
                        </div>

                        <div class="promotion-content">
                            <h3><?= htmlspecialchars($promotion['Title']) ?></h3>
                            <p><?= htmlspecialchars($promotion['Description']) ?></p>

                            <div class="promotion-dates">
                                <div class="date-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span>Từ: <?= date('d/m/Y', strtotime($promotion['StartDate'])) ?></span>
                                </div>
                                <div class="date-item">
                                    <i class="fas fa-calendar-times"></i>
                                    <span>Đến: <?= date('d/m/Y', strtotime($promotion['EndDate'])) ?></span>
                                </div>
                            </div>

                            <div class="promotion-actions">
                                <a href="https://electromart-t8ou8.ondigitalocean.app/public/promotions/<?= $promotion['PromotionID'] ?>"
                                    class="btn btn-primary">
                                    <i class="fas fa-shopping-bag"></i>
                                    Xem sản phẩm
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-promotions">
                    <i class="fas fa-tags"></i>
                    <p>Hiện tại chưa có chương trình khuyến mãi nào.</p>
                    <a href="https://electromart-t8ou8.ondigitalocean.app/public/" class="btn btn-primary">Về trang chủ</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>

<style>
    .page-header {
        background: linear-gradient(135deg, #ff6b6b 0%, #ffa500 100%);
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

    .promotions-section {
        padding: 60px 0;
        background: #f8f9fa;
    }

    .promotions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 30px;
        margin-top: 40px;
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
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ff6b6b, #e74c3c);
        color: white;
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: bold;
        font-size: 0.9rem;
        z-index: 2;
        box-shadow: 0 2px 10px rgba(231, 76, 60, 0.3);
    }

    .promotion-image {
        height: 200px;
        overflow: hidden;
        position: relative;
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
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: 15px;
        color: #333;
        line-height: 1.3;
    }

    .promotion-content p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
    }

    .promotion-dates {
        margin-bottom: 25px;
    }

    .date-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 8px;
        font-size: 0.9rem;
        color: #555;
    }

    .date-item i {
        color: #ff6b6b;
        width: 16px;
    }

    .promotion-actions {
        text-align: center;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        font-size: 0.95rem;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
    }

    .btn i {
        margin-right: 8px;
    }

    .no-promotions {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
        color: #666;
    }

    .no-promotions i {
        font-size: 4rem;
        margin-bottom: 25px;
        color: #ddd;
    }

    .no-promotions p {
        font-size: 1.2rem;
        margin-bottom: 30px;
    }

    /* Countdown timer animation */
    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .promotion-badge {
        animation: pulse 2s infinite;
    }

    @media (max-width: 768px) {
        .promotions-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .page-header h1 {
            font-size: 2rem;
        }

        .promotion-content h3 {
            font-size: 1.2rem;
        }
    }
</style>