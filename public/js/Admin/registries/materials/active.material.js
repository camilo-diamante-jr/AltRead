export function initializeActiveMaterials() {
  $("#materialTable tbody tr").each(function (index) {
    $(this)
      .find(".index-column")
      .text(index + 1);
  });

  const materialTable = $("#materialTable").DataTable({
    ordering: false, // Disable sorting (if necessary)
    scrollCollapse: true,
    responsive: true,
  });

  $("#addNewMaterials").on("click", function () {
    $("#addNewMaterialsModal").modal("show");
  });

  return materialTable;
}
