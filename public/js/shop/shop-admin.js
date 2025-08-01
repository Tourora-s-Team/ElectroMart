// Shop Admin JavaScript

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

// Global variables
let currentChart = null;

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    initializeShopAdmin();
});

function initializeShopAdmin() {
    // Initialize sidebar toggle
    initializeSidebar();

    // Initialize dropdowns
    initializeDropdowns();

    // Initialize notifications
    initializeNotifications();

    // Initialize toast messages
    initializeToasts();

    // Initialize forms
    initializeForms();

    // Initialize charts if they exist
    initializeCharts();

    // Initialize modals
    initializeModals();

    // Initialize file uploads
    initializeFileUploads();
}

// Initialize dropdowns
function initializeDropdowns() {
    // Notification dropdown
    const notificationToggle = document.getElementById('notificationToggle');
    const notificationMenu = document.getElementById('notificationMenu');

    if (notificationToggle && notificationMenu) {
        notificationToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            notificationMenu.classList.toggle('show');
        });
    }
}

// Initialize notifications
function initializeNotifications() {
    // Mark all as read button
    const markAllReadBtn = document.querySelector('.mark-all-read');
    if (markAllReadBtn) {
        markAllReadBtn.addEventListener('click', function () {
            // Mark all notifications as read
            fetch('/electromart/public/shop/api/notifications/mark-all-read', {
                method: 'POST',
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
                    if (data.success) {
                        // Update UI
                        const unreadItems = document.querySelectorAll('.notification-item.unread');
                        unreadItems.forEach(item => {
                            item.classList.remove('unread');
                        });

                        // Update count
                        const countElement = document.querySelector('.notification-count');
                        if (countElement) {
                            countElement.style.display = 'none';
                        }

                        showToast('Đã đánh dấu tất cả thông báo là đã đọc', 'success');
                    } else {
                        showToast(data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error marking notifications as read:', error);
                    showToast('Có lỗi xảy ra khi cập nhật thông báo', 'error');
                });
        });
    }
}

// Sidebar functionality
function initializeSidebar() {
    const toggleBtn = document.getElementById('sidebarToggle');
    const mobileToggleBtn = document.getElementById('mobileSidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    // Desktop sidebar toggle
    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('collapsed');
        });
    }

    // Mobile sidebar toggle
    if (mobileToggleBtn && sidebar && overlay) {
        mobileToggleBtn.addEventListener('click', function () {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Close sidebar when clicking overlay
        overlay.addEventListener('click', function () {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }

    // Auto-collapse sidebar on mobile when navigating
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('open');
                if (overlay) {
                    overlay.classList.remove('active');
                }
                document.body.style.overflow = '';
            }
        });
    });
}

// Toast messages
function initializeToasts() {
    const toasts = document.querySelectorAll('.toast');
    toasts.forEach(toast => {
        // Auto hide after 5 seconds
        setTimeout(() => {
            hideToast(toast);
        }, 5000);

        // Allow manual close
        toast.addEventListener('click', () => {
            hideToast(toast);
        });
    });
}

function hideToast(toast) {
    toast.style.animation = 'slideOut 0.3s ease forwards';
    setTimeout(() => {
        if (toast.parentNode) {
            toast.parentNode.removeChild(toast);
        }
    }, 300);
}

function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
    toast.innerHTML = `
        <i class="fas ${icon}"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        hideToast(toast);
    }, 5000);
}

// Form handling
function initializeForms() {
    // Handle form submissions with loading state
    const forms = document.querySelectorAll('form[data-async]');
    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Đang xử lý...';
            }
        });
    });

    // Auto-resize textareas
    const textareas = document.querySelectorAll('.form-textarea');
    textareas.forEach(textarea => {
        textarea.addEventListener('input', function () {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
}

// Chart functionality
function initializeCharts() {
    // Revenue chart
    const revenueChartCanvas = document.getElementById('revenueChart');
    if (revenueChartCanvas) {
        initializeRevenueChart();
    }
}

function initializeRevenueChart() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    const chartData = window.chartData || [];

    currentChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'],
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: chartData,
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function (value) {
                            return formatCurrency(value);
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            tooltips: {
                callbacks: {
                    label: function (context) {
                        return 'Doanh thu: ' + formatCurrency(context.parsed.y);
                    }
                }
            }
        }
    });
}

function updateChart(year) {
    if (!currentChart) return;

    fetch(`/electromart/public/shop/finance/chart-data?year=${year}`)
        .then(response => response.json())
        .then(data => {
            currentChart.data.datasets[0].data = data;
            currentChart.update();
        })
        .catch(error => {
            console.error('Error updating chart:', error);
            showToast('Có lỗi khi cập nhật biểu đồ', 'error');
        });
}

// Modal functionality
function initializeModals() {
    // Close modals when clicking outside
    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('modal')) {
            closeModal(e.target);
        }
    });

    // Close modals with close button
    const closeButtons = document.querySelectorAll('.modal-close');
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const modal = btn.closest('.modal');
            if (modal) {
                closeModal(modal);
            }
        });
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.modal[style*="flex"]');
            if (openModal) {
                closeModal(openModal);
            }
        }
    });
}

function openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeModal(modal) {
    if (typeof modal === 'string') {
        modal = document.getElementById(modal);
    }
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';

        // Reset forms in modal
        const form = modal.querySelector('form');
        if (form) {
            form.reset();
        }
    }
}

// File upload functionality
function initializeFileUploads() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    fileInputs.forEach(input => {
        input.addEventListener('change', function () {
            handleFileSelection(this);
        });
    });

    // Drag and drop
    const dropZones = document.querySelectorAll('.image-upload');
    dropZones.forEach(zone => {
        zone.addEventListener('dragover', function (e) {
            e.preventDefault();
            this.classList.add('drag-over');
        });

        zone.addEventListener('dragleave', function () {
            this.classList.remove('drag-over');
        });

        zone.addEventListener('drop', function (e) {
            e.preventDefault();
            this.classList.remove('drag-over');

            const fileInput = this.querySelector('input[type="file"]');
            if (fileInput) {
                fileInput.files = e.dataTransfer.files;
                handleFileSelection(fileInput);
            }
        });
    });
}

function handleFileSelection(input) {
    const files = input.files;
    const previewContainer = input.closest('.form-group').querySelector('.image-preview');

    if (previewContainer) {
        previewContainer.innerHTML = '';

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
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
}

// Product management functions
function editProduct(productId) {
    // Load product data via AJAX
    fetch(`/electromart/public/shop/products/edit/${productId}`, {
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

                // Set modal title and button text for editing
                const modalTitle = document.getElementById('productModalTitle');
                const submitText = document.getElementById('productSubmitText');
                if (modalTitle) modalTitle.textContent = 'Chỉnh sửa sản phẩm';
                if (submitText) submitText.textContent = 'Cập nhật sản phẩm';

                // Populate form fields
                const productIdInput = document.getElementById('productId');
                const productNameInput = document.getElementById('productName');
                const productBrandInput = document.getElementById('productBrand');
                const productDescInput = document.getElementById('productDescription');
                const productPriceInput = document.getElementById('productPrice');
                const productStockInput = document.getElementById('productStock');
                const productCategoryInput = document.getElementById('productCategory');
                const productActiveInput = document.getElementById('productActive');

                if (productIdInput) productIdInput.value = product.ProductID;
                if (productNameInput) productNameInput.value = product.ProductName;
                if (productBrandInput) productBrandInput.value = product.Brand;
                if (productDescInput) productDescInput.value = product.Description || '';
                if (productPriceInput) productPriceInput.value = product.Price;
                if (productStockInput) productStockInput.value = product.StockQuantity;
                if (productCategoryInput) productCategoryInput.value = product.CategoryID;
                if (productActiveInput) productActiveInput.checked = product.IsActive == 1;

                // Display existing images
                if (data.images && data.images.length > 0) {
                    const imagePreview = document.getElementById('imagePreview');
                    if (imagePreview) {
                        imagePreview.innerHTML = data.images.map(img => `
                            <div class="preview-item existing-image">
                                <img src="${getImageUrl(img.ImageURL)}" alt="Product Image">
                                <button type="button" class="remove-image" onclick="removeExistingImage(${img.ImageID})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        `).join('');
                    }
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

function addProduct() {
    // Reset form for adding new product
    const modalTitle = document.getElementById('productModalTitle');
    const submitText = document.getElementById('productSubmitText');
    if (modalTitle) modalTitle.textContent = 'Thêm sản phẩm mới';
    if (submitText) submitText.textContent = 'Thêm sản phẩm';

    // Clear all form fields
    const productIdInput = document.getElementById('productId');
    const productNameInput = document.getElementById('productName');
    const productBrandInput = document.getElementById('productBrand');
    const productDescInput = document.getElementById('productDescription');
    const productPriceInput = document.getElementById('productPrice');
    const productStockInput = document.getElementById('productStock');
    const productCategoryInput = document.getElementById('productCategory');
    const productActiveInput = document.getElementById('productActive');

    if (productIdInput) productIdInput.value = '';
    if (productNameInput) productNameInput.value = '';
    if (productBrandInput) productBrandInput.value = '';
    if (productDescInput) productDescInput.value = '';
    if (productPriceInput) productPriceInput.value = '';
    if (productStockInput) productStockInput.value = '';
    if (productCategoryInput) productCategoryInput.value = '';
    if (productActiveInput) productActiveInput.checked = true;

    // Clear image preview
    const imagePreview = document.getElementById('imagePreview');
    if (imagePreview) {
        imagePreview.innerHTML = '';
    }

    openModal('productModal');
}

function removeExistingImage(imageId) {
    if (confirm('Bạn có chắc chắn muốn xóa hình ảnh này?')) {
        fetch('/electromart/public/shop/products/remove-image', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: `imageId=${imageId}`
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
                    // Remove the image preview element
                    const imageElement = document.querySelector(`button[onclick="removeExistingImage(${imageId})"]`).closest('.preview-item');
                    if (imageElement) {
                        imageElement.remove();
                    }
                    showToast('Đã xóa hình ảnh thành công', 'success');
                } else {
                    showToast(data.message || 'Không thể xóa hình ảnh', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi xóa hình ảnh', 'error');
            });
    }
}

function toggleProductStatus(productId, currentStatus) {
    const newStatus = currentStatus === '1' ? '0' : '1';
    const statusText = newStatus === '1' ? 'kích hoạt' : 'ngừng bán';

    if (confirm(`Bạn có chắc chắn muốn ${statusText} sản phẩm này?`)) {
        showLoading();

        fetch('/electromart/public/shop/products/toggle-status', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: `productID=${productId}&status=${newStatus}`
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
                hideLoading();
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                hideLoading();
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi cập nhật trạng thái sản phẩm', 'error');
            });
    }
}

function deleteProduct(productId, productName) {
    if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${productName}"? Hành động này không thể hoàn tác.`)) {
        showLoading();

        window.location.href = `/electromart/public/shop/products/delete/${productId}`;
    }
}

// Bank account management
function editBankAccount(accountId) {
    // Implementation for editing bank account
    openModal('bankAccountModal');

    // Load account data and populate form
    // This would typically fetch data via AJAX
}

function deleteBankAccount(accountId, bankName) {
    if (confirm(`Bạn có chắc chắn muốn xóa tài khoản ${bankName}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.style.display = 'none';

        form.innerHTML = `
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="BankAccountID" value="${accountId}">
        `;

        document.body.appendChild(form);
        form.submit();
    }
}

function setDefaultBankAccount(accountId) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.style.display = 'none';

    form.innerHTML = `
        <input type="hidden" name="action" value="set_default">
        <input type="hidden" name="BankAccountID" value="${accountId}">
    `;

    document.body.appendChild(form);
    form.submit();
}

// Order functions
function viewOrderDetail(orderId) {
    window.location.href = `/electromart/public/shop/orders/view/${orderId}`;
}

function updateOrderStatus(orderId, currentStatus) {
    const statusOptions = {
        'Pending': 'Processing',
        'Processing': 'Shipped',
        'Shipped': 'Completed'
    };

    const nextStatus = statusOptions[currentStatus];
    if (nextStatus) {
        if (confirm(`Cập nhật trạng thái đơn hàng thành "${nextStatus}"?`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.style.display = 'none';

            form.innerHTML = `<input type="hidden" name="status" value="${nextStatus}">`;

            document.body.appendChild(form);
            form.submit();
        }
    }
}

// Search functions
function searchOrders() {
    const searchInput = document.getElementById('orderSearch');
    if (searchInput && searchInput.value.trim()) {
        window.location.href = `/electromart/public/shop/orders/search?q=${encodeURIComponent(searchInput.value.trim())}`;
    }
}

function searchProducts() {
    const searchInput = document.getElementById('productSearch');
    const statusFilter = document.getElementById('statusFilter');

    let url = '/electromart/public/shop/products?';
    const params = [];

    if (searchInput && searchInput.value.trim()) {
        params.push(`search=${encodeURIComponent(searchInput.value.trim())}`);
    }

    if (statusFilter && statusFilter.value !== '') {
        params.push(`status=${statusFilter.value}`);
    }

    window.location.href = url + params.join('&');
}

// Utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function formatNumber(number) {
    return new Intl.NumberFormat('vi-VN').format(number);
}

function showLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function confirmDelete(message, callback) {
    if (confirm(message || 'Bạn có chắc chắn muốn xóa?')) {
        if (typeof callback === 'function') {
            callback();
        }
        return true;
    }
    return false;
}

// Filter functions
function applyDateFilter() {
    const fromDate = document.getElementById('fromDate');
    const toDate = document.getElementById('toDate');
    const statusFilter = document.getElementById('statusFilter');

    let url = window.location.pathname + '?';
    const params = [];

    if (fromDate && fromDate.value) {
        params.push(`fromDate=${fromDate.value}`);
    }

    if (toDate && toDate.value) {
        params.push(`toDate=${toDate.value}`);
    }

    if (statusFilter && statusFilter.value) {
        params.push(`status=${statusFilter.value}`);
    }

    window.location.href = url + params.join('&');
}

function resetFilters() {
    const inputs = document.querySelectorAll('.filter-section input, .filter-section select');
    inputs.forEach(input => {
        if (input.type === 'select-one') {
            input.selectedIndex = 0;
        } else {
            input.value = '';
        }
    });

    window.location.href = window.location.pathname;
}

// Export functions
function exportData(type) {
    showLoading();

    let url = '';
    switch (type) {
        case 'orders':
            url = '/electromart/public/shop/orders/export';
            break;
        case 'products':
            url = '/electromart/public/shop/products/export';
            break;
        case 'revenue':
            url = '/electromart/public/shop/finance/export';
            break;
    }

    if (url) {
        window.location.href = url;
        setTimeout(hideLoading, 2000);
    } else {
        hideLoading();
    }
}

// Auto-save draft functionality
function initializeAutoSave() {
    const forms = document.querySelectorAll('form[data-autosave]');
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        inputs.forEach(input => {
            input.addEventListener('input', debounce(() => {
                saveDraft(form, input);
            }, 1000));
        });
    });
}

function saveDraft(form, input) {
    const formId = form.getAttribute('data-autosave');
    const draftData = localStorage.getItem(`draft_${formId}`) || '{}';
    const draft = JSON.parse(draftData);

    draft[input.name] = input.value;
    localStorage.setItem(`draft_${formId}`, JSON.stringify(draft));

    // Show subtle indication that draft is saved
    showDraftSavedIndicator();
}

function loadDraft(formId) {
    const draftData = localStorage.getItem(`draft_${formId}`);
    if (draftData) {
        const draft = JSON.parse(draftData);
        const form = document.querySelector(`form[data-autosave="${formId}"]`);

        if (form) {
            Object.keys(draft).forEach(key => {
                const input = form.querySelector(`[name="${key}"]`);
                if (input && !input.value) {
                    input.value = draft[key];
                }
            });
        }
    }
}

function clearDraft(formId) {
    localStorage.removeItem(`draft_${formId}`);
}

function showDraftSavedIndicator() {
    // Show a subtle indicator that draft is saved
    const indicator = document.createElement('div');
    indicator.innerHTML = '<i class="fas fa-check"></i> Đã lưu tự động';
    indicator.className = 'draft-saved-indicator';
    indicator.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #10b981;
        color: white;
        padding: 8px 12px;
        border-radius: 4px;
        font-size: 12px;
        z-index: 9999;
        opacity: 0;
        transition: opacity 0.3s ease;
    `;

    document.body.appendChild(indicator);

    setTimeout(() => {
        indicator.style.opacity = '1';
    }, 10);

    setTimeout(() => {
        indicator.style.opacity = '0';
        setTimeout(() => {
            if (indicator.parentNode) {
                indicator.parentNode.removeChild(indicator);
            }
        }, 300);
    }, 2000);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Initialize auto-save when DOM is loaded
document.addEventListener('DOMContentLoaded', function () {
    initializeAutoSave();
});

// Global error handler
window.addEventListener('error', function (e) {
    console.error('Global error:', e.error);
    showToast('Có lỗi xảy ra trong hệ thống', 'error');
});

// Global unhandled promise rejection handler
window.addEventListener('unhandledrejection', function (e) {
    console.error('Unhandled promise rejection:', e.reason);
    showToast('Có lỗi xảy ra khi xử lý dữ liệu', 'error');
});

// Add CSS for draft indicator
const style = document.createElement('style');
style.textContent = `
    .drag-over {
        border-color: var(--primary-color) !important;
        background-color: rgba(37, 99, 235, 0.05);
    }
    
    .image-upload.drag-over {
        transform: scale(1.02);
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
