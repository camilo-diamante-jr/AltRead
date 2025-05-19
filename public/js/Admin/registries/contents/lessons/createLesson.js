export function createLesson() {
  const lessonAlert = $(".lessonAlert");
  const alertMsg = $(".alertMsg");

  $("#lessonSubmitBtn").on("click", function (e) {
    e.preventDefault(); // Prevent default form submission

    const moduleID = $("#moduleID").val().trim();
    const lessonName = $("#lessonName").val().trim();
    const lessonDescription = $("#lessonDescription").val().trim();

    if (!moduleID || !lessonName || !lessonDescription) {
      lessonAlert
        .removeClass("d-none alert-primary alert-success")
        .addClass("alert-danger");
      alertMsg.text("All fields are required!");
      return;
    }

    // Show processing message
    lessonAlert
      .removeClass("d-none alert-danger alert-success")
      .addClass("alert-primary");
    alertMsg.text("Processing...");

    $.ajax({
      url: "/ajax/insertLesson",
      type: "POST",
      data: {
        moduleID: moduleID,
        lessonName: lessonName,
        lessonDescription: lessonDescription,
      },
      dataType: "json", // Expect JSON response
      success: function (response) {
        lessonAlert
          .removeClass("alert-primary alert-danger")
          .addClass(response.success ? "alert-success" : "alert-danger");
        alertMsg.text(response.message);

        if (response.success) {
          $("#lessonSubmitForm")[0].reset(); // Reset form on success
        }
      },
      error: function (xhr) {
        lessonAlert
          .removeClass("alert-primary alert-success")
          .addClass("alert-danger");
        alertMsg.text("Error saving lesson! " + xhr.statusText);
      },
    });
  });

  $(".lessonCloseBtn").on("click", () => {
    window.location.reload();
  });
}
