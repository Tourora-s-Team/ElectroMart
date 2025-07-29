// Orders-specific JavaScript functionality

// Order management functions
window.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addProductForm");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        fetch("/electromart/public/admin/products/update", {
            method: "POST",
            body: formData,
        })
            .then(res => res.json())
            .then(data => {
                alert(data.success ? "Cập nhật thành công!" : "Thất bại!");
            })
            .catch(err => {
                console.error("Lỗi:", err);
            });
    });
});
document.getElementById("addProductForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch("/electromart/public/admin/products/update", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert("Cập nhật sản phẩm thành công!");
                closeAddProductModal();
            } else {
                alert("Cập nhật thất bại!");
            }
        });
});
class OrderManager {
    constructor() {
        this.orders = [];
        this.filteredOrders = [];
        this.currentSort = { column: null, direction: 'asc' };
        this.init();
    }

    init() {
        this.loadOrdersFromDOM();
        this.setupEventListeners();
        this.initializeFilters();
    }


    setupEventListeners() {
        // Modal events
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('modal')) {
                this.closeModal(e.target);
            }
        });

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                this.closeAllModals();
            }
        });

        // Table row click events
        const tableRows = document.querySelectorAll('.order-row');
        tableRows.forEach(row => {
            row.addEventListener('click', (e) => {
                if (!e.target.closest('.action-buttons')) {
                    const orderId = row.dataset.orderId;
                    this.viewOrder(orderId);
                }
            });
        });
    }

    loadOrdersFromDOM() {
        // Load orders from the existing table in DOM
        const tableRows = document.querySelectorAll('.order-row');
        this.orders = Array.from(tableRows).map(row => {
            return {
                OrderID: row.querySelector('.order-id .font-medium').textContent.trim(),
                OrderDate: row.querySelector('.timestamp').dataset.date,
                Status: row.querySelector('.status-badge').textContent.trim(),
                ShippingFee: this.parseCurrency(row.querySelector('.shipping-fee .currency').textContent),
                TotalAmount: this.parseCurrency(row.querySelector('.total-amount .currency').textContent),
                UserID: row.querySelector('.user-id span').textContent.trim()
            };
        });

        this.filteredOrders = [...this.orders];
    }

    // Order action methods
    viewOrder(orderId) {
        const order = this.orders.find(o => o.OrderID === orderId);
        if (!order) return;

        // Create and show order details modal
        this.showOrderDetailsModal(order);
    }

    editOrder(orderId) {
        const order = this.orders.find(o => o.OrderID === orderId);
        if (!order) return;

        // Create and show edit order modal
        this.showEditOrderModal(order);
    }

    deleteOrder(orderId) {
        if (!confirm(`Bạn có chắc chắn muốn xóa đơn hàng ${orderId}?`)) {
            return;
        }

        // In real implementation, this would make an AJAX call
        console.log('Deleting order:', orderId);

        // Remove from arrays
        this.orders = this.orders.filter(o => o.OrderID !== orderId);
        this.filteredOrders = this.filteredOrders.filter(o => o.OrderID !== orderId);

        // Remove from DOM
        const row = document.querySelector(`[data-order-id="${orderId}"]`);
        if (row) {
            row.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                row.remove();
                this.updateStats();
            }, 300);
        }

        // Show success message
        this.showSuccessMessage(`Đã xóa đơn hàng ${orderId} thành công`);
    }




    saveOrderChanges(event, orderId) {
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form);
        const updatedData = {
            Status: formData.get('status'),
            ShippingFee: parseFloat(formData.get('shippingFee')),
            TotalAmount: parseFloat(formData.get('totalAmount'))
        };

        // Update order in arrays
        const orderIndex = this.orders.findIndex(o => o.OrderID === orderId);
        if (orderIndex !== -1) {
            this.orders[orderIndex] = { ...this.orders[orderIndex], ...updatedData };
        }

        const filteredIndex = this.filteredOrders.findIndex(o => o.OrderID === orderId);
        if (filteredIndex !== -1) {
            this.filteredOrders[filteredIndex] = { ...this.filteredOrders[filteredIndex], ...updatedData };
        }

        // Update DOM
        this.updateOrderRowInDOM(orderId, updatedData);
        this.updateStats();
        this.closeAllModals();
        this.showSuccessMessage(`Đã cập nhật đơn hàng ${orderId} thành công`);
    }

    updateOrderRowInDOM(orderId, updatedData) {
        const row = document.querySelector(`[data-order-id="${orderId}"]`);
        if (!row) return;

        // Update status
        const statusBadge = row.querySelector('.status-badge');
        statusBadge.textContent = updatedData.Status;
        statusBadge.className = `status-badge status-${updatedData.Status.toLowerCase()}`;

        // Update shipping fee
        const shippingFee = row.querySelector('.shipping-fee .currency');
        shippingFee.textContent = this.formatCurrency(updatedData.ShippingFee);

        // Update total amount
        const totalAmount = row.querySelector('.total-amount .currency');
        totalAmount.textContent = this.formatCurrency(updatedData.TotalAmount);

        // Add update animation
        row.style.animation = 'pulse 0.5s ease';
        setTimeout(() => {
            row.style.animation = '';
        }, 500);
    }

    updateStats() {
        const totalOrders = document.getElementById('totalOrders');
        const totalRevenue = document.getElementById('totalRevenue');
        const completedOrders = document.getElementById('completedOrders');
        const pendingOrders = document.getElementById('pendingOrders');

        if (totalOrders) {
            totalOrders.textContent = this.filteredOrders.length;
        }

        if (totalRevenue) {
            const revenue = this.filteredOrders.reduce((sum, order) => sum + order.TotalAmount, 0);
            totalRevenue.textContent = this.formatCurrency(revenue);
        }

        if (completedOrders) {
            const completed = this.filteredOrders.filter(order => order.Status === 'Completed').length;
            completedOrders.textContent = completed;
        }

        if (pendingOrders) {
            const pending = this.filteredOrders.filter(order =>
                order.Status === 'Pending' || order.Status === 'Processing'
            ).length;
            pendingOrders.textContent = pending;
        }
    }

    createModal(title, content) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h3>${title}</h3>
                    <button class="modal-close" onclick="orderManager.closeModal(this.closest('.modal'))">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    ${content}
                </div>
            </div>
        `;
        return modal;
    }

    closeModal(modal) {
        if (modal) {
            modal.style.animation = 'modalSlideOut 0.3s ease';
            setTimeout(() => {
                modal.remove();
                document.body.style.overflow = 'auto';
            }, 300);
        }
    }

    closeAllModals() {
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => this.closeModal(modal));
    }

    showSuccessMessage(message) {
        const notification = document.createElement('div');
        notification.className = 'success-notification';
        notification.innerHTML = `
            <i class="fas fa-check-circle"></i>
            ${message}
        `;

        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: #16a34a;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 3000;
            animation: slideInRight 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        `;

        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }



    initializeFilters() {
        // Set default date range (last 30 days)
        const today = new Date();
        const thirtyDaysAgo = new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000);

        const fromDateInput = document.getElementById('fromDate');
        const toDateInput = document.getElementById('toDate');

        if (fromDateInput && !fromDateInput.value) {
            fromDateInput.value = thirtyDaysAgo.toISOString().split('T')[0];
        }

        if (toDateInput && !toDateInput.value) {
            toDateInput.value = today.toISOString().split('T')[0];
        }
    }

    // Utility methods
    formatCurrency(amount) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(amount);
    }

    formatDate(date) {
        return new Intl.DateTimeFormat('vi-VN', {
            year: 'numeric',
            month: '2-digit',
            day: '2-digit'
        }).format(date);
    }

    parseCurrency(currencyString) {
        return parseFloat(currencyString.replace(/[^\d]/g, ''));
    }

    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    debounce(func, wait) {
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
}
function deleteProduct(id) {
    if (confirm("Bạn có chắc chắn muốn xoá sản phẩm này?")) {
        fetch(`/electromart/public/admin/products/delete/${id}`, {
            method: 'POST', // ✅ sửa từ GET thành POST
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                alert("Xoá thành công!");
                location.reload();
            } else {
                alert("Xoá thất bại. Mã lỗi: " + response.status);
            }
        })
        .catch(error => {
            console.error("Lỗi:", error);
        });
    }
}



function showEditProductModal(product) {
    // Gán dữ liệu vào form
    document.getElementById('editProductName').value = product.ProductName;
    document.getElementById('editProductDescription').value = product.Description;
    document.getElementById('editProductStockQuantity').value = product.StockQuantity;
    document.getElementById('editProductPrice').value = product.Price;
    document.getElementById('editProductBrand').value = product.Brand;
    document.getElementById('editProductImageURL').value = product.ImageURL;
    console.log(document.querySelectorAll('#product_id').length);
    // Gán ProductID
    document.getElementById('product_id1').value = product.ProductID;
    
    // Mở modal
    document.getElementById('editProductModal').style.display = 'block';
}

    
    function lockProduct(productId) {
        if (confirm("Bạn có muốn khoá sản phẩm không?")) {
            fetch(`/electromart/public/admin/products/lock?id=${productId}`, {
                method: 'POST'
            })
            .then(response => {
                if (response.ok) {
                    alert("Sản phẩm đã bị khoá.");
                    location.reload();
                } else {
                    alert("Có lỗi xảy ra khi khoá sản phẩm.");
                }
            });
        }
    }


function closeEditProductModal() {
    document.getElementById('editProductModal').style.display = 'none';
}
document.getElementById("editProductForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    fetch("/electromart/public/admin/products/update", {
        method: "POST",
        body: formData,
    })
        .then((res) => res.json())

        .then((data) => {
            if (data.success) {
                alert("Cập nhật sản phẩm thành công!");
                closeEditProductModal();
                // Gọi lại load sản phẩm nếu cần
            } else {
                alert("Lỗi khi gửi dữ liệu!");
            }
        })
        .catch((err) => {
            console.error(err);
            alert("Lỗi kết nối tới server!");
        });
});

function editProduct(product) {
    if (parseInt(product.IsActive) === 0) {
        alert("Sản phẩm đã bị khoá và không thể chỉnh sửa.");
        return;
    }
    showEditProductModal(product);
}



document.getElementById("addProductForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    fetch("/electromart/public/admin/products/save", {
        method: "POST",
        body: formData
    }).then(() => location.reload());
});


// Initialize order manager when DOM is loaded
let orderManager;
document.addEventListener('DOMContentLoaded', function () {
    orderManager = new OrderManager();
});

// Global functions for backward compatibility
function viewOrder(orderId) {
    if (orderManager) {
        orderManager.viewOrder(orderId);
    }
}

function editOrder(orderId) {
    if (orderManager) {
        orderManager.editOrder(orderId);
    }
}

function deleteOrder(orderId) {
    if (orderManager) {
        orderManager.deleteOrder(orderId);
    }
}

function openAddOrderModal() {
    const modal = document.getElementById('addOrderModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeAddOrderModal() {
    const modal = document.getElementById('addOrderModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}
// Main JavaScript functionality for ElectroMart Admin

// Global variables
let currentOrders = [];
let filteredOrders = [];

// Initialize application
document.addEventListener('DOMContentLoaded', function () {
    initializeApp();
});

function initializeApp() {
    // Load initial data
    loadOrdersFromTable();

    // Set up event listeners
    setupEventListeners();

    // Initialize components
    initializeComponents();
}


function setupEventListeners() {
    // Filter form submission
    const filterForm = document.getElementById('orderFilterForm');
    if (filterForm) {
        filterForm.addEventListener('submit', handleFilterSubmit);
    }

    // Real-time filter updates
    const filterInputs = document.querySelectorAll('.filter-select, .filter-input');
    filterInputs.forEach(input => {
        input.addEventListener('change', debounce(applyClientSideFilters, 300));
    });

    // Search input real-time filtering
    const userIdFilter = document.getElementById('userIdFilter');
    if (userIdFilter) {
        userIdFilter.addEventListener('input', debounce(applyClientSideFilters, 300));
    }

    // Mobile sidebar toggle
    setupMobileSidebar();
}


function setupMobileSidebar() {
    // Add mobile menu button if not exists
    if (window.innerWidth <= 1024) {
        const header = document.querySelector('.content-header');
        if (header && !document.querySelector('.mobile-menu-btn')) {
            const menuBtn = document.createElement('button');
            menuBtn.className = 'mobile-menu-btn';
            menuBtn.innerHTML = '<i class="fas fa-bars"></i>';
            menuBtn.onclick = toggleSidebar;
            header.querySelector('.header-content').prepend(menuBtn);
        }
    }
}

function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open');
}

function initializeComponents() {
    // Initialize tooltips
    initializeTooltips();

    // Set current date as default for date filters
    setDefaultDates();

    // Initialize table sorting (if needed)
    initializeTableSorting();
}

// Filter functionality
function handleFilterSubmit(event) {
    // Let the form submit naturally to server
    // This will reload the page with filtered results
}

function applyClientSideFilters() {
    // This function applies filters on the client side for better UX
    const statusFilter = document.getElementById('statusFilter').value;
    const fromDate = document.getElementById('fromDate').value;
    const toDate = document.getElementById('toDate').value;
    const userIdFilter = document.getElementById('userIdFilter').value.toLowerCase();

    filteredOrders = currentOrders.filter(order => {
        // Status filter
        if (statusFilter && order.Status !== statusFilter) {
            return false;
        }

        // Date range filter
        if (fromDate && new Date(order.OrderDate) < new Date(fromDate)) {
            return false;
        }

        if (toDate && new Date(order.OrderDate) > new Date(toDate)) {
            return false;
        }

        // User ID filter
        if (userIdFilter && !order.UserID.toLowerCase().includes(userIdFilter)) {
            return false;
        }

        return true;
    });

    updateTableDisplay();
    updateStats();
}

function updateTableDisplay() {
    const tableBody = document.getElementById('ordersTableBody');
    const orderCount = document.getElementById('orderCount');

    if (!tableBody) return;

    // Update order count
    if (orderCount) {
        orderCount.textContent = filteredOrders.length;
    }

    // Show loading state
    tableBody.classList.add('loading');

    setTimeout(() => {
        // Clear existing rows
        tableBody.innerHTML = '';

        if (filteredOrders.length === 0) {
            tableBody.innerHTML = `
                <tr class="no-data">
                    <td colspan="7" class="text-center">
                        <div class="no-data-content">
                            <i class="fas fa-shopping-cart no-data-icon"></i>
                            <p class="no-data-text">Không tìm thấy đơn hàng nào</p>
                            <p class="no-data-subtext">Thử điều chỉnh bộ lọc để xem thêm kết quả</p>
                        </div>
                    </td>
                </tr>
            `;
        } else {
            // Add filtered orders to table
            filteredOrders.forEach(order => {
                const row = createOrderRow(order);
                tableBody.appendChild(row);
            });
        }

        tableBody.classList.remove('loading');
        initializeTooltips(); // Reinitialize tooltips for new elements
    }, 200);
}



function updateStats() {
    const totalOrders = document.getElementById('totalOrders');
    const totalRevenue = document.getElementById('totalRevenue');
    const completedOrders = document.getElementById('completedOrders');
    const pendingOrders = document.getElementById('pendingOrders');

    if (totalOrders) {
        totalOrders.textContent = filteredOrders.length;
    }

    if (totalRevenue) {
        const revenue = filteredOrders.reduce((sum, order) => sum + parseFloat(order.TotalAmount), 0);
        totalRevenue.textContent = formatCurrency(revenue);
    }

    if (completedOrders) {
        const completed = filteredOrders.filter(order => order.Status === 'Completed').length;
        completedOrders.textContent = completed;
    }

    if (pendingOrders) {
        const pending = filteredOrders.filter(order =>
            order.Status === 'Pending' || order.Status === 'Processing'
        ).length;
        pendingOrders.textContent = pending;
    }
}

// Order actions
function viewOrder(orderId) {
    console.log('Viewing order:', orderId);
    showNotification('Xem chi tiết đơn hàng: ' + orderId, 'info');
}

function editOrder(orderId) {
    console.log('Editing order:', orderId);
    showNotification('Chỉnh sửa đơn hàng: ' + orderId, 'info');
}

function openAddOrderModal() {
    const modal = document.getElementById('addOrderModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
}

function closeAddOrderModal() {
    const modal = document.getElementById('addOrderModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

// Utility functions
function loadOrdersFromTable() {
    // Extract order data from the existing table
    const tableRows = document.querySelectorAll('.order-row');
    currentOrders = Array.from(tableRows).map(row => {
        return {
            OrderID: row.querySelector('.order-id .font-medium').textContent.trim(),
            OrderDate: row.querySelector('.timestamp').dataset.date,
            Status: row.querySelector('.status-badge').textContent.trim(),
            ShippingFee: parseCurrency(row.querySelector('.shipping-fee .currency').textContent),
            TotalAmount: parseCurrency(row.querySelector('.total-amount .currency').textContent),
            UserID: row.querySelector('.user-id span').textContent.trim()
        };
    });

    filteredOrders = [...currentOrders];
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN', {
        style: 'currency',
        currency: 'VND'
    }).format(amount);
}

function parseCurrency(currencyString) {
    return parseFloat(currencyString.replace(/[^\d]/g, ''));
}

function formatDate(date) {
    return new Intl.DateTimeFormat('vi-VN', {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit'
    }).format(date);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
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

function setDefaultDates() {
    const today = new Date();
    const oneWeekAgo = new Date(today.getTime() - 7 * 24 * 60 * 60 * 1000);

    const fromDateInput = document.getElementById('fromDate');
    const toDateInput = document.getElementById('toDate');

    if (fromDateInput && !fromDateInput.value) {
        fromDateInput.value = oneWeekAgo.toISOString().split('T')[0];
    }

    if (toDateInput && !toDateInput.value) {
        toDateInput.value = today.toISOString().split('T')[0];
    }
}

function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(event) {
    const tooltip = document.createElement('div');
    tooltip.className = 'tooltip';
    tooltip.textContent = event.target.dataset.tooltip;
    document.body.appendChild(tooltip);

    const rect = event.target.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';
}

function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

function initializeTableSorting() {
    const headers = document.querySelectorAll('.orders-table th');
    headers.forEach((header, index) => {
        if (index < 6) { // Don't make actions column sortable
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => sortTable(index));
        }
    });
}

function sortTable(columnIndex) {
    console.log('Sorting by column:', columnIndex);
    // TODO: Implement table sorting functionality
}


function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
        ${message}
    `;

    // Add notification styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#16a34a' : type === 'error' ? '#dc2626' : '#3b82f6'};
        color: white;
        padding: 12px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        z-index: 3000;
        animation: slideInRight 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    `;

    document.body.appendChild(notification);

    // Remove notification after 3 seconds
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.95);
        }
    }

    .mobile-menu-btn {
        display: none;
        background: none;
        border: none;
        font-size: 20px;
        color: #374151;
        cursor: pointer;
        padding: 8px;
        border-radius: 4px;
        transition: background-color 0.2s ease;
    }

    .mobile-menu-btn:hover {
        background-color: #f3f4f6;
    }

    @media (max-width: 1024px) {
        .mobile-menu-btn {
            display: block;
        }
    }
`;
document.head.appendChild(style);


// Add additional CSS animations
const additionalStyle = document.createElement('style');
additionalStyle.textContent = `
    @keyframes modalSlideOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-50px);
        }
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.02);
            background-color: #f0f9ff;
        }
        100% {
            transform: scale(1);
        }
    }

    .order-details .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .order-details .detail-row:last-child {
        border-bottom: none;
    }

    .order-details .detail-label {
        font-weight: 600;
        color: #374151;
        min-width: 120px;
    }

    .order-details .detail-value {
        color: #111827;
        text-align: right;
    }

    .edit-order-form .form-group {
        margin-bottom: 16px;
    }

    .edit-order-form label {
        display: block;
        font-weight: 600;
        color: #374151;
        margin-bottom: 6px;
        font-size: 14px;
    }

    .edit-order-form input,
    .edit-order-form select {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #d1d5db;
        border-radius: 6px;
        font-size: 14px;
        transition: border-color 0.2s ease;
        font-family: 'Roboto', sans-serif;
    }

    .edit-order-form input:focus,
    .edit-order-form select:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .form-actions {
        display: flex;
        gap: 12px;
        justify-content: flex-end;
        margin-top: 24px;
        padding-top: 16px;
        border-top: 1px solid #e5e7eb;
    }

    .btn-secondary {
        background-color: #6b7280;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #4b5563;
        transform: translateY(-1px);
    }

    .order-row {
        cursor: pointer;
    }

    .order-row:hover {
        background-color: #f8fafc !important;
    }
`;
document.head.appendChild(additionalStyle);