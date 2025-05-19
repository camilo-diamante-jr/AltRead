export function archiveMaterial() {
  const activeMaterialTable = $("#materialTable").DataTable();
  const archiveMaterialTable = $("#archivedMaterialTable").DataTable();

  $(document).on("click", ".mat-archive-btn", function () {
    const row = $(this).closest("tr");
    const materialID = $(this).data("material-id");

    if (!materialID) {
      console.error("Material ID is missing.");
      return;
    }

    // Extract material details from the row
    const materialTitle = row.find("td:nth-child(2)").text().trim();
    const materialCategory = row.find("td:nth-child(3)").text().trim();
    const fileName = row.find("td:nth-child(4) a").text().trim();

    Swal.fire({
      title: "Are you sure?",
      text: "Do you want to archive this material?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, archive it!",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/archiveMaterial",
          type: "POST",
          data: JSON.stringify({ materialID: materialID }),
          contentType: "application/json",
          success: function (response) {
            if (response.success) {
              Swal.fire({
                icon: "success",
                title: "Success!",
                text: "Material successfully moved to archive!",
                timer: 2000,
                showConfirmButton: false,
              });

              // Remove row from Active Materials Table
              activeMaterialTable.row(row).remove().draw(false);

              // Add new row to Archived Materials Table (Include placeholder for 'No.' column)
              archiveMaterialTable.row
                .add([
                  "", // Placeholder for "No." column
                  materialTitle, // Title
                  materialCategory, // Category
                  fileName
                    ? `<a href="../../files/uploads/${fileName}" data-fancybox="pdf-gallery" class="text-decoration-underline text-primary">${fileName}</a>`
                    : "No file uploaded", // Attach Files
                  `<button class="btn btn-sm btn-secondary mat-restore-btn" data-material-id="${materialID}">Restore</button>`, // Actions
                ])
                .draw(false);

              // Recalculate row numbering for the Archived Materials Table
              archiveMaterialTable
                .rows()
                .every(function (index) {
                  this.cell(index, 0).data(index + 1); // Update "No." column (index + 1)
                })
                .invalidate()
                .draw(); // Invalidate and redraw the table
            } else {
              console.error("Error archiving material:", response.error);
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                  response.error ||
                  "Failed to archive material. Please try again.",
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to archive material. Please try again.",
            });
          },
        });
      }
    });
  });
}
