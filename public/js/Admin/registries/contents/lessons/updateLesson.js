export function updateLessonSubmitForm() {
  $(document).on("click", "#saveLessonChanges", function (e) {
    e.preventDefault();

    // Get the closest modal to the clicked button
    const modal = $(this).closest(".modal");

    // Retrieve values from the correct modal
    const lessonID = $(this).data("lesson-id");
    const moduleID = modal.find("select.editModuleID").val(); // Ensure it's fetching from the dropdown
    const lessonName = modal.find(".editLessonName").val().trim();
    const lessonDescription = modal.find(".editLessonDescription").val().trim();

    console.log("Selected Module ID:", moduleID);

    // Validate inputs
    if (!lessonID || !moduleID || !lessonName || !lessonDescription) {
      Swal.fire({
        icon: "warning",
        title: "Missing Fields!",
        text: "Please fill in all fields.",
      });
      return;
    }

    // Prepare data for AJAX request
    let formData = { lessonID, moduleID, lessonName, lessonDescription };

    // AJAX request to update lesson
    $.ajax({
      url: "/ajax/updateLesson",
      type: "POST",
      data: JSON.stringify(formData),
      contentType: "application/json",
      dataType: "json",
      success: function (response) {
        if (response.success) {
          Swal.fire({
            position: "top-right",
            icon: "success",
            title: "Lesson Updated!",
            text: response.message,
            timer: 1500,
          });

          // Close modal properly
          modal.modal("hide");

          // Update the lesson row in DataTable
          updateLessonRow(lessonID, moduleID, lessonName, lessonDescription);
        } else {
          Swal.fire({
            position: "bottom",
            icon: "error",
            title: "Update Failed!",
            text: response.message,
          });
        }
      },
      error: function (xhr) {
        Swal.fire({
          icon: "error",
          title: "Request Failed!",
          text: "Error updating lesson: " + xhr.statusText,
        });
      },
    });
  });
}

// ✅ Function to update lesson row dynamically in DataTable
export function updateLessonRow(
  lessonID,
  moduleID,
  lessonName,
  lessonDescription
) {
  let table = window.lessonTable;

  let rowIndex = table
    .rows()
    .eq(0)
    .filter((index) => {
      return table
        .row(index)
        .data()[3]
        .includes(`data-lesson-id="${lessonID}"`);
    });

  if (rowIndex.length) {
    table
      .row(rowIndex[0])
      .data([
        `Module ${moduleID}`, // Prefix with "Module" for display
        lessonName,
        lessonDescription,
        `<div class="btn-group">
          <button class="btn btn-sm btn-warning editLessonBtn" 
            data-bs-toggle="modal" 
            data-bs-target="#updateLessonModal_${lessonID}" 
            data-lesson-id="${lessonID}">
            <i class="fa fa-edit"></i>
        </button>
        <button class="btn btn-sm btn-danger removeLessonBtn" 
            data-lesson-id="${lessonID}">
            <i class="fa fa-trash"></i>
        </button>
        </div>`,
      ])
      .draw(false);
  }
}
