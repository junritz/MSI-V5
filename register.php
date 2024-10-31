<?php
include('header.php');
?>
<link rel="stylesheet" href="assets/css/register.css" />
<!--====== CONTENT ======-->
<div class="wrapper position-relative d-flex align-items-center justify-content-center ">
  <fieldset class="form-fieldset w-100" id="register">
    <!-- <div class="logo-container">
      <img src="assets/images/pet-item-2.png" class="w-100 h-100" alt="" />
    </div> -->
    <h1 class="m-0 title text-center">Register</h1>
    <form action="" id="registerForm" class="register-form d-flex align-items-center flex-column mt-3 mb-4 gap-2 px-3">
      <div class="input-group mb-3">
        <span class="input-group-text">
          <i class="fa-solid fa-user text-success"></i>
        </span>
        <input type="text" class="form-control" name="fullName" id="fullName" placeholder="Enter full name" required />
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">
          <i class="fa-solid fa-envelope text-success"></i>
        </span>
        <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required />
      </div>
      <div class="input-group mb-3">
        <span class="input-group-text">
          <i class="fa-solid fa-lock text-success"></i>
        </span>
        <input type="password" class="form-control password-input" name="password" id="password" autocomplete="off" placeholder="Enter your password" required />
        <span class="toggle-password">
          <i class="fa-solid fa-eye" id="togglePassword"></i>
        </span>
      </div>

      <div class="input-group">
        <span class="input-group-text">
          <i class="fa-solid fa-lock text-success"></i>
        </span>
        <input type="password" class="form-control password-input" name="confirm_password" id="confirm_password" autocomplete="off" placeholder="Type your password again" required />
        <span class="toggle-password">
          <i class="fa-solid fa-eye" id="toggleConfirmPassword"></i>
        </span>
      </div>
      <!-- Terms and Conditions Section -->
      <div class="terms-condition w-100 mb-3 d-flex align-items-center gap-3">
      <input type="checkbox" name="terms-condition-check" id="terms-condition-check" />
        <label for="tems">I accept all terms & conditions</label>
      </div>

      <button type="submit" class="register-button">Submit</button>
    </form>
    <p>
      You already have an account?
      <span class="text-primary text-decoration-underline switch" id="login-btn">Login</span>
    </p>
  </fieldset>

  <fieldset class="form-fieldset w-100" id="login">
    <h1 class="m-0 title text-center">Login</h1>
    <form action="" id="loginForm" class="register-form d-flex align-items-center flex-column mt-3 mb-4 gap-2 px-3">
      <div class="input-group mb-3">
        <span class="input-group-text">
          <i class="fa-solid fa-envelope text-success"></i>
        </span>
        <input type="email" class="form-control" name="email" id="login-email" placeholder="Enter your email"
          required />
      </div>
      <div class="input-group">
        <span class="input-group-text">
          <i class="fa-solid fa-lock text-success"></i>
        </span>
        <input type="password" class="form-control password-input" name="password" id="login-password" autocomplete="off" placeholder="Enter your password" required />
        <span class="toggle-password">
          <i class="fa-solid fa-eye" id="togglePassword"></i>
        </span>
      </div>
      <div class="d-flex align-items-center justify-content-between w-100 mb-3">
        <div class="d-flex align-items-center gap-2">
          <input type="checkbox" name="remember-me" id="remember-me-input">
          <label for="remember-me">Remember me</label>
        </div>
        <a href="forgot-password.php" class="text-decoration-none text-dark"><small class="forgot-password">Forgot Password</small></a>
      </div>
      <button type="submit" class="register-button">Login</button>
    </form>
    <p>
      You don't have an account yet?
      <span class="text-primary text-decoration-underline switch" id="register-btn">Register</span>
    </p>
  </fieldset>
</div>

<!-- OTP VERIFICATION MODAL -->
<div class="modal fade" id="otp-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
  aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-body">
        <div class="text-center">
          <h4 id="otp-modal-title">OTP Verification</h4>
          <p class="text-secondary">
            A code has been sent to
            <span id="otp-email-account">email@gmail.com</span>
          </p>
          <p class="text-danger">
            OTP will expire in <span id="otp-timer">05:00</span>
          </p>
        </div>
        <form id="otp-form">
          <div class="d-flex align-items-center justify-content-center">
            <div id="otp" class="inputs d-flex flex-row justify-content-center mt-2">
              <input class="m-2 text-center form-control rounded" type="text" id="otp-first-input" maxlength="1" />
              <input class="m-2 text-center form-control rounded" type="text" id="otp-second-input" maxlength="1" />
              <input class="m-2 text-center form-control rounded" type="text" id="otp-third-input" maxlength="1" />
              <input class="m-2 text-center form-control rounded" type="text" id="otp-fourth-input" maxlength="1" />
              <input class="m-2 text-center form-control rounded" type="text" id="otp-fifth-input" maxlength="1" />
              <input class="m-2 text-center form-control rounded" type="text" id="otp-sixth-input" maxlength="1" />
            </div>
          </div>
      </div>
      <div class="text-center text-secondary resend-otp">
        <small>Did not receive an email?</small>
        <small class="m-0 text-primary" id="resend-otp-button">Resend OTP</small>
      </div>
      <div class="modal-footer border-0">
        <button type="submit" class="modal-button important-button m-auto">Validate</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- TERMS AND CONDITION MODAL -->
<div class="modal fade" id="termsModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
      </div>
      <div class="modal-body">
        <p style="text-align: justify;">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
          <br>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
          <br>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
          <br>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
          <br>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
          <br>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
          <br>
          <br>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque varius condimentum est a hendrerit. Quisque suscipit faucibus tortor eget facilisis. Etiam pellentesque dui ac dolor vulputate, a tempus arcu vestibulum. Morbi semper, orci a vehicula euismod, dui enim rutrum dolor, in vulputate urna enim at massa. Suspendisse hendrerit, erat vel vehicula consectetur, leo mauris placerat nunc, a tempor est libero sit amet dui. Praesent quis tellus quis felis mollis vulputate. Nunc non massa mauris. Sed ac posuere ante, vel lacinia enim. Ut ut est mi.
        </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" id="disagree-btn">Disagree</button>
        <button type="button" class="btn btn-primary" id="accept-terms-btn">Agree</button>
      </div>
    </div>
  </div>
</div>


<?php
include('footer.php');
include('toast-notification.php');
?>

<script type="module" src="assets/javascript/register.js"></script>