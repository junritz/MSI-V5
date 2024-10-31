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
    <div class="d-flex justify-content-end mb-3 gap-2">
      <button type="button" class="action-btn" data-bs-toggle="modal" data-bs-target="#create-product">Add Product</button>
      <button type="button" class="action-btn" data-bs-toggle="modal" data-bs-target="#edit-vat">Vat Tax</button>
    </div>
    <!-- Product Catalog -->
    <div class="table-container rounded" id="productTable">
      <div class="search-container d-flex justify-content-between flex-wrap gap-2 mb-3">
        <h4 class="m-0">Products Catalog</h4>
        <form id="product-search-form" class="d-flex search-form" role="search">
          <input class="form-control me-2 search-input" type="search" placeholder="Search product name or ID" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

      </div>
      <div class="table-responsive rounded">
        <!-- Table and pagination for product table -->
        <table class="table table-striped table-borderless">
          <thead class="table">
            <tr>
              <th>Product ID</th>
              <th>Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Actions</th>
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


<!-- CREATE MODAL -->
<div class="modal fade" id="create-product" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="create-productLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="create-productLabel">Add New Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="m-0">Product Details</h4>
        <small class="text-secondary">Please ensure the details are correct.</small>
        <form id="product-form" enctype="multipart/form-data">
          <div class="row pb-4">
            <!-- Product Name -->
            <div class="col-12">
              <div class="form-group mt-3">
                <label for="product-name">Product Name</label>
                <input type="text" name="product-name" id="product-name" required placeholder="Enter product name" class="form-control">
              </div>
            </div>
            <!-- Product Image -->
            <div class="col-12">
              <div class="form-group mt-3">
                <label for="product-image">Product Image <small class="text-secondary">(jpg, jpeg, png, webp files only)</small></label>
                <input type="file" name="product-image" id="product-image" required class="form-control" accept=".jpg, .jpeg, .png, .webp">
              </div>
            </div>
            <!-- Product Categories -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="categories">Categories</label>
                <select class="form-select" required aria-label="Select Product Category" name="categories" id="categories">
                  <option value="" disabled selected>Select Category</option>
                  <option value="Apparel">Apparel</option>
                  <option value="Mugs & Drinkware">Mugs & Drinkware</option>
                  <option value="Accessories">Accessories</option>
                  <option value="Frames">Frames</option>
                  <option value="Bags">Bags</option>
                  <option value="Stationery">Stationery</option>
                  <option value="Gadgets">Gadgets</option>
                  <option value="Others">Others</option>
                </select>
              </div>
            </div>
            <!-- Product Discount -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="discount-percentage">Discount Percentage <small class="text-secondary">(number only)</small></label>
                <input type="number" name="discount-percentage" id="discount-percentage" placeholder="Enter discount percentage" class="form-control" min="0" max="100" step="0.01">
              </div>
            </div>
            <!-- Stocks -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="stocks-count">Stocks <small class="text-secondary">(number only)</small></label>
                <input type="number" required name="stocks-count" id="stocks-count" placeholder="Enter stock quantity" class="form-control" min="1">
              </div>
            </div>
            <!-- Price -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="price">Price <small class="text-secondary">(number only)</small></label>
                <input type="number" required name="price" id="price" placeholder="Enter product price" class="form-control" step="0.01" min="0">
              </div>
            </div>
          </div>

      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="modal-button" form="product-form">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>


<!-- EDIT MODAL-->
<div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="edit-modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-5" id="edit-modalLabel">Edit Product</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h4 class="m-0">Product Details</h4>
        <small class="text-secondary">Please ensure the details are correct.</small>
        <form action="" id="edit-product-form">
          <input type="hidden" name="edit-product-id" id="edit-product-id">
          <div class="row pb-4">
            <div class="col-12">
              <div class="d-flex flex-column justify-content-center align-items-center mt-3">
                <label for="edit-product-image">Product Image (Current)</small></label>
                <!-- Image preview for the current product image -->
                <div class="mb-3">
                  <img id="current-product-image" src="" alt="Current Product Image" class="img-fluid img-thumbnail" style="max-width: 300px; height: 15em;">
                </div>
              </div>
            </div>
            <!-- Product Name -->
            <div class="col-12">
              <div class="form-group mt-3">
                <label for="edit-product-name">Product Name</label>
                <input type="text" name="product-name" id="edit-product-name" required placeholder="Enter product name" class="form-control">
                <div class="invalid-feedback">Please enter the product name.</div>
              </div>
            </div>
            <!-- Edit Product Image optionally -->
            <div class="col-12">
              <div class="form-group mt-3">
                <label for="edit-product-image">Edit Product Image</label>
                <input type="file" name="product-image" id="edit-product-image" class="form-control" accept=".jpg, .jpeg, .png, .webp">
                <div class="invalid-feedback">Please upload a valid product image (jpg, jpeg, png, or webp).</div>
              </div>
            </div>
            <!-- Product Categories -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="edit-categories">Categories</label>
                <select class="form-select" required aria-label="Select Product Category" name="categories" id="edit-categories">
                  <option value="" disabled selected>Select Category</option>
                  <option value="T-shirt">T-shirt</option>
                  <option value="Polo shirt">Polo shirt</option>
                  <option value="PE uniforms">PE uniforms</option>
                  <option value="Jacket">Jacket</option>
                  <option value="Sweatshirt">Sweatshirt</option>
                  <option value="Jersey">Jersey</option>
                  <option value="Vest/Blazer">Vest/Blazer</option>
                  <option value="Glass Clock"> Glass Clock</option>
                  <option value="Badge Pin">Badge Pin</option>
                  <option value="Pillow">Pillow</option>
                  <option value="Mug">Mug</option>
                  <option value="Magic Mug">Magic Mug</option>
                  <option value="Tumbler">Tumbler</option>
                  <option value="Cellphone Case">Cellphone Case</option>
                  <option value="Photo Rock">Photo Rock</option>
                  <option value="Glass Frame">Glass Frame</option>
                  <option value="Wall Picture">Wall Picture</option>
                  <option value="Stand Frame">Stand Frame</option>
                  <option value="Tote Bag">Tote Bag</option>
                  <option value="Ballpen">Ballpen</option>
                  <option value="Bottle Opener">Bottle Opener</option>
                  <option value="Ref Magnet">Ref Magnet</option>
                  <option value="Keychain">Keychain</option>
                  <option value="Mousepad">Mousepad</option>
                  <option value="Gaming mousepad">Gaming mousepad</option>
                  <option value="Notebook">Notebook</option>
                  <option value="Foldable Fan">Foldable Fan</option>
                  <option value="Umbrella">Umbrella</option>
                  <option value="Cap">Cap</option>
                  <option value="Others">Others</option>
                </select>
                <div class="invalid-feedback">Please select a product category.</div>
              </div>
            </div>
            <!-- Product Discount-->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="discounts-count">Discount <small class="text-secondary">(number only)</small></label>
                <input type="number" required name="edit-discount-percentage" id="edit-discount-percentage" placeholder="Enter discount number" class="form-control" min="1">
              </div>
            </div>
            <!-- Product Stock -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="edit-product-stock">Stocks <small class="text-secondary">(number only)</small></label>
                <input type="number" required name="product-stock" id="edit-product-stock" placeholder="Enter stock quantity" class="form-control" min="1">
                <div class="invalid-feedback">Please enter a valid stock quantity.</div>
              </div>
            </div>
            <!-- Product Price -->
            <div class="col-lg-6 col-sm-12">
              <div class="form-group mt-3">
                <label for="edit-price">Price <small class="text-secondary">(number only)</small></label>
                <input type="number" required name="price" id="edit-price" placeholder="Enter product price" class="form-control" step="0.01" min="0">
                <div class="invalid-feedback">Please enter a valid price.</div>
              </div>
            </div>
          </div>
      </div>
      <div class="modal-footer mt-2 border-0">
        <button type="button" class="btn btn-outline-secondary py-1 px-2" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="modal-button">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- EDIT VAT TAX MODAL-->
<div class="modal fade" id="edit-vat" tabindex="-1" aria-labelledby="vat-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-5" id="vat-modalLabel">Edit VAT Tax</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="vat-tax-form">
          <div class="form-group mb-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
              <label for="vat-tax" class="form-label">VAT Tax (%)</label>
              <p class="m-0 text-secondary" id="current-tax"></p>
            </div>
            <input type="number" step="0.01" id="vat-tax" name="vat-tax" class="form-control" placeholder="Enter VAT tax percentage" required>
          </div>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-outline-secondary px-3 py-1" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="modal-button">Update</button>
      </div>
      </form>
    </div>
  </div>
</div>



<!-- DELETE MODAL-->
<div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="delete-modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white border-0">
        <h1 class="modal-title fs-5" id="delete-modalLabel">
          Confirm Product Deletion
        </h1>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <p class="text-danger m-0">
          <i class="fas fa-exclamation-circle me-1 fs-5"></i> Are you sure you want to delete this product? This action cannot be undone.
        </p>
        <p><strong>Product Name:</strong> <span id="delete-product-name" class="text-primary"></span></p>
        <form action="" id="delete-product-form">
          <input type="hidden" name="delete-product-id" id="delete-product-id" required>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="fas fa-times"></i> Cancel
        </button>
        <button type="submit" class="btn btn-danger" id="confirm-delete-btn">
          <i class="fas fa-trash-alt"></i> Delete
        </button>
      </div>
      </form>
    </div>
  </div>
</div>



<?php
include('footer.php');
include('toast-notification.php');
?>

<script type="module" src="assets/javascript/admin-products.js"></script>