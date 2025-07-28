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

    .summary__status .status {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: 600;
    }

    .summary__status .status i {
        margin-right: 6px;
    }

    .status--completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status--processing {
        background-color: #fff3cd;
        color: #856404;
    }

    .status--cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .list-product__item {
        margin: 12px 0;
    }
</style>
<div class="history-item">
    <div class="item-header flex-row-sb">
        <div class="summary">
            <p class="summary__order-id">Mã đơn hàng: <?= $orderHistory[0]['OrderID']?></p>
            <p class="summary__date">Ngày đặt: <?= $orderHistory[0]['OrderDate']?></p>
        </div>
        <div class="summary__status">
            <span class="status status--completed"><i class="fa-solid fa-circle-check"></i>Đã hoàn thành</span>
            <span class="hide status status--processing"><i class="fa-solid fa-circle-notch"></i>Đang xử lý</span>
            <span class="hide status status--cancelled"><i class="fa-solid fa-circle-xmark"></i>Đã hủy</span>
        </div>
    </div>
    <div class="list-product container">
        <div class="list-product__item flex-row-sb">
            <div class="product-details">
                <p class="inline-block product-name">Tên sản phẩm</p>
                <p class="inline-block product-quantity">x 2</p>
            </div>
            <div class="product-price">
                <p class="product-price">Giá: 500.000đ</p>
            </div>
        </div>
    </div>

    <div class="item-footer flex-row-sb">
        <div class="actions">
            <button class="btn btn-secondary">Chi tiết</button>
            <button class="btn btn-primary">Mua lại</button>
        </div>
        <div class="total-price">
            <p class="total-price__label">Tổng tiền:</p>
            <p class="total-price__amount">1.000.000đ</p>
        </div>
    </div>
</div>