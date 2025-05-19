export function initializeRenderingTeacher() {
  $(document).on("click", ".update-teacher-btn", function () {
    const teacherId = $(this).data("teacher-id"); // Get the teacher ID from the data attribute

    $.ajax({
      url: "/admin/teachers/fetchTeacherByID", // The PHP endpoint
      method: "POST", // Use POST method to send data
      data: {
        teacher_id: teacherId, // Pass teacher ID in the POST request
      },
      success: function (response) {
        console.log("Response from server:", response); // Log the server response

        // Ensure the response is in the expected format
        if (response.status === 200) {
          const teacher = response.teacher;

          // Populate the modal with the teacher data
          //   $("#teacherModalLabel").text();
          $("#edit_first_name").val(teacher.first_name);
          $("#edit_middle_name").val(teacher.middle_name);
          $("#edit_last_name").val(teacher.last_name);
          $("#edit_email").val(teacher.email);
          $("#edit_contact_number").val(teacher.contact_number);
          $("#edit_position").val(teacher.position);
          $("#edit_address").val(teacher.address);
          $("#edit_dob").val(teacher.date_of_birth.split(" ")[0]);

          $("#teacher_id").val(teacher.teacher_id);

          // Show the modal
          $("#teacherModal").modal("show");
        } else {
          // Handle the case where no teacher data is returned
          alert(response.error || "Teacher not found");
        }
      },
      error: function () {
        alert("Error fetching teacher data");
      },
    });
  });
}
