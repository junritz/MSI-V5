// Display TOAST message after submission of form
export function showToast(toastId, message) {
  const toastElement = document.getElementById(toastId);
  if (toastElement) {
    const toastBodyId =
      toastId === "successToast" ? "toast-message" : "error-toast-message";
    const toastBody = toastElement.querySelector(`#${toastBodyId}`);
    if (toastBody) {
      toastBody.textContent = message;
    }
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
  } else {
    console.error(`Toast element with id "${toastId}" not found.`);
  }
}
// SIDEBAR TOGGLE
export function sideBarToggle() {
  document.addEventListener("DOMContentLoaded", function () {
    const toggle = document.querySelector(".toggle");
    const navigation = document.querySelector(".navigation");
    const main = document.querySelector(".main");

    if (toggle && navigation && main) {
      toggle.onclick = function () {
        navigation.classList.toggle("active");
        main.classList.toggle("active");
      };
    }
  });
}

export function formatDateTime(dateTime) {
  const date = new Date(dateTime);

  const monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  const year = date.getFullYear();
  const month = monthNames[date.getMonth()];
  const day = date.getDate();
  const hours = date.getHours();
  const minutes = date.getMinutes().toString().padStart(2, "0");

  const isPM = hours >= 12;
  const formattedHours = hours % 12 || 12;
  const period = isPM ? "PM" : "AM";

  return `${month} ${day}, ${year}, ${formattedHours}:${minutes} ${period}`;
}

// FOR ADMIN TABLE
export function searchTableFunction(searchFormSelector, tableRenderCallback) {
  $(searchFormSelector).on("submit", function (e) {
    e.preventDefault();
    const searchQuery = $(this).find(".search-input").val();
    tableRenderCallback(1, searchQuery);
  });
}

// USER SIDE PRODUCT SEARCH
export function productSearchWithSuggestions() {
  const searchBar = $(".search-bar");
  const suggestionContainer = $(".suggestions-container");
  const suggestionBox = $("<ul class='suggestions-list'></ul>").appendTo(
    suggestionContainer
  );

  let debounceTimer;
  function fetchSuggestions(query) {
    $.ajax({
      url: "assets/backend/search-suggestions.php",
      method: "GET",
      data: { query: query },
      dataType: "json",
      beforeSend: function () {
        suggestionBox.empty();
        suggestionContainer.hide();
      },
      success: function (response) {
        suggestionBox.empty();

        if (response.length === 0) {
          suggestionContainer.hide();
          return;
        }
        response.forEach(function (suggestion) {
          suggestionBox.append(
            `<li class="suggestion-item">${suggestion}</li>`
          );
        });

        suggestionContainer.show();
      },
      error: function () {
        console.error("Failed to fetch suggestions");
        suggestionContainer.hide();
      },
    });
  }

  searchBar.on("input", function () {
    const query = $(this).val().trim();

    if (query.length < 2) {
      suggestionContainer.hide();
      return;
    }

    clearTimeout(debounceTimer);
    debounceTimer = setTimeout(() => {
      fetchSuggestions(query);
    }, 300);
  });

  $(document).on("click", ".suggestion-item", function () {
    const selectedProduct = $(this).text();
    searchBar.val(selectedProduct);
    userDisplayProduct(1, selectedProduct);
    suggestionContainer.hide();
  });

  $(".search-button").on("click", function () {
    handleSearch();
  });
  searchBar.on("keypress", function (e) {
    if (e.which === 13) {
      handleSearch();
    }
  });

  $(document).on("click", function (e) {
    if (!$(e.target).closest(".navbar-header-middle-section").length) {
      suggestionContainer.hide();
    }
  });

  searchBar.on("keydown", function (e) {
    if (e.key === "Escape") {
      suggestionContainer.hide();
    }
  });

  function handleSearch() {
    const query = searchBar.val().trim();
    if (!query) {
      userDisplayProduct(1, "");
    } else {
      userDisplayProduct(1, query);
    }
    suggestionContainer.hide();
  }
}

export function addToCart() {
  let cartCount = 0;

  document.querySelectorAll("#add-order-btn").forEach((button) => {
    addEventListener("click", () => {
      cartCount++;

      document.querySelector("#javascript-cart-quantity").innerHTML = cartCount;
    });
  });
}

export function showSendingEmailModal(
  email,
  notificationText = "The email notification is being sent to:"
) {
  $("#modal-notification-text").text(notificationText);
  $("#email-address").text(email);
  $("#send-email-modal").modal("show");
}
