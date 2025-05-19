export function addNewMaterial() {
  // Event delegation for dynamically loaded elements
  $(document).on("submit", "#addNewMaterialSubmitForm", function (e) {
    e.preventDefault();

    const newMaterialsForm = document.getElementById(
      "addNewMaterialSubmitForm"
    );
    const formData = new FormData(newMaterialsForm);
    $.ajax({
      url: "/insertMaterial",
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
            Swal.fire({
              icon: "success",
              title: "Success!",
              text: "Material added successfully!",
              timer: 2000,
              showConfirmButton: false,
            });

            // Hide the modal
            $("#addNewMaterialsModal").modal("hide");

            // Get the form data for the new material
            const materialTitle = formData.get("title") || "Not Applicable";
            const materialSubtitle =
              formData.get("subtitle") || "Not Applicable";
            const materialCategory =
              formData.get("category") || "Not Applicable";
            const materialFile = formData.get("file");
            const fileName =
              materialFile && materialFile.name
                ? materialFile.name
                : "No file uploaded";

            // Use the materialID returned from the backend
            const newMaterialID = response.materialID;

            // Add the new row to the DataTable
            materialTable.row
              .add([
                materialTable.rows().count() + 1, // No.
                `${materialTitle}: ${materialSubtitle}`, // Title
                materialCategory, // Category
                fileName
                  ? `<a href="../../files/uploads/${fileName}" data-fancybox="pdf-gallery" class="text-decoration-underline text-primary">${fileName}</a>`
                  : "No file uploaded", // Attach Files
                `<button class="btn mat-edit-btn btn-sm btn-warning" data-material-id="${newMaterialID}">
                          <i class="fa fa-edit" aria-hidden="true"></i> <span>Edit</span>
                        </button>
                        <button class="btn mat-archive-btn btn-sm btn-danger" data-material-id="${newMaterialID}">
                          <i class="fa fa-archive" aria-hidden="true"></i> <span>Archive</span>
                        </button>`, // Actions (with materialID for buttons)
              ])
              .draw(false); // Update the table without resetting pagination
          } else {
            Swal.fire({
              icon: "error",
              title: "Oops...",
              text:
                response.error || "Failed to add material. Please try again.",
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
        console.error("Error submitting material:", error);
        Swal.fire({
          icon: "error",
          title: "Oops...",
          text: "Failed to add material. Please try again.",
        });
      },
    });
  });
}
