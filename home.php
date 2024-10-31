<?php
include('header.php');
?>
<link rel="stylesheet" href="assets/CSS/user.css">


<div class="navbar-header">
  <div class="navbar-header-left-section">
    <a href="user-home.php" class="pb-1">
      <img class="navbar-brand"
        src="assets/images/brand-logo.png">
      <img class="amazon-mobile-logo"
        src="assets/images/urban-small-screen.png">
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
    <a class="orders-link header-link d-flex flex-column " href="register.php">
      <span class="account-name">Hello, Sign in</span>
      <span class="account-details">Accounts Details</span>
    </a>
  </div>
</div>


<section class="container-fluid d-flex align-items-center justify-content-center">
  <div class="product-container mt-4">
    <div class="row gy-3">
      <div class="col-12">
        <div id="carouselExampleIndicators" class="carousel slide" style="height: 26em;">
          <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
          </div>
          <div class="carousel-inner h-100 rounded">
            <div class="carousel-item active h-100">
              <img src="assets/images/slide-1-img.png" class="d-block w-100 h-100" alt="..." >
            </div>
            <div class="carousel-item h-100">
              <img src="assets/images/slide-2-img.png" class="d-block w-100 h-100" alt="..." >
            </div>
            <div class="carousel-item h-100">
              <img src="assets/images/slide-3-img.png" class="d-block w-100 h-100" alt="...">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
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
      <h1>Marco<b class="accent">Media</b></h1>
      <p>service provider</p>
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

<script type="module" src="assets/javascript/home.js"></script>