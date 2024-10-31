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
      <button type="button" class="action-btn" data-bs-toggle="modal" data-bs-target="#createEventModal">Create Account</button>
    </div>

    <!-- Registered Users Table -->
    <div class="table-container rounded" id="users-table">
      <div class="search-container d-flex justify-content-between flex-wrap gap-2 mb-3">
        <h4 class="m-0">Users Record</h4>
        <form id="user-search-form" class="d-flex search-form" role="search">
          <input class="form-control me-2 search-input" type="search" placeholder="Search by name or User ID" aria-label="Search">
          <button class="btn btn-outline-primary" type="submit">Search</button>
        </form>
      </div>

      <div class="table-responsive rounded">
        <!-- Table and pagination for reservation table -->
        <table class="table table-striped table-borderless">
          <thead class="table">
            <tr>
              <th>User ID</th>
              <th>Name</th>
              <th class="text-center">Email</th>
              <th>Contact Number</th>
              <th class="text-center">Created at</th>
              <th class='text-center'>Gender</th>
              <th class="text-center">Status</th>
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Delete User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="delete-user-form">
          Are you sure you want to delete this user?
          <input type="hidden" id="deleteUserId">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
      </div>
      </form>
    </div>
  </div>
</div>



<?php
include_once('footer.php');
include_once('toast-notification.php');
?>

<script type="module" src="assets/javascript/admin-registered-user.js"></script>