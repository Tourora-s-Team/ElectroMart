<?php require_once ROOT_PATH . '/core/ImageHelper.php'; ?>
<!-- Products Management -->
<div class="products-management">
    <!-- Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">Quản lý sản phẩm</h1>
            <p class="page-description">Quản lý danh sách sản phẩm của shop</p>
        </div>
        <div class="header-actions">
            <a href="/electromart/public/shop/products/add" type="button" class="btn btn-primary">
                <i class="fas fa-plus"></i>
                Thêm sản phẩm
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-body">
            <form method="GET"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
                <!-- Search -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="search" class="form-label">Tìm kiếm</label>
                    <input type="text" id="search" name="search" class="form-input"
                        placeholder="Tên sản phẩm, thương hiệu..."
                        value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                </div>

                <!-- Category -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="category" class="form-label">Danh mục</label>
                    <select id="category" name="category" class="form-select">
                        <option value="">Tất cả danh mục</option>
                        <?php if (!empty($categories)): ?>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['CategoryID']; ?>" <?php echo (($_GET['category'] ?? '') == $category['CategoryID']) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($category['CategoryName']); ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>

                <!-- Status -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="status" class="form-label">Trạng thái</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Tất cả</option>
                        <option value="1" <?php echo (($_GET['status'] ?? '') === '1') ? 'selected' : ''; ?>>Đang bán
                        </option>
                        <option value="0" <?php echo (($_GET['status'] ?? '') === '0') ? 'selected' : ''; ?>>Ngừng bán
                        </option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="price_from" class="form-label">Giá từ</label>
                    <input type="number" id="price_from" name="price_from" class="form-input" placeholder="0"
                        value="<?php echo htmlspecialchars($_GET['price_from'] ?? ''); ?>">
                </div>

                <div class="form-group" style="margin-bottom: 0;">
                    <label for="price_to" class="form-label">Giá đến</label>
                    <input type="number" id="price_to" name="price_to" class="form-input" placeholder="999999999"
                        value="<?php echo htmlspecialchars($_GET['price_to'] ?? ''); ?>">
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 0.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search"></i>
                        Tìm kiếm
                    </button>
                    <a href="/electromart/public/shop/products" class="btn btn-outline">
                        <i class="fas fa-refresh"></i>
                        Làm mới
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stats -->
    <div class="stats-grid" style="margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--primary-color);">
                <i class="fas fa-box"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $stats['total_products'] ?? 0; ?></h3>
                <p>Tổng sản phẩm</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--success-color);">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $stats['active_products'] ?? 0; ?></h3>
                <p>Đang bán</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--warning-color);">
                <i class="fas fa-pause-circle"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo $stats['inactive_products'] ?? 0; ?></h3>
                <p>Ngừng bán</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon" style="background-color: var(--info-color);">
                <i class="fas fa-eye"></i>
            </div>
            <div class="stat-info">
                <h3><?php echo number_format($stats['total_views'] ?? 0); ?></h3>
                <p>Lượt xem</p>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Danh sách sản phẩm</h3>
            <div class="card-actions">
                <button type="button" class="btn btn-outline btn-sm" onclick="toggleView()">
                    <i class="fas fa-th" id="viewToggleIcon"></i>
                    <span id="viewToggleText">Chế độ lưới</span>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (!empty($products)): ?>
                <!-- Table View (Default) -->
                <div id="tableView" class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 80px;">Hình ảnh</th>
                                <th>Sản phẩm</th>
                                <th style="width: 120px;">Giá</th>
                                <th style="width: 100px;">Tồn kho</th>
                                <th style="width: 100px;">Lượt xem</th>
                                <th style="width: 100px;">Trạng thái</th>
                                <th style="width: 150px;">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <div style="width: 60px; height: 60px;">
                                            <?php if (!empty($product['ImageURL'])): ?>
                                                <script>
                                                    console.log('Image URL:', '<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>');
                                                    </script>
                                                <img src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                                                    alt="<?php echo htmlspecialchars($product['ProductName']); ?>"
                                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--border-color);">
                                            <?php else: ?>
                                                <div
                                                    style="width: 100%; height: 100%; background-color: var(--background-color); border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);">
                                                    <i class="fas fa-image" style="color: var(--text-light);"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <h4 class="font-medium" style="margin-bottom: 0.25rem;">
                                                <?php echo htmlspecialchars($product['ProductName']); ?>
                                            </h4>
                                            <p
                                                style="font-size: 0.875rem; color: var(--text-secondary); margin-bottom: 0.25rem;">
                                                <?php echo htmlspecialchars($product['Brand']); ?>
                                            </p>
                                            <p style="font-size: 0.75rem; color: var(--text-light);">
                                                ID: <?php echo $product['ProductID']; ?>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="font-medium"><?php echo number_format($product['Price']); ?>₫</td>
                                    <td>
                                        <span
                                            class="<?php echo ($product['StockQuantity'] > 0) ? 'text-success' : 'text-danger'; ?>">
                                            <?php echo $product['StockQuantity']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo number_format($product['ViewCount'] ?? 0); ?></td>
                                    <td>
                                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span
                                                class="status-badge status-<?php echo $product['IsActive'] ? 'active' : 'inactive'; ?>">
                                                <?php echo $product['IsActive'] ? 'Đang bán' : 'Ngừng bán'; ?>
                                            </span>
                                            <label class="switch">
                                                <input type="checkbox" <?php echo $product['IsActive'] ? 'checked' : ''; ?>
                                                    onchange="toggleProductStatus(<?php echo $product['ProductID']; ?>, this.checked)">
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 0.5rem;">
                                            <button type="button" class="btn btn-outline btn-sm"
                                                onclick="editProduct(<?php echo $product['ProductID']; ?>)" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline btn-sm"
                                                onclick="viewProduct(<?php echo $product['ProductID']; ?>)"
                                                title="Xem chi tiết">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="deleteProduct(<?php echo $product['ProductID']; ?>)" title="Xóa">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Grid View -->
                <div id="gridView" class="products-grid" style="display: none;">
                    <?php foreach ($products as $product): ?>
                        <div class="product-card">
                            <div class="product-image">
                                <?php if (!empty($product['ImageURL'])): ?>
                                    <img src="<?php echo ImageHelper::getImageUrlWithFallback($product['ImageURL']); ?>"
                                        alt="<?php echo htmlspecialchars($product['ProductName']); ?>">
                                <?php else: ?>
                                    <div class="placeholder-image">
                                        <i class="fas fa-image"></i>
                                    </div>
                                <?php endif; ?>

                                <!-- Status Badge -->
                                <div class="product-status">
                                    <span
                                        class="status-badge status-<?php echo $product['IsActive'] ? 'active' : 'inactive'; ?>">
                                        <?php echo $product['IsActive'] ? 'Đang bán' : 'Ngừng bán'; ?>
                                    </span>
                                </div>

                                <!-- Actions Overlay -->
                                <div class="product-actions">
                                    <button type="button" class="btn btn-sm btn-primary"
                                        onclick="editProduct(<?php echo $product['ProductID']; ?>)" title="Chỉnh sửa">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline"
                                        onclick="viewProduct(<?php echo $product['ProductID']; ?>)" title="Xem chi tiết">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteProduct(<?php echo $product['ProductID']; ?>)" title="Xóa">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="product-info">
                                <h4 class="product-name"><?php echo htmlspecialchars($product['ProductName']); ?></h4>
                                <p class="product-brand"><?php echo htmlspecialchars($product['Brand']); ?></p>
                                <div class="product-price"><?php echo number_format($product['Price']); ?>₫</div>

                                <div class="product-meta">
                                    <span class="meta-item">
                                        <i class="fas fa-box"></i>
                                        <?php echo $product['StockQuantity']; ?> trong kho
                                    </span>
                                    <span class="meta-item">
                                        <i class="fas fa-eye"></i>
                                        <?php echo number_format($product['ViewCount'] ?? 0); ?> lượt xem
                                    </span>
                                </div>

                                <!-- Toggle Switch -->
                                <div class="product-toggle">
                                    <label class="switch">
                                        <input type="checkbox" <?php echo $product['IsActive'] ? 'checked' : ''; ?>
                                            onchange="toggleProductStatus(<?php echo $product['ProductID']; ?>, this.checked)">
                                        <span class="slider"></span>
                                    </label>
                                    <span><?php echo $product['IsActive'] ? 'Đang bán' : 'Ngừng bán'; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Pagination -->
                <?php if (!empty($pagination)): ?>
                    <div class="pagination-container">
                        <div class="pagination-info">
                            Hiển thị <?php echo $pagination['start']; ?>-<?php echo $pagination['end']; ?>
                            trong tổng số <?php echo $pagination['total']; ?> sản phẩm
                        </div>

                        <?php if ($pagination['total_pages'] > 1): ?>
                            <div class="pagination">
                                <?php if ($pagination['current_page'] > 1): ?>
                                    <a href="?page=<?php echo $pagination['current_page'] - 1; ?><?php echo !empty($_GET) ? '&' . http_build_query(array_filter($_GET, function ($k) {
                                                                                                        return $k !== 'page';
                                                                                                    }, ARRAY_FILTER_USE_KEY)) : ''; ?>" class="pagination-btn">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                <?php endif; ?>

                                <?php for ($i = max(1, $pagination['current_page'] - 2); $i <= min($pagination['total_pages'], $pagination['current_page'] + 2); $i++): ?>
                                    <a href="?page=<?php echo $i; ?><?php echo !empty($_GET) ? '&' . http_build_query(array_filter($_GET, function ($k) {
                                                                        return $k !== 'page';
                                                                    }, ARRAY_FILTER_USE_KEY)) : ''; ?>"
                                        class="pagination-btn <?php echo ($i == $pagination['current_page']) ? 'active' : ''; ?>">
                                        <?php echo $i; ?>
                                    </a>
                                <?php endfor; ?>

                                <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                                    <a href="?page=<?php echo $pagination['current_page'] + 1; ?><?php echo !empty($_GET) ? '&' . http_build_query(array_filter($_GET, function ($k) {
                                                                                                        return $k !== 'page';
                                                                                                    }, ARRAY_FILTER_USE_KEY)) : ''; ?>" class="pagination-btn">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php else: ?>
                <div class="empty-state">
                    <i class="fas fa-box-open"></i>
                    <h3>Chưa có sản phẩm nào</h3>
                    <p>Hãy thêm sản phẩm đầu tiên cho shop của bạn</p>
                    <a href="/electromart/public/shop/products/add" type="button" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Thêm sản phẩm
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add/Edit Product Modal -->
<div id="productModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <div class="modal-header">
            <h3 class="modal-title" id="productModalTitle">Thêm sản phẩm mới</h3>
            <button type="button" class="modal-close" onclick="closeModal('productModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="productForm" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="productId" name="product_id" value="">
            <div class="modal-body">
                <!-- Basic Information -->
                <div class="form-section">
                    <h4 class="section-title">Thông tin cơ bản</h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="productName" class="form-label">Tên sản phẩm *</label>
                            <input type="text" id="productName" name="product_name" class="form-input" required>
                        </div>

                        <div class="form-group">
                            <label for="productBrand" class="form-label">Thương hiệu *</label>
                            <input type="text" id="productBrand" name="brand" class="form-input" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productDescription" class="form-label">Mô tả sản phẩm</label>
                        <textarea id="productDescription" name="description" class="form-textarea" rows="4"></textarea>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="form-section">
                    <h4 class="section-title">Giá cả & Kho hàng</h4>

                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
                        <div class="form-group">
                            <label for="productPrice" class="form-label">Giá bán *</label>
                            <input type="number" id="productPrice" name="price" class="form-input" min="0" step="1000"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="productStock" class="form-label">Số lượng tồn kho *</label>
                            <input type="number" id="productStock" name="stock_quantity" class="form-input" min="0"
                                required>
                        </div>

                        <div class="form-group">
                            <label for="productCategory" class="form-label">Danh mục *</label>
                            <select id="productCategory" name="category_id" class="form-select" required>
                                <option value="">Chọn danh mục</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['CategoryID']; ?>">
                                            <?php echo htmlspecialchars($category['CategoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="form-section">
                    <h4 class="section-title">Hình ảnh sản phẩm</h4>

                    <div class="form-group">
                        <label for="productImages" class="form-label">Chọn hình ảnh</label>
                        <input type="file" id="productImages" name="images[]" class="form-input" multiple
                            accept="image/*">
                        <div class="form-help">
                            Chọn tối đa 5 hình ảnh. Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB/ảnh.
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" class="image-preview"></div>
                </div>

                <!-- Status -->
                <div class="form-section">
                    <h4 class="section-title">Trạng thái</h4>

                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" id="productActive" name="is_active" value="1" checked>
                            <span class="checkmark"></span>
                            Sản phẩm đang được bán
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('productModal')">
                    Hủy
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    <span id="productSubmitText">Thêm sản phẩm</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Helper function to convert database image path to web URL
    function getImageUrl(imagePath) {
        if (!imagePath) {
            return '/electromart/public/images/no-image.jpg';
        }

        // Remove './' prefix if exists
        const cleanPath = imagePath.replace(/^\.\//, '');

        // Add web prefix
        return '/electromart/' + cleanPath;
    }

    let currentView = 'table';

    function toggleView() {
        const tableView = document.getElementById('tableView');
        const gridView = document.getElementById('gridView');
        const viewToggleIcon = document.getElementById('viewToggleIcon');
        const viewToggleText = document.getElementById('viewToggleText');

        if (currentView === 'table') {
            tableView.style.display = 'none';
            gridView.style.display = 'grid';
            viewToggleIcon.className = 'fas fa-list';
            viewToggleText.textContent = 'Chế độ bảng';
            currentView = 'grid';
        } else {
            tableView.style.display = 'block';
            gridView.style.display = 'none';
            viewToggleIcon.className = 'fas fa-th';
            viewToggleText.textContent = 'Chế độ lưới';
            currentView = 'table';
        }

        localStorage.setItem('productsView', currentView);
    }


    function editProduct(productId) {
        // Load product data via AJAX
        fetch(`/electromart/public/shop/products/update/${productId}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 403) {
                        throw new Error('Bạn không có quyền thực hiện thao tác này. Vui lòng đăng nhập lại.');
                    } else if (response.status === 401) {
                        throw new Error('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
                    }
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.text();
            })
            .then(text => {
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Response is not valid JSON:', text);
                    throw new Error('Server trả về dữ liệu không hợp lệ. Vui lòng thử lại.');
                }
                return data;
            })
            .then(data => {
                if (data.success && data.product) {
                    const product = data.product;

                    document.getElementById('productModalTitle').textContent = 'Chỉnh sửa sản phẩm';
                    document.getElementById('productSubmitText').textContent = 'Cập nhật sản phẩm';
                    document.getElementById('productId').value = product.ProductID;
                    document.getElementById('productName').value = product.ProductName;
                    document.getElementById('productBrand').value = product.Brand;
                    document.getElementById('productDescription').value = product.Description || '';
                    document.getElementById('productPrice').value = product.Price;
                    document.getElementById('productStock').value = product.StockQuantity;
                    document.getElementById('productCategory').value = product.CategoryID;
                    document.getElementById('productActive').checked = product.IsActive == 1;

                    // Display existing images
                    if (data.images && data.images.length > 0) {
                        const imagePreview = document.getElementById('imagePreview');
                        imagePreview.innerHTML = data.images.map(img => `
                        <div class="preview-item existing-image">
                            <img src="${getImageUrl(img.ImageURL)}" alt="Product Image">
                            <button type="button" class="remove-image" onclick="removeExistingImage(${img.ImageID})">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `).join('');
                    }

                    openModal('productModal');
                } else {
                    showToast(data.message || 'Không thể tải thông tin sản phẩm', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi tải thông tin sản phẩm', 'error');
            });

    }

    function viewProduct(productId) {
        window.open(`/electromart/public/product-detail/${productId}`, '_blank');
    }



    function toggleProductStatus(productId, isActive) {
        fetch(`/electromart/public/shop/products/toggle-status/${productId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({
                    is_active: isActive
                })
            })
            .then(response => {
                if (!response.ok) {
                    if (response.status === 403) {
                        throw new Error('Bạn không có quyền thực hiện thao tác này. Vui lòng đăng nhập lại.');
                    } else if (response.status === 401) {
                        throw new Error('Phiên đăng nhập đã hết hạn. Vui lòng đăng nhập lại.');
                    }
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                return response.text();
            })
            .then(text => {
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    console.error('Response is not valid JSON:', text);
                    throw new Error('Server trả về dữ liệu không hợp lệ. Vui lòng thử lại.');
                }
                return data;
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    // Update status badge
                    setTimeout(() => location.reload(), 1000);
                } else {
                    showToast(data.message || 'Không thể cập nhật trạng thái', 'error');
                    // Revert switch
                    event.target.checked = !isActive;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra', 'error');
                // Revert switch
                event.target.checked = !isActive;
            });
    }

    function removeExistingImage(imageId) {
        if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
            fetch(`/electromart/public/shop/products/delete-image/${imageId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.querySelector(`[onclick="removeExistingImage(${imageId})"]`).closest('.preview-item').remove();
                        showToast('Xóa hình ảnh thành công', 'success');
                    } else {
                        showToast('Không thể xóa hình ảnh', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra', 'error');
                });
        }
    }

    // Form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);
        const productId = document.getElementById('productId').value;
        const url = productId ?
            `/electromart/public/shop/products/update/${productId}` :
            '/electromart/public/shop/products/add';

        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        // Hiển thị đang xử lý
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
        submitBtn.disabled = true;

        fetch(url, {
                method: 'POST',
                body: formData,
            })
            .then(response => {
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.includes("application/json")) {
                    return response.json();
                } else {
                    throw new Error("Không nhận được phản hồi JSON hợp lệ");
                }
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message || 'Thành công!', 'success');

                    // Tự đóng modal (nếu bạn dùng modal Bootstrap, sửa lại cho phù hợp)
                    const modal = document.getElementById('productModal');
                    if (modal) {
                        modal.classList.remove('show');
                        modal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) backdrop.remove();
                    }

                    // Tự reload trang
                    setTimeout(() => {
                        window.location.href = "/electromart/public/shop/products";
                    }, 1000);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
                showToast('Đã xảy ra lỗi không mong muốn', 'error');
            })
            .finally(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            });
    });


    // Load saved view preference
    document.addEventListener('DOMContentLoaded', function() {
        const savedView = localStorage.getItem('productsView');
        if (savedView === 'grid') {
            toggleView();
        }
    });
</script>

<style>
    /* Products Grid */
    .products-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .product-card {
        background: white;
        border-radius: 0.75rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    }

    .product-image {
        position: relative;
        width: 100%;
        height: 200px;
        overflow: hidden;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.05);
    }

    .placeholder-image {
        width: 100%;
        height: 100%;
        background-color: var(--background-color);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-light);
        font-size: 2rem;
    }

    .product-status {
        position: absolute;
        top: 0.75rem;
        right: 0.75rem;
    }

    .product-actions {
        position: absolute;
        top: 0.75rem;
        left: 0.75rem;
        display: flex;
        gap: 0.5rem;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .product-card:hover .product-actions {
        opacity: 1;
    }

    .product-info {
        padding: 1rem;
    }

    .product-name {
        font-weight: 600;
        margin-bottom: 0.25rem;
        color: var(--text-primary);
        font-size: 1rem;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .product-brand {
        color: var(--text-secondary);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .product-price {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 0.75rem;
    }

    .product-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 0.75rem;
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .product-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 0.75rem;
        border-top: 1px solid var(--border-color);
    }

    .product-toggle span {
        font-size: 0.875rem;
        color: var(--text-secondary);
    }

    /* Image Preview */
    .image-preview {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 1rem;
    }

    .preview-item {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 0.5rem;
        overflow: hidden;
        border: 2px solid var(--border-color);
    }

    .preview-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        background: var(--danger-color);
        color: white;
        border: none;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .remove-image:hover {
        background: #c53030;
    }

    /* Form Sections */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--primary-color);
        display: inline-block;
    }

    /* Switch */
    .switch {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }

    input:checked+.slider {
        background-color: var(--success-color);
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .content-header {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .header-actions {
            display: flex;
            gap: 0.5rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .modal-content {
            margin: 1rem;
            max-width: calc(100vw - 2rem);
        }

        .form-section>div[style*="grid-template-columns"] {
            grid-template-columns: 1fr !important;
        }
    }
</style>