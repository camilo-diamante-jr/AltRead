<?php

/* */ $this->renderView('pages/Student/partials/header-student', $data);

?>

<main class="app-main mt-5">
    <section class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card content-card">
                    <div class="card-header pb-0">
                        <!-- Navigation Pills -->
                        <ul class="nav nav-underline" id="navTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#pills-pretest"
                                    class="nav-link active fw-bolder"
                                    id="pills-pretest-tab"
                                    data-bs-toggle="pill"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-pretest"
                                    aria-selected="true">
                                    <i class="bi bi-pencil me-2"></i>Pretest
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#pills-exams"
                                    class="nav-link"
                                    id="pills-exams-tab"
                                    data-bs-toggle="pill"
                                    role="tab"
                                    aria-controls="pills-exams"
                                    aria-selected="false">
                                    <i class="bi bi-journal-text me-2"></i>Exams
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#pills-quizzes"
                                    class="nav-link"
                                    id="pills-quizzes-tab"
                                    data-bs-toggle="pill"
                                    type="button"
                                    role="tab"
                                    aria-controls="pills-quizzes"
                                    aria-selected="false">
                                    <i class="bi bi-question-circle me-2"></i>Quizzes
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <article class="content tab-content" id="pills-tabContent">
                            <div
                                class="tab-pane  active"
                                id="pills-pretest"
                                role="tabpanel"
                                aria-labelledby="pills-pretest-tab">

                                <?php
                                include_once 'assessment/pretest/main-pretest.php'
                                ?>
                            </div>


                            <div
                                class="tab-pane fade"
                                id="pills-exams"
                                role="tabpanel"
                                aria-labelledby="pills-exams-tab">
                                <h5 class="mb-3">Exams</h5>
                                <p>Select an exam to start:</p>

                                <?php
                                include_once 'assessment/exam/main-exam.php';
                                ?>
                            </div>

                            <div
                                class="tab-pane fade"
                                id="pills-quizzes"
                                role="tabpanel"
                                aria-labelledby="pills-quizzes-tab">
                                <h5 class="mb-3">Quizzes</h5>
                                <p>Personalize quizzes goes here:</p>

                                <?php
                                include_once 'assessment/quiz/quizzes.php';
                                ?>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>


</main>






<?php
$this->renderView('./pages/Student/partials/footer-student');
?>



<!-- Script for Active Tab Persistence -->
<script>
    $(document).ready(function() {
        const navLinks = $("#navTabs .nav-link");

        // Get stored active tab from localStorage
        let activeTab = localStorage.getItem("activeTab");

        // If there's a saved tab, activate it
        if (activeTab) {
            navLinks.removeClass("active");
            $(".tab-pane").removeClass("show active");

            $(`#navTabs .nav-link[href="${activeTab}"]`).addClass("active");
            $(activeTab).addClass("show active");
        }

        // Store the clicked tab in localStorage
        navLinks.on("click", function() {
            let tabId = $(this).attr("href");
            localStorage.setItem("activeTab", tabId);
        });
    });
</script>