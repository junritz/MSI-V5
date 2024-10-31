import { productSearchWithSuggestions } from "./utility.js";
import { homeDisplayProduct } from "./fetch-data.js";

homeDisplayProduct();

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
