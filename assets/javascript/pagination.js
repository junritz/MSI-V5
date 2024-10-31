export function pagination(
  totalPages,
  currentPage,
  paginationSelector,
  tableRenderCallback
) {
  const paginationContainer = $(paginationSelector);
  paginationContainer.empty();

  if (totalPages <= 1) return;

  // Previous Page
  paginationContainer.append(`
    <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
      <a class="page-link" href="#" aria-label="Previous" data-page="${
        currentPage - 1
      }" ${currentPage === 1 ? 'aria-disabled="true"' : ""}>
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
  `);

  // Page Numbers
  for (let i = 1; i <= totalPages; i++) {
    paginationContainer.append(`
      <li class="page-item ${i === currentPage ? "active" : ""}">
        <a class="page-link" href="#" data-page="${i}">${i}</a>
      </li>
    `);
  }

  // Next Page
  paginationContainer.append(`
    <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
      <a class="page-link" href="#" aria-label="Next" data-page="${
        currentPage + 1
      }" ${currentPage === totalPages ? 'aria-disabled="true"' : ""}>
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  `);

  // Event Listener for Pagination Click
  $(`${paginationSelector} a`).on("click", function (e) {
    e.preventDefault();
    const page = $(this).data("page");

    // Ignore click if the page is disabled
    if ($(this).parent().hasClass("disabled")) {
      return;
    }

    const searchQuery = $(".search-input").val(); 
    tableRenderCallback(page, searchQuery);
  });
}
