
window.onload = function() {
    // Đoạn mã JavaScript của bạn ở đây
    const logoutButton = document.getElementById('logoutButton');
const confirmationModal = document.getElementById('confirmationModal');
const confirmLogoutButton = document.getElementById('confirmLogoutButton');
const cancelLogoutButton = document.getElementById('cancelLogoutButton');

logoutButton.addEventListener('click', () => {
    confirmationModal.style.display = 'block';
});

confirmLogoutButton.addEventListener('click', () => {
    // Thực hiện đăng xuất
    window.location.href = '/logout';

});

cancelLogoutButton.addEventListener('click', () => {
    confirmationModal.style.display = 'none';
});
};