export function removeCurrentLesson() {
  $(document).on("click", ".removeLessonBtn", function () {
    const lessonID = $(this).data("lesson-id");
    removeLesson(lessonID, this);
  });
}

function removeLesson(lessonID, element) {
  Swal.fire({
    title: "Are you sure?",
    text: "This lesson will be remove!",
    icon: "warning",
    position: "center",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Yes, remove it!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/ajax/removeLesson",
        type: "POST",
        data: JSON.stringify({ lessonID }),
        contentType: "application/json",
        dataType: "json",
        success: function (response) {
          if (response.success) {
            Swal.fire({
              icon: "success",
              title: "Lesson successfully remove!",
              text: response.message,
              timer: 1500,
            });

            window.lessonTable.row($(element).closest("tr")).remove().draw();
          } else {
            showErrorPopup(response.message);
          }
        },
        error: handleAjaxError,
      });
    }
  });
}
