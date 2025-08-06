<?php require_once ROOT_PATH . '/core/ImageHelper.php'; ?>
<!-- Order Detail -->
<div class="order-detail">
    <!-- Back Button -->
    <div style="margin-bottom: 1.5rem;">
        <a href="https://electromart-t8ou8.ondigitalocean.app/public/shop/orders" class="btn btn-outline">
            <i class="fas fa-arrow-left"></i>
            Quay lại danh sách
        </a>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <!-- Order Information -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Thông tin đơn hàng #<?php echo $order['order']['OrderID']; ?></h3>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <span class="status-badge status-<?php echo strtolower($order['order']['Status']); ?>">
                        <?php echo $order['order']['Status']; ?>
                    </span>
                    <?php if (in_array($order['order']['Status'], ['Pending', 'Processing'])): ?>
                        <button type="button" class="btn btn-primary btn-sm" onclick="openStatusUpdateModal()">
                            <i class="fas fa-edit"></i>
                            Cập nhật trạng thái
                        </button>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card-body">
                <!-- Basic Order Info -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-bottom: 2rem;">
                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">
                            Thông tin cơ bản
                        </h4>
                        <div style="space-y: 0.5rem;">
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Ngày đặt hàng:</span>
                                <div class="font-medium">
                                    <?php echo date('d/m/Y H:i', strtotime($order['order']['OrderDate'])); ?>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Phí vận chuyển:</span>
                                <div class="font-medium"><?php echo number_format($order['order']['ShippingFee']); ?>₫
                                </div>
                            </div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Tổng tiền:</span>
                                <div class="font-medium" style="color: var(--primary-color); font-size: 1.125rem;">
                                    <?php echo number_format($order['order']['TotalAmount']); ?>₫
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">
                            Thông tin thanh toán
                        </h4>
                        <div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Phương thức:</span>
                                <div class="font-medium"><?php echo $order['order']['PaymentMethod'] ?? 'Chưa rõ'; ?>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Số tiền thanh
                                    toán:</span>
                                <div class="font-medium">
                                    <?php echo number_format($order['order']['PaymentAmount'] ?? 0); ?>₫
                                </div>
                            </div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Trạng thái thanh
                                    toán:</span>
                                <span
                                    class="status-badge status-<?php echo strtolower($order['order']['PaymentStatus'] ?? 'pending'); ?>">
                                    <?php echo $order['order']['PaymentStatus'] ?? 'Chưa thanh toán'; ?>
                                </span>
                            </div>
                            <?php if (!empty($order['order']['TransactionCode'])): ?>
                                <div style="margin-bottom: 0.5rem;">
                                    <span style="color: var(--text-secondary); font-size: 0.875rem;">Mã giao dịch:</span>
                                    <div class="font-medium"><?php echo $order['order']['TransactionCode']; ?></div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div>
                    <h4 style="font-weight: 600; margin-bottom: 1rem; color: var(--text-primary);">
                        Sản phẩm trong đơn hàng
                    </h4>

                    <?php if (!empty($order['items'])): ?>
                        <div class="table-container">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Đơn giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subtotal = 0;
                                    foreach ($order['items'] as $item):
                                        $itemTotal = $item['Quantity'] * $item['UnitPrice'];
                                        $subtotal += $itemTotal;
                                        ?>
                                        <tr>
                                            <td>
                                                <div style="display: flex; align-items: center; gap: 1rem;">
                                                    <div style="width: 60px; height: 60px; flex-shrink: 0;">
                                                        <?php if (!empty($item['ImageURL'])): ?>
                                                            <img src="<?php echo ImageHelper::getImageUrlWithFallback($item['ImageURL']); ?>"
                                                                alt="<?php echo htmlspecialchars($item['ProductName']); ?>"
                                                                style="width: 100%; height: 100%; object-fit: cover; border-radius: 0.375rem; border: 1px solid var(--border-color);">
                                                        <?php else: ?>
                                                            <div
                                                                style="width: 100%; height: 100%; background-color: var(--background-color); border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border-color);">
                                                                <i class="fas fa-image" style="color: var(--text-light);"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div>
                                                        <div class="font-medium">
                                                            <?php echo htmlspecialchars($item['ProductName']); ?>
                                                        </div>
                                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                                            Thương hiệu: <?php echo htmlspecialchars($item['Brand']); ?>
                                                        </div>
                                                        <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                                            ID: <?php echo $item['ProductID']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="font-medium"><?php echo number_format($item['UnitPrice']); ?>₫</td>
                                            <td class="font-medium"><?php echo $item['Quantity']; ?></td>
                                            <td class="font-medium"><?php echo number_format($itemTotal); ?>₫</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr style="border-top: 2px solid var(--border-color);">
                                        <td colspan="3" class="font-medium">Tạm tính:</td>
                                        <td class="font-medium"><?php echo number_format($subtotal); ?>₫</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="font-medium">Phí vận chuyển:</td>
                                        <td class="font-medium">
                                            <?php echo number_format($order['order']['ShippingFee']); ?>₫
                                        </td>
                                    </tr>
                                    <tr style="border-top: 1px solid var(--border-color);">
                                        <td colspan="3" class="font-medium" style="font-size: 1.125rem;">Tổng cộng:</td>
                                        <td class="font-medium" style="color: var(--primary-color); font-size: 1.125rem;">
                                            <?php echo number_format($order['order']['TotalAmount']); ?>₫
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-box"></i>
                            <h3>Không có sản phẩm</h3>
                            <p>Không tìm thấy sản phẩm nào trong đơn hàng này</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Customer & Shipping Info -->
        <div>
            <!-- Customer Information -->
            <div class="card" style="margin-bottom: 1.5rem;">
                <div class="card-header">
                    <h3 class="card-title">Thông tin khách hàng</h3>
                </div>
                <div class="card-body">
                    <div style="text-align: center; margin-bottom: 1rem;">
                        <div
                            style="width: 60px; height: 60px; background-color: var(--primary-color); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; margin: 0 auto 0.5rem;">
                            <i class="fas fa-user"></i>
                        </div>
                        <h4 style="font-weight: 600; margin-bottom: 0.25rem;">
                            <?php echo htmlspecialchars($order['order']['CustomerName']); ?>
                        </h4>
                        <p style="color: var(--text-secondary); font-size: 0.875rem;">ID:
                            <?php echo $order['order']['UserID']; ?>
                        </p>
                    </div>

                    <div>
                        <div style="margin-bottom: 0.75rem;">
                            <span style="color: var(--text-secondary); font-size: 0.875rem;">Giới tính:</span>
                            <div>
                                <?php echo ($order['order']['Gender'] == 'M') ? 'Nam' : (($order['order']['Gender'] == 'F') ? 'Nữ' : 'Không xác định'); ?>
                            </div>
                        </div>

                        <?php if (!empty($order['order']['BirthDate'])): ?>
                            <div style="margin-bottom: 0.75rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Ngày sinh:</span>
                                <div><?php echo date('d/m/Y', strtotime($order['order']['BirthDate'])); ?></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Shipping Information -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Thông tin giao hàng</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($order['order']['ReceiverName'])): ?>
                        <div style="margin-bottom: 1rem;">
                            <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Người nhận</h4>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Tên:</span>
                                <div class="font-medium"><?php echo htmlspecialchars($order['order']['ReceiverName']); ?>
                                </div>
                            </div>
                            <div style="margin-bottom: 0.5rem;">
                                <span style="color: var(--text-secondary); font-size: 0.875rem;">Số điện thoại:</span>
                                <div class="font-medium"><?php echo htmlspecialchars($order['order']['ContactNumber']); ?>
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 style="font-weight: 600; margin-bottom: 0.5rem;">Địa chỉ giao hàng</h4>
                            <div style="line-height: 1.6;">
                                <?php
                                $address = [];
                                if (!empty($order['order']['AddressDetail']))
                                    $address[] = $order['order']['AddressDetail'];
                                if (!empty($order['order']['Street']))
                                    $address[] = $order['order']['Street'];
                                if (!empty($order['order']['Ward']))
                                    $address[] = $order['order']['Ward'];
                                if (!empty($order['order']['City']))
                                    $address[] = $order['order']['City'];
                                if (!empty($order['order']['Country']))
                                    $address[] = $order['order']['Country'];
                                echo htmlspecialchars(implode(', ', $address));
                                ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="fas fa-map-marker-alt"></i>
                            <h3>Chưa có thông tin giao hàng</h3>
                            <p>Thông tin người nhận chưa được cập nhật</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusUpdateModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Cập nhật trạng thái đơn hàng</h3>
            <button type="button" class="modal-close" onclick="closeModal('statusUpdateModal')">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form method="POST">
            <div class="modal-body">
                <div class="form-group">
                    <label for="newStatus" class="form-label">Trạng thái mới</label>
                    <select id="newStatus" name="status" class="form-select" required>
                        <option value="">Chọn trạng thái</option>
                        <?php if ($order['order']['Status'] == 'Pending'): ?>
                            <option value="Processing">Đang xử lý</option>
                            <option value="Cancelled">Hủy đơn</option>
                        <?php elseif ($order['order']['Status'] == 'Processing'): ?>
                            <option value="Shipped">Đã giao hàng</option>
                            <option value="Cancelled">Hủy đơn</option>
                        <?php elseif ($order['order']['Status'] == 'Shipped'): ?>
                            <option value="Completed">Hoàn thành</option>
                        <?php endif; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Trạng thái hiện tại</label>
                    <div style="padding: 0.75rem; background-color: var(--background-color); border-radius: 0.375rem;">
                        <span class="status-badge status-<?php echo strtolower($order['order']['Status']); ?>">
                            <?php echo $order['order']['Status']; ?>
                        </span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="statusNote" class="form-label">Ghi chú (tùy chọn)</label>
                    <textarea id="statusNote" name="note" class="form-textarea" rows="3"
                        placeholder="Thêm ghi chú về việc cập nhật trạng thái..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline" onclick="closeModal('statusUpdateModal')">
                    Hủy
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i>
                    Cập nhật trạng thái
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openStatusUpdateModal() {
        openModal('statusUpdateModal');
    }

    // Print order functionality
    function printOrder() {
        window.print();
    }

    // Export order to PDF (placeholder)
    function exportToPDF() {
        showToast('Chức năng xuất PDF sẽ được phát triển trong phiên bản tới', 'info');
    }

    // Add print styles
    const printStyles = `
    @media print {
        .sidebar, .content-header, .btn, .modal {
            display: none !important;
        }
        
        .main-content {
            margin-left: 0 !important;
        }
        
        .page-content {
            padding: 0 !important;
        }
        
        .card {
            box-shadow: none !important;
            border: 1px solid #000 !important;
        }
        
        body {
            color: #000 !important;
            background: white !important;
        }
    }
`;

    const styleSheet = document.createElement('style');
    styleSheet.textContent = printStyles;
    document.head.appendChild(styleSheet);

    // Add quick actions
    document.addEventListener('DOMContentLoaded', function () {
        // Add floating action button for quick actions
        const fab = document.createElement('div');
        fab.innerHTML = `
        <div style="position: fixed; bottom: 2rem; right: 2rem; z-index: 1000;">
            <div class="fab-menu" style="display: none; position: absolute; bottom: 4rem; right: 0; background: white; border-radius: 0.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15); min-width: 150px;">
                <button type="button" class="fab-action" onclick="printOrder()" style="display: flex; align-items: center; gap: 0.5rem; width: 100%; padding: 0.75rem 1rem; border: none; background: none; text-align: left; cursor: pointer;">
                    <i class="fas fa-print"></i>
                    In đơn hàng
                </button>
                <button type="button" class="fab-action" onclick="exportToPDF()" style="display: flex; align-items: center; gap: 0.5rem; width: 100%; padding: 0.75rem 1rem; border: none; background: none; text-align: left; cursor: pointer;">
                    <i class="fas fa-file-pdf"></i>
                    Xuất PDF
                </button>
            </div>
            <button type="button" class="fab-main btn btn-primary" style="width: 3.5rem; height: 3.5rem; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="fas fa-ellipsis-v"></i>
            </button>
        </div>
    `;

        if (window.innerWidth > 768) {
            document.body.appendChild(fab);

            const fabMain = fab.querySelector('.fab-main');
            const fabMenu = fab.querySelector('.fab-menu');

            fabMain.addEventListener('click', function (e) {
                e.stopPropagation();
                fabMenu.style.display = fabMenu.style.display === 'block' ? 'none' : 'block';
            });

            document.addEventListener('click', function () {
                fabMenu.style.display = 'none';
            });
        }
    });
</script>

<style>
    .fab-action:hover {
        background-color: var(--background-color) !important;
    }

    @media (max-width: 768px) {
        .order-detail>div:first-child {
            grid-template-columns: 1fr !important;
        }
    }
</style>