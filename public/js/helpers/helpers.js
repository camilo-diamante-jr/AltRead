export function showErrorPopup(message) {
  Swal.fire({
    icon: "error",
    title: "Oops! Something went wrong.",
    html: `<p style="font-size: 16px; color: #333;"><strong>${message}</strong></p>`,
    confirmButtonText: "Got it",
    confirmButtonColor: "#d33",
  });
}

export function handleAjaxError(xhr) {
  console.error("AJAX Error:", xhr.responseText);
  let errorMessage = "An unexpected error occurred. Please try again.";
  try {
    let errorResponse = JSON.parse(xhr.responseText);
    if (errorResponse.message) {
      errorMessage = errorResponse.message;
    }
  } catch (e) {
    console.error("Error parsing JSON response:", e);
  }
  showErrorPopup(errorMessage);
}

export function loadModules() {
  $("#moduleListContainer").load(
    location.href + " #moduleListContainer",
    function () {
      if ($.fn.DataTable.isDataTable("#mainContentRegistry .table")) {
        $("#mainContentRegistry .table").DataTable().destroy();
      }
      $("#mainContentRegistry .table").DataTable();
    }
  );
}
