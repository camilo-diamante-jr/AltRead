export function initializeLessons() {
  $(document).on("click", ".showLessonBtn", handleShowLesson);
  $(document).on("click", ".goBackBtn", handleBackToModules);
  $(document).on("click", ".goBackToLessonBtn", handleBackToLessons);
}

// Fetch and display lessons for a selected module
function handleShowLesson() {
  const module_id = $(this).data("module-id");

  if (!module_id) {
    displayAlert("Module ID is missing.", "error");
    return;
  }

  showLoading("Fetching lessons, hang tight...");

  setTimeout(() => {
    $.ajax({
      url: "/ajax/showLessonsPerModule",
      type: "POST",
      data: { module_id },
      dataType: "json",
      success: function (response) {
        Swal.close(); // Close loading after exactly 5 seconds

        setTimeout(() => {
          if (response.status === "success") {
            renderLessons(response.data);
            displayAlert("Lessons fetch successfully!", "success");
          } else {
            displayAlert(response.message, "warning");
          }
        }, 300); // Short delay to make transition smoother
      },
      error: function () {
        Swal.close();
        setTimeout(() => {
          displayAlert("An error occurred while fetching lessons.", "error");
        }, 300);
      },
    });
  }, 5000); // Ensure the loading screen lasts exactly 5 seconds
}

// Render lessons dynamically using Bootstrap
function renderLessons(lessons) {
  $("#moduleContainer").fadeOut("fast", function () {
    $("#lessonContainer").removeClass("d-none").fadeIn("fast");
  });

  let lessonHTML = `
    <section id="lessonsContent">
      <button class="btn btn-outline-secondary mb-3 goBackBtn">
        <i class="fa fa-arrow-left"></i> Go Back
      </button>

      <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
  `;

  lessons.forEach((lesson) => {
    lessonHTML += `
      <div class="col">
        <div class="card shadow-sm h-100 border-0">
          <div class="card-body text-center">
            <h5 class="card-title text-primary fw-bold">${lesson.lesson_name}</h5>
            <p class="card-text text-muted">${lesson.lesson_description}</p>
            <span class="text-success fw-semibold takeLessonBtn" 
              data-lesson-id="${lesson.lesson_id}" style="cursor: pointer;" data-lessonname="${lesson.lesson_name}">
              <i class="fa fa-play-circle me-1"></i> Take Lesson
            </span>
          </div>
        </div>
      </div>
    `;
  });

  lessonHTML += `</div></section>`;

  $("#lessonContainer .lessons-content").html(lessonHTML);
}

// Navigation Functions
function handleBackToModules() {
  $("#lessonContainer").fadeOut("fast", function () {
    $("#moduleContainer").fadeIn("fast");
  });
}

function handleBackToLessons() {
  $("#partsContent").fadeOut("fast", function () {
    $("#lessonContainer").fadeIn("fast");
  });
}

// Display alert using SweetAlert2
function displayAlert(message, type) {
  Swal.fire({
    position: "center",
    icon: type,
    title: message,
    showConfirmButton: false,
    timer: 1500,
  });
}

// Show loading spinner for 5 seconds
function showLoading(message) {
  Swal.fire({
    title: message,
    allowOutsideClick: false,
    timer: 5000,
    didOpen: () => {
      Swal.showLoading();
    },
    icon: "info", // You can change this to "warning", "success", or "question"
    showConfirmButton: false,
    backdrop: `
      rgba(0,0,123,0.4)
      url("https://i.gifer.com/ZZ5H.gif")  // You can replace this with any custom loading animation
      center center
      no-repeat
    `,
  });
}
