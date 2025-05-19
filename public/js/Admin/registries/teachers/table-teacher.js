export function teachersTable() {
  const tableElement = $("#teachersTable");

  // Check if the table element exists
  if (tableElement.length === 0) {
    console.error("#teachersTable element not found");
    return null; // Return null if the table is not found
  }

  // Initialize the DataTable with custom settings
  const table = tableElement.DataTable({
    responsive: true,
    columnDefs: [
      {
        orderable: false,
        targets: [4], // Disable ordering for the 5th column
      },
    ],
  });

  return table; // Return the initialized DataTable
}
