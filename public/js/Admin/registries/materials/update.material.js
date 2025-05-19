export function updateMaterial() {
  const materialTable = $("#materialTable").DataTable(); // Ensure DataTable is initialized

  // Event delegation for dynamically loaded elements
  $(document).on("click", ".mat-edit-btn", function () {
    const materialID = $(this).data("material-id");
    console.log("Material ID Sent:", materialID);

    $.ajax({
      url: "/getMaterialById",
      type: "POST",
      data: JSON.stringify({ materialID: materialID }),
      contentType: "application/json",
      success: function (response) {
        try {
          if (typeof response === "string") {
            response = JSON.parse(response);
          }

          if (response && response.material) {
            $("#updateMaterialID").val(response.material.materialID);
            $("#updateTitle").val(
              response.material.materialTitle || "Not Applicable"
            );
            $("#updateSubtitle").val(
              response.material.materialSubtitle || "Not Applicable"
            );
            $("#updateCategory").val(
              response.material.materialCategory || "Not Applicable"
            );
            $("#updateGenre").val(
              response.material.materialGenre || "Not Applicable"
            );

            if (response.material.materialFiles) {
              $("#currentFileLabel").text(response.material.materialFiles); // Display file name
              $("#currentFileLabel").data(
                "original-file",
                response.material.materialFiles
              ); // Store original file name
            } else {
              $("#currentFileLabel").text("No file uploaded");
              $("#currentFileLabel").data("original-file", null);
            }

            $("#editMaterialsModal").modal("show");
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "No material data found! Please try again.",
            });
          }
        } catch (error) {
          console.error("JSON Parse Error:", error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Invalid server response. Please try again.",
          });
        }
      },
      error: function (xhr, status, error) {
        console.error("Error retrieving material:", error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Failed to retrieve material. Please try again.",
        });
      },
    });
  });

  // Event delegation to prevent duplicate binding
  $(document)
    .off("submit", "#editMaterialSubmitForm")
    .on("submit", "#editMaterialSubmitForm", function (e) {
      e.preventDefault();

      const editMaterialsForm = document.getElementById(
        "editMaterialSubmitForm"
      );
      const formData = new FormData(editMaterialsForm);
      const materialID = $("#updateMaterialID").val();
      const updatedMaterialFile = formData.get("updateFile"); // Get new file input
      const originalFileName = $("#currentFileLabel").data("original-file"); // Get stored original file name

      // If no new file is selected, retain the original file name
      if (!updatedMaterialFile || updatedMaterialFile.size === 0) {
        formData.append("updateFile", originalFileName);
      }

      $.ajax({
        url: "/updateMaterial",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          try {
            if (typeof response === "string") {
              response = JSON.parse(response);
            }

            if (response.success) {
              $("#editMaterialsModal").modal("hide");

              Swal.fire({
                icon: "success",
                title: "Success!",
                text: "Material updated successfully!",
                timer: 2000,
                showConfirmButton: false,
              });

              // Find the row and update content in DataTable
              let row = materialTable.row(
                $(`.mat-edit-btn[data-material-id="${materialID}"]`).closest(
                  "tr"
                )
              );

              const updatedMaterialTitle =
                formData.get("updateTitle") || "Not Applicable";
              const updatedMaterialSubtitle =
                formData.get("updateSubtitle") || "";
              const updatedMaterialCategory =
                formData.get("updateCategory") || "Not Applicable";

              // Use the new file name if uploaded; otherwise, use the original file name
              const fileName = updatedMaterialFile?.name || originalFileName;

              row
                .data([
                  row.index() + 1, // No.
                  `${updatedMaterialTitle}: ${updatedMaterialSubtitle}`, // Title
                  updatedMaterialCategory, // Category
                  fileName
                    ? `<a href="../../files/uploads/${fileName}" data-fancybox="pdf-gallery" class="text-decoration-underline text-primary">${fileName}</a>`
                    : "No file uploaded", // Attach Files
                  `<button class="btn mat-edit-btn btn-sm btn-warning" data-material-id="${materialID}">
                  <i class="fa fa-edit" aria-hidden="true"></i> 
                </button>
                <button class="btn mat-archive-btn btn-sm btn-danger" data-material-id="${materialID}">
                  <i class="fa fa-archive" aria-hidden="true"></i>
                </button>`, // Actions
                ])
                .draw(false); // Update and redraw the table without pagination reset
            } else {
              Swal.fire({
                icon: "error",
                title: "Oops...",
                text:
                  response.error ||
                  "Failed to update material. Please try again.",
              });
            }
          } catch (error) {
            console.error("JSON Parse Error:", error);
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: "Invalid server response. Please try again.",
            });
          }
        },
        error: function (xhr, status, error) {
          console.error("Error updating material:", error);
          Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Failed to update material. Please try again.",
          });
        },
      });
    });
}
