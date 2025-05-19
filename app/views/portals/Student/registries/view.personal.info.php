<?php
$this->renderView('/pages/Student/partials/header-student', $data);
?>

<!-- Main Content -->
<main class="app-main mt-5">
    <section class="app-main-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2"></i>
                        You should fill in this form in order to have access to all pages.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div id="messageBox"></div>

                    <div class="card shadow-sm rounded-3">
                        <header class="card-header">
                            <h3>Personal Information Sheet</h3>
                        </header>
                        <article class="card-body p-4">
                            <form id="personalInformationSheet">
                                <ol>
                                    <li class="mb-2">What is your complete name?</li>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <input type="text" class="form-control" name="first_name" placeholder="First Name" required />
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="text" class="form-control" name="middle_name" placeholder="Middle Name" required />
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <input type="text" class="form-control" name="last_name" placeholder="Last Name" required />
                                        </div>
                                    </div>

                                    <li>What is your sex? Check (✔) the corresponding box.</li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sex" id="male" value="male" required />
                                        <label class="form-check-label" for="male">Male</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sex" id="female" value="female" required />
                                        <label class="form-check-label" for="female">Female</label>
                                    </div>

                                    <li>When is your date of birth?</li>
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <input type="text" class="form-control" name="birth_month" placeholder="Month" required />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <input type="number" class="form-control" name="birth_day" placeholder="Day" required />
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <input type="number" class="form-control" name="birth_year" placeholder="Year" required />
                                        </div>
                                    </div>

                                    <li>Where do you live?</li>
                                    <input type="text" class="form-control mb-2" name="address_street" placeholder="House number/Street" required />
                                    <input type="text" class="form-control mb-2" name="address_barangay" placeholder="Barangay" required />
                                    <input type="text" class="form-control mb-2" name="address_city" placeholder="City/Town" required />
                                    <input type="text" class="form-control mb-2" name="address_province" placeholder="Province" required />

                                    <li>What is your religion?</li>
                                    <input type="text" class="form-control mb-3" name="religion" placeholder="Religion" required />

                                    <li>What is your marital status? Check (✔) the corresponding box.</li>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marital_status" id="single" value="Single" required />
                                        <label class="form-check-label" for="single">Single</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marital_status" id="widow" value="Widow/Widower" required />
                                        <label class="form-check-label" for="widow">Widow/Widower</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marital_status" id="married" value="Married" required />
                                        <label class="form-check-label" for="married">Married</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="marital_status" id="separated" value="Separated/Divorced" required />
                                        <label class="form-check-label" for="separated">Separated/Divorced</label>
                                    </div>

                                    <li>What is your job/occupation?</li>
                                    <input type="text" class="form-control mb-3" name="occupation" placeholder="Job/Occupation" required />

                                    <li>What is your highest educational attainment?</li>
                                    <input type="text" class="form-control mb-3" name="education" placeholder="Educational Attainment" required />

                                    <li>Write a paragraph composed of two (2) to three (3) sentences about yourself, including your interests and ambition.</li>
                                    <textarea class="form-control mb-3" name="about" rows="4" placeholder="Write here..." required></textarea>
                                </ol>

                                <div class="d-flex justify-content-center">
                                    <button type="reset" class="btn me-3 rounded-5 btn-warning">Reset</button>
                                    <button type="submit" class="btn rounded-5 btn-primary">Submit</button>
                                </div>
                            </form>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php
$this->renderView('pages/Student/partials/footer-student');
?>

<script>
    $(document).ready(function() {
        $('#personalInformationSheet').on("submit", function(e) {
            e.preventDefault();
            loadPersonalInformationSheet();
        });
    });

    function loadPersonalInformationSheet() {
        let form = document.getElementById("personalInformationSheet");
        let formData = new FormData(form);

        $.ajax({
            url: "/ajax/insertNewLearner",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function(response) {
                if (response.status === "success") {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: response.message,
                        timer: 2000, // Auto close after 2 seconds
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // Reload only on success
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: response.message
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error submitting form:", error);
                Swal.fire({
                    icon: "error",
                    title: "Oops!",
                    text: "An error occurred. Please try again."
                });
            }
        });
    }
</script>