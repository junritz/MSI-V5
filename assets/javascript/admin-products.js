import { addProduct, editProduct, deleteProduct, addVat } from "./form-submission.js";
import { adminProductDisplay, editModalPopulate,  displayCurrentTax } from "./fetch-data.js";
import { searchTableFunction, sideBarToggle } from "./utility.js"; 


sideBarToggle();


adminProductDisplay();
editModalPopulate();
displayCurrentTax();

deleteProduct();
addProduct();
editProduct();
addVat();



$(document).ready(function () {
  searchTableFunction("#product-search-form", adminProductDisplay); 
});
