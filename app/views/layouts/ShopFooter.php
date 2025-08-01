</div>
</main>
</div>

<!-- Success/Error Messages -->
<?php if (isset($_SESSION['success_message'])): ?>
    <div class="toast toast-success" id="successToast">
        <i class="fas fa-check-circle"></i>
        <span><?php echo $_SESSION['success_message'];
        unset($_SESSION['success_message']); ?></span>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error_message'])): ?>
    <div class="toast toast-error" id="errorToast">
        <i class="fas fa-exclamation-circle"></i>
        <span><?php echo $_SESSION['error_message'];
        unset($_SESSION['error_message']); ?></span>
    </div>
<?php endif; ?>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin"></i>
        <p>Đang xử lý...</p>
    </div>
</div>

<script src="public/js/shop/shop-admin.js"></script>
</body>

</html>