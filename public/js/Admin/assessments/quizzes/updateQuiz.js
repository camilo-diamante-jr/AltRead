export function initializeUpdateQuizzes() {
  $(document).on("click", ".editQuizButton", showQuizModal);
  $(document).on("submit", "#quizEditForm", submitUpdateQuizForm);
}

function showQuizModal() {
  const quizID = $(this).data("quiz-id"); // Get the quiz ID from the button

  $.ajax({
    url: "/renderQuizById", // Server endpoint to get quiz data by ID
    method: "POST",
    data: { quiz_id: quizID }, // Pass the quiz ID
    dataType: "json",
    success: function (response) {
      if (response.success) {
        // Populate the modal with the fetched quiz data
        $("#edit_quiz_title").val(response.quizData.quiz_title);
        $("#edit_quiz_type").val(response.quizData.quiz_type);
        $("#edit_quiz_question").val(response.quizData.quiz_question);

        // Populate Sub Contents (if any)
        let subContentsHTML = "";
        for (let i = 1; i <= 6; i++) {
          let subContentValue =
            response.quizData[`sub_content_${i}`] || "No Sub Content Available";
          subContentsHTML += `
            <textarea class="form-control mb-2" name="sub_content_${i}" rows="3">${subContentValue}</textarea>
          `;
        }
        $("#editQuizSubContentsWrapper").html(subContentsHTML);

        // Populate Choices (if any)
        let choicesHTML = "";
        for (let i = 1; i <= 6; i++) {
          let choiceValue =
            response.quizData[`choices_${i}`] || "No Choice Available";
          choicesHTML += `
            <input type="text" class="form-control mb-2" name="choices_${i}" value="${choiceValue}" placeholder="Choice ${i}">
          `;
        }
        $("#editQuizChoicesWrapper").html(choicesHTML);

        // Show the modal
        $("#editQuizModal").modal("show");
      } else {
        Swal.fire("Error!", "Could not fetch quiz data.", "error");
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX error:", status, error);
      Swal.fire("Oops!", "Server error occurred.", "error");
    },
  });
}

// Function to handle the quiz update form submission
function submitUpdateQuizForm(e) {
  e.preventDefault();

  const quizID = $("#edit_quiz_id").val(); // Assuming quiz ID is present in a hidden field
  const quizTitle = $("#edit_quiz_title").val();
  const quizType = $("#edit_quiz_type").val();
  const quizQuestion = $("#edit_quiz_question").val();

  const subContents = [];
  for (let i = 1; i <= 6; i++) {
    subContents.push($(`#edit_quiz_sub_content_${i}`).val() || null); // Push null if empty
  }

  const choices = [];
  for (let i = 1; i <= 6; i++) {
    choices.push($(`#edit_quiz_choice_${i}`).val() || null); // Push null if empty
  }

  $.ajax({
    url: "/updateQuizzes", // Endpoint to handle quiz update
    method: "POST",
    data: {
      quiz_id: quizID,
      quiz_title: quizTitle,
      quiz_type: quizType,
      quiz_question: quizQuestion,
      sub_contents: subContents,
      choices: choices,
    },
    success: function (response) {
      if (response.success) {
        Swal.fire("Success!", "Quiz updated successfully!", "success");
        $("#editQuizModal").modal("hide"); // Close modal after success
      } else {
        Swal.fire(
          "Error!",
          response.message || "Failed to update quiz.",
          "error"
        );
      }
    },
    error: function (xhr, status, error) {
      Swal.fire("Oops!", "Something went wrong!", "error");
      console.error(error);
    },
  });
}
