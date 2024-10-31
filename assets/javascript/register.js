import { registerForm, loginForm } from "./form-submission.js";

registerForm();
loginForm();

// FOR OTP
document.addEventListener("DOMContentLoaded", function (event) {
  function OTPInput() {
    const inputs = document.querySelectorAll("#otp > *[id]");
    for (let i = 0; i < inputs.length; i++) {
      inputs[i].addEventListener("keydown", function (event) {
        if (event.key === "Backspace") {
          inputs[i].value = "";
          if (i !== 0) inputs[i - 1].focus();
        } else {
          if (i === inputs.length - 1 && inputs[i].value !== "") {
            return true;
          } else if (event.keyCode > 47 && event.keyCode < 58) {
            inputs[i].value = event.key;
            if (i !== inputs.length - 1) inputs[i + 1].focus();
            event.preventDefault();
          } else if (event.keyCode > 64 && event.keyCode < 91) {
            inputs[i].value = String.fromCharCode(event.keyCode);
            if (i !== inputs.length - 1) inputs[i + 1].focus();
            event.preventDefault();
          }
        }
      });
    }
  }
  OTPInput();
});

const registerFieldSet = document.querySelector("#register");
const loginFieldSet = document.querySelector("#login");

document.querySelector("#login-btn").addEventListener("click", () => {
  registerFieldSet.style.display = "none";
  loginFieldSet.style.display = "flex";
});

document.querySelector("#register-btn").addEventListener("click", () => {
  registerFieldSet.style.display = "flex";
  loginFieldSet.style.display = "none";
});

document.addEventListener("DOMContentLoaded", function () {
  // Function to toggle password visibility and icon
  function togglePasswordVisibility(toggleButton, passwordField) {
    const type =
      passwordField.getAttribute("type") === "password" ? "text" : "password";
    passwordField.setAttribute("type", type);

    // Toggle between fa-eye and fa-eye-slash
    if (type === "text") {
      toggleButton.classList.remove("fa-eye");
      toggleButton.classList.add("fa-eye-slash");
    } else {
      toggleButton.classList.remove("fa-eye-slash");
      toggleButton.classList.add("fa-eye");
    }
  }

  // Register form password fields
  const togglePasswordRegister = document.querySelector("#togglePassword");
  const passwordInputRegister = document.querySelector("#password");
  const toggleConfirmPasswordRegister = document.querySelector(
    "#toggleConfirmPassword"
  );
  const confirmPasswordInputRegister =
    document.querySelector("#confirm-password");

  togglePasswordRegister.addEventListener("click", function () {
    togglePasswordVisibility(this, passwordInputRegister);
  });

  toggleConfirmPasswordRegister.addEventListener("click", function () {
    togglePasswordVisibility(this, confirmPasswordInputRegister);
  });

  // Login form password field
  const togglePasswordLogin = document.querySelector("#login #togglePassword");
  const passwordInputLogin = document.querySelector("#login-password");

  togglePasswordLogin.addEventListener("click", function () {
    togglePasswordVisibility(this, passwordInputLogin);
  });
});

// Get the checkbox, modal, agree, and disagree button elements
const checkbox = document.getElementById("terms-condition-check");
const termsModal = new bootstrap.Modal(document.getElementById("termsModal"));
const acceptButton = document.getElementById("accept-terms-btn");
const disagreeButton = document.getElementById("disagree-btn");

// Add event listener for checkbox change
checkbox.addEventListener("change", function () {
  if (this.checked) {
    // Show the modal when the checkbox is checked
    termsModal.show();
  }
});

// Add event listener for the Agree button
acceptButton.addEventListener("click", function () {
  // Keep the checkbox checked if the user clicks the Agree button
  termsModal.hide(); // Hide the modal after accepting
});

// Add event listener for the Disagree button
disagreeButton.addEventListener("click", function () {
  // Uncheck the checkbox when the Disagree button is clicked
  checkbox.checked = false;
  termsModal.hide(); // Hide the modal after disagreeing
});


