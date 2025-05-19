export function restoreMaterial() {
  const activeMaterialTable = $("#materialTable").DataTable();
  const archiveMaterialTable = $("#archivedMaterialTable").DataTable();

  $(document).on("click", ".mat-restore-btn", function () {
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
      position: "top",
      title: "Are you sure?",
      text: "Do you want to restore this material?",
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes, restore it!",
      cancelButtonText: "Cancel",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "/restoreMaterial",
          type: "POST",
          data: JSON.stringify({ materialID: materialID }),
          contentType: "application/json",
          success: function (response) {
            if (response.success) {
              Swal.fire({
                position: "top",
                icon: "success",
                title: "Success!",
                text: "Material successfully restored!",
                timer: 2000,
                showConfirmButton: false,
              });

              // Remove row from Archived Materials Table
              archiveMaterialTable.row(row).remove().draw(false);

              // Recalculate numbering in Archived Table after row removal
              archiveMaterialTable
                .rows()
                .every(function (index) {
                  this.cell(index, 0).data(index + 1); // Update No. column
                })
                .draw(false);

              // Add restored material to Active Materials Table with "Edit" and "Archive" buttons
              activeMaterialTable.row
                .add([
                  activeMaterialTable.rows().count() + 1, // Auto-update numbering
                  materialTitle, // Title
                  materialCategory, // Category
                  fileName
                    ? `<a href="../../files/uploads/${fileName}" data-fancybox="pdf-gallery" class="text-decoration-underline text-primary">${fileName}</a>`
                    : "No file uploaded", // Attach Files
                  `<button class="btn btn-sm btn-primary mat-edit-btn" data-material-id="${materialID}">Edit</button>  
                   <button class="btn btn-sm btn-danger mat-archive-btn" data-material-id="${materialID}">Archive</button>`, // Actions
                ])
                .draw(false);

              // Recalculate numbering for the Active Table after adding a row
              activeMaterialTable
                .rows()
                .every(function (index) {
                  this.cell(index, 0).data(index + 1); // Update No. column
                })
                .draw(false);
            } else {
              console.error("Error restoring material:", response.error);
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                  response.error ||
                  "Failed to restore material. Please try again.",
              });
            }
          },
          error: function (xhr, status, error) {
            console.error("AJAX Error:", error);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Failed to restore material. Please try again.",
            });
          },
        });
      }
    });
  });
}
