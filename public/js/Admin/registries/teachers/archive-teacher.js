export function initializeArchiveTeacher() {
  $(document).on("click", ".delete-teacher", remove);
}

function remove() {
  const teacherId = $(this).data("teacher-id");
  console.log("Teacher ID:", teacherId); // Verify teacher ID

  // Show a confirmation dialog
  Swal.fire({
    title: "Are you sure?",
    text: "This will archive the teacher.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Yes, archive it!",
    cancelButtonText: "No, cancel!",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "/admin/teachers/remove", // Correct endpoint
        type: "POST",
        data: { teacher_id: teacherId }, // Pass teacher_id as data
        success: function (response) {
          if (typeof response === "string") {
            response = JSON.parse(response); // Parse the JSON response if it's a string
          }

          if (response.success) {
            Swal.fire({
              icon: "success",
              title: "Teacher Archived",
              text:
                response.message ||
                "The teacher has been archived successfully.",
              timer: 1500,
              showConfirmButton: false,
            });
            const table = $("#teachersTable").DataTable();
            table.row($(this).parents("tr")).remove().draw();
          } else {
            Swal.fire({
              icon: "error",
              title: "Failed to Archive",
              text:
                response.message || "Something went wrong. Please try again.",
            });
          }
        },
        error: function (xhr, status, error) {
          Swal.fire({
            icon: "error",
            title: "AJAX Error",
            text: "Something went wrong. Please try again later.",
          });
          console.error("AJAX Error:", error);
        },
      });
    }
  });
}
