<?php
$title = "Xác minh email - ElectroMart";
?>

<link rel="stylesheet" href="<?= getenv('STYLE_PATH') . 'auth.css' ?>">

<!-- Main Content -->
<main class="main-content">
    <div class="container">
        <div id="toast-container"></div>

        <!-- Email Verification Container -->
        <div class="auth-container">
            <div class="auth-card">
                <div class="auth-header">
                    <div class="verification-icon">
                        <i class="fa-solid fa-envelope-circle-check"
                            style="font-size: 4rem; color: #007bff; margin-bottom: 1rem;"></i>
                    </div>
                    <h2>Xác minh email của bạn</h2>
                    <p>Chúng tôi đã gửi một email xác minh đến địa chỉ email của bạn</p>
                </div>

                <div class="verification-content">
                    <div class="verification-info">
                        <div class="info-item">
                            <i class="fa-solid fa-paper-plane"></i>
                            <div>
                                <h4>Email đã được gửi</h4>
                                <p>Kiểm tra hộp thư đến của bạn và tìm email từ ElectroMart</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fa-solid fa-mouse-pointer"></i>
                            <div>
                                <h4>Nhấp vào liên kết</h4>
                                <p>Mở email và nhấp vào liên kết xác minh để kích hoạt tài khoản</p>
                            </div>
                        </div>

                        <div class="info-item">
                            <i class="fa-solid fa-clock"></i>
                            <div>
                                <h4>Thời gian hiệu lực</h4>
                                <p>Liên kết xác minh có hiệu lực trong vòng 24 giờ</p>
                            </div>
                        </div>
                    </div>

                    <div class="verification-actions">
                        <p class="help-text">Không nhận được email?</p>

                        <div class="action-buttons">
                            <button type="button" class="btn btn-outline" onclick="checkSpamFolder()">
                                <i class="fa-solid fa-search"></i>
                                Kiểm tra thư mục spam
                            </button>

                            <button type="button" class="btn btn-primary" onclick="resendEmail()">
                                <i class="fa-solid fa-paper-plane"></i>
                                Gửi lại email
                            </button>
                        </div>

                        <div class="back-to-login">
                            <a href="https://electromart-t8ou8.ondigitalocean.app/public/account/signin" class="link">
                                <i class="fa-solid fa-arrow-left"></i>
                                Quay lại đăng nhập
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    .verification-content {
        padding: 2rem 0;
    }

    .verification-info {
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.5rem;
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #007bff;
    }

    .info-item i {
        font-size: 1.2rem;
        color: #007bff;
        margin-top: 0.2rem;
        min-width: 20px;
    }

    .info-item h4 {
        margin: 0 0 0.5rem 0;
        color: #333;
        font-size: 1rem;
        font-weight: 600;
    }

    .info-item p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    .verification-actions {
        text-align: center;
        padding-top: 1rem;
        border-top: 1px solid #eee;
    }

    .help-text {
        margin-bottom: 1.5rem;
        color: #666;
        font-size: 0.95rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 2rem;
        flex-wrap: wrap;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 6px;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        min-width: 140px;
        justify-content: center;
    }

    .btn-primary {
        background: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background: #0056b3;
        transform: translateY(-1px);
    }

    .btn-outline {
        background: transparent;
        color: #007bff;
        border: 2px solid #007bff;
    }

    .btn-outline:hover {
        background: #007bff;
        color: white;
        transform: translateY(-1px);
    }

    .back-to-login {
        margin-top: 1rem;
    }

    .back-to-login .link {
        color: #666;
        text-decoration: none;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: color 0.3s ease;
    }

    .back-to-login .link:hover {
        color: #007bff;
    }

    .verification-icon {
        text-align: center;
        margin-bottom: 1rem;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .btn {
            width: 100%;
            max-width: 250px;
        }

        .info-item {
            padding: 0.75rem;
        }

        .verification-icon i {
            font-size: 3rem !important;
        }
    }
</style>

<script>
    function checkSpamFolder() {
        showToast('Vui lòng kiểm tra thư mục spam/junk mail trong email của bạn. Đôi khi email xác minh có thể bị chuyển vào đó.', 'info');
    }

    function resendEmail() {
        // Hiển thị loading state
        const btn = event.target.closest('.btn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Đang gửi...';
        btn.disabled = true;

        // Gửi request đến server để gửi lại email
        fetch('https://electromart-t8ou8.ondigitalocean.app/public/account/resend-verification', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            }
        })
            .then(response => response.json())
            .then(data => {
                btn.innerHTML = originalText;
                btn.disabled = false;

                if (data.success) {
                    showToast(data.message, 'success');
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(error => {
                btn.innerHTML = originalText;
                btn.disabled = false;
                showToast('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
            });
    }

    // Toast notification function
    function showToast(message, type = 'info') {
        const toastContainer = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;

        const icon = type === 'success' ? 'check-circle' :
            type === 'error' ? 'exclamation-circle' :
                'info-circle';

        toast.innerHTML = `
        <i class="fa-solid fa-${icon}"></i>
        <span>${message}</span>
        <button class="toast-close" onclick="this.parentElement.remove()">
            <i class="fa-solid fa-times"></i>
        </button>
    `;

        toastContainer.appendChild(toast);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.remove();
            }
        }, 5000);
    }
</script>

<style>
    /* Toast Styles */
    #toast-container {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
        max-width: 400px;
    }

    .toast {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        margin-bottom: 0.5rem;
        border-radius: 8px;
        color: white;
        font-size: 0.9rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
    }

    .toast-success {
        background: #28a745;
    }

    .toast-error {
        background: #dc3545;
    }

    .toast-info {
        background: #17a2b8;
    }

    .toast-close {
        background: none;
        border: none;
        color: white;
        cursor: pointer;
        padding: 0;
        margin-left: auto;
        font-size: 1rem;
    }

    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }

        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>