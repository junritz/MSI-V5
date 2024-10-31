<!-- CSS FOR SIDE BAR -->
<link rel="stylesheet" href="assets/CSS/sidebar.css">
<!-- ADMIN SIDE -->
<link rel="stylesheet" href="assets/CSS/admin-side.css">

<!-- SideBar Navigation -->
<div class="container position-relative m-0 p-0 navigation-container">
  <div class="navigation position-fixed h-100 overflow-hidden">
    <ul class="position-absolute top-0 left-0 m-0 p-0">
      <li class="pe-none">
        <a href="#" class="position-relative d-flex align-items-center gap-2 justify-content-center text-center">
          <span class="icon position-relative d-block text-center py-2"><img src="" class="img-fluid" alt=""></span>
        </a>
        <hr class="line">
      </li>
      <!-- Dashboard Button -->
      <li>
        <a href="admin-dashboard.php" class="position-relative d-flex align-items-center">
          <span class="icon position-relative d-block text-center"><i class="fas fa-tachometer-alt"></i></span>
          <span class="title">Overview</span>
        </a>
      </li>

      <!-- Products Button -->
      <li>
        <a href="admin-create-products.php" class="position-relative d-flex align-items-center">
          <span class="icon position-relative d-block text-center"><i class="fa-solid fa-cart-shopping"></i></span>
          <span class="title">Products</span>
        </a>
      </li>
      <!-- Registered User Button -->
      <li>
        <a href="admin-registered-users.php" class="position-relative d-flex align-items-center">
          <span class="icon position-relative d-block text-center"><i class="fas fa-users"></i></span>
          <span class="title">Registered User</span>
        </a>
      </li>
        <!-- Order Record Button -->
        <li>
        <a href="admin-order-record.php" class="position-relative d-flex align-items-center">
          <span class="icon position-relative d-block text-center"><i class="fa-solid fa-truck-ramp-box"></i></span>
          <span class="title">Order Record</span>
        </a>
      </li>
      <!-- Payment Record Button -->
      <li>
        <a href="admin-payment-record.php" class="position-relative d-flex align-items-center">
          <span class="icon position-relative d-block text-center"><i class="fas fa-file-invoice-dollar"></i></span>
          <span class="title">Payment Record</span>
        </a>
      </li>
      <li>
        <a href="admin-payment-record.php" class="position-relative d-flex align-items-center">
          <span class="icon position-relative d-block text-center"><i class="fa-solid fa-arrow-right-from-bracket"></i></span>
          <span class="title">Logout</span>
        </a>
      </li>
    </ul>

    <div class="position-absolute w-100  bottom-0 d-flex align-items-center justify-content-center flex-column">
      <hr class="line m-0">
      <div class="logo-container d-flex mt-2 gap-2 align-items-center mb-2">
          <h1 class="fs-4 m-0 text-light">Sample<b>Logo</b></h1> 
      </div>
    </div>
  </div>
</div>