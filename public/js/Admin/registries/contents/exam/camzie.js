class LessonExamHandler {
    constructor() {
      this.initializeEvents();
    }
  
    // Initialize event listeners
    initializeEvents() {
      $(".view-exam-button").on("click", (event) => {
        const lessonID = $(event.currentTarget).data("lesson-id");
        if (lessonID) {
          this.fetchQuestionsByLessonId(lessonID);
        } else {
          console.warn("Lesson ID is missing.");
        }
      });
  
      this.initializeCompleteExaminations();
    }
  
    // Fetch questions based on the lesson ID
    fetchQuestionsByLessonId(lessonID) {
      $.ajax({
        url: "/ajax/getQuestionsByLessonId",
        type: "POST",
        data: { lesson_id: lessonID },
        success: (response) => {
          try {
            const data =
              typeof response === "string"
                ? jQuery.parseJSON(response)
                : response;
  
            if (data.status === 200) {
              this.showPartsPerLesson(lessonID);
            } else {
              this.noExamsFoundNotify(data.message);
            }
          } catch (error) {
            console.error("Error parsing response:", error);
            this.showAjaxErrorNotify();
          }
        },
        error: (xhr, status, error) => {
          console.error("AJAX Error:", error);
          this.showAjaxErrorNotify();
        },
      });
    }
  
    // Show parts of the lesson with a carousel loader
    showPartsPerLesson(lessonID) {
      Swal.fire({
        title: "Loading Lesson Parts",
        text: "Please wait while we prepare the lesson details...",
        icon: "info",
        allowOutsideClick: false,
        showConfirmButton: false,
        customClass: {
          title: "swal-title-lg",
          popup: "swal-popup-loader",
        },
        didOpen: () => Swal.showLoading(),
      });
  
      setTimeout(() => {
        Swal.close();
        $("#partPerLesson").removeClass("d-none");
        $("#lessonPerModule").addClass("d-none");
  
        $("#partPerLesson input").val(lessonID);
  
        this.initializeOwlCarousel();
  
        $(".back-to-lesson-btn")
          .off("click")
          .on("click", () => {
            $("#partPerLesson").addClass("d-none");
            $("#lessonPerModule").removeClass("d-none");
          });
      }, 1200);
    }
  
    // Initialize Owl Carousel
    initializeOwlCarousel() {
      $(".part-owl-carousel").owlCarousel({
        loop: true,
        margin: 20,
        nav: false,
        dots: true,
        responsive: {
          0: { items: 1 },
          600: { items: 2 },
          1000: { items: 3 },
        },
      });
    }
    initializeCompleteExaminations() {
      $(".start-examination-btn").on("click", (event) => {
          event.preventDefault(); // Prevent form submission if the button is inside a form
  
          const lessonID = $("#questionPerPartID").val();
          const partID = $(event.currentTarget).data("part-id");
  
          // Show loading Swal
          Swal.fire({
              title: 'Get Ready!',
              text: 'You will be redirected to the exam in 5 seconds...',
              timer: 5000, // 5 seconds
              timerProgressBar: true,
              didOpen: () => {
                  Swal.showLoading();
              },
              willClose: () => {
                  clearInterval(timerInterval);
              }
          }).then(() => {
              // Make the AJAX request to get the examination data
              $.ajax({
                  url: "/ajax/getAllExaminations",
                  type: "GET",
                  data: {
                      lessonID: lessonID,
                      partID: partID
                  },
                  success: (response) => {
                      // Assuming response contains the data you want to display in the modal
                      // Populate the modal with the received data
                      $('#examModal .modal-body').html(response); // Adjust this line based on your response structure
  
                      // Show the modal
                      $('#examModal').modal("show");
                  },
                  error: (xhr, status, error) => {
                      // Handle any errors that occur during the AJAX request
                      Swal.fire({
                          icon: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong while fetching the examination data!',
                      });
                  }
              });
          });
  
          // Optional: If you want to show a countdown in the Swal text
          let timerInterval = setInterval(() => {
              Swal.getContent().querySelector('strong').textContent = Math.ceil((Swal.getTimerLeft() / 1000)) + ' seconds remaining';
          }, 1000);
      });
  }
    // Notify when no exams are found
    noExamsFoundNotify(message) {
      Swal.fire({
        icon: "warning", // Relatable icon for missing content
        title: "No Exams Available",
        text: message || "It seems there are no exams for this lesson right now.",
        confirmButtonText: "OK",
        customClass: {
          popup: "swal-popup-md",
          title: "swal-title-warning",
        },
      });
    }
  
    // Notify of an AJAX error
    showAjaxErrorNotify() {
      Swal.fire({
        icon: "error", // Error icon for AJAX issues
        title: "An Error Occurred",
        text: "Oops! We encountered an issue. Please try again later.",
        confirmButtonText: "Retry",
        customClass: {
          popup: "swal-popup-lg",
          title: "swal-title-error",
        },
      });
    }
  }
  
  // Instantiate the handler and initialize events on document load
  $(document).ready(() => {
    new LessonExamHandler();
  });
  