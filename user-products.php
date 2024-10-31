<?php
include('header.php');
require_once('assets/backend/authorization.php');
?>
<link rel="stylesheet" href="assets/CSS/user.css">


<div class="navbar-header">
  <div class="navbar-header-left-section">
    <a href="user-home.php" class="pb-1">
      <img class="navbar-brand"
        src="assets/images/brand-logo.png">
      <img class="amazon-mobile-logo"
        src="assets/images/brand-logo.png">
    </a>
  </div>

  <div class="navbar-header-middle-section">
    <input class="search-bar" type="text" placeholder="Search">
    <button class="search-button">
      <img class="search-icon" src="assets/images/icons/search-icon.png">
    </button>
    <div class="suggestions-container">
      <!-- Suggestions dynamically loaded here -->
    </div>
  </div>

  <div class="navbar-header-right-section">
    <a class="orders-link header-link d-flex flex-column " href="user-details.php">
      <span class="account-name">Hello, <?php echo $_SESSION['full_name']; ?></span>
      <span class="account-details">Accounts Details</span>
    </a>
  </div>
</div>


<section class="container-fluid d-flex align-items-center justify-content-center">
  <div class="product-container mt-5">
    <div class="row">
      <div class="col-lg-2">
        <!-- Categories Selection -->
        <div class="categories-container d-flex flex-column align-items-start">
          <div class="d-flex align-items-center gap-2 mb-3">
            <i class="fa-solid fa-filter"></i>
            <h5 class="m-0">Search Filter</h5>
          </div>
          <small>By Category</small>

          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="all" id="all">
            <label for="all">All</label>
          </div>
          <!-- Bags -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="bags" id="bags">
            <label for="bags">Bags</label>
          </div>
          <!-- Apparel -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="apparel" id="apparel">
            <label for="apparel">Apparel</label>
          </div>
          <!-- Frames -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="frames" id="frames">
            <label for="frames">Frames</label>
          </div>
          <!-- Gadgets -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="gadgets" id="gadgets">
            <label for="gadgets">Gadgets</label>
          </div>
          <!-- Stationery -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="stationery" id="stationery">
            <label for="stationery">Stationery</label>
          </div>
          <!-- Accessories -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="accessories" id="accessories">
            <label for="accessories">Accessories</label>
          </div>
          <!-- Mugs & Drinkware -->
          <div class="form-group mt-2 d-flex align-items-center gap-2">
            <input type="checkbox" name="mugs" id="mugs">
            <label for="mugs">Mugs & Drinkware</label>
          </div>
        </div>
      </div>
      <div class="col-lg-10">
        <h4>Our Product</h4>
        <div class="card-container mt-4">
          <div class="row" id="user-product-container">
            <!-- DISPLAY CARDS DYNAMIC -->
          </div>
          <nav aria-label="Page navigation example" class="mt-5">
            <ul class="pagination justify-content-center" id="pagination-container">
              <!-- Pagination buttons will be populated dynamically -->
            </ul>
          </nav>

        </div>
      </div>
    </div>

  </div>
</section>

<div class="modal fade" id="check-out-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-3" id="exampleModalLabel">Order Checkout</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" id="payment-form">
          <h5 class="m-0">Customer Details</h5>
          <small class="text-secondary">Please make sure all details are correct</small>
          <!-- Hidden fields to store order data -->
          <input type="text" name="cart_items" id="cart_items" hidden>

          <div class="row mb-3">
            <!-- User Details -->
            <div class="col-lg-6 col-sm-12">
              <div class="user-details mt-3">
                <label for="full_name">Fullname</label>
                <input type="text" class="form-control" readonly name="full_name" id="full_name" required value="<?php echo $_SESSION['full_name']; ?>">
              </div>
            </div>
            <div class="col-lg-6 col-sm-12">
              <div class="user-details mt-3">
                <label for="contact_number">Contact Number</label>
                <input type="tel" class="form-control" name="contact_number" id="contact_number" minlength="11" required>
              </div>
            </div>
            <div class="col-12">
              <div class="user-details mt-3">
                <label for="address">Address (House number, Street, Municipality, Zone)</label>
                <input type="text" class="form-control" name="address" id="address" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12">
              <div class="user-details mt-3">
                <label for="email">Email</label>
                <input type="email" class="form-control" readonly name="email" id="email" value="<?php echo $_SESSION['email']; ?>" required>
              </div>
            </div>
            <div class="col-lg-6 col-sm-12">
              <div class="user-details mt-3">
                <label for="downpayment">Downpayment</label>
                <input type="number" class="form-control" name="downpayment" id="downpayment" min='0' required>
              </div>
            </div>
          </div>

          <!-- Section for displaying product details -->
          <h4 class="m-0">Product Details</h4>
          <small class="text-secondary">Review your order before proceeding</small>
          <div class="order-summary mb-4 bg-light border p-3 rounded">
            <div class="row gy-1">
              <div class="col-12">
                <p class="m-0">Product: <span id="modal-product-name"></span></p>
              </div>
              <div class="col-12">
                <p class="m-0">Quantity: <span id="modal-quantity"></span></p>
              </div>
              <div class="col-12">
                <p class="m-0">Total Amount (VAT Incl.):₱<span id="modal-total-amount"></span></p>
              </div>
            </div>
          </div>

          <div class="modal-footer border-0 mt-4">
            <button type="button" class="btn btn-outline-secondary px-2 py-1" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="modal-button">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<footer class="footer" id="footer">
  <div class="footer-container">
    <div class="footer-links">
      <h2 class="">Quick Links</h2>
      <div class="link-container">
        <div class="links">
          <a href="">Home</a>
          <a href="home.html#about">About</a>
          <a href="home.html#owner">Procedure</a>
        </div>
        <div class="links">
          <a href="">Products</a>
          <a href="home.html#about">Contact</a>
          <a href="home.html#owner">Register/Login</a>
        </div>
      </div>
    </div>
    <div class="footer-brand">
      <h1>Sample<b class="accent">Logo</b></h1>
      <p>sample footer details!</p>
      <div class="socials">
        <a href=""><i class="fa-brands fa-facebook fs-5"></i></a>
        <a href=""><i class="fa-brands fa-twitter fs-5"></i></a>
        <a href=""><i class="fa-brands fa-instagram fs-5"></i></a>
        <a href=""><i class="fa-brands fa-tiktok fs-5"></i></a>
      </div>
    </div>
    <div class="footer-contact-info">
      <div class="contact-info-item">
        <i class="fa-regular fa-envelope"></i>
        <p class="m-0">sample@gmail.com</p>
      </div>
      <div class="contact-info-item">
        <i class="fa-solid fa-phone"></i>
        <p class="m-0">(+63) 0993 333 2523</p>
      </div>
    </div>
  </div>
  <p class="copyright">All Rights Reserved to <b>Croco</b></p>
</footer>

<?php
include_once('footer.php');
include_once('toast-notification.php');
?>

<script type="module" src="assets/javascript/user-products.js"></script>