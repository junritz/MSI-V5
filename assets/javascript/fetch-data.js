import { pagination } from "./pagination.js";
import { showToast, formatDateTime } from "./utility.js";

export function adminProductDisplay(page = 1, search = "") {
  $.ajax({
    url: "assets/fetch-data/admin-get-products-table.php",
    method: "GET",
    data: {
      page: page,
      search: search,
    },
    dataType: "json",
    success: function (response) {
      const tbody = $("tbody");
      tbody.empty();

      if (response.status === "success") {
        if (response.products.length === 0) {
          tbody.append(`
            <tr>
              <td colspan="6" class="text-center">No products available. Please add new products to display them here.</td>
            </tr>
          `);
        } else {
          response.products.forEach((product) => {
            tbody.append(`
              <tr>
                <td>${product.product_id}</td>
                <td>${product.product_name}</td>
                <td>${product.categories}</td>
                <td>₱${product.price}</td>
                <td>${product.stock_count} pcs</td>
                <td class="d-flex align-items-center flex-column gap-2">
                  <button class="table-button edit-btn" data-bs-toggle="modal" data-bs-target="#edit-modal"
                    data-product-id="${product.product_id}"
                    data-product-image="${product.image_url}"
                    data-product-name="${product.product_name}"
                    data-product-category="${product.categories}"
                    data-product-stock="${product.stock_count}"
                    data-product-price="${product.price}"
                    data-product-discount="${product.discount_percentage || 0}">
                    Edit
                  </button>
                  <button class="table-button delete-btn" data-bs-toggle="modal" data-bs-target="#delete-modal"
                    data-product-id="${product.product_id}"
                    data-product-name="${product.product_name}">
                    Delete
                  </button>
                </td>
              </tr>
            `);
          });

          $(".delete-btn").on("click", function () {
            const productId = $(this).data("product-id");
            const productName = $(this).data("product-name");
            $("#delete-product-id").val(productId);
            $("#delete-product-name").text(productName);
          });
        }

        pagination(
          response.total_pages,
          response.current_page,
          ".pagination",
          adminProductDisplay
        );
      } else {
        showToast("errorToast", response.message);
      }
    },
    error: function () {
      showToast("errorToast", "Error fetching product data");
    },
  });
}

export function editModalPopulate() {
  $(document).on("click", ".edit-btn", function () {
    const productId = $(this).data("product-id");
    const productName = $(this).data("product-name");
    const productCategory = $(this).data("product-category");
    const productStock = $(this).data("product-stock");
    const productPrice = $(this).data("product-price");
    const productDiscount = $(this).data("product-discount");
    const productImageUrl = $(this).data("product-image");

    $("#edit-product-id").val(productId);
    $("#edit-product-name").val(productName);
    $("#edit-categories").val(productCategory);
    $("#edit-product-stock").val(productStock);
    $("#edit-price").val(productPrice);
    $("#edit-discount-percentage").val(productDiscount);

    if (productImageUrl) {
      $("#current-product-image").attr("src", productImageUrl).show();
    } else {
      $("#current-product-image").attr("src", "").hide();
    }

    const categories = [
      "T-shirt",
      "Polo shirt",
      "PE uniforms",
      "Jacket",
      "Sweatshirt",
      "Jersey",
      "Vest/Blazer",
      "Glass Clock",
      "Badge Pin",
      "Pillow",
      "Mug",
      "Magic Mug",
      "Tumbler",
      "Cellphone Case",
      "Photo Rock",
      "Glass Frame",
      "Wall Picture",
      "Stand Frame",
      "Tote Bag",
      "Ballpen",
      "Bottle Opener",
      "Ref Magnet",
      "Keychain",
      "Mousepad",
      "Gaming mousepad",
      "Notebook",
      "Foldable Fan",
      "Umbrella",
      "Cap",
      "Others",
    ];
    const categorySelect = $("#edit-categories");
    categorySelect.empty();

    categories.forEach((category) => {
      const selected = category === productCategory ? "selected" : "";
      categorySelect.append(
        `<option value="${category}" ${selected}>${category}</option>`
      );
    });
  });
}

// ADMIN DISPLAY TAX ON THE VAT MODAL
export function displayCurrentTax() {
  $.ajax({
    url: "assets/fetch-data/get-tax-record.php",
    method: "GET",
    dataType: "json",
    success: function (response) {
      if (response.vat_percentage) {
        $("#current-tax").text(`Current Vat Tax: ${response.vat_percentage}%`);
      } else {
        $("#current-tax").text("No VAT record found");
      }
    },
    error: function () {
      $("#current-tax").text("Failed to fetch VAT data");
    },
  });
}

// USER SIDE PRODUCT PAGE
export function userDisplayProduct(page = 1) {
  $.ajax({
    url: `assets/fetch-data/user-get-product.php?page=${page}`,
    method: "GET",
    dataType: "json",
    success: function (response) {
      const parentContainer = $("#user-product-container");
      parentContainer.empty();

      response.products.forEach((product) => {
        const discount = product.discount_percentage || 0;
        const discountedPrice =
          product.price - (product.price * discount) / 100;

        const discountRibbon =
          discount > 0
            ? `<div class="ribbon"><span>${discount}% OFF</span></div>`
            : "";

        const productCard = `
             <div class="col-lg-3 col-sm-12">
              <div class="product-card card p-3 position-relative">
                <div class="box">
                  ${discountRibbon}
                </div>
                <img src="${product.image_url}" class="" alt="Product Image">
                <div class="card-body p-0">
                  <h6 class="card-title">${product.product_name}</h6>
                  <div class="d-flex align-items-center justify-content-between mt-4">
                    <p class="price m-0">
                      ₱<span id="amount" class='fw-bold'>
                        ${
                          discount > 0
                            ? discountedPrice.toFixed(2)
                            : product.price.toFixed(2)
                        }
                      </span>
                      ${
                        discount > 0
                          ? `<small class="text-muted text-decoration-line-through fw-light">₱${product.price}</small>`
                          : ""
                      }
                    </p>
                    <div class="quantity-selector d-flex align-items-center">
                      <button class="decrement d-flex align-items-center justify-content-center">-</button>
                      <input type="text" class="quantity text-center" value="1" readonly />
                      <button class="increment d-flex align-items-center justify-content-center">+</button>
                    </div>
                  </div>
                  <a href="#" class="btn buy-btn w-100 mt-4 position-absolute" 
                     data-bs-toggle="modal" data-bs-target="#check-out-modal" 
                     data-product='${JSON.stringify(product)}'>Buy</a>
                </div>
              </div>
            </div>
          `;
        parentContainer.append(productCard);
      });

      $(document).on("click", ".increment", function () {
        const quantityInput = $(this).siblings(".quantity");
        let currentValue = parseInt(quantityInput.val());
        quantityInput.val(currentValue + 1);
      });

      $(document).on("click", ".decrement", function () {
        const quantityInput = $(this).siblings(".quantity");
        let currentValue = parseInt(quantityInput.val());
        if (currentValue > 1) {
          quantityInput.val(currentValue - 1);
        }
      });

      $(document).on("click", ".buy-btn", function () {
        const product = JSON.parse($(this).attr("data-product"));
        const quantity = $(this)
          .closest(".product-card")
          .find(".quantity")
          .val();
        const totalPrice = (product.price * quantity * 1.12).toFixed(2);

        // Update Modal with Product Info
        $("#modal-product-name").text(product.product_name);
        $("#modal-quantity").text(quantity);
        $("#modal-total-amount").text(totalPrice);

        // Pass Data to Hidden Fields
        const cartItem = {
          product_id: product.product_id,
          product_name: product.product_name,
          quantity: quantity,
          price: product.price,
          total_price: totalPrice,
        };
        $("#cart_items").val(JSON.stringify(cartItem));
        $("#exampleModalLabel").text("Order Checkout");
      });

      const { total_pages, current_page } = response;
      pagination(
        total_pages,
        current_page,
        "#pagination-container",
        userDisplayProduct
      );
    },
    error: function () {
      console.error("Failed to fetch product data");
    },
  });
}

// LANDING PAGE HOME PAGE
export function homeDisplayProduct(page = 1) {
  $.ajax({
    url: `assets/fetch-data/user-get-product.php?page=${page}`,
    method: "GET",
    dataType: "json",
    success: function (response) {
      const parentContainer = $("#user-product-container");
      parentContainer.empty();

      response.products.forEach((product) => {
        const discount = product.discount_percentage || 0;
        const discountedPrice =
          product.price - (product.price * discount) / 100;

        const discountRibbon =
          discount > 0
            ? `<div class="ribbon"><span>${discount}% OFF</span></div>`
            : "";

        const productCard = `
             <div class="col-lg-3 col-sm-12">
              <div class="product-card card p-3 position-relative">
                <div class="box">
                  ${discountRibbon}
                </div>
                <img src="${product.image_url}" class="" alt="Product Image">
                <div class="card-body p-0">
                  <h6 class="card-title">${product.product_name}</h6>
                  <div class="d-flex align-items-center justify-content-between mt-4">
                    <p class="price m-0">
                      ₱<span id="amount" class='fw-bold'>
                        ${
                          discount > 0
                            ? discountedPrice.toFixed(2)
                            : product.price.toFixed(2)
                        }
                      </span>
                      ${
                        discount > 0
                          ? `<small class="text-muted text-decoration-line-through fw-light">₱${product.price}</small>`
                          : ""
                      }
                    </p>
                  </div>
                  <a href="#" class="btn buy-btn w-100 mt-4 position-absolute" 
                     data-product='${JSON.stringify(product)}'>Buy</a>
                </div>
              </div>
            </div>
          `;
        parentContainer.append(productCard);
      });

      $(document).on("click", ".buy-btn", function () {
        alert("You need to log in first to buy the product.");
      });

      const { total_pages, current_page } = response;
      pagination(
        total_pages,
        current_page,
        "#pagination-container",
        homeDisplayProduct
      );
    },
    error: function () {
      console.error("Failed to fetch product data");
    },
  });
}
