import { showToast, showSendingEmailModal } from "./utility.js";
import { adminProductDisplay } from "./fetch-data.js";

export function addProduct() {
  $("#product-form").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: "assets/backend/add-product.php",
      method: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.status === "success") {
          $("#product-form")[0].reset();
          $("#create-product").modal("hide");
          adminProductDisplay();
          showToast("successToast", response.message);
        } else {
          showToast("errorToast", response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("An error occurred:", error);
        showToast(
          "errorToast",
          "An unexpected error occurred. Please try again."
        );
      },
    });
  });
}
// ADMIN SIDE PRODUCT PAGE
export function editProduct() {
  $("#edit-product-form").on("submit", function (e) {
    e.preventDefault();

    const productId = $("#edit-product-id").val();

    const formData = new FormData(this);
    formData.append("product_id", productId); 

    $.ajax({
      url: "assets/backend/edit-product.php",
      method: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.status === "success") {
          $("#edit-product-form")[0].reset();
          $("#edit-modal").modal("hide");
          adminProductDisplay(); 
          showToast("successToast", response.message);
        } else {
          showToast("errorToast", response.message);
        }
      },
      error: function () {
        alert("Error updating the product");
      },
    });
  });
}
// ADMIN SIDE PRODUCT PAGE
export function deleteProduct() {
  $("#delete-product-form").on("submit", function (e) {
    e.preventDefault();

    const productId = $("#delete-product-id").val();

    const formData = new FormData(this);
    formData.append("product_id", productId);

    $.ajax({
      url: "assets/backend/delete-product.php",
      method: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.status === "success") {
          $("#delete-modal").modal("hide");
          adminProductDisplay();
          showToast("successToast", response.message);
        } else {
          showToast("errorToast", response.message);
        }
      },
      error: function () {
        alert("Error deleting the product");
      },
    });
  });
}
// ADMIN SIDE PRODUCT PAGE
export function addVat() {
  $("#vat-tax-form")
    .off("submit")
    .on("submit", function (e) {
      e.preventDefault();

      const formData = new FormData(this);

      $.ajax({
        url: "assets/backend/add-vat.php",
        method: "POST",
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: (response) => {
          if (response.status === "success") {
            $("#edit-vat").modal("hide");
            showToast("successToast", response.message);
          } else {
            showToast("errorToast", response.message);
          }
        },
        error: (jqXHR, textStatus, errorThrown) => {
          console.error("Error during AJAX request:", textStatus, errorThrown);
          showToast("errorToast", "An error occurred. Please check console.");
        },
      });
    });
}

// USER SIDE
export function registerForm() {
  $("#registerForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const email = $("#registerForm input[name='email']").val();

    if (!email) {
      showToast("errorToast", "Email address is missing.");
      return;
    }

    showSendingEmailModal(email, "Your registration email is being sent to:");

    $.ajax({
      url: "assets/backend/register-check.php",
      method: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        $("#send-email-modal").modal("hide");

        if (response.status === "success") {
          $("#registerForm")[0].reset();
          showToast("successToast", response.message);
        } else {
          showToast("errorToast", response.message);
        }
      },
      error: function () {
        $("#send-email-modal").modal("hide");
        showToast("errorToast", "An unexpected error occurred.");
      },
    });
  });
}
// USER SIDE
export function loginForm() {
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();

    const formData = new FormData(this);

    $.ajax({
      url: "assets/backend/login-check.php",
      method: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        console.log("AJAX success block called:", response);
        if (response.status === "success") {
          $("#loginForm")[0].reset();
          showToast("successToast", response.message);
          if (response.redirect) {
            window.location.href = response.redirect;
          }
        } else {
          showToast("errorToast", response.message);
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log("AJAX error block called:", textStatus, errorThrown);
        $("#process-modal").modal("hide");
        showToast("errorToast", "An unexpected error occurred.");
      },
    });
  });
}

// USER SIDE
export function payment() {
  $("#payment-form").on("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
      url: "assets/backend/place-order.php",
      method: "POST",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      success: function (response) {
        if (response.status === "success") {
          $("#payment-form")[0].reset();
          $("#check-out-modal").modal("hide");
          showToast("successToast", response.message);

          if (response.pdf && response.orderId) {
            const companyName = "Marco Media";
            const pdfUrl = `view-pdf.html?pdf=${encodeURIComponent(
              response.pdf
            )}&order_id=${response.orderId}&company_name=${encodeURIComponent(
              companyName
            )}`;
            window.open(pdfUrl, "_blank");
          }
        } else {
          showToast("errorToast", response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX Error:", { status: status, error: error });
        console.log("Response Text:", xhr.responseText);
        showToast("errorToast", "Form submission failed: " + status);
      },
    });
  });
}
