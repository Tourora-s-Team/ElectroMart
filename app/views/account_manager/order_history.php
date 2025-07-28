<?php
require_once __DIR__ . "/./account_navbar.php";
?>
<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/order_history.css' ?>"> 
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Lịch sử mua hàng</h1>
    </div>
    <!-- File css: order_history.css -->
    <div class="history-list">
        <?php
        if ($orderHistory != null) {
            for ($i = 0; $i < $orderCount; $i++) {
                include __DIR__ . '/./item/item_history.php';
            }
        } else {
            echo '<div class="no-information"><p>Bạn chưa có đơn hàng nào.</p></div>';
        }
        ?>

    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>