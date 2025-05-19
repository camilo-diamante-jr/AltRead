<section class="">
    <!-- General Directions Card -->
    <div id="generalDirectionsCard" class="card border-0 shadow-sm bg-light p-4 mb-4">
        <h5 class="card-title fw-bold text-primary mb-3">General Directions:</h5>
        <p class="card-text">
            <?= $directions['pretestDirections'] ?>
        </p>

        <div class="text-center mt-3">
            <button type="button" id="startUpBtn" class="btn btn-primary btn-lg px-5">Start Pretest</button>
        </div>
    </div>

    <!-- Pre-Assessment Card -->
    <div id="preAssessmentCard" class="d-none">
        <div id="countdownTimer" class="alert alert-info text-center fw-bold mb-4" style="font-size: 1.5rem;">
            00:00:00
        </div>

        <form id="preAssessmentForm" method="POST">
            <?php foreach ($pre_assessments as $index => $pretest): ?>
                <div class="pretest-question card shadow-sm p-4 mb-3 d-none" data-question-id="<?= $pretest['pretest_id']; ?>">

                    <input type="hidden" class="learnerID" name="learner_id" value="<?= $data['learnerID'] ?>">
                    <input type="hidden" id="pretestID_<?= $index; ?>" name="pretest_id[<?= $pretest['pretest_id']; ?>]"
                        value="<?= $pretest['pretest_id']; ?>">

                    <input type="hidden" name="correct_answer<?= $pretest['pretest_id'] ?>" value="<?= $pretest['correct_answer'] ?>">

                    <!-- Directions based on question type (Reading/Writing) -->
                    <?php if ($pretest['pretest_type'] === "Reading"): ?>
                        <div class="text-primary mb-4 border-bottom pb-3">
                            <h5 class="fw-bold">Part I: Reading</h5>
                            <p class="mb-0"><strong>Directions:</strong>
                                <span><?= htmlspecialchars("For reading questions, select the most appropriate answer based on the text provided."); ?></span>
                            </p>
                        </div>

                    <?php elseif ($pretest['pretest_type'] === "Writing"): ?>
                        <div class="text-primary mb-4 border-bottom pb-3">
                            <h5 class="fw-bold">Part II: Writing</h5>
                            <p class="mb-0"><strong>Directions:</strong>
                                <span><?= htmlspecialchars("For writing questions, write your answer in the provided text box."); ?></span>
                            </p>
                        </div>
                    <?php endif; ?>

                    <h6 class="fw-bold mb-4"><?= $index + 1; ?>. <?= htmlspecialchars($pretest['question']); ?></h6>

                    <?php if (!empty($pretest['context'])): ?>
                        <div class="border mb-3 border-1 p-3 bg-light">
                            <!-- Main Context if Any -->
                            <?= htmlspecialchars($pretest['context']); ?>

                            <!-- Sub Context if Any -->
                            <section class="mt-3">
                                <p><?= !empty($pretest['first_sub_context']) ? htmlspecialchars($pretest['first_sub_context']) : ''; ?></p>

                                <p><?= !empty($pretest['second_sub_context']) ? htmlspecialchars($pretest['second_sub_context']) : ''; ?></p>

                                <p><?= !empty($pretest['third_sub_context']) ? htmlspecialchars($pretest['third_sub_context']) : ''; ?></p>

                                <p><?= !empty($pretest['fourth_sub_context']) ? htmlspecialchars($pretest['fourth_sub_context']) : ''; ?></p>
                            </section>
                        </div>
                    <?php endif; ?>

                    <div class="choices">
                        <!-- If pretest type is equal to Reading load this -->
                        <?php if ($pretest['pretest_type'] === "Reading"): ?>
                            <?php foreach (['a', 'b', 'c', 'd'] as $choice): ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="pretest_answer[<?= $pretest['pretest_id']; ?>]"
                                        value="<?= strtoupper($choice); ?>" id="choice_<?= $pretest['pretest_id']; ?>_<?= $choice; ?>"
                                        required>
                                    <label class="form-check-label choice-content"
                                        for="choice_<?= $pretest['pretest_id']; ?>_<?= $choice; ?>"
                                        data-content="<?= htmlspecialchars($pretest["choice_$choice"]); ?>">
                                        <?= htmlspecialchars($pretest["choice_$choice"]); ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif ?>

                        <!-- If pretest type is equal to Writing load this -->
                        <?php if ($pretest['pretest_type'] === "Writing"): ?>
                            <textarea class="form-control" name="pretest_answer[<?= $pretest['pretest_id']; ?>]"
                                required></textarea>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Buttons to take action -->
            <div class="navigation-buttons d-flex justify-content-between mt-4">
                <button type="button" id="prevBtn" class="btn btn-secondary px-4 d-none">Previous</button>
                <button type="button" id="nextBtn" class="btn btn-primary px-4">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-success px-4 d-none">Submit</button>
            </div>
        </form>
    </div>

    <script>
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
                duration: 30 * 60, // 30 minutes in seconds
                remainingTime: 30 * 60,
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
                this.elements.questions.each(function() {
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
                $(".pretest-question .choice-content").each(function() {
                    const content = $(this).data("content");
                    if (/\.(png|jpg|jpeg|gif)$/i.test(content)) {
                        $(this).html(
                            `<img src="files/uploads/pretest_choices/${content}" class="img-fluid" alt="Choice Image" width="80">`
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
                e && e.preventDefault(); // Prevent default form submission
                this.stopTimer();

                console.log("Submitting pretest..."); // Debugging log

                const preAssessmentForm = document.getElementById("preAssessmentForm");
                const formData = new FormData(preAssessmentForm);

                $.ajax({
                    type: "POST",
                    url: "/submitPretest", // Ensure this URL processes the form correctly
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    success: function(response) {
                        console.log(response); // Debugging log

                        if (response.status === "success") {
                            let message, icon, extraHtml = "";

                            if (response.score >= response.passingScore) {
                                icon = "success";
                                message = `Congratulations! You passed with a score of <strong>${response.score}</strong> out of <strong>${response.perfectScore}</strong>.`;
                                extraHtml = `<p>Click <a href="nextlevel.php" class="alert-link text-decoration-underline">here</a> to proceed.</p>`;
                            } else {
                                icon = "error";
                                message = `You scored <strong>${response.score}</strong> out of <strong>${response.perfectScore}</strong>. Don't give up!`;
                                extraHtml = `<p>You have <strong>${response.remainingAttempts}</strong> attempt(s) left.</p>
                        <div class="text-center mt-3">
                            <button type="button" id="startUpBtn" class="btn btn-primary btn-lg px-5">Retake Pretest</button>
                        </div>`;
                            }

                            Swal.fire({
                                heightAuto: false,
                                icon: icon,
                                title: "Pretest Result",
                                html: message + extraHtml,
                                confirmButtonText: "OK",
                            }).then(function() {
                                localStorage.clear();
                                pretest.elements.assessmentCard.addClass("d-none");

                                // Show the correct message dynamically
                                if (response.score >= response.passingScore) {
                                    $("#submissionSuccessMessage").removeClass("d-none");
                                } else {
                                    $("#submissionFailedMessage").removeClass("d-none");
                                }
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
                    error: function() {
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
                    // 30 = 1800 seconds minutes
                    Math.floor(this.state.remainingTime / 1800)
                ).padStart(2, "0");
                const minutes = String(
                    Math.floor((this.state.remainingTime % 1800) / 60)
                ).padStart(2, "0");
                const seconds = String(this.state.remainingTime % 60).padStart(2, "0");
                this.elements.countdown.text(`${hours}:${minutes}:${seconds}`);
            },
        };

        pretest.init();
    </script>
</section>