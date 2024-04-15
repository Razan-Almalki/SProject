// Wait for the DOM to be ready
document.addEventListener("DOMContentLoaded", function () {
    // Get the form element
    var loginForm = document.getElementById("loginForm");

    // Get the input fields
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');

    // Add event listeners for input/change events on each input field
    emailInput.addEventListener('input', validateForm);
    passwordInput.addEventListener('input', validateForm);

    // Add event listener for form submission
    loginForm.addEventListener("submit", function (event) {
        // Prevent the default form submission
        event.preventDefault();

        // Validate the form one last time before submission
        validateForm();
    });

    function validateForm() {
        const email = emailInput.value.trim();
        const password = passwordInput.value.trim();

        resetErrors();

        if (email === '') {
            displayError(emailInput, 'الرجاء إدخال البريد الإلكتروني');
        } else if (!isValidEmail(email)) {
            displayError(emailInput, 'الرجاء إدخال بريد إلكتروني صالح');
        }

        if (password === '') {
            displayError(passwordInput, 'الرجاء إدخال كلمة المرور');
        }
    }

    function displayError(input, message) {
        const errorContainer = input.parentNode.querySelector('.error-message');
        errorContainer.innerText = message;
    }

    function resetErrors() {
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(function (errorMessage) {
            errorMessage.innerText = '';
        });
    }

    function isValidEmail(email) {
        // Simple email format validation using regular expression
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
});