<?php
    require_once __DIR__ . "/./dashboard.php";
?>
<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Lịch sử mua hàng</h1>
    </div>

    <!-- File css: order_history.css -->
    <div class="history-list">
        <?php
        // Example of how to include history items
        // This should be replaced with actual data fetching logic
        for ($i = 0; $i < 5; $i++) {
            // Include the history item template
            include __DIR__ . '/./item/item_history.php';
        }

        ?>

    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>
