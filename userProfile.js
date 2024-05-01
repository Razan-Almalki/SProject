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

    // Get elements
    const editButton = document.getElementById('edit-button');
    const editForm = document.getElementById('edit-form');
    const verificationSection = document.getElementById('verification-section');
    const verifyButton = document.getElementById('verify-button');
    const newUsernameInput = document.getElementById('new-username');
    const newPhoneInput = document.getElementById('new-phone');
    const usernameSpan = document.getElementById('username');
    const phoneSpan = document.getElementById('phone');


    // Get elements

    const userSection = document.getElementById('user-info');
    const editSection = document.getElementById('edit-user-info');
    const passwordSection = document.getElementById('password-info');
    const deletSection = document.getElementById('delet-info');

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
        deletSection.style.display = 'none';
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
                deletSection.style.display = 'block';
                break;
            default:
                break;
        }
    }
    function isValidPassword(password) {
        // Password validation regex (at least 6 characters, one uppercase letter)
        var passwordRegex = /^(?=.*[A-Z]).{6,}$/;
        return passwordRegex.test(password);
      }
      
      // Add event listener to the 'change-password-form'
      document.getElementById('change-password-form').addEventListener('submit', function(event) {
        var newPassword = document.getElementById('new-password').value;
        var confirmPassword = document.getElementById('confirm-password').value;
        var passwordError = document.getElementById('password-error');
      
        // Check password validation using your function
        if (!isValidPassword(newPassword)) {
          event.preventDefault(); // Prevent form submission
          passwordError.innerHTML = "كلمة المرور يجب أن تحتوي على حرف كبير على الأقل وأن تتكون من 6 أحرف على الأقل";
          return;
        }
      
        // Check if new password and confirm password match (existing logic)
        if (newPassword !== confirmPassword) {
          event.preventDefault();
          passwordError.innerHTML = "كلمة المرور الجديدة غير متطابقة!";
          return;
        }
      
      });
    
});