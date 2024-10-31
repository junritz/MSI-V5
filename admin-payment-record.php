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
  <section class="container-fluid mt-2 pb-5">
    <div class="d-flex justify-content-end mb-3">
      <button type="button" class="action-btn" data-bs-toggle="modal" data-bs-target="#createEventModal">Generate PDF</button>
    </div>

    <!-- ORDER RECORD Table -->
    <div class="table-container rounded" id="payment-record-table">
      <div class="search-container d-flex justify-content-between flex-wrap gap-2 mb-3">
        <h4 class="m-0">Payment Record</h4>
        <form id="payment-search-form" class="d-flex search-form" role="search">
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
              <th>Product ID</th>
              <th class="text-center">Quantity</th>
              <th class="text-center">Total Amount</th>
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


<!-- VIEW MODAL -->
<div class="modal fade" id="view-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="view-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="view-modalLabel">Order Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="view-order-form">
          <div class="container">

            <!-- User Details Section -->
            <div class="card mb-3">
              <div class="card-header">Customer Details</div>
              <div class="card-body">
                <div class="row">
                  <!-- Full Name -->
                  <div class="col-md-4 mb-3">
                    <label for="view-order-full-name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="view-order-full-name" name="view-order-full-name" readonly>
                  </div>
                  <!-- Email -->
                  <div class="col-md-4 mb-3">
                    <label for="view-order-email" class="form-label">Email</label>
                    <input type="text" class="form-control" id="view-order-email" name="view-order-email" readonly>
                  </div>
                  <!-- Contact Number -->
                  <div class="col-md-4 mb-3">
                    <label for="view-contact-number" class="form-label">Contact Number</label>
                    <input type="text" class="form-control" id="view-contact-number" name="view-contact-number" readonly>
                  </div>
                  <!-- Address -->
                  <div class="col-md-12 mb-3">
                    <label for="view-address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="view-address" name="view-address" readonly>
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
                    <label for="view-order-id" class="form-label">Order ID</label>
                    <input type="text" class="form-control" id="view-order-id" name="view-order-id" readonly>
                  </div>
                  <!-- Order Date -->
                  <div class="col-md-6 mb-3">
                    <label for="view-order-date" class="form-label">Order Date</label>
                    <input type="text" class="form-control" id="view-order-date" name="view-order-date" readonly>
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
                    <label for="view-product-id" class="form-label">Product ID</label>
                    <input type="text" class="form-control" id="view-product-id" name="view-product-id" readonly>
                  </div>
                  <!-- Product Name -->
                  <div class="col-md-6 mb-3">
                    <label for="view-product-name" class="form-label">Product Name</label>
                    <input type="text" class="form-control" id="view-product-name" name="view-product-name" readonly>
                  </div>
                  <!-- Quantity -->
                  <div class="col-md-6 mb-3">
                    <label for="view-order-quantity" class="form-label">Quantity</label>
                    <input type="text" class="form-control" id="view-order-quantity" name="view-order-quantity" readonly>
                  </div>
                  <!-- Product Price -->
                  <div class="col-md-6 mb-3">
                    <label for="view-product-price" class="form-label">Product Price</label>
                    <input type="text" class="form-control" id="view-product-price" name="view-product-price" readonly>
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
                    <label for="view-vat" class="form-label">VAT</label>
                    <input type="text" class="form-control" id="view-vat" name="view-vat" readonly>
                  </div>
                  <!-- Total Amount -->
                  <div class="col-md-4 mb-3">
                    <label for="view-total-amount" class="form-label">Total Amount</label>
                    <input type="text" class="form-control" id="view-total-amount" name="view-total-amount" readonly>
                  </div>
                  <!-- Downpayment -->
                  <div class="col-md-4 mb-3">
                    <label for="view-downpayment" class="form-label">Downpayment</label>
                    <input type="text" class="form-control" id="view-downpayment" name="view-downpayment" readonly>
                  </div>
                  <!-- Balance -->
                  <div class="col-md-12 mb-3">
                    <label for="view-balance" class="form-label">Balance</label>
                    <input type="text" class="form-control" id="view-balance" name="view-balance" readonly>
                  </div>
                </div>
              </div>
            </div>

            <!-- Status Details Section -->
            <div class="card mb-3">
              <div class="card-header">Status Details</div>
              <div class="card-body">
                <div class="row">
                  <!-- ORDER STATUS -->
                  <div class="col-md-6 mb-3">
                    <label for="view-order-status" class="form-label">Order Status</label>
                    <input type="text" class="form-control" id="view-order-status" name="view-order-status" readonly>
                  </div>
                  <!-- ORDER STATUS DATE -->
                  <div class="col-md-6 mb-3">
                    <label for="view-status-date" class="form-label">Date</label>
                    <input type="text" class="form-control" id="view-order-date" name="view-order-date" readonly>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </form>

      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary px-2 py-1" data-bs-dismiss="modal">Close</button>
        <button type="button" class="modal-button" disabled>VIEW</button>
      </div>
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
        <form action="" id="order-payment-delete">
          <div class="d-flex align-items-center justify-content-center  gap-2 flex-wrap">
            <label for="">Order ID:</label>
            <input type="text" name="payment_order_id" id="payment_order_id" required class="border-0 outline-0 bg-transparent w-25" style="pointer-events: none;">
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


<script type="module" src="assets/javascript/admin-payment-record.js"></script>