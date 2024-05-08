document.addEventListener('DOMContentLoaded', function() {
    // Get form elements
    const resetPasswordForm = document.getElementById('reset-password-form');
    const resetEmailInput = document.getElementById('reset-email');
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const passwordError = document.getElementById('password-error');

    // Function to validate email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation regex
        return emailRegex.test(email);
    }

    // Function to validate password strength
    function isValidPassword(password) {
        const passwordRegex = /^(?=.*[A-Z]).{6,}$/; // At least one uppercase letter, and 6 characters
        return passwordRegex.test(password);
    }

    // Function to display error messages
    function displayError(element, message) {
        element.innerText = message;
    }

    // Function to reset error messages
    function resetErrors() {
        passwordError.innerText = '';
    }

    // Add event listener for form submission
    resetPasswordForm.addEventListener('submit', function(event) {
        resetErrors();

        const email = resetEmailInput.value.trim();
        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();

        // Validate email
        if (!isValidEmail(email)) {
            event.preventDefault();
            displayError(passwordError, 'البريد الإلكتروني غير صحيح!');
            return;
        }

        // Validate password strength
        if (!isValidPassword(newPassword)) {
            event.preventDefault();
            displayError(passwordError, 'كلمة المرور يجب أن تحتوي على حرف كبير على الأقل وأن تتكون من 6 أحرف على الأقل.');
            return;
        }

        // Validate password confirmation
        if (newPassword !== confirmPassword) {
            event.preventDefault();
            displayError(passwordError, 'كلمة المرور الجديدة غير متطابقة!');
            return;
        }
    });
});
