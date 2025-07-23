<style>
    .adress-item {
        background-color: white;
        border-radius: 12px;
        padding: 40px;
        position: relative;
        min-height: 150px;

    }

    .address {
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
        background-color: white;
    }

    .button-edit button:hover {
        cursor: pointer;
        background-color: rgb(230, 232, 234);
    }

</style>
<div class="adress-item">
    <p>Địa chỉ nhà <span class="default-address">Mặc định</span> </p>

    <p class="address">123, Lê Lợi, Quận 1, TP. HCM 700000</p>

    <div class="button-edit">
        <button type="submit">✏️</button>
    </div>

    <a class="set-default-address" href="">Đặt làm địa chỉ mặc định</a>
</div>

<script>
    var hideClass = document.getElementsByClassName("default-addrees");

</script>