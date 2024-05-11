// Wait for the DOM to be ready
document.addEventListener("DOMContentLoaded", function () {
    // Get the form element
    var loginForm = document.getElementById("vendorLoginForm");

    // Get the input fields
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    // Get the input mess
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');


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
            displayError(emailError, 'الرجاء إدخال البريد الإلكتروني');
        } else if (!isValidEmail(email)) {
            displayError(emailError, 'الرجاء إدخال بريد إلكتروني صالح');
        }

        if (password === '') {
            displayError(passwordError, 'الرجاء إدخال كلمة المرور');
        }

        // If validation passes, send the request to the PHP script
        if (email !== '' && password !== '' && isValidEmail(email)) {
            sendLoginRequest(email, password);
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

    function sendLoginRequest(email, password) {
        // Create a new XMLHttpRequest object
        const xhr = new XMLHttpRequest();

        // Open a POST request to the login.php script
        xhr.open("POST", "Login_vendor.php", true);

        // Set the request header to send form data
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onload = function () {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    // Successful login
                    console.log("Login successful");
                    // Redirect to the dashboard or display a success message
                    window.location.href = 'vendorProfile.php';  // Redirect to the user profile page
                } else {
                    // Login failed
                    console.error("Login failed");
                    // Display an error message to the user
                    errorMessage.textContent = response.message; // Display the error message
                }
            } else {
                // Request failed, display an error message
                console.error("Request failed:", xhr.status);
                // Display an error message to the user
            }
        };

        // Send the form data as a URL-encoded string
        const formData = `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`;
        xhr.send(formData);
    }

});