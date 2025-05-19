/*---------------------------
  DataTable Initialization
---------------------------*/
function initializeUsersDataTable() {
  window.userAccountsTable = $("#userAccountsTable").DataTable({
    paging: true,
    searching: true,
    ordering: true,
    // order: [[1, "asc"]],
    columnDefs: [
      { orderable: false, targets: [4] }, // Disable sorting on column index 4
      { targets: [0, 2], type: "string" }, // Ensure columns 0 and 2 are sorted alphabetically
    ],
    language: {
      paginate: {
        next: '<i class="fa fa-chevron-right"></i>',
        previous: '<i class="fa fa-chevron-left"></i>',
      },
      search: '<i class="fa fa-search"></i>',
      searchPlaceholder: "Search users...",
    },
  });
}
