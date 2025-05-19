export function removeCurrentModule() {
  $(document).on("click", ".removeModuleBtn", function () {
    const moduleId = $(this).data("module-id");
    removeModule(moduleId, this);
  });
}

function removeModule(moduleId, element) {
  Swal.fire({
    title: "Are you sure?",
    text: "This module will be removed but not deleted!",
    icon: "warning",
    position: "center",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Yes, remove it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/ajax/removeModule",
        type: "POST",
        data: JSON.stringify({ moduleId }),
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: "success",
              title: "Deactivated!",
              text: response.message,
              timer: 1500,
            });

            window.moduleTable.row($(element).closest("tr")).remove().draw();
          } else {
            showErrorPopup(response.message);
          }
        },
        error: handleAjaxError,
      });
    }
  });
}
