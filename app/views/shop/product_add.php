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
                action="https://electromart-t8ou8.ondigitalocean.app/public/shop/products/add"
                enctype="multipart/form-data" data-async>
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
                                accept=".jpg,.jpeg,.png,.gif,image/jpeg,image/jpg,image/png,image/gif"
                                style="display: none;">
                        </div>

                        <div class="form-help" style="margin-top: 0.5rem;">
                            <strong>Lưu ý:</strong> Chọn tối đa 5 hình ảnh.
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
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="button" class="btn btn-outline"
                        onclick="window.location.href='https://electromart-t8ou8.ondigitalocean.app/public/shop/products'">
                        <i class="fas fa-times"></i>
                        Hủy
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
        grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
        max-width: 100%;
    }

    .preview-item {
        position: relative;
        display: inline-block;
    }

    .image-preview img {
        width: 100%;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e5e7eb;
        transition: border-color 0.3s ease;
    }

    .image-preview img:hover {
        border-color: #3b82f6;
    }

    .remove-preview {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #ef4444;
        color: white;
        border: none;
        font-size: 14px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        transition: background-color 0.3s ease;
    }

    .remove-preview:hover {
        background: #dc2626;
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
    // Form validation and submission
    document.getElementById('addProductForm').addEventListener('submit', function (e) {
        const price = document.getElementById('productPrice').value;
        const stock = document.getElementById('productStock').value;
        const productName = document.getElementById('productName').value.trim();
        const brand = document.getElementById('productBrand').value.trim();
        const categoryId = document.getElementById('productCategory').value;

        if (!productName) {
            e.preventDefault();
            showToast('Vui lòng nhập tên sản phẩm', 'error');
            return;
        }

        if (!brand) {
            e.preventDefault();
            showToast('Vui lòng nhập thương hiệu', 'error');
            return;
        }

        if (!categoryId) {
            e.preventDefault();
            showToast('Vui lòng chọn danh mục', 'error');
            return;
        }

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

        const fileInput = document.getElementById('productImages');
        const files = fileInput.files;

        if (files.length === 0) {
            const confirmContinue = confirm('Bạn chưa chọn hình ảnh nào. Bạn có muốn tiếp tục không?');
            if (!confirmContinue) {
                e.preventDefault();
                return;
            }
        }

        if (files.length > 5) {
            e.preventDefault();
            showToast('Chỉ được chọn tối đa 5 hình ảnh', 'error');
            return;
        }

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            if (file.size > 2 * 1024 * 1024) {
                e.preventDefault();
                showToast(`Hình ảnh "${file.name}" vượt quá 2MB`, 'error');
                return;
            }

            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(file.type)) {
                e.preventDefault();
                showToast(`Định dạng file "${file.name}" không được hỗ trợ`, 'error');
                return;
            }
        }

        // Cho submit bình thường (form HTML)
    });



    // Global variables
    let isProcessingFiles = false;
    let fileInputInitialized = false;
    let currentFiles = []; // Mảng lưu trữ các file hiện tại

    // Image preview functionality - ĐÃ SỬA
    function handleProductImageSelection(files, triggerSource = 'manual') {
        if (isProcessingFiles) {
            console.log('Already processing files, skipping...');
            return;
        }
        isProcessingFiles = true;

        console.log(`Processing ${files.length} files from ${triggerSource}`);

        const previewContainer = document.getElementById('imagePreview');
        const fileInput = document.getElementById('productImages');

        // Clear current files và preview khi là lựa chọn mới
        if (triggerSource === 'file-input' || triggerSource === 'drag-drop') {
            currentFiles = [];
            previewContainer.innerHTML = '';
            console.log('Cleared previous files and preview');
        }

        // Validate maximum 5 images
        if (currentFiles.length + files.length > 5) {
            showToast('Chỉ được chọn tối đa 5 hình ảnh', 'error');
            fileInput.value = '';
            isProcessingFiles = false;
            return;
        }

        // Process each file sequentially to avoid duplicates
        const filesToProcess = Array.from(files);
        let processedCount = 0;

        filesToProcess.forEach((file, index) => {
            // Validate file
            if (file.size > 2 * 1024 * 1024) {
                showToast(`Hình ảnh "${file.name}" vượt quá 2MB`, 'error');
                processedCount++;
                if (processedCount === filesToProcess.length) {
                    updateFileInput();
                }
                return;
            }

            if (!file.type.match('image.*')) {
                showToast(`File "${file.name}" không phải là hình ảnh`, 'error');
                processedCount++;
                if (processedCount === filesToProcess.length) {
                    updateFileInput();
                }
                return;
            }

            // Add to current files
            currentFiles.push(file);

            // Create preview
            const reader = new FileReader();
            reader.onload = function (e) {
                const previewItem = document.createElement('div');
                previewItem.className = 'preview-item';
                previewItem.dataset.index = currentFiles.length - 1;
                previewItem.dataset.fileName = file.name;

                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}" 
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                    <button type="button" class="remove-preview" 
                            onclick="removeProductImagePreview(${currentFiles.length - 1})"
                            style="position: absolute; top: -8px; right: -8px; width: 20px; height: 20px; 
                                   border-radius: 50%; background: #ef4444; color: white; border: none; 
                                   font-size: 12px; cursor: pointer; display: flex; align-items: center; 
                                   justify-content: center;">×</button>
                `;

                previewContainer.appendChild(previewItem);
                console.log(`Added preview for ${file.name}`);

                processedCount++;
                if (processedCount === filesToProcess.length) {
                    updateFileInput();
                }
            };
            reader.readAsDataURL(file);
        });

        function updateFileInput() {
            // Update file input
            const dataTransfer = new DataTransfer();
            currentFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;

            isProcessingFiles = false;
            console.log('File processing completed');
        }
    }

    // Remove image preview - ĐÃ SỬA
    function removeProductImagePreview(index) {
        const previewContainer = document.getElementById('imagePreview');
        const fileInput = document.getElementById('productImages');

        console.log(`Removing image at index ${index}`);

        // Remove file from currentFiles
        currentFiles.splice(index, 1);

        // Clear and rebuild preview
        previewContainer.innerHTML = '';
        currentFiles.forEach((file, newIndex) => {
            const previewItem = document.createElement('div');
            previewItem.className = 'preview-item';
            previewItem.dataset.index = newIndex;
            previewItem.dataset.fileName = file.name;

            const reader = new FileReader();
            reader.onload = function (e) {
                previewItem.innerHTML = `
                    <img src="${e.target.result}" alt="${file.name}"
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; border: 2px solid #e5e7eb;">
                    <button type="button" class="remove-preview" 
                            onclick="removeProductImagePreview(${newIndex})"
                            style="position: absolute; top: -8px; right: -8px; width: 20px; height: 20px; 
                                   border-radius: 50%; background: #ef4444; color: white; border: none; 
                                   font-size: 12px; cursor: pointer; display: flex; align-items: center; 
                                   justify-content: center;">×</button>
                `;
                previewContainer.appendChild(previewItem);
            };
            reader.readAsDataURL(file);
        });

        // Update file input
        const dataTransfer = new DataTransfer();
        currentFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;

        console.log(`Updated file input with ${currentFiles.length} files`);
    }

    // Drag and drop initialization - ĐÃ SỬA
    function initializeDragAndDrop() {
        const uploadArea = document.querySelector('.image-upload');
        const fileInput = document.getElementById('productImages');

        if (!uploadArea || !fileInput || fileInputInitialized) return;

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop area
        ['dragenter', 'dragover'].forEach(eventName => {
            uploadArea.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            uploadArea.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        uploadArea.addEventListener('drop', handleDrop, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight() {
            uploadArea.style.borderColor = '#3b82f6';
            uploadArea.style.backgroundColor = '#eff6ff';
        }

        function unhighlight() {
            uploadArea.style.borderColor = '#d1d5db';
            uploadArea.style.backgroundColor = '#f9fafb';
        }

        function handleDrop(e) {
            console.log('Files dropped');
            const dt = e.dataTransfer;
            const files = dt.files;
            handleProductImageSelection(files, 'drag-drop');
        }

        fileInputInitialized = true;
    }

    // File input change handler - ĐÃ SỬA
    function handleProductFileInputChange(e) {
        console.log('Product file input change event triggered');
        const files = e.target.files;
        if (files.length > 0) {
            handleProductImageSelection(files, 'file-input');
        }
    }

    // DOMContentLoaded initialization - ĐÃ SỬA
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('productImages');

        console.log('Initializing product image upload...');

        // Initialize file input event
        if (fileInput) {
            // Remove any existing listeners first
            fileInput.removeEventListener('change', handleProductFileInputChange);
            fileInput.addEventListener('change', handleProductFileInputChange);
            console.log('Product file input event listener added');
        }

        // Initialize drag and drop
        initializeDragAndDrop();
    });

</script>