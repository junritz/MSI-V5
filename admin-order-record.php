<?php
include('header.php');
?>

<?php
include_once('admin-sidebar.php');
?>

<main class="main position-absolute overflow-hidden">
  <!-- TOP SECTIONS -->
  <div class="topbar">
    <div class="toggle position-relative text-white"><i class="fa-solid fa-bars text-dark"></i></div>
  </div>

  <!-- MAIN CONTENT -->
  <section class="container-fluid mt-5 pb-5">
    <!-- ORDER RECORD Table -->
    <div class="table-container rounded" id="order-record-table">
      <div class="search-container d-flex justify-content-between flex-wrap gap-2 mb-3">
        <h4 class="m-0">Order Record</h4>
        <form id="order-search-form" class="d-flex search-form" role="search">
          <input class="form-control me-2 search-input" type="search" placeholder="Search by customer name or Order ID" aria-label="Search">
          <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
      </div>

      <div class="table-responsive rounded">
        <!-- Table and pagination for reservation table -->
        <table class="table table-striped table-borderless">
          <thead class="table">
            <tr>
              <th>Order ID</th>
              <th>Name</th>
              <th class="text-center">Email</th>
              <th class="text-center">Order Date</th>
              <th class="text-center">Product ID</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Total Amount</th>
              <th class="text-center">Order Status</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Dynamic data will be inserted here -->
          </tbody>
        </table>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <!-- Pagination will be inserted dynamically here -->
          </ul>
        </nav>
      </div>
    </div>
  </section>
</main>

<!-- EMAIL MODAL -->
<div class="modal fade" id="email-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="email-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5 d-flex align-items-center" id="email-modalLabel">Notify Customer for Pickup</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-envelope text-primary me-2 fs-1"></i>
        <p class="text-muted">
          Would you like to send an email to inform the customer that their order is ready for pickup? Please review the email address and message below before sending.
        </p>
        <form action="" id="email-form">
          <!-- Hidden field to store order ID -->
          <input type="text" name="email_order_id" id="email_order_id">
          <div class="d-flex flex-column align-items-center gap-2">
            <div class="form-group w-100">
              <label for="customer_email">Customer Email:</label>
              <input type="email" name="customer_email" id="customer_email" required class="form-control" readonly>
            </div>
            <div class="form-group w-100">
              <label for="email_message">Message:</label>
              <textarea name="email_message" id="email_message" required class="form-control" placeholder="Enter your message here"></textarea>
            </div>
          </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary px-2 py-1" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="modal-button" id="confirm-send-btn">Send Email</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- RELEASE MODAL -->
<div class="modal fade" id="release-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="release-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="release-modalLabel">Order Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="release-order-form">
          <div class="container">

            <!-- User Details Section -->
            <div class="card mb-3">
              <div class="card-header">Customer Details</div>
              <div class="card-body">
                <div class="row">
                  <!-- Full Name -->
                  <div class="col-md-4 mb-3">
                    <label for="release-order-full-name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="release-order-full-name" name="release-order-full-name" readonly>
                  </div>
                  <!-- Email -->
                  <div class="col-md-4 mb-3">
                    <label for="release-order-email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="release-order-email" name="release-order-email" readonly>
                  </div>
                  <!-- Contact Number -->
                  <div class="col-md-4 mb-3">
                    <label for="release-contact-number" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="release-contact-number" name="release-contact-number" readonly>
                  </div>
                  <!-- Address -->
                  <div class="col-md-12 mb-3">
                    <label for="release-address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="release-address" name="release-address" readonly>
                  </div>
                </div>
              </div>
            </div>

            <!-- Order Details Section -->
            <div class="card mb-3">
              <div class="card-header">Order Details</div>
              <div class="card-body">
                <div class="row">
                  <!-- Order ID -->
                  <div class="col-md-6 mb-3">
                    <label for="release-order-id" class="form-label">Order ID</label>
                    <input type="text" class="form-control" id="release-order-id" name="release-order-id" readonly>
                  </div>
                  <!-- Order Date -->
                  <div class="col-md-6 mb-3">
                    <label for="release-order-date" class="form-label">Order Date</label>
                    <input type="text" class="form-control" id="release-order-date" name="release-order-date" readonly>
                  </div>
                </div>
              </div>
            </div>

            <!-- Product Details Section -->
            <div class="card mb-3">
              <div class="card-header">Product Details</div>
              <div class="card-body">
                <div class="row">
                  <!-- Product ID -->
                  <div class="col-md-6 mb-3">
                    <label for="release-product-id" class="form-label">Product ID</label>
                    <input type="text" class="form-control" id="release-product-id" name="release-product-id" readonly>
                  </div>
                  <!-- Product Name -->
                  <div class="col-md-6 mb-3">
                    <label for="release-product-name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="release-product-name" name="release-product-name" readonly>
                  </div>
                  <!-- Quantity -->
                  <div class="col-md-6 mb-3">
                    <label for="release-order-quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control" id="release-order-quantity" name="release-order-quantity" readonly>
                  </div>
                  <!-- Product Price -->
                  <div class="col-md-6 mb-3">
                    <label for="release-product-price" class="form-label">Product Price</label>
                    <input type="text" class="form-control" id="release-product-price" name="release-product-price" readonly>
                  </div>
                </div>
              </div>
            </div>

            <!-- Billing Details Section -->
            <div class="card mb-3">
              <div class="card-header">Billing Details</div>
              <div class="card-body">
                <div class="row">
                  <!-- VAT -->
                  <div class="col-md-4 mb-3">
                    <label for="release-vat" class="form-label">VAT</label>
                    <input type="text" class="form-control" id="release-vat" name="release-vat" readonly>
                  </div>
                  <!-- Total Amount -->
                  <div class="col-md-4 mb-3">
                    <label for="release-total-amount" class="form-label">Total Amount</label>
                    <input type="text" class="form-control" id="release-total-amount" name="release-total-amount" readonly>
                  </div>
                  <!-- Downpayment -->
                  <div class="col-md-4 mb-3">
                    <label for="release-downpayment" class="form-label">Downpayment</label>
                    <input type="text" class="form-control" id="release-downpayment" name="release-downpayment" readonly>
                  </div>
                  <!-- Balance -->
                  <div class="col-md-12 mb-3">
                    <label for="release-balance" class="form-label">Balance</label>
                    <input type="text" class="form-control" id="release-balance" name="release-balance" readonly>
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary px-2 py-1" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="modal-button">Release</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- DELETE MODAL -->
<div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="delete-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <!-- Icon and Title -->
        <h1 class="modal-title fs-5 d-flex align-items-center" id="delete-modalLabel">
          Delete Order
        </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <i class="fas fa-exclamation-triangle text-warning me-2 fs-2"></i>
        <!-- Informative Text -->
        <p class="text-danger">
          Are you sure you want to delete this order? This action cannot be undone, and all data related to this order will be permanently removed.
        </p>
        <form action="" id="order-delete">
          <div class="d-flex align-items-center justify-content-center  gap-2 flex-wrap">
            <label for="">Order ID:</label>
            <input type="text" name="order_id" id="order_id" required class="border-0 outline-0 bg-transparent w-25" style="pointer-events: none;">
          </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" id="confirm-delete-btn">Delete Order</button>
      </div>
      </form>
    </div>
  </div>
</div>

<?php
include_once('footer.php');
include_once('toast-notification.php');
?>


<script type="module" src="assets/javascript/admin-order-record.js"></script>