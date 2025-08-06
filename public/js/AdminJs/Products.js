// File: public/js/products.js

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
    window.location.href = 'https://electromart-t8ou8.ondigitalocean.app/public/admin/products/export-txt';
}

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('addProductForm');
    if (form) {
        form.addEventListener('submit', function (e) {
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
    }

    // Click outside modal
    window.onclick = function (event) {
        const modal = document.getElementById('addProductModal');
        if (event.target === modal) {
            closeAddProductModal();
        }
    }

    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                searchProducts();
            }
        });
    }
});

document.getElementById("addProductForm").addEventListener("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    fetch("https://electromart-t8ou8.ondigitalocean.app/public/admin/products/save", {
        method: "POST",
        body: formData
    }).then(() => location.reload());
});
window.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("addProductForm");
    if (!form) return;

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        fetch("https://electromart-t8ou8.ondigitalocean.app/public/admin/products/update", {
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
    fetch("https://electromart-t8ou8.ondigitalocean.app/public/admin/products/update", {
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
function deleteProduct(id) {
    if (confirm("Bạn có chắc chắn muốn xoá sản phẩm này?")) {
        fetch(`https://electromart-t8ou8.ondigitalocean.app/public/admin/products/delete/${id}`, {
            method: 'POST',
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
        fetch(`https://electromart-t8ou8.ondigitalocean.app/public/admin/products/lock?id=${productId}`, {
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

    fetch("https://electromart-t8ou8.ondigitalocean.app/public/admin/products/update", {
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
function toggleProductStatus(productID, isChecked) {

    const status = isChecked ? 1 : 0;

    fetch('https://electromart-t8ou8.ondigitalocean.app/public/admin/products/toggle-status/' + productID, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ is_active: status })
    })
        .then(async response => {
            if (!response.ok) {
                const text = await response.text();
                throw new Error(`HTTP ${response.status}: ${text}`);
            }
            location.reload();
        })
        .then(data => {
            if (!data.success) {
                alert('❌ ' + data.message);
                document.querySelector(`input[onchange*="${productID}"]`).checked = !isChecked;
            } else {
                console.log('✅ ' + data.message);

            }
        })

}

