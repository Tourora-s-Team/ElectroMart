
// ElectroMart JavaScript.
//       Đảm bảo toàn bộ HTML đã tải xong trước khi JS thao tác với DOM
document.addEventListener('DOMContentLoaded', function () {
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
//      Tự động xóa sau 3s
function showToast(message, type) {
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) return;

    const toast = document.createElement('div');
    toast.classList.add('toast', type);

    // Nội dung toast + nút đóng
    if (type === "error") {
        toast.innerHTML = `<i class="fas fa-exclamation-circle"></i> ${message}`;
    } else {
        toast.innerHTML = `<i class='fas fa-check'></i> ${message}`;
    }

    // Tạo nút đóng
    const closeBtn = document.createElement('button');
    closeBtn.innerHTML = '&times;';
    closeBtn.classList.add('toast-close');
    closeBtn.onclick = () => toast.remove();
    toast.appendChild(closeBtn);

    toastContainer.appendChild(toast);

    // Tự động xóa sau 3s
    setTimeout(() => {
        toast.remove();
    }, 3000);
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

// Toggle password visibility
function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const button = input.nextElementSibling;

    if (input.type === 'password') {
        input.type = 'text';
        button.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
    } else {
        input.type = 'password';
        button.innerHTML = '<i class="fa-solid fa-eye"></i>';
    }
}

function addToWishList(productId) {
    const btn = document.querySelector(`.add-to-wishlist-btn[data-id='${productId}']`);
    btn.disabled = true;
    fetch(`/electromart/public/account/wish-list-add/${productId}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (response.ok) {
                btn.disabled = false;
                showToast("Đã thêm vào danh sách yêu thích.", "success");
            } else {
                showToast("Sản phẩm đã có trong danh sách yêu thích.", "error");
            }
        })
        .catch(error => {
            showToast("Lỗi khi gửi yêu cầu", "error");
            console.error('Lỗi:', error);
        });
}
