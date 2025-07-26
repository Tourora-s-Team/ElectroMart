<?php
    require_once __DIR__ . "/./account_navbar.php";
?>
<link rel="stylesheet" href="<?= $_ENV['STYLE_PATH'] . 'account_manager/receiver_info.css' ?>">

<div class="account-info">
    <div class="subheader flex-row-sb">
        <h1 class="subheader__title">Địa chỉ giao hàng</h1>
        <button id="new-address-btn" class="subheader__btn-edit btn" onclick="openAddModal()"><i class="fa-regular fa-pen-to-square"></i>Thêm địa chỉ mới</button>
    </div>

    <div id="receiver-list">
        <?php
        for ($i = 0; $i < 4; $i++) {
            include __DIR__ ."/./item/item_receiver.php";
        }
        ?>
    </div>
</div>

<?php include ROOT_PATH . '/app/views/layouts/footer.php'; ?>


