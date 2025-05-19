export function updateModuleSubmitForm() {
  $(document).on("submit", ".editModuleForm", function (event) {
    event.preventDefault();

    let form = $(this);
    let moduleId = form.data("module-id");
    let moduleName = form.find("input[name='moduleName']").val().trim();
    let moduleDescription = form
      .find("textarea[name='moduleDescription']")
      .val()
      .trim();

    if (!moduleId || !moduleName || !moduleDescription) {
      Swal.fire({
        icon: "warning",
        title: "Missing Fields!",
        text: "Please fill in all fields.",
      });
      return;
    }

    let formData = { moduleId, moduleName, moduleDescription };

    $.ajax({
      url: "/ajax/updateModule",
      type: "POST",
      data: JSON.stringify(formData),
      contentType: "application/json",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            icon: "success",
            title: "Success!",
            text: response.message,
            timer: 1500,
          });

          $("#editModuleModal_" + moduleId).modal("hide");

          updateModuleRow(moduleId, moduleName, moduleDescription);
        } else {
          showErrorPopup(response.message);
        }
      },
      error: handleAjaxError,
    });
  });
}

// ✅ Function to update module row dynamically
export function updateModuleRow(moduleId, moduleName, moduleDescription) {
  let table = window.moduleTable;

  let rowIndex = table
    .rows()
    .eq(0)
    .filter((index) => {
      return table
        .row(index)
        .data()[2]
        .includes(`data-module-id="${moduleId}"`);
    });

  if (rowIndex.length) {
    table
      .row(rowIndex[0])
      .data([
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
  }
}
