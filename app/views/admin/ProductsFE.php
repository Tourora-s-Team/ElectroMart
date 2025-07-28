<div class="products-management-page">
    <!-- Search and Sort Section -->

    <div class="search-sort-section">
        <div class="header-actions">
            <button class="btn btn-success" onclick="showAddProductModal()">
                <i class="fas fa-plus"></i> Thêm sản phẩm
            </button>
            <button class="btn btn-warning" onclick="exportProducts()">
                <i class="fas fa-download"></i> Xuất file TXT
            </button>
        </div>
        <div class="search-container">
            <input type="text" id="searchInput" placeholder="Tìm kiếm sản phẩm theo tên..."
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <button class="btn btn-primary" onclick="searchProducts()">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </div>

        <div class="sort-container">
            <select id="sortBy" onchange="sortProducts()">
                <option value="StockQuantity" <?= ($_GET['sort_by'] ?? '') === 'StockQuantity' ? 'selected' : '' ?>>
                    Sắp xếp theo số lượng tồn kho
                </option>
                <option value="ProductName" <?= ($_GET['sort_by'] ?? '') === 'ProductName' ? 'selected' : '' ?>>
                    Sắp xếp theo tên sản phẩm
                </option>
                <option value="Price" <?= ($_GET['sort_by'] ?? '') === 'Price' ? 'selected' : '' ?>>
                    Sắp xếp theo giá
                </option>
                <option value="Brand" <?= ($_GET['sort_by'] ?? '') === 'Brand' ? 'selected' : '' ?>>
                    Sắp xếp theo thương hiệu
                </option>
            </select>

            <select id="sortOrder" onchange="sortProducts()">
                <option value="ASC" <?= ($_GET['sort_order'] ?? '') === 'ASC' ? 'selected' : '' ?>>Tăng dần</option>
                <option value="DESC" <?= ($_GET['sort_order'] ?? '') === 'DESC' ? 'selected' : '' ?>>Giảm dần</option>
            </select>
        </div>
    </div>
</div>
<!-- Products Table -->
<div class="table-wrapper">
    <table class="orders-table" id="ordersTable">
        <thead>
            <tr>
                <th>Ảnh sản phẩm</th>
                <th>Tên sản phẩm</th>
                <th>Loại sản phẩm</th>
                <th>Số lượng</th>
                <th>Thương hiệu</th>
                <th>Giá sản phẩm</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="ordersTableBody">
            <?php if (isset($products) && !empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td class="product-image">
                            <?php if (!empty($product['ImageURL'])): ?>
                                <img src="/electromart/<?= htmlspecialchars(str_replace('./', '', $product['ImageURL'])) ?>"
                                    alt="<?= htmlspecialchars($product['ProductName']) ?>"
                                    onerror="this.src='../public/images/no-image.png'">
                            <?php else: ?>
                                <div class="no-image">Không có ảnh</div>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['ProductName']) ?></td>
                        <td><?= htmlspecialchars($product['ProductType']) ?></td>
                        <td>
                            <span class="stock-badge <?= $product['StockQuantity'] < 10 ? 'low-stock' : 'in-stock' ?>">
                                <?= number_format($product['StockQuantity']) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($product['Brand']) ?></td>
                        <td class="price"><?= number_format($product['Price'], 0, ',', '.') ?> VNĐ</td>
                        <td class="edit">
                            <button onclick='editProduct(<?php echo json_encode($product); ?>)'>✏️Sửa</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="no-data">
                    <td colspan="7" class="text-center">
                        <div class="no-data-content">
                            <i class="fas fa-shopping-cart no-data-icon"></i>
                            <p class="no-data-text">Không tìm thấy đơn hàng nào</p>
                            <p class="no-data-subtext">Thử điều chỉnh bộ lọc để xem thêm kết quả</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- Statistics -->
<div class="products-stats">
    <div class="stat-item">
        <i class="fas fa-box"></i>
        <span>Tổng số sản phẩm: <strong><?= number_format($totalProducts ?? 0) ?></strong></span>
    </div>
</div>
</div>

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Thêm sản phẩm mới</h2>
            <span class="close" onclick="closeAddProductModal()">&times;</span>
        </div>
        <form id="addProductForm">
            <input type="hidden" id="product_id" name="product_id">
            <div class="form-group">
                <label for="product_name">Tên sản phẩm *</label>
                <input type="text" id="product_name" name="ProductName" required>
            </div>

            <div class="form-group">
                <label for="product_type">Loại sản phẩm *</label>
                <input type="text" id="product_type" name="Description" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="stock_quantity">Số lượng *</label>
                    <input type="number" id="stock_quantity" name="StockQuantity" min="0" required>
                </div>

                <div class="form-group">
                    <label for="price">Giá sản phẩm *</label>
                    <input type="number" id="price" name="Price" min="0" step="1000" required>
                </div>
            </div>

            <div class="form-group">
                <label for="brand">Thương hiệu *</label>
                <input type="text" id="brand" name="Brand" required>
            </div>

            <div class="form-group">
                <label for="image_url">URL ảnh sản phẩm</label>
                <input type="text" id="image_url" name="ImageURL" placeholder="./public/images/electro_mart/....png">
            </div>
            <select name="ShopID" id="ShopIDSelect" required onchange="updateSelectedShopID()">
                <option value="">-- Chọn cửa hàng --</option>
                <option value="1">Shop 1</option>
                <option value="2">Shop 2</option>
                <option value="3">Shop 3</option>
                <option value="4">Shop 4</option>
                <option value="5">Shop 5</option>
                <option value="6">Shop 6</option>
                <option value="7">Shop 7</option>
                <option value="8">Shop 8</option>
                <option value="9">Shop 9</option>
                <option value="10">Shop 10</option>
            </select>

            <select name="CategoryID" required>
                <option value="">-- Chọn danh mục --</option>
                <option value="1">Điện thoại</option>
                <option value="2">Laptop</option>
                <option value="3">Phụ kiện</option>
                <option value="4">Đồ gia dụng</option>
                <option value="5">Thiết bị âm thanh</option>
                <option value="6">Camera</option>
                <option value="7">Đồng hồ thông minh</option>
                <option value="8">Thiết bị gaming</option>
                <option value="9">Smart Home</option>
                <option value="10">Thiết bị văn phòng</option>

            </select>



            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Thêm sản phẩm
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeAddProductModal()">
                    Hủy
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Sản phẩm -->
<div id="editProductModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Sửa sản phẩm</h2>
            <span class="close" onclick="closeEditProductModal()">&times;</span>
        </div>
        <form id="editProductForm">
            <input type="hidden" id="product_id1" name="ProductID">
            <div class="form-group">
                <label for="product_name">Tên sản phẩm *</label>
                <input type="text" id="editProductName" name="ProductName" required>
            </div>

            <div class="form-group">
                <label for="product_type">Loại sản phẩm *</label>
                <input type="text" id="editProductDescription" name="Description" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="stock_quantity">Số lượng *</label>
                    <input type="number" id="editProductStockQuantity" name="StockQuantity" min="0" required>
                </div>

                <div class="form-group">
                    <label for="price">Giá sản phẩm *</label>
                    <input type="number" id="editProductPrice" name="Price" min="0" step="1000" required>
                </div>
            </div>

            <div class="form-group">
                <label for="brand">Thương hiệu *</label>
                <input type="text" id="editProductBrand" name="Brand" required>
            </div>

            <div class="form-group">
                <label for="image_url">URL ảnh sản phẩm</label>
                <input type="text" id="editProductImageURL" name="ImageURL" placeholder="./public/images/electro_mart/....png">
            </div>
            <select name="ShopID" id="ShopIDSelect" required>
                <option value="">-- Chọn cửa hàng --</option>
                <option value="1">Shop 1</option>
                <option value="2">Shop 2</option>
                <option value="3">Shop 3</option>
                <option value="4">Shop 4</option>
                <option value="5">Shop 5</option>
                <option value="6">Shop 6</option>
                <option value="7">Shop 7</option>
                <option value="8">Shop 8</option>
                <option value="9">Shop 9</option>
                <option value="10">Shop 10</option>
            </select>

            <select name="CategoryID" required>
                <option value="">-- Chọn danh mục --</option>
                <option value="1">Điện thoại</option>
                <option value="2">Laptop</option>
                <option value="3">Phụ kiện</option>
                <option value="4">Đồ gia dụng</option>
                <option value="5">Thiết bị âm thanh</option>
                <option value="6">Camera</option>
                <option value="7">Đồng hồ thông minh</option>
                <option value="8">Thiết bị gaming</option>
                <option value="9">Smart Home</option>
                <option value="10">Thiết bị văn phòng</option>

            </select>



            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Lưu sản phẩm
                </button>
                <button type="button" class="btn btn-secondary" onclick="closeEditProductModal()">
                    Hủy
                </button>
            </div>
        </form>
    </div>
</div>


<script>
    function showAddProductModal() {
        document.getElementById('addProductModal').style.display = 'block';
    }

    function closeAddProductModal() {
        document.getElementById('addProductModal').style.display = 'none';
        document.getElementById('addProductForm').reset();
    }


    function searchProducts() {
        const search = document.getElementById('searchInput').value;
        const sortBy = document.getElementById('sortBy').value;
        const sortOrder = document.getElementById('sortOrder').value;

        window.location.href = `?admin/products&search=${encodeURIComponent(search)}&sort_by=${sortBy}&sort_order=${sortOrder}`;
    }

    function sortProducts() {
        const search = document.getElementById('searchInput').value;
        const sortBy = document.getElementById('sortBy').value;
        const sortOrder = document.getElementById('sortOrder').value;

        window.location.href = `?admin/products&search=${encodeURIComponent(search)}&sort_by=${sortBy}&sort_order=${sortOrder}`;
    }

    function exportProducts() {
        window.location.href = '/electromart/public/admin/products/export-txt';
    }

    // Handle form submission
    document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        fetch('products/add', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    closeAddProductModal();
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi thêm sản phẩm!');
            });
    });

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('addProductModal');
        if (event.target == modal) {
            closeAddProductModal();
        }
    }

    // Search on Enter key
    document.getElementById('searchInput').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            searchProducts();
        }
    });
</script>
<script src="/ElectroMart/public/js/AdminJs/Orders.js"></script>
<script>
    function deleteProduct(id) {
        if (confirm(`Bạn có chắc muốn xoá sản phẩm ID: ${id}?`)) {
            fetch(`/electromart/public/admin/products/delete/${id}`, {
                    method: 'GET'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message || "Xoá thành công!");
                        location.reload();
                    } else {
                        alert(data.message || "Xoá thất bại!");
                    }
                })
                .catch(error => {
                    console.error("Lỗi khi xoá:", error);
                    alert("Đã xảy ra lỗi khi xoá sản phẩm.");
                });
        }
    }
</script>
<style>
    .products-management-page {
        padding: 20px;
    }

    .search-sort-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }

    .header-actions {
        display: flex;
        margin-left: 820px;
    }

    .search-container {
        display: flex;
        gap: 10px;
        flex: 1;
        max-width: 400px;
    }

    .search-container input {
        flex: 1;
        padding: 10px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 14px;
    }

    .sort-container {
        display: flex;
        gap: 10px;
    }

    .sort-container select {
        padding: 10px;
        border: 2px solid #e1e5e9;
        border-radius: 8px;
        font-size: 14px;
    }

    .product-image {
        width: 80px;
        text-align: center;
    }

    .product-image img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #e1e5e9;
    }

    .no-image {
        width: 60px;
        height: 60px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        color: #6c757d;
        text-align: center;
    }

    .price {
        font-weight: 600;
        color: #27ae60;
    }

    .products-stats {
        background: white;
        padding: 15px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        margin-top: 20px;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #2c3e50;
    }

    .stat-item i {
        color: #667eea;
        font-size: 18px;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 12px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .modal-header {
        padding: 20px;
        border-bottom: 1px solid #e1e5e9;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h2 {
        margin: 0;
        color: #2c3e50;
    }

    .close {
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        color: #aaa;
    }

    .close:hover {
        color: #000;
    }

    #addProductForm {
        padding: 20px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    @media (max-width: 768px) {
        .search-sort-section {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container {
            max-width: none;
        }

        .form-row {
            grid-template-columns: 1fr;
        }
    }
</style>