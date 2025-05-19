export function updateTeacher() {
  $(document).on("submit", "#editTeacherForm", initializeUpdateTeacher);
}

function initializeUpdateTeacher(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  $.ajax({
    url: "/admin/teachers/update",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      if (typeof response === "string") {
        response = JSON.parse(response);
      }

      if (response.success && response.teacherUpdatedData) {
        const teacher = response.teacherUpdatedData;

        const table = $("#teachersTable").DataTable();
        const fullName = `${teacher.last_name}, ${teacher.first_name}${
          teacher.middle_name ? " " + teacher.middle_name : ""
        }`;

        // Loop over all rows to find the one with matching teacher_id
        table.rows().every(function () {
          const rowData = this.data();
          console.log("Comparing row:", rowData[0], "with", teacher.teacher_id);

          if (rowData[0] == teacher.teacher_id) {
            console.log("Match found! Updating row.");
            this.data([
              teacher.teacher_id,
              fullName,
              teacher.email || "",
              teacher.position || "",
              `
              <div class="text-center">
                <a href="#teacherModal" class="text-warning update-teacher-btn" data-teacher-id="${teacher.teacher_id}" data-bs-toggle="modal">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="#" class="text-danger delete-teacher" data-teacher-id="${teacher.teacher_id}" data-bs-toggle="modal">
                  <i class="bi bi-trash-fill"></i>
                </a>
              </div>
               `,
            ]);
          }
        });

        table.draw(false); // Redraw table without resetting pagination

        Swal.fire({
          icon: "success",
          title: "Teacher Updated",
          text:
            response.message ||
            "The teacher data has been updated successfully!",
          timer: 1500,
          showConfirmButton: false,
        });

        $("#teacherModal").modal("hide");
      } else {
        Swal.fire({
          icon: "info",
          title: "No Changes",
          text: response.message || "No changes were made to the teacher data.",
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
