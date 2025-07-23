<script>
    // Thêm hiệu ứng cuộn mượt mà khi nhấn vào nút "Mua sắm ngay"
    document.querySelector('.cta-btn').addEventListener('click', function(e) {
        e.preventDefault(); // Ngừng hành động mặc định của liên kết
        
        // Cuộn mượt mà tới section với id="product-section"
        document.querySelector('#product-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    });
</script>