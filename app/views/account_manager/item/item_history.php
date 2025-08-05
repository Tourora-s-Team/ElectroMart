<style>
    .hide {
        display: none !important;
    }

    .inline-block {
        display: inline-block;
    }

    .history-item {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        margin-top: 8px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .summary__date {
        font-size: 14px;
        color: #6c757d;
        margin-top: 5px;
    }

    .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
    }

    .status i {
        margin-right: 6px;
    }

    .status--completed {
        background-color: #EDF2FA;
        color: #1566C1;
    }

    .status--processing {
        background-color: #fff3cd;
        color: #856404;
    }

    .status--shipping {
        background-color: #cce5ff;
        color: #155724;
    }

    .status--cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .list-product__item {
        margin: 12px 0;
    }

    .product-item {
        margin: 10px 0;
    }

    .product-image {
        width: 75px;
        height: 75px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 10px;
    }
</style>

<?php
require_once ROOT_PATH . '/core/ImageHelper.php';
?>
<div id="<?= $orders[$i]['OrderID'] ?>" class="history-item">
    <div class="item-header flex-row-sb">
        <div class="summary">
            <p class="summary__order-id">Mã đơn hàng: <?= $orders[$i]['OrderID'] ?></p>
            <p class="summary__date">Ngày đặt: <?= $orders[$i]['OrderDate'] ?></p>
        </div>
        <div class="summary__status">
            <?php
            $status = $orders[$i]['Status'];
            ?>
            <span class="status status--completed <?= $status === 'Completed' ? '' : 'hide' ?>">
                <i class="fa-solid fa-circle-check"></i>Đã hoàn thành
            </span>
            <span class="status status--processing <?= $status === 'Processing' ? '' : 'hide' ?>">
                <i class="fa-solid fa-circle-notch"></i>Đang xử lý
            </span>
            <span class="status status--shipping <?= $status === 'Shipped' ? '' : 'hide' ?>">
                <i class="fa-solid fa-circle-notch"></i>Đang giao hàng
            </span>
            <span class="status status--cancelled <?= $status === 'Cancelled' ? '' : 'hide' ?>">
                <i class="fa-solid fa-circle-xmark"></i>Đã hủy
            </span>
        </div>
    </div>
    <div class="list-product container">
        <div class="list-product__item flex-col">
            <?php
            foreach ($orders[$i]['ProductDetails'] as $product) {
                $productId = $product['ProductID'];
                $productName = $product['ProductName'] ?? 'Sản phẩm';
                $productImage = ImageHelper::getImageUrlWithFallback($product['Image'] ?? './public/images/no-image.jpg');
                $quantity = $product['Quantity'];
                $unitPrice = $product['UnitPrice'];
                echo '<div class="product-item flex-row-sb">
                        <div class="product-details flex-row-sb">
                            <img class="product-image" src="' . $productImage . '" alt="Ảnh sản phẩm ' . $productName . '">
                            <p class="product-name">' . $productName . '</p>
                            <p class="product-quantity"> x ' . $quantity . '</p>
                        </div>
                        <div class="product-price">
                            <p class="product-price">' . number_format($unitPrice, 0, ',', '.') . ' đ</p>
                        </div>
                    </div>';
            }
            ?>
        </div>
    </div>
    <div class="item-footer flex-row-sb">
        <div class="actions">
            <button class="btn btn-secondary openModalBtn" 
                data-order-id="<?= $orders[$i]['OrderID'] ?>"
                >Chi tiết</button>
        </div>
        <div class="total-price">
            <p class="total-price__amount product-price">Tổng tiền: <?= number_format($orders[$i]['TotalAmount'], 0, ',', '.') ?>đ</p>
        </div>
    </div>
</div>
