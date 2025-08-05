<?php if (!empty($_SESSION['error_message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast("<?= addslashes($_SESSION['error_message']) ?>", 'error');
        });
    </script>
    <?php unset($_SESSION['error_message']); ?>
<?php elseif (!empty($_SESSION['success_message'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            showToast("<?= addslashes($_SESSION['success_message']) ?>", 'success');
        });
    </script>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>
<!-- Shop Info Management -->
<div class="shop-info-page">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Thông tin Shop</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.25rem;">
                Cập nhật thông tin shop của bạn để khách hàng có thể tìm hiểu thêm về cửa hàng
            </p>
        </div>
        <div class="card-body">
            <form method="POST" data-async>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="ShopName" class="form-label">Tên Shop *</label>
                        <input type="text" id="ShopName" name="ShopName" class="form-input"
                            value="<?php echo htmlspecialchars($shop['ShopName'] ?? ''); ?>" required maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="Email" class="form-label">Email liên hệ *</label>
                        <input type="email" id="Email" name="Email" class="form-input"
                            value="<?php echo htmlspecialchars($shop['Email'] ?? ''); ?>" required maxlength="100">
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div class="form-group">
                        <label for="PhoneNumber" class="form-label">Số điện thoại *</label>
                        <input type="tel" id="PhoneNumber" name="PhoneNumber" class="form-input"
                            value="<?php echo htmlspecialchars($shop['PhoneNumber'] ?? ''); ?>" required maxlength="20">
                    </div>

                    <div class="form-group">
                        <label for="Status" class="form-label">Trạng thái Shop</label>
                        <select id="Status" name="Status" class="form-select" disabled>
                            <option value="1" <?php echo ($shop['Status'] == 1) ? 'selected' : ''; ?>>Đang hoạt động
                            </option>
                            <option value="0" <?php echo ($shop['Status'] == 0) ? 'selected' : ''; ?>>Tạm ngừng</option>
                        </select>
                        <small
                            style="color: var(--text-secondary); font-size: 0.75rem; margin-top: 0.25rem; display: block;">
                            Liên hệ admin để thay đổi trạng thái shop
                        </small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="Address" class="form-label">Địa chỉ *</label>
                    <textarea id="Address" name="Address" class="form-textarea" rows="3" required
                        maxlength="500"><?php echo htmlspecialchars($shop['Address'] ?? ''); ?></textarea>
                </div>

                <div class="form-group">
                    <label for="Description" class="form-label">Mô tả Shop</label>
                    <textarea id="Description" name="Description" class="form-textarea" rows="4" maxlength="1000"
                        placeholder="Mô tả về shop, sản phẩm và dịch vụ của bạn..."><?php echo htmlspecialchars($shop['Description'] ?? ''); ?></textarea>
                </div>

                <!-- Shop Statistics (Read-only) -->
                <div style="border-top: 1px solid var(--border-color); padding-top: 1.5rem; margin-top: 1.5rem;">
                    <h4 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">
                        Thống kê Shop
                    </h4>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                        <div style="background-color: var(--background-color); padding: 1rem; border-radius: 0.375rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="fas fa-star" style="color: var(--warning-color);"></i>
                                <span style="font-weight: 500; color: var(--text-primary);">Đánh giá</span>
                            </div>
                            <div style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary);">
                                <?php echo number_format($shop['RatingShop'] ?? 0, 1); ?>/5.0
                            </div>
                        </div>

                        <div style="background-color: var(--background-color); padding: 1rem; border-radius: 0.375rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="fas fa-calendar" style="color: var(--primary-color);"></i>
                                <span style="font-weight: 500; color: var(--text-primary);">Ngày tạo</span>
                            </div>
                            <div style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary);">
                                <?php echo date('d/m/Y', strtotime($shop['CreateAt'] ?? '')); ?>
                            </div>
                        </div>

                        <div style="background-color: var(--background-color); padding: 1rem; border-radius: 0.375rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem;">
                                <i class="fas fa-user" style="color: var(--success-color);"></i>
                                <span style="font-weight: 500; color: var(--text-primary);">ID Người dùng</span>
                            </div>
                            <div style="font-size: 1.25rem; font-weight: 600; color: var(--text-primary);">
                                #<?php echo $shop['UserID'] ?? ''; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
                    <button type="button" class="btn btn-outline" onclick="resetForm()">
                        <i class="fas fa-undo"></i>
                        Đặt lại
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i>
                        Lưu thay đổi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Shop Preview -->
    <div class="card" style="margin-top: 2rem;">
        <div class="card-header">
            <h3 class="card-title">Xem trước thông tin Shop</h3>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-top: 0.25rem;">
                Đây là cách khách hàng sẽ nhìn thấy shop của bạn
            </p>
        </div>
        <div class="card-body">
            <div class="shop-preview"
                style="border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 1.5rem; background-color: white;">
                <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                    <div
                        style="width: 80px; height: 80px; background-color: var(--primary-color); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                        <i class="fas fa-store"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);"
                            id="previewShopName">
                            <?php echo htmlspecialchars($shop['ShopName'] ?? 'Tên Shop'); ?>
                        </h3>
                        <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                            <span
                                style="display: flex; align-items: center; gap: 0.25rem; color: var(--text-secondary); font-size: 0.875rem;">
                                <i class="fas fa-star" style="color: var(--warning-color);"></i>
                                <?php echo number_format($shop['RatingShop'] ?? 0, 1); ?>
                            </span>
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">
                                <i class="fas fa-calendar"></i>
                                Tham gia <?php echo date('m/Y', strtotime($shop['CreateAt'] ?? '')); ?>
                            </span>
                        </div>
                        <div style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 0.5rem;">
                            <span
                                style="display: flex; align-items: center; gap: 0.25rem; color: var(--text-secondary); font-size: 0.875rem;"
                                id="previewEmail">
                                <i class="fas fa-envelope"></i>
                                <?php echo htmlspecialchars($shop['Email'] ?? ''); ?>
                            </span>
                            <span
                                style="display: flex; align-items: center; gap: 0.25rem; color: var(--text-secondary); font-size: 0.875rem;"
                                id="previewPhone">
                                <i class="fas fa-phone"></i>
                                <?php echo htmlspecialchars($shop['PhoneNumber'] ?? ''); ?>
                            </span>
                        </div>
                        <div style="display: flex; align-items: start; gap: 0.25rem; color: var(--text-secondary); font-size: 0.875rem;"
                            id="previewAddress">
                            <i class="fas fa-map-marker-alt" style="margin-top: 0.1rem;"></i>
                            <span><?php echo htmlspecialchars($shop['Address'] ?? ''); ?></span>
                        </div>
                    </div>
                </div>

                <div style="border-top: 1px solid var(--border-color); padding-top: 1rem;">
                    <h4 style="font-weight: 600; margin-bottom: 0.5rem; color: var(--text-primary);">Giới thiệu</h4>
                    <p style="color: var(--text-secondary); line-height: 1.6;" id="previewDescription">
                        <?php echo nl2br(htmlspecialchars($shop['Description'] ?? 'Chưa có mô tả')); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Real-time preview update
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea');

        inputs.forEach(input => {
            input.addEventListener('input', function () {
                updatePreview();
            });
        });
    });

    function updatePreview() {
        // Update shop name
        const shopName = document.getElementById('ShopName').value || 'Tên Shop';
        document.getElementById('previewShopName').textContent = shopName;

        // Update email
        const email = document.getElementById('Email').value || '';
        document.getElementById('previewEmail').innerHTML = `
        <i class="fas fa-envelope"></i>
        ${email}
    `;

        // Update phone
        const phone = document.getElementById('PhoneNumber').value || '';
        document.getElementById('previewPhone').innerHTML = `
        <i class="fas fa-phone"></i>
        ${phone}
    `;

        // Update address
        const address = document.getElementById('Address').value || '';
        document.getElementById('previewAddress').innerHTML = `
        <i class="fas fa-map-marker-alt" style="margin-top: 0.1rem;"></i>
        <span>${address}</span>
    `;

        // Update description
        const description = document.getElementById('Description').value || 'Chưa có mô tả';
        document.getElementById('previewDescription').innerHTML = description.replace(/\n/g, '<br>');
    }

    function resetForm() {
        if (confirm('Bạn có chắc chắn muốn đặt lại form? Tất cả thay đổi chưa lưu sẽ bị mất.')) {
            document.querySelector('form').reset();
            updatePreview();
        }
    }

    // Form validation
    document.querySelector('form').addEventListener('submit', function (e) {
        const shopName = document.getElementById('ShopName').value.trim();
        const email = document.getElementById('Email').value.trim();
        const phone = document.getElementById('PhoneNumber').value.trim();
        const address = document.getElementById('Address').value.trim();

        if (!shopName) {
            e.preventDefault();
            showToast('Vui lòng nhập tên shop', 'error');
            document.getElementById('ShopName').focus();
            return;
        }

        if (!email) {
            e.preventDefault();
            showToast('Vui lòng nhập email liên hệ', 'error');
            document.getElementById('Email').focus();
            return;
        }

        if (!phone) {
            e.preventDefault();
            showToast('Vui lòng nhập số điện thoại', 'error');
            document.getElementById('PhoneNumber').focus();
            return;
        }

        if (!address) {
            e.preventDefault();
            showToast('Vui lòng nhập địa chỉ shop', 'error');
            document.getElementById('Address').focus();
            return;
        }

        // Email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            showToast('Email không hợp lệ', 'error');
            document.getElementById('Email').focus();
            return;
        }

        // Phone validation (Vietnamese phone number)
        const phoneRegex = /^(0[3|5|7|8|9])+([0-9]{8})$/;
        if (!phoneRegex.test(phone)) {
            e.preventDefault();
            showToast('Số điện thoại không hợp lệ', 'error');
            document.getElementById('PhoneNumber').focus();
            return;
        }
    });

    // Character count for textareas
    document.addEventListener('DOMContentLoaded', function () {
        const textareas = document.querySelectorAll('textarea[maxlength]');
        textareas.forEach(textarea => {
            const maxLength = textarea.getAttribute('maxlength');
            const counter = document.createElement('div');
            counter.style.cssText = `
            font-size: 0.75rem;
            color: var(--text-secondary);
            text-align: right;
            margin-top: 0.25rem;
        `;

            textarea.parentNode.appendChild(counter);

            function updateCounter() {
                const remaining = maxLength - textarea.value.length;
                counter.textContent = `${textarea.value.length}/${maxLength} ký tự`;
                counter.style.color = remaining < 50 ? 'var(--error-color)' : 'var(--text-secondary)';
            }

            updateCounter();
            textarea.addEventListener('input', updateCounter);
        });
    });
</script>