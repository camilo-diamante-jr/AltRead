// Constants for DOM element selectors
const EXAM_MODAL_ID = "#examModal";
const EXAM_MODAL_TITLE_SELECTOR = ".modal-title";
const EXAM_MODAL_CONTENT_SELECTOR = "#modalContent";
const EXAM_STARTUP_BTN = ".startupButton";
const EXAM_CARD_SELECTOR = ".parts-card";
const PART_COLUMN_SELECTOR = ".parts-column";

/**
 * Initializes event listeners for loading examinations.
 */
function loadQuestionsInitialization() {
  $(".viewPartsPerLesson").on("click", function () {
    const lessonId = $(this).data("lesson-id");
    console.log("Fetching exams for lesson ID:", lessonId); // Debugging

    // Call fetchExamsByLessonId when the button is clicked
    fetchExamsByLessonId(lessonId)
      .then((response) => {
        console.log("Response from backend:", response); // Debugging
        if (response.status === 200) {
          const questions = response.exams;
          if (Array.isArray(questions) && questions.length > 0) {
            updateModalContent(questions, lessonId);
          } else {
            notifyNoExamsAvailable(lessonId);
          }
        } else {
          notifyError(response.message || "Error loading exams.");
        }
      })
      .catch((error) => {
        errorHandling(error);
      });
  });
}

/**
 * Fetches exams associated with a specific lesson ID via AJAX.
 * @param {number|string} lessonId - The ID of the lesson.
 * @returns {Promise<Object>} - A promise resolving to the server response.
 */
function fetchExamsByLessonId(lessonId) {
  return $.ajax({
    url: "/ajax/getQuestionsByLessonId", // Ensure this is the correct API endpoint
    method: "POST",
    data: { lesson_id: lessonId },
  })
    .then((response) => jQuery.parseJSON(response))
    .catch((error) => {
      throw error;
    });
}

/**
 * Updates the modal content with exam information.
 * @param {Array} questions - List of questions to display.
 * @param {number|string} lessonId - The lesson ID for the exams.
 */
function updateModalContent(questions, lessonId) {
  const modalTitle = `Examinations for Lesson ${lessonId}`;
  const examList = buildExamCards(questions);

  $(EXAM_MODAL_CONTENT_SELECTOR).html(examList);
  $(EXAM_MODAL_TITLE_SELECTOR).text(modalTitle);

  $(EXAM_MODAL_ID).modal("show");

  // Attach event listeners for the "Start Exam" button
  attachExamCardEventListeners();
}

/**
 * Builds HTML for the list of exam cards.
 * @param {Array} questions - List of question objects.
 * @returns {string} - HTML string for the exam cards.
 */
function buildExamCards(questions) {
  return ``;
}

/**
 * Attaches event listeners to exam cards for the "Start Exam" button.
 */
function attachExamCardEventListeners() {
  // Event delegation to prevent multiple bindings of listeners
  $(document).on("click", EXAM_STARTUP_BTN, function () {
    $(EXAM_CARD_SELECTOR).addClass("d-none");
    $(EXAM_MODAL_CONTENT_SELECTOR).append(examinationForm());
  });
}

/**
 * Generates the examination form HTML.
 * @returns {string} - HTML string for the examination form.
 */
function examinationForm() {
  return `
        <form>
            <div class="card">
                <div class="card-body">
                    <p>What is the Capital of France?</p>
                </div>
            </div>
        </form>
    `;
}

/**
 * Displays a notification when no exams are available for a lesson.
 * @param {number|string} lessonId - The lesson ID with no exams.
 */
function notifyNoExamsAvailable(lessonId) {
  Swal.fire({
    icon: "info",
    title: "No Exams Available",
    text: `No exams available for lesson ID: ${lessonId}`,
  });
}

/**
 * Displays an error notification.
 * @param {string} message - The error message to display.
 */
function notifyError(message) {
  Swal.fire({
    icon: "error",
    title: "Error",
    text: message,
  });
}

/**
 * Centralized error handling function.
 * @param {Object} error - The error object or message.
 */
function errorHandling(error) {
  console.error("AJAX error:", error);
  Swal.fire({
    icon: "error",
    title: "Error",
    text: "Error loading exams. Please try again.",
  });
}
