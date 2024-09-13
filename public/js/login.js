document.addEventListener('DOMContentLoaded', function() {
    const passwordToggle = document.querySelector('.password-toggle');
    const passwordInput = document.querySelector('#password');

    passwordToggle.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.textContent = type === 'password' ? '👁️' : '👁️‍🗨️';
    });
});
