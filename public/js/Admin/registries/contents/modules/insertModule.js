export function insertModuleSubmitForm() {
  $("#addModuleForm").submit(function (event) {
    event.preventDefault();

    const moduleName = $("#moduleName").val().trim();
    const moduleDescription = $("#moduleDescription").val().trim();

    if (!moduleName || !moduleDescription) {
      Swal.fire({
        icon: "warning",
        title: "Validation Error",
        text: "All fields are required.",
      });
      return;
    }

    $.ajax({
      type: "POST",
      url: "/ajax/insertModule",
      data: JSON.stringify({ moduleName, moduleDescription }),
      contentType: "application/json; charset=utf-8",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          let moduleId = response.moduleId; // Get ID from response

          Swal.fire({
            icon: "success",
            title: "Success",
            text: response.message,
            timer: 1500,
          }).then(() => {
            $("#addModuleModal").modal("hide");
            $("#addModuleForm")[0].reset();

            // ✅ Dynamically add new row to DataTable
            window.moduleTable.row
              .add([
                moduleName,
                moduleDescription,
                `<button class="btn btn-sm btn-primary editModuleBtn" 
                data-bs-toggle="modal" 
                data-bs-target="#editModuleModal_${moduleId}" 
                data-module-id="${moduleId}">
                <i class="fa fa-pencil"></i>
              </button>
              <button class="btn btn-sm btn-danger removeModuleBtn" 
                data-module-id="${moduleId}">
                <i class="fa fa-trash"></i>
              </button>`,
              ])
              .draw(false);
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Error",
            text: response.message,
          });
        }
      },
      error: function (xhr, status, error) {
        console.log(xhr.responseText);
        Swal.fire({
          icon: "error",
          title: "Server Error",
          text: "Something went wrong. Please try again.",
        });
      },
    });
  });
}
