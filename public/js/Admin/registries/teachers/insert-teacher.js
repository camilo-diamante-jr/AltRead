export function insertTeacher() {
  $(document).on("submit", "#addTeacherForm", initializeSubmissions);
}

function initializeSubmissions(e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  $.ajax({
    url: "/admin/teachers/insert",
    type: "POST",
    data: formData,
    contentType: false,
    processData: false,
    success: function (response) {
      if (typeof response === "string") {
        response = JSON.parse(response);
      }

      if (response.success && response.teacherData) {
        const teacher = response.teacherData;

        // Insert new teacher row to DataTable (adjust if you're using DataTables)
        const table = $("#teachersTable").DataTable();
        const fullName = `${teacher.lastName}, ${teacher.firstName}${
          teacher.middleName ? " " + teacher.middleName : ""
        }`;

        table.row
          .add([
            teacher.id || "",
            fullName, // Display full name in "LastName, FirstName MiddleName" format
            teacher.email || "",
            teacher.position || "",
            `
              <div class="text-center">
                <a href="#teacherModal" class="text-warning update-teacher-btn" data-teacher-id="${teacher.id}" data-bs-toggle="modal">
                  <i class="bi bi-pencil-fill"></i>
                </a>
                <a href="#" class="text-danger delete-teacher" data-teacher-id="${teacher.id}" data-bs-toggle="modal">
                  <i class="bi bi-trash-fill"></i>
                </a>
              </div>
            `,
          ])
          .draw(false);

        // Reset the form without closing the modal
        form.reset();

        // Show success message
        Swal.fire({
          icon: "success",
          title: "Teacher Added",
          text: response.message || "The teacher has been added successfully!",
          timer: 1500,
          showConfirmButton: false,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text:
            response.message || "An error occurred while adding the teacher.",
        });
        console.error(response.message);
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
