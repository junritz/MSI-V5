import { userDisplayProduct} from "./fetch-data.js";
import { productSearchWithSuggestions} from "./utility.js";
import {payment} from './form-submission.js'

userDisplayProduct(); 
payment();



// Initialize search suggestions
$(document).ready(function () {
  productSearchWithSuggestions();
});

$(document).ready(function () {
  let selectedCategories = [];

  $('input[type="checkbox"]').on("change", function () {
    const category = $(this).attr("name");

    if (category === "all") {
      if ($(this).is(":checked")) {
        $('input[type="checkbox"]').prop("checked", false);
        $(this).prop("checked", true);
        selectedCategories = [];
        userDisplayProduct(1, "", "");
      } else {
        userDisplayProduct(1, "", "");
      }
    } else {
      $("#all").prop("checked", false);
      if ($(this).is(":checked")) {
        selectedCategories.push(category);
      } else {
        selectedCategories = selectedCategories.filter(
          (item) => item !== category
        );
      }
      const categoriesToFilter =
        selectedCategories.length > 0 ? selectedCategories.join(",") : "";
      userDisplayProduct(1, "", categoriesToFilter);
    }
  });
});


const downpaymentInput = document.getElementById('downpayment');
downpaymentInput.addEventListener('input', function() {
  if (this.value < 0) {
    this.value = 0;
  }
});