export function initializeExaminations() {
  $(document).on("click", ".takeLessonBtn", handleTakeLesson);
}

const startedLessons = new Set(); // Track started lessons to avoid multiple countdowns

function handleTakeLesson() {
  const lesson_id = $(this).data("lesson-id");
  const module_id = $(this).data("module-id");

  if (!lesson_id) {
    showAlert("Missing Data", "Lesson ID is required.", "error");
    return;
  }

  $.ajax({
    url: "/ajax/showQuestionsPerLesson",
    type: "POST",
    data: { lesson_id, module_id },
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        if (Array.isArray(response.data) && response.data.length > 0) {
          if (!startedLessons.has(lesson_id)) {
            startedLessons.add(lesson_id);
            showLessonStartCountdown(() =>
              openLesson(response.data, response.lesson_name)
            );
          } else {
            openLesson(response.data, response.lesson_name);
          }
        } else {
          showAlert(
            "No Questions",
            "This lesson currently has no questions available.",
            "info"
          );
        }
      } else {
        showAlert(
          "Warning",
          response.message || "No questions found.",
          "warning"
        );
      }
    },
    error: function (xhr) {
      console.error("Error fetching questions:", xhr.status, xhr.responseText);

      let errorMessage = "An error occurred while fetching questions.";

      if (xhr.status === 404) {
        try {
          const response = JSON.parse(xhr.responseText);
          errorMessage =
            response.message || "No questions available for this lesson.";
        } catch (e) {
          errorMessage = "No questions available.";
        }
      }

      showAlert("Notice", errorMessage, "warning");
    },
  });
}

// Show countdown before the lesson starts
function showLessonStartCountdown(callback) {
  let countdown = 5;
  Swal.fire({
    title: "Preparing your lesson...",
    html: `
      <div class="fw-bold">Loading questions...</div>
      <h2 class="fw-bold"><span id="countdown">${countdown}</span></h2>
    `,
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    showConfirmButton: false,
    draggable: true,
    didOpen: () => {
      const countdownElement = document.getElementById("countdown");
      const interval = setInterval(() => {
        countdown--;
        countdownElement.textContent = countdown;
        if (countdown === 0) {
          clearInterval(interval);
          Swal.close();
          callback();
        }
      }, 1000);
    },
  });
}

// Open the lesson after countdown
function openLesson(questions, lessonTitle) {
  renderExaminationModal(questions, lessonTitle);
  $("#examinationModal").modal("show");
}

function renderExaminationModal(questions, lessonTitle = "Lesson") {
  if (!questions || questions.length === 0) {
    $("#examinationModal .modal-title").html(`<strong>${lessonTitle}</strong>`);
    $("#examinationModal .modal-body").html(
      `<p class="text-center text-muted">No questions available for this lesson.</p>`
    );
    return;
  }

  // Group questions by part_id
  const questionsByPart = {};
  questions.forEach((question) => {
    if (!questionsByPart[question.part_id]) {
      questionsByPart[question.part_id] = [];
    }
    questionsByPart[question.part_id].push(question);
  });

  let questionsHTML = "";
  const totalParts = Object.keys(questionsByPart).length;

  Object.keys(questionsByPart).forEach((partId, idx) => {
    const partQuestions = questionsByPart[partId];
    const partTitle = partQuestions[0].part_name || `Part ${partId}`;

    questionsHTML += `
      <section class="question-part ${
        idx === 0 ? "d-block" : "d-none"
      }" data-part-index="${idx}">
        <h4 class="fw-bold text-uppercase text-center mb-4">${partTitle}</h4>
    `;

    partQuestions.forEach((question) => {
      questionsHTML += `
        <div class="custom-card border rounded p-3 mb-4 m-auto">
          <h5 class="mb-2">${question.content_title ?? ""}</h5>
          <p>${question.questions_direction ?? ""}</p>
          <p>${question.question_text ?? ""}</p>

         <img src="../files/uploads/question_photos/${question.content_img}" 
     alt="Question Image" 
     class="img-fluid mb-3 ${
       !question.content_img || question.content_img === "NULL" ? "d-none" : ""
     }">


          <p>
            ${question.sub_content_1 ?? ""} 
            ${question.sub_content_2 ?? ""} 
            ${question.sub_content_3 ?? ""} 
            ${question.sub_content_4 ?? ""}
          </p>
      `;

      if (question.question_type === "multiple_choice") {
        questionsHTML += `<div class="choices">`;
        question.choices.forEach((choice) => {
          questionsHTML += `
            <div class="form-check">
              <input class="form-check-input" type="radio" name="question_${question.id}" value="${choice.value}">
              <label class="form-check-label">${choice.choice_text}</label>
            </div>
          `;
        });
        questionsHTML += `</div>`;
      } else if (question.question_type === "true_false") {
        questionsHTML += `
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="question_${question.id}" value="true">
            <label class="form-check-label">True</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="question_${question.id}" value="false">
            <label class="form-check-label">False</label>
          </div>
        `;
      } else if (question.question_type === "short_answer") {
        questionsHTML += `
          <textarea name="question_${question.id}" rows="3" class="form-control"></textarea>
        `;
      }

      questionsHTML += `</div>`; // Close custom-card
    });

    // Navigation Buttons
    questionsHTML += `
      <div class="d-flex justify-content-center gap-4 mt-4">
        <button class="btn btn-outline-secondary prev-btn" ${
          idx === 0 ? "disabled" : ""
        }>Previous</button>
        ${
          idx === totalParts - 1
            ? '<button class="btn btn-success submit-btn">Submit</button>'
            : '<button class="btn btn-primary next-btn">Next</button>'
        }
      </div>
    `;

    questionsHTML += `</section>`;
  });

  $("#examinationModal .modal-title").html(`<strong>${lessonTitle}</strong>`);
  $("#examinationModal .modal-body").html(questionsHTML);

  // Navigation logic
  $(".next-btn").click(function () {
    const current = $(".question-part.d-block");
    const next = current.next(".question-part");
    if (next.length) {
      current.removeClass("d-block").addClass("d-none");
      next.removeClass("d-none").addClass("d-block");
    }
  });

  $(".prev-btn").click(function () {
    const current = $(".question-part.d-block");
    const prev = current.prev(".question-part");
    if (prev.length) {
      current.removeClass("d-block").addClass("d-none");
      prev.removeClass("d-none").addClass("d-block");
    }
  });
  $(".submit-btn").click(function () {
    // Initialize an array to store all the answers
    const answersData = [];

    // Iterate over each question in the modal and collect the answers
    $(".custom-card").each(function () {
      const questionId = $(this)
        .find("input, textarea")
        .attr("name")
        .split("_")[1]; // Get question_id from the name attribute
      let answer = null;
      let choiceId = null;
      let isCorrect = false; // Default to incorrect

      // Determine the type of the question (multiple choice, true/false, or short answer)
      if ($(this).find("input[type='radio']").length > 0) {
        // If it's a radio button (multiple choice or true/false)
        const selectedOption = $(this).find("input[type='radio']:checked");

        if (selectedOption.length > 0) {
          answer = selectedOption.val();
          choiceId = selectedOption.val(); // Assuming value is the choice ID
          // You can check if the choice is correct here by comparing with the database or predefined correct answers
          // For now, we'll assume it's correct if it's selected
          isCorrect = true; // You should replace this with actual logic
        }
      } else if ($(this).find("textarea").length > 0) {
        // If it's a short answer question
        answer = $(this).find("textarea").val();
        isCorrect = false; // No validation for short answers, assume incorrect unless you implement logic
      }

      // Add the answer data for this question
      if (answer !== null) {
        answersData.push({
          question_id: questionId,
          choice_id: choiceId,
          answer: answer,
          is_correct: isCorrect, // You can implement a real correctness check here
          learner_id: learnerId, // Assuming learnerId is available
        });
      }
    });

    // Send AJAX request to submit answers
    $.ajax({
      url: "/ajax/submitExamination", // The endpoint to handle the submission
      type: "POST",
      data: {
        answers: answersData,
        lesson_id: lesson_id, // If needed, send lesson_id along with answers
      },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          showAlert(
            "Success",
            "Your answers have been submitted successfully.",
            "success"
          );
          // Optionally, you can redirect the user to a different page or reset the form
        } else {
          showAlert(
            "Error",
            response.message ||
              "An error occurred while submitting your answers.",
            "error"
          );
        }
      },
      error: function (xhr, status, error) {
        console.error(
          "Error submitting answers:",
          xhr.status,
          xhr.responseText
        );
        showAlert(
          "Error",
          "There was an error submitting your answers. Please try again later.",
          "error"
        );
      },
    });
  });
}

// Function for improved Swal alerts
function showAlert(title, message, icon = "info") {
  Swal.fire({
    title,
    text: message,
    icon,
    confirmButtonColor: "#3085d6",
    confirmButtonText: "OK",
  });
}
