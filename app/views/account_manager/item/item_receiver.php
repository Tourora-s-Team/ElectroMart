<style>
    .receiver-item {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        position: relative;
        min-height: 150px;
        margin-bottom: 20px;
    }

    .receiver-info {
        line-height: 40px;
    }

    .default-address {
        background-color: #DCFCE7;
        color: #4C926B;
        border-radius: 16px;
        padding: 6px;
        font-size: 10px;
        font-weight: 450;
    }

    .button-edit {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .button-edit button {
        border: none;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 1.2rem;
        background-color: white;
    }

    .button-edit button:hover {
        cursor: pointer;
        background-color: rgb(230, 232, 234);
    }

    .set-default-address {
        background-color: #E0F2FE;
        color: #0284C7;
        border-radius: 8px;
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 500;
        border: none;
        float: right;
    }

    .set-default-address:hover {
        background-color: #BEE3F8;
        color: #0369A1;
        cursor: pointer;
    }

    @media (max-width: 768px) {
        #receiver-list {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .receiver-item {
            width: 90%;
        }
    }
</style>

<!-- Thông tin địa chỉ -->
<div id="<?= $receiver->getReceiverID() ?>" class="receiver-item">
    <p>Địa chỉ nhà <?php if ($receiver->getIsDefault()): ?> &nbsp;&nbsp;<span class="default-address">Mặc
                định</span><?php endif; ?></p>
    <p class="receiver-info">[<?= $receiver->getAddressDetail() ?>] Đường <?= $receiver->getStreet() ?>,
        <?= $receiver->getWard() ?>, <?= $receiver->getCity() ?>, <?= $receiver->getCountry() ?>
    </p>
    <p class="receiver-info">Người nhận: <?= $receiver->getReceiverName() ?></p>
    <p class="receiver-info">SĐT: <?= $receiver->getContactNumber() ?></p>

    <div id="edit-address-btn" class="button-edit">
        <button type="button" onclick="openEditModal(this)"><i class="fa-solid fa-pen-to-square"
                style="color: #007BFF"></i></button>
    </div>
    <?php if (!$receiver->getIsDefault()): ?>
        <form method="POST"
            action="https://electromart-t8ou8.ondigitalocean.app/public/account/set-default-receiver/<?= $receiver->getReceiverID() ?>"
            style="display: inline;">
            <button type="submit" class="set-default-address">Đặt làm địa chỉ mặc định</button>
        </form>
    <?php endif; ?>
</div>