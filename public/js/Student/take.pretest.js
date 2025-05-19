export function takePretest() {
  const pretest = {
    elements: {
      questions: $(".pretest-question"),
      countdown: $("#countdownTimer"),
      startButton: $("#startUpBtn"),
      prevButton: $("#prevBtn"),
      nextButton: $("#nextBtn"),
      submitButton: $("#submitBtn"),
      directionsCard: $("#generalDirectionsCard"),
      assessmentCard: $("#preAssessmentCard"),
    },

    state: {
      currentQuestion: 0,
      timer: null,
      duration: 1 * 60, // 30 minutes in seconds
      remainingTime: 1 * 60,
      timeUpNotified: false, // Flag to track if time's up message has been shown
    },

    storageKeys: {
      time: "remainingTime",
      questionIndex: "currentQuestionIndex",
      started: "pretestStarted",
      answerPrefix: "answer_", // Prefix for storing answers
    },

    init() {
      this.loadState();
      this.bindEvents();
      this.renderChoices();

      if (localStorage.getItem(this.storageKeys.started) === "true") {
        this.resumePretest();
      } else {
        this.setupStartButton();
      }
    },

    bindEvents() {
      this.elements.prevButton.click(() => this.showPreviousQuestion());
      this.elements.nextButton.click(() => this.showNextQuestion());
      this.elements.submitButton.click((e) => this.submitPretest(e));

      // Save answer to local storage on selection
      $(".form-check-input").change((e) => {
        const questionId = $(e.target)
          .closest(".pretest-question")
          .data("question-id");
        const selectedAnswer = $(e.target).val();
        localStorage.setItem(
          `${this.storageKeys.answerPrefix}${questionId}`,
          selectedAnswer
        );
      });
    },

    saveState() {
      localStorage.setItem(this.storageKeys.time, this.state.remainingTime);
      localStorage.setItem(
        this.storageKeys.questionIndex,
        this.state.currentQuestion
      );
      localStorage.setItem(this.storageKeys.started, "true");
    },

    loadState() {
      const savedTime = localStorage.getItem(this.storageKeys.time);
      const savedIndex = localStorage.getItem(this.storageKeys.questionIndex);
      if (savedTime) this.state.remainingTime = parseInt(savedTime, 10);
      if (savedIndex) this.state.currentQuestion = parseInt(savedIndex, 10);

      // Load saved answers
      this.elements.questions.each(function () {
        const questionId = $(this).data("question-id");
        const savedAnswer = localStorage.getItem(
          `${pretest.storageKeys.answerPrefix}${questionId}`
        );
        if (savedAnswer) {
          $(this)
            .find(`.form-check-input[value="${savedAnswer}"]`)
            .prop("checked", true);
        }
      });
    },

    renderChoices() {
      $(".pretest-question .choice-content").each(function () {
        const content = $(this).data("content");
        if (/\.(png|jpg|jpeg|gif)$/i.test(content)) {
          $(this).html(
            `<img src="../../assets/images/pretest/${content}" class="img-fluid" alt="Choice Image" width="80">`
          );
        } else {
          $(this).text(content);
        }
      });
    },

    showQuestion(index) {
      this.elements.questions
        .addClass("d-none")
        .eq(index)
        .removeClass("d-none");
      this.elements.prevButton.toggleClass("d-none", index === 0);
      this.elements.nextButton.toggleClass(
        "d-none",
        index === this.elements.questions.length - 1
      );
      this.elements.submitButton.toggleClass(
        "d-none",
        index !== this.elements.questions.length - 1
      );
    },

    showPreviousQuestion() {
      if (this.state.currentQuestion > 0) {
        this.state.currentQuestion--;
        this.saveState();
        this.showQuestion(this.state.currentQuestion);
      }
    },

    showNextQuestion() {
      if (this.state.currentQuestion < this.elements.questions.length - 1) {
        this.state.currentQuestion++;
        this.saveState();
        this.showQuestion(this.state.currentQuestion);
      }
    },

    submitPretest(e) {
      e && e.preventDefault(); // If event is provided, prevent default action
      this.stopTimer();

      console.log("Submitting pretest..."); // Debugging log to ensure it's called

      const preAssessmentForm = document.getElementById("preAssessmentForm");
      const formData = new FormData(preAssessmentForm);

      $.ajax({
        type: "POST",
        url: "/submitPretest", // Check if this URL is correct and reachable
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        success: function (response) {
          console.log(response); // Log response for debugging
          if (response.status === "success") {
            Swal.fire({
              heightAuto: false,
              icon: "success",
              title: "Pretest Submitted!",
              text: "Your submission was successful.",
              confirmButtonText: "OK",
            }).then(function () {
              localStorage.clear();
              pretest.elements.assessmentCard.addClass("d-none");
              $("#submissionSuccessMessage").removeClass("d-none");
            });
          } else {
            Swal.fire({
              heightAuto: false,
              icon: "error",
              title: "Submission Failed",
              text: response.message || "An error occurred during submission.",
            });
          }
        },
        error: function () {
          Swal.fire({
            heightAuto: false,
            icon: "error",
            title: "Error",
            text: "Failed to submit your pretest. Please try again later.",
          });
        },
      });
    },

    setupStartButton() {
      this.elements.startButton.click(() => {
        Swal.fire({
          position: "top",
          title: "Your pretest will start in...",
          html: `<strong><span id="pretestCountdown">5</span></strong> seconds`,
          timer: 5000,
          timerProgressBar: true,
          showConfirmButton: false,
          allowOutsideClick: false,
          didOpen: () => {
            let countdown = 5;
            const interval = setInterval(() => {
              countdown--;
              $("#pretestCountdown").text(countdown);
            }, 1000);
            setTimeout(() => clearInterval(interval), 5000);
          },
        }).then(() => {
          this.startPretest();
        });
      });
    },

    startPretest() {
      this.elements.directionsCard.addClass("d-none");
      this.elements.assessmentCard.removeClass("d-none");
      this.showQuestion(this.state.currentQuestion);
      this.startTimer();
      this.saveState();
    },

    resumePretest() {
      this.elements.directionsCard.addClass("d-none");
      this.elements.assessmentCard.removeClass("d-none");
      this.showQuestion(this.state.currentQuestion);
      this.startTimer();
    },

    startTimer() {
      this.state.timer = setInterval(() => {
        if (this.state.remainingTime <= 0) {
          if (!this.state.timeUpNotified) {
            this.state.timeUpNotified = true; // Prevent further pop-ups
            Swal.fire({
              icon: "warning",
              title: "Time's Up!",
              text: "Your pretest has been automatically submitted.",
              showConfirmButton: true,
              confirmButtonText: "Submit Now", // The button user needs to click
            }).then((result) => {
              if (result.isConfirmed) {
                // Ensure that submitPretest is called on 'this' (the pretest object)
                console.log("Submit Now clicked! Submitting pretest..."); // Debugging log
                this.submitPretest(null); // Calling 'this.submitPretest'
              }
            });
          }
        } else {
          this.state.remainingTime--;
          this.saveState();
          this.updateCountdownDisplay();
        }
      }, 1000);
    },
    stopTimer() {
      if (this.state.timer) {
        clearInterval(this.state.timer);
        this.state.timer = null;
      }
    },

    updateCountdownDisplay() {
      const hours = String(
        Math.floor(this.state.remainingTime / 3600)
      ).padStart(2, "0");
      const minutes = String(
        Math.floor((this.state.remainingTime % 3600) / 60)
      ).padStart(2, "0");
      const seconds = String(this.state.remainingTime % 60).padStart(2, "0");
      this.elements.countdown.text(`${hours}:${minutes}:${seconds}`);
    },
  };

  pretest.init();
}
