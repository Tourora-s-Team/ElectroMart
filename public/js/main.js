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