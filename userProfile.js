document.addEventListener('DOMContentLoaded', function () {
    // Sections in the user profile
    const choices = document.querySelectorAll('.choice');
    const infoContainers = document.querySelectorAll('.info');
    const userSection = document.getElementById('user-info');
    const editSection = document.getElementById('edit-user-info');
    const passwordSection = document.getElementById('password-info');
    const deleteSection = document.getElementById('delet-info');

    // Fields in the edit form
    const editForm = document.getElementById('edit-form');
    const firstNameInput = document.getElementById('new-firstname');
    const lastNameInput = document.getElementById('new-lastname');
    const phoneInput = document.getElementById('new-phone');
    const phoneError = document.getElementById('phone-error');

    // Fields in the password change form
    const passwordForm = document.getElementById('change-password-form');
    const currentPasswordInput = document.getElementById('current-password');
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const passwordError = document.getElementById('password-error');

    // Fields in the delete account form
    const deleteForm = document.getElementById('delete-account-form');
    const emailInput = document.getElementById('entered-email');

    // Helper functions
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation regex
        return emailRegex.test(email);
    }

    function isValidPhone(phone) {
        const phoneRegex = /^05\d{8}$/; // Phone number starts with '05' and has 10 digits
        return phoneRegex.test(phone);
    }

    function isValidPassword(password) {
        const passwordRegex = /^(?=.*[A-Z]).{6,}$/; // At least 6 characters with one uppercase
        return passwordRegex.test(password);
    }

    function displayError(element, message) {
        element.innerText = message;
    }

    function resetErrorMessages() {
        document.querySelectorAll('.error-message').forEach(function (errorMsg) {
            errorMsg.innerText = '';
        });
    }

    // Click event for choices
    choices.forEach((choice) => {
        choice.addEventListener('click', function (event) {
            event.preventDefault();
            const selectedChoice = this.getAttribute('data-choice');
            hideAllSections();
            showSection(selectedChoice);
        });
    });

    function hideAllSections() {
        infoContainers.forEach((info) => {
            info.style.display = 'none';
        });
    }

    function showSection(section) {
        switch (section) {
            case 'info':
                userSection.style.display = 'block';
                break;
            case 'edit':
                editSection.style.display = 'block';
                break;
            case 'password':
                passwordSection.style.display = 'block';
                break;
            case 'delet':
                deleteSection.style.display = 'block';
                break;
            default:
                break;
        }
    }

    // Add event listener for form submissions
    editForm.addEventListener('submit', function (event) {
        resetErrorMessages();

        const phone = phoneInput.value.trim();

        if (!isValidPhone(phone)) {
            event.preventDefault();
            displayError(phoneError, 'رقم الهاتف غير صحيح!');
        }
    });

    passwordForm.addEventListener('submit', function (event) {
        resetErrorMessages();

        const newPassword = newPasswordInput.value.trim();
        const confirmPassword = confirmPasswordInput.value.trim();

        if (!isValidPassword(newPassword)) {
            event.preventDefault();
            displayError(passwordError, 'كلمة المرور يجب أن تحتوي على حرف كبير على الأقل وأن تتكون من 6 أحرف على الأقل.');
            return;
        }

        if (newPassword !== confirmPassword) {
            event.preventDefault();
            displayError(passwordError, 'كلمة المرور الجديدة غير متطابقة!');
            return;
        }
    });

    deleteForm.addEventListener('submit', function (event) {
        resetErrorMessages();

        const email = emailInput.value.trim();

        if (!isValidEmail(email)) {
            event.preventDefault();
            displayError(document.getElementById('mess'), 'البريد الإلكتروني غير صحيح!');
        }
    });
});