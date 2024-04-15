// Wait for the DOM to be ready
document.addEventListener("DOMContentLoaded", function() {
    // Get the form element
    var signUpForm = document.getElementById("signUpForm");
  
    // Get the input fields
    const nameInput = document.getElementById('name');
    const usernameInput = document.getElementById('username');
    const emailInput = document.getElementById('email');
    const phoneInput = document.getElementById('phone');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirmPassword');
  
    // Add event listeners for input/change events on each input field
    nameInput.addEventListener('input', validateForm);
    usernameInput.addEventListener('input', validateForm);
    emailInput.addEventListener('input', validateForm);
    phoneInput.addEventListener('input', validateForm);
    passwordInput.addEventListener('input', validateForm);
    confirmPasswordInput.addEventListener('input', validateForm);
  
    // Add event listener for form submission
    signUpForm.addEventListener("submit", function(event) {
      // Prevent the default form submission
      event.preventDefault();
  
      // Validate the form one last time before submission
      validateForm();
    });
  
    function validateForm() {
      const name = nameInput.value.trim();
      const username = usernameInput.value.trim();
      const email = emailInput.value.trim();
      const phone = phoneInput.value.trim();
      const password = passwordInput.value.trim();
      const confirmPassword = confirmPasswordInput.value.trim();
  
      resetErrors();
  
      if (name === '') {
        displayError(nameInput, 'الرجاء ادخال اسمك');
      }
  
      if (username === '') {
        displayError(usernameInput, 'الرجاء إدخال اسم المستخدم');
      }
  
      if (email === '') {
        displayError(emailInput, 'الرجاء إدخال البريد الإلكتروني');
      } else if (!isValidEmail(email)) {
        displayError(emailInput, 'الرجاء إدخال بريد إلكتروني صالح');
      }
  
      if (phone === '') {
        displayError(phoneInput, 'الرجاء إدخال رقم الهاتف');
      } else if (!isValidPhoneNumber(phone)) {
        displayError(phoneInput, 'الرجاء إدخال رقم هاتف صالح');
      }
  
      if (password === '') {
        displayError(passwordInput, 'الرجاء إدخال كلمة المرور');
      } else if (!isValidPassword(password)) {
        displayError(passwordInput,'كلمة المرور يجب أن تحتوي على 6 حروف، وحرف كبير واحد على الأقل');
      }
  
      if (confirmPassword === '') {
        displayError(confirmPasswordInput, 'الرجاء تأكيد كلمة المرور');
      } else if (password !== confirmPassword) {
        displayError(confirmPasswordInput, 'كلمة المرور غير متطابقة');
      }
    }
  
    function displayError(input, message) {
      const errorContainer = input.parentNode.querySelector('.error-message');
      errorContainer.innerText = message;
    }
  
    function resetErrors() {
      const errorMessages = document.querySelectorAll('.error-message');
      errorMessages.forEach(function(errorMessage) {
        errorMessage.innerText = '';
      });
    }
  
    function isValidEmail(email) {
      // Simple email format validation using regular expression
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  
    function isValidPhoneNumber(phone) {
      // Phone number format validation using regular expression
      const phoneRegex = /^05\d{8}$/; // Assumes a 10-digit phone number format starting with '05'
      return phoneRegex.test(phone);
    }
  
    function isValidPassword(password) {
        // Password strength validation using regular expression
        // Requires at least 6 characters and at least one uppercase letter
        const passwordRegex = /^(?=.*[A-Z]).{6,}$/;
        return passwordRegex.test(password);
      }
  });