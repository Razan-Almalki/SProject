// Set the countdown time (in seconds)
const countdownTime = 300; // 5 minutes

function validatePaymentForm() {
  // Get form inputs
  const cardNumberInput = document.getElementsByName("cardNumber")[0];
  const expiryDateInput = document.getElementsByName("expiryDate")[0];
  const cvvInput = document.getElementsByName("cvv")[0];
  const errorText = document.getElementById("errorText");

  // Reset error message
  errorText.innerHTML = "";

  // Validate card number
  if (!validateCardNumber(cardNumberInput.value)) {
    errorText.innerHTML = "رقم البطاقة غير صالحة. يجب أن يحتوي على 16 رقمًا.";
    cardNumberInput.focus();
    return false;
  }

  // Validate CVV
  if (!validateCVV(cvvInput.value)) {
    errorText.innerHTML = "رمز التحقق من البطاقة (CVV) غير صالح. يجب أن يحتوي على 3 أرقام.";
    cvvInput.focus();
    return false;
  }

  // Validate expiry date
  if (!validateExpiryDate(expiryDateInput.value)) {
    errorText.innerHTML = "تاريخ انتهاء الصلاحية غير صالح. يجب أن يكون بتنسيق MM/YY.";
    expiryDateInput.focus();
    return false;
  }

  // All validations passed
  alert("تم الدفع بنجاح!.");
  errorText.innerHTML = "تم الدفع بنجاح!.";
  return true;
}

function validateCardNumber(cardNumber) {
  return /^\d{16}$/.test(cardNumber);
}

function validateCVV(cvv) {
  return /^\d{3}$/.test(cvv);
}

function validateExpiryDate(expiryDate) {
  return /^((0[1-9])|(1[0-2]))\/(\d{2})$/.test(expiryDate);
}
