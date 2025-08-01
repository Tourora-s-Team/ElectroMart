<!-- Add Product Page -->
<div class="product-add-page">
    <!-- Header -->
    <div class="content-header">
        <div>
            <h1 class="page-title">Thêm sản phẩm mới</h1>
            <p class="page-description">Thêm sản phẩm mới vào shop của bạn</p>
        </div>
        <div class="header-actions">
            <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/products" class="btn btn-outline">
                <i class="fas fa-arrow-left"></i>
                Quay lại
            </a>
        </div>
    </div>

    <!-- Add Product Form -->
    <div class="card">
        <div class="card-body">
            <form id="addProductForm" method="POST"
                action="https://electromart-t8ou8.ondigitalocean.app/public/shop/products/add" enctype="multipart/form-data"
                data-async>
                <!-- Basic Information -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Thông tin cơ bản
                    </h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="productName" class="form-label">Tên sản phẩm <span
                                    class="required">*</span></label>
                            <input type="text" id="productName" name="product_name" class="form-input" required
                                placeholder="Nhập tên sản phẩm">
                            <div class="form-help">Tên sản phẩm phải rõ ràng và dễ hiểu</div>
                        </div>

                        <div class="form-group">
                            <label for="productBrand" class="form-label">Thương hiệu <span
                                    class="required">*</span></label>
                            <input type="text" id="productBrand" name="brand" class="form-input" required
                                placeholder="Nhập thương hiệu">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="productDescription" class="form-label">Mô tả sản phẩm</label>
                        <textarea id="productDescription" name="description" class="form-textarea" rows="5"
                            placeholder="Nhập mô tả chi tiết về sản phẩm"></textarea>
                        <div class="form-help">Mô tả chi tiết sẽ giúp khách hàng hiểu rõ hơn về sản phẩm</div>
                    </div>
                </div>

                <!-- Pricing & Stock -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-dollar-sign"></i>
                        Giá cả & Kho hàng
                    </h4>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="productPrice" class="form-label">Giá bán <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="number" id="productPrice" name="price" class="form-input" min="0"
                                    step="1000" required placeholder="0">
                                <span class="input-suffix">VNĐ</span>
                            </div>
                            <div class="form-help">Giá bán sẽ hiển thị cho khách hàng</div>
                        </div>

                        <div class="form-group">
                            <label for="productStock" class="form-label">Số lượng tồn kho <span
                                    class="required">*</span></label>
                            <input type="number" id="productStock" name="stock_quantity" class="form-input" min="0"
                                required placeholder="0">
                            <div class="form-help">Số lượng sản phẩm hiện có trong kho</div>
                        </div>

                        <div class="form-group">
                            <label for="productCategory" class="form-label">Danh mục <span
                                    class="required">*</span></label>
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
                            <div class="form-help">Chọn danh mục phù hợp cho sản phẩm</div>
                        </div>
                    </div>
                </div>

                <!-- Images -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-images"></i>
                        Hình ảnh sản phẩm
                    </h4>

                    <div class="form-group">
                        <label for="productImages" class="form-label">Chọn hình ảnh sản phẩm</label>
                        <div class="image-upload" onclick="document.getElementById('productImages').click()">
                            <div class="upload-placeholder">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Kéo thả hình ảnh vào đây hoặc click để chọn</p>
                                <p class="upload-help">Định dạng: JPG, PNG, GIF. Kích thước tối đa: 2MB/ảnh. Tối đa 5
                                    ảnh.</p>
                            </div>
                            <input type="file" id="productImages" name="images[]" class="form-file-input" multiple
                                accept="image/*" style="display: none;">
                        </div>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="image-preview"></div>
                    </div>
                </div>

                <!-- Additional Options -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-cog"></i>
                        Tùy chọn khác
                    </h4>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="productActive" name="is_active" value="1" checked>
                                <span class="checkmark"></span>
                                <span class="checkbox-text">Sản phẩm đang được bán</span>
                            </label>
                            <div class="form-help">Bỏ chọn nếu bạn muốn lưu nháp sản phẩm</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox-group">
                            <label class="checkbox-label">
                                <input type="checkbox" id="productFeatured" name="is_featured" value="1">
                                <span class="checkmark"></span>
                                <span class="checkbox-text">Sản phẩm nổi bật</span>
                            </label>
                            <div class="form-help">Sản phẩm nổi bật sẽ được ưu tiên hiển thị</div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-outline"
                        onclick="window.location.href='https://electromart-t8ou8.ondigitalocean.app/public/shop/products'">
                        <i class="fas fa-times"></i>
                        Hủy
                    </button>
                    <button type="button" class="btn btn-secondary" onclick="saveDraft()">
                        <i class="fas fa-save"></i>
                        Lưu nháp
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus"></i>
                        Thêm sản phẩm
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="loading-overlay" style="display: none;">
    <div class="loading-spinner">
        <i class="fas fa-spinner fa-spin"></i>
        <p>Đang xử lý...</p>
    </div>
</div>

<style>
    /* Form Styles */
    .form-section {
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        color: #374151;
        font-size: 1.125rem;
        font-weight: 600;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .required {
        color: #ef4444;
    }

    .input-group {
        position: relative;
    }

    .input-suffix {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #6b7280;
        font-weight: 500;
    }

    .image-upload {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 3rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #f9fafb;
    }

    .image-upload:hover {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .upload-placeholder i {
        font-size: 3rem;
        color: #9ca3af;
        margin-bottom: 1rem;
    }

    .upload-placeholder p {
        margin: 0.5rem 0;
        color: #4b5563;
    }

    .upload-help {
        font-size: 0.875rem;
        color: #6b7280 !important;
    }

    .image-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .image-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
    }

    .checkbox-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .checkbox-text {
        font-weight: 500;
        color: #374151;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid #e5e7eb;
        margin-top: 2rem;
    }

    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .loading-spinner {
        background: white;
        padding: 2rem;
        border-radius: 8px;
        text-align: center;
    }

    .loading-spinner i {
        font-size: 2rem;
        color: #3b82f6;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-actions {
            flex-direction: column;
        }

        .header-actions {
            margin-top: 1rem;
        }
    }
</style>

<script>
    // Save draft functionality
    function saveDraft() {
        const form = document.getElementById('addProductForm');
        const formData = new FormData(form);

        // Remove is_active to save as draft
        formData.delete('is_active');
        formData.append('is_draft', '1');

        showLoading();

        fetch('https://electromart-t8ou8.ondigitalocean.app/public/shop/products/add', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                hideLoading();
                if (data.success) {
                    showToast('Đã lưu nháp sản phẩm', 'success');
                    setTimeout(() => {
                        window.location.href = 'https://electromart-t8ou8.ondigitalocean.app/public/shop/products';
                    }, 1000);
                } else {
                    showToast(data.message || 'Có lỗi xảy ra khi lưu nháp', 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi lưu nháp', 'error');
            });
    }

    // Form validation
    document.getElementById('addProductForm').addEventListener('submit', function (e) {
        const price = document.getElementById('productPrice').value;
        const stock = document.getElementById('productStock').value;

        if (parseInt(price) < 0) {
            e.preventDefault();
            showToast('Giá sản phẩm không thể âm', 'error');
            return;
        }

        if (parseInt(stock) < 0) {
            e.preventDefault();
            showToast('Số lượng tồn kho không thể âm', 'error');
            return;
        }
    });

    // Image preview functionality
    document.getElementById('productImages').addEventListener('change', function () {
        handleFileSelection(this);
    });

    function handleFileSelection(input) {
        const files = input.files;
        const previewContainer = document.getElementById('imagePreview');

        if (files.length > 5) {
            showToast('Chỉ được chọn tối đa 5 hình ảnh', 'error');
            input.value = '';
            return;
        }

        previewContainer.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (file.size > 2 * 1024 * 1024) {
                showToast(`Hình ảnh ${file.name} vượt quá 2MB`, 'error');
                continue;
            }

            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.alt = file.name;
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        }
    }
</script>