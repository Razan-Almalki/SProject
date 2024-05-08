$(document).ready(function() {
    $('#vendorSignUpForm').submit(function(event) {
      event.preventDefault();
      validateForm();
    });
  
    function validateForm() {
      var firstname = $('#firstname').val().trim();
      var lastname = $('#lastname').val().trim();
      var email = $('#email').val().trim();
      var phone = $('#phone').val().trim();
      var password = $('#password').val().trim();
      var confirmPassword = $('#confirmPassword').val().trim();
  
      resetErrors();
  
      if (firstname === '') {
        displayError($('#firstname'), 'يرجى ادخال الاسم الاول.');
      }
  
      if (lastname === '') {
        displayError($('#lastname'), 'الرجاء إدخال اسمك الأخير.');
      }
  
      if (email === '') {
        displayError($('#email'), 'الرجاء إدخال عنوان البريد الإلكتروني الخاص بك.');
      } else if (!isValidEmail(email)) {
        displayError($('#email'), 'يرجى إدخال عنوان بريد إلكتروني صالح.');
      }
  
      if (phone === '') {
        displayError($('#phone'), 'يرجى إدخال رقم الهاتف الخاص بك.');
      } else if (!isValidPhoneNumber(phone)) {
        displayError($('#phone'), 'يرجى إدخال رقم هاتف صالح.');
      }
  
      if (password === '') {
        displayError($('#password'), 'الرجاء إدخال كلمة المرور.');
      } else if (!isValidPassword(password)) {
        displayError($('#password'), 'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل وتحتوي على حرف كبير واحد على الأقل.');
      }
  
      if (confirmPassword === '') {
        displayError($('#confirmPassword'), 'يرجى التأكد من صحة كلمة المرور الخاصة بك.');
      } else if (password !== confirmPassword) {
        displayError($('#confirmPassword'), 'كلمة المرور غير مطابقة.');
      }
  
      // Check if form is valid
      if ($('#signUpForm')[0].checkValidity()) {
        submitForm();
      } else {
        // Mark invalid fields and display error messages
        $('#signUpForm')[0].reportValidity();
      }
    }
  
    function displayError(input, message) {
      var errorContainer = input.parent().find('.error-message');
      errorContainer.text(message);
    }
  
    function resetErrors() {
      $('.error-message').text('');
    }
  
    function isValidEmail(email) {
      var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return emailRegex.test(email);
    }
  
    function isValidPhoneNumber(phone) {
      var phoneRegex = /^05\d{8}$/;
      return phoneRegex.test(phone);
    }
  
    function isValidPassword(password) {
      var passwordRegex = /^(?=.*[A-Z]).{6,}$/;
      return passwordRegex.test(password);
    }
  
    function submitForm() {
      var formData = $('#vendorSignUpForm').serialize();
  
      $.ajax({
        type: 'POST',
        url: 'SignUp_vendor.php',
        data: formData,
        success: function(response) {
          // Handle success response
          console.log(response);
          // Display an error message to the user
          errorMessage.textContent = response; // Display the error message
        },
        error: function(xhr, status, error) {
          // Handle error response
          console.log(xhr.responseText);
          errorMessage.textContent = response; // Display the error message
        }
      });
    }
  });