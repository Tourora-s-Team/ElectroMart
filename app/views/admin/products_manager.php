<link rel="stylesheet" href="/electromart/public/css/admin/StyleProducs.css">
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
                            <button type="button" onclick='editProduct(<?= json_encode($product, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>)'>✏️Sửa</button>
                            <button type="button" onclick="deleteProduct(<?= $product['ProductID'] ?>)">🗑️Xoá</button>
                            <button onclick="lockProduct(<?= $product['ProductID'] ?>)"> <i class="fas fa-lock" title="Đã khóa" style="color:#dc2626;"></i>Khoá sản phẩm
                            </button>
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
            <input type="hidden" id="isactive" name="IsActive">

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
<script src="/electromart/public/js/adminJs/Producs.js"></script>