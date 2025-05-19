export function createNewPretest() {
  let subContextCount = 0;

  $("#add-sub-context").click(function () {
    if (subContextCount < 4) {
      subContextCount++;
      $("#sub-context-container").append(`
        <div class="mb-3 sub-context" id="sub-context-${subContextCount}">
          <div class="d-flex justify-content-between align-items-center">
            <label class="form-label">Sub Context ${subContextCount}</label>
            <button type="button" class="btn btn-danger btn-sm mb-1 rounded-circle remove-sub-context" data-id="${subContextCount}">
              <i class="fa fa-times fa-lg"></i>
            </button>
          </div>
          <textarea name="sub_context_${subContextCount}" class="form-control"></textarea>
        </div>
      `);
    } else {
      Swal.fire(
        "Limit Reached",
        "Maximum of 4 sub-contexts allowed.",
        "warning"
      );
    }
  });

  $(document).on("click", ".remove-sub-context", function () {
    const id = $(this).data("id");
    $(`#sub-context-${id}`).remove();
    subContextCount--;
  });

  $('select[name="pretest_type"]')
    .change(function () {
      const isWriting = $(this).val() === "Writing";
      $(
        "#choices-section, #add-sub-context, #sub-context-container, #correct-answer-section"
      ).toggle(!isWriting);
    })
    .trigger("change");

  $("#choice-type")
    .change(function () {
      const isText = $(this).val() === "text";
      $("#text-choices input").attr("required", isText);
      $("#image-choices input").attr("required", !isText);
      $("#text-choices").toggle(isText);
      $("#image-choices").toggle(!isText);
    })
    .trigger("change");

  $("#insertPretestSubmitForm").on("submit", function (e) {
    e.preventDefault();
    const formData = new FormData(this);

    $.ajax({
      url: "/createPretest",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function () {
        $(".btn-save-pretest").prop("disabled", true).text("Saving...");
      },
      success: function (response) {
        Swal.fire({
          title: response.success ? "Success" : "Error",
          text: response.message,
          icon: response.success ? "success" : "error",
        }).then(() => {
          if (response.success) {
            $("#insertPretestModal").modal("hide");
            $("#insertPretestSubmitForm")[0].reset();
            $("#sub-context-container").empty();
            subContextCount = 0;
          }
        });
      },
      error: function (xhr) {
        Swal.fire("Error", xhr.responseText, "error");
      },
      complete: function () {
        $(".btn-save-pretest").prop("disabled", false).text("Save");
      },
    });
  });
}
