document.addEventListener('DOMContentLoaded', function () {
    const choices = document.querySelectorAll('.choice');
    const infoContainers = document.querySelectorAll('.info');
    const usernameElement = document.getElementById('username');
    const emailElement = document.getElementById('email');
    const phoneElement = document.getElementById('phone');

    choices.forEach(choice => {
        choice.addEventListener('click', function (e) {
            e.preventDefault();
            const selectedChoice = this.getAttribute('data-choice');

            infoContainers.forEach(info => {
                info.style.display = 'none';
            });

            document.getElementById(`${selectedChoice}-info`).style.display = 'block';
        });
    });

    // Simulated user data
    const userData = {
        username: 'JohnDoe',
        email: 'johndoe@example.com',
        phone: '123-456-7890'
    };

    // Display user information
    usernameElement.textContent = userData.username;
    emailElement.textContent = userData.email;
    phoneElement.textContent = userData.phone;

    // Get elements
    const editButton = document.getElementById('edit-button');
    const editForm = document.getElementById('edit-form');
    const verificationSection = document.getElementById('verification-section');
    const verifyButton = document.getElementById('verify-button');
    const newUsernameInput = document.getElementById('new-username');
    const newPhoneInput = document.getElementById('new-phone');
    const usernameSpan = document.getElementById('username');
    const phoneSpan = document.getElementById('phone');

    // Edit form submit event
    editForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const newUsername = newUsernameInput.value;
        const newPhone = newPhoneInput.value;

        // Phone number validation
        const phoneRegex = /^05\d{8}$/; // Assumes a 10-digit phone number format starting with '05'
        if (!phoneRegex.test(newPhone)) {
            const phoneErrorElement = document.getElementById('phone-error');
            phoneErrorElement.textContent = 'رقم الجوال غير صحيح. يرجى إدخال رقم الجوال بالصيغة الصحيحة.';
            return;
        }

        // Clear the error message if validation succeeds
        const phoneErrorElement = document.getElementById('phone-error');
        phoneErrorElement.textContent = '';

        // Perform phone number verification here
        // ...

        // Update the displayed values
        usernameSpan.textContent = newUsername;
        phoneSpan.textContent = newPhone;

        // Show verification section
        verificationSection.style.display = 'block';
    });

    // Verify button click event
    verifyButton.addEventListener('click', () => {
        const verificationCodeInput = document.getElementById('verification-code');
        const verificationCode = verificationCodeInput.value;

        // Perform verification code validation here
        // ...

        // Hide verification section
        verificationSection.style.display = 'none';
    });

    // Get elements

    const userSection = document.getElementById('user-info');
    const editSection = document.getElementById('edit-user-info');
    const passwordSection = document.getElementById('password-info');
    const notificationSection = document.getElementById('notification-info');

    // Click event for choices
    choices.forEach((choice) => {
        choice.addEventListener('click', function (event) {
            event.preventDefault();
            const selectedChoice = this.getAttribute('data-choice');
            hideAllSections();
            showSection(selectedChoice);
        });
    });

    // Helper functions
    function hideAllSections() {
        userSection.style.display = 'none';
        editSection.style.display = 'none';
        passwordSection.style.display = 'none';
        notificationSection.style.display = 'none';
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
            case 'notification':
                notificationSection.style.display = 'block';
                break;
            default:
                break;
        }
    }

    // change password function 
    // Get elements
    const changePasswordForm = document.getElementById('change-password-form');
    const currentPasswordInput = document.getElementById('current-password');
    const newPasswordInput = document.getElementById('new-password');
    const confirmPasswordInput = document.getElementById('confirm-password');
    const passwordErrorElement = document.getElementById('password-error');

    // Change password form submit event
    changePasswordForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const currentPassword = currentPasswordInput.value;
        const newPassword = newPasswordInput.value;
        const confirmPassword = confirmPasswordInput.value;

// Password validation
if (!/^(?=.*[A-Z]).{6,}$/.test(newPassword)) {
    passwordErrorElement.textContent = "كلمة المرور يجب أن تحتوي على 6 حروف، وحرف كبير واحد على الأقل";
    return;
} else if (newPassword !== confirmPassword) {
    passwordErrorElement.textContent = "كلمة المرور غير متطابقة";
    return;
}

// Clear the error message if validation succeeds
passwordErrorElement.textContent = ''; // Clear the error message

        // Reset the form
        changePasswordForm.reset();
    });
});