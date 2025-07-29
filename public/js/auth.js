
function getBaseUrl() {
    const parts = window.location.pathname.split('/');
    return parts.slice(0, -1).join('/');
}

// Toggle between login and register forms
function showLogin() {
    const base = getBaseUrl();

    const newUrl = base + '/' + 'signin';
    window.location.href = newUrl;
}

function showRegister() {
    const base = getBaseUrl();

    const newUrl = base + '/' + 'signup';
    window.location.href = newUrl;
}

// Form validation
document.addEventListener('DOMContentLoaded', function () {
    // Login form validation
    const loginForm = document.querySelector('#loginForm form');
    if (loginForm) {
        loginForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const loginInfo = document.getElementById('loginInfo').value;

            if (!validateEmail(loginInfo) && !validatePhone(loginInfo)) {
                showToast('Email hoặc số điện thoại không hợp lệ!', 'error');
                return;
            }
            loginForm.submit();
        });
    }

    // Register form validation
    const registerForm = document.querySelector('#registerForm form');
    if (registerForm) {
        registerForm.addEventListener('submit', function (e) {
            e.preventDefault();
            console.log('Register form submitted');
            const email = document.getElementById('registerEmail').value;
            const phone = document.getElementById('registerPhone').value;
            const password = document.getElementById('registerPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const terms = document.getElementById('registerAgree').checked;

            if (!validateEmail(email)) {
                showToast('Email không hợp lệ!', 'error');
                return;
            }
            if (validatePhone(phone) === false) {
                showToast('Số điện thoại không hợp lệ!', 'error');
                return;
            }
            if (password !== confirmPassword) {
                showToast('Mật khẩu xác nhận không khớp!', 'error');
                return;
            }

            if (!terms) {
                showToast('Vui lòng đồng ý với điều khoản sử dụng!', 'error');
                return;
            }
            registerForm.submit();
        });
    }

    // Add smooth transitions
    const authContainers = document.querySelectorAll('.auth-container');
    authContainers.forEach(container => {
        container.style.transition = 'opacity 0.3s ease-in-out';
    });
});


// Real-time validation
document.addEventListener('DOMContentLoaded', function () {
    // Email validation
    const emailInputs = document.querySelectorAll('input[type="email"]');
    emailInputs.forEach(input => {
        input.addEventListener('blur', function () {
            if (this.value && !validateEmail(this.value)) {
                this.style.borderColor = '#ef4444';
                showError(this, 'Email không hợp lệ');
            } else {
                this.style.borderColor = '#d1d5db';
                hideError(this);
            }
        });
    });

    // Phone validation
    const phoneInputs = document.querySelectorAll('input[type="tel"]');
    phoneInputs.forEach(input => {
        input.addEventListener('blur', function () {
            if (this.value && !validatePhone(this.value)) {
                this.style.borderColor = '#ef4444';
                showError(this, 'Số điện thoại không hợp lệ');
            } else {
                this.style.borderColor = '#d1d5db';
                hideError(this);
            }
        });
    });

    // login info validation
    const loginInfo = document.getElementById('loginInfo');
    loginInfo.addEventListener('blur', function () {
        if (this.value) {
            if (!validateEmail(this.value) && !validatePhone(this.value)) {
                this.style.borderColor = '#ef4444';
                showError(this, 'Email hoặc số điện thoại không hợp lệ');
            }
            else {
                this.style.borderColor = '#d1d5db';
                hideError(this);
            }
        }
    });

    // Show error message if exists
    const errorDiv = document.getElementById('login-error');
    if (errorDiv) {
        const message = errorDiv.dataset.error;
        if (message) {
            alert(message);
        }
    }
});

function showError(input, message) {
    hideError(input); // Remove existing error

    const errorDiv = document.createElement('div');
    errorDiv.className = 'error-message';
    errorDiv.style.color = '#ef4444';
    errorDiv.style.fontSize = '0.75rem';
    errorDiv.style.marginTop = '0.25rem';
    errorDiv.textContent = message;

    input.parentNode.parentNode.appendChild(errorDiv);
}

function hideError(input) {
    const errorMessage = input.parentNode.parentNode.querySelector('.error-message');
    if (errorMessage) {
        errorMessage.remove();
    }
}

