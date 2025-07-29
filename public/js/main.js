console.log('main.js đã được tải!');

// ElectroMart JavaScript.
//       Đảm bảo toàn bộ HTML đã tải xong trước khi JS thao tác với DOM
document.addEventListener('DOMContentLoaded', function () {

    // // Add to cart functionality
    // //      Lấy tất cả nút có class .add-to-cart-btn
    // //      Gắn click event để gọi addToCart(productId) — gửi POST lên /cart/add
    // const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    // addToCartButtons.forEach(button => {
    //     button.addEventListener('click', function (e) {
    //         console.log("Button clicked", this.dataset.productId); // Kiểm tra xem productId có được lấy đúng không (xem trong console F12)
    //         e.preventDefault();
    //         const productId = this.dataset.productId;
    //         addToCart(productId);
    //     });
    // });

    // // Cart quantity controls
    // //       Với mỗi nút .quantity-btn, đọc data-action (increase hoặc decrease)
    // //       Tìm input.quantity-input và dataset.itemId của sản phẩm
    // //       Tăng/giảm số lượng và gọi updateCartItem(itemId, quantity)
    // const quantityButtons = document.querySelectorAll('.quantity-btn');

    // quantityButtons.forEach(button => {
    //     button.addEventListener('click', function () {
    //         const action = this.dataset.action;
    //         const quantityInput = this.parentElement.querySelector('.quantity-input');
    //         const itemId = this.closest('.cart-item').dataset.itemId;

    //         let quantity = parseInt(quantityInput.value);

    //         if (action === 'increase') {
    //             quantity++;
    //         } else if (action === 'decrease' && quantity > 1) {
    //             quantity--;
    //         }

    //         quantityInput.value = quantity;
    //         updateCartItem(itemId, quantity);
    //     });
    // });

    // // Remove item buttons
    // //      Khi click vào nút xóa, xác nhận với confirm()
    // //      Gọi removeCartItem(itemId) để gửi POST /cart/remove
    // //      Nếu thành công, xóa element khỏi DOM + cập nhật lại hiển thị
    // const removeButtons = document.querySelectorAll('.remove-btn');

    // removeButtons.forEach(button => {
    //     button.addEventListener('click', function () {
    //         const itemId = this.dataset.itemId;
    //         removeCartItem(itemId);
    //     });
    // });


    // Search functionality
    //      Khi form được submit, kiểm tra input rỗng không
    //      Nếu rỗng, chặn submit + focus vào input
    const searchForm = document.querySelector('.search-box form');

    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            const searchInput = this.querySelector('input[name="q"]');
            if (!searchInput.value.trim()) {
                e.preventDefault();
                searchInput.focus();
            }
        });
    }

    // Sort functionality
    //       Khi select thay đổi, gọi sortProducts(sortValue)
    //       Sắp xếp .product-card trong .product-grid theo:
    //       price-asc: tăng dần
    //       price-desc: giảm dần
    //       rating: đánh giá cao
    const sortSelect = document.getElementById('sort-select');

    if (sortSelect) {
        sortSelect.addEventListener('change', function () {
            const sortValue = this.value;
            sortProducts(sortValue);
        });
    }

    // Update cart count
    // updateCartCount();
});

// // Add product to cart
// //       Dùng fetch để gửi dữ liệu FormData
// //       Gọi showNotification() nếu thành công hoặc lỗi
// function addToCart(productId, quantity = 1) {
//     const formData = new FormData();
//     formData.append('product_id', productId);
//     formData.append('quantity', quantity);

//     fetch('/electromart/public/cart/add', {
//         method: 'POST',
//         body: formData
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
//                 updateCartCount();
//             } else {
//                 showNotification(data.message || 'Có lỗi xảy ra!', 'error');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             showNotification('Có lỗi xảy ra!', 'error');
//         });

// }

// // Update cart item quantity
// //      Gửi POST /cart/update để cập nhật số lượng server-side
// //      Sau đó gọi updateCartDisplay() để cập nhật lại giao diện
// function updateCartItem(itemId, quantity) {
//     const formData = new FormData();
//     formData.append('cart_item_id', itemId);
//     formData.append('quantity', quantity);

//     fetch('/cart/update', {
//         method: 'POST',
//         body: formData
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 updateCartDisplay();
//             } else {
//                 showNotification(data.message || 'Có lỗi xảy ra!', 'error');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             showNotification('Có lỗi xảy ra!', 'error');
//         });
// }

// // Remove cart item
// function removeCartItem(itemId) {
//     if (!confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
//         return;
//     }

//     const formData = new FormData();
//     formData.append('cart_item_id', itemId);

//     fetch('/cart/remove', {
//         method: 'POST',
//         body: formData
//     })
//         .then(response => response.json())
//         .then(data => {
//             if (data.success) {
//                 const cartItem = document.querySelector(`[data-item-id="${itemId}"]`);
//                 if (cartItem) {
//                     cartItem.remove();
//                 }
//                 updateCartDisplay();
//                 showNotification('Đã xóa sản phẩm khỏi giỏ hàng!', 'success');
//             } else {
//                 showNotification(data.message || 'Có lỗi xảy ra!', 'error');
//             }
//         })
//         .catch(error => {
//             console.error('Error:', error);
//             showNotification('Có lỗi xảy ra!', 'error');
//         });
// }

// // Update cart display.
// //       Tính lại từng item - subtotal = price * quantity
// //       Cập nhật tổng phụ(.subtotal) và tổng cộng(.total - amount)
// //       Cộng thêm phí ship cố định 30.000đ
// function updateCartDisplay() {
//     // Recalculate totals
//     let subtotal = 0;
//     const cartItems = document.querySelectorAll('.cart-item');

//     cartItems.forEach(item => {
//         const price = parseFloat(item.querySelector('.item-price').textContent.replace(/[^\d]/g, ''));
//         const quantity = parseInt(item.querySelector('.quantity-input').value);
//         const itemSubtotal = price * quantity;

//         item.querySelector('.item-subtotal').textContent = formatPrice(itemSubtotal);
//         subtotal += itemSubtotal;
//     });

//     // Update summary
//     const subtotalElement = document.querySelector('.subtotal');
//     const totalElement = document.querySelector('.total-amount');

//     if (subtotalElement) {
//         subtotalElement.textContent = formatPrice(subtotal);
//     }

//     if (totalElement) {
//         const shipping = 30000;
//         totalElement.textContent = formatPrice(subtotal + shipping);
//     }

//     updateCartCount();
// }

// // Update cart count in header
// function updateCartCount() {
//     const cartItems = document.querySelectorAll('.cart-item');
//     const cartCount = document.querySelector('.cart-count');

//     if (cartCount) {
//         cartCount.textContent = cartItems.length;
//     }
// }

// Sort products
function sortProducts(sortType) {
    const productGrid = document.querySelector('.product-grid');
    const products = Array.from(productGrid.querySelectorAll('.product-card'));

    products.sort((a, b) => {
        switch (sortType) {
            case 'price-asc':
                return getPrice(a) - getPrice(b);
            case 'price-desc':
                return getPrice(b) - getPrice(a);
            case 'rating':
                return getRating(b) - getRating(a);
            default:
                return 0;
        }
    });

    // Re-append sorted products
    products.forEach(product => productGrid.appendChild(product));
}

// Get price from product card
function getPrice(productCard) {
    const priceText = productCard.querySelector('.product-price').textContent;
    return parseFloat(priceText.replace(/[^\d]/g, ''));
}

// Get rating from product card
function getRating(productCard) {
    const ratingText = productCard.querySelector('.rating-text').textContent;
    return parseFloat(ratingText.replace(/[^\d.]/g, ''));
}

// Format price
function formatPrice(price) {
    return new Intl.NumberFormat('vi-VN').format(price) + 'đ';
}

// Show notification
//       Tạo thông báo nổi góc phải (top-right)
//       Kiểu success, error, hoặc info
//       Tự động ẩn sau 3 giây
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.notification');
    existingNotifications.forEach(notification => notification.remove());

    // Create notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;

    // Add styles
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: ${type === 'success' ? '#4CAF50' : type === 'error' ? '#f44336' : '#2196F3'};
        color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10000;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    `;

    document.body.appendChild(notification);

    // Show notification
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);

    // Hide notification after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Smooth scrolling for anchor links
//       Khi click vào liên kết nội bộ, cuộn mượt đến phần tử có id tương ứng
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});

// Mobile menu toggle (if needed)
//      Chuyển đổi menu trên thiết bị di động bằng cách thêm/xóa class active
function toggleMobileMenu() {
    const mobileMenu = document.querySelector('.mobile-menu');
    if (mobileMenu) {
        mobileMenu.classList.toggle('active');
    }
}

// Image lazy loading
//      Dùng IntersectionObserver để tải ảnh khi ảnh xuất hiện trên màn hình
//      Gán img.src = img.dataset.src khi vào viewport
function lazyLoadImages() {
    const images = document.querySelectorAll('img[data-src]');

    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    images.forEach(img => imageObserver.observe(img));
}

// Initialize lazy loading
lazyLoadImages();
// showToast - Thông báo kiểu toast ngắn
//      Tạo toast trong phần tử có ID toast - container(phải có sẵn trong HTML)
//      Tự động xóa sau 4s
function showToast(message, type) {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.classList.add('toast');
    toast.classList.add(type);

    // Có thể thay đổi màu theo type nếu muốn (error, success, etc.)
    toast.textContent = message;
    toastContainer.appendChild(toast);

    // Tự động xóa sau 4s
    setTimeout(() => {
        toast.remove();
    }, 4000);
}

//      Sử dụng regex để kiểm tra:
//      Email hợp lệ: a@b.c
//      Số điện thoại Việt Nam: bắt đầu bằng 03, 05, 07, 08, 09 + 8 số

// Email validation
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Phone validation (Vietnamese phone numbers)
function validatePhone(phone) {
    const re = /^(0[3|5|7|8|9])+([0-9]{8})$/;
    return re.test(phone);
}