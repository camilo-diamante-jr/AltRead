<?php $this->renderView('./pages/Teacher/partials/teachers-header', $data); ?>

<style>
    .status-enrolled {
        color: #fff;
        background-color: #28a745;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .status-pending {
        color: #fff;
        background-color: #17a2b8;
        padding: 5px 10px;
        border-radius: 5px;
    }

    .status-rejected {
        color: #dc3545;
        font-weight: bold;
    }
</style>
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Learners</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="/admin">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Manage Learners
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <!-- 
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-0 mb-3"
                            data-bs-toggle="modal" data-bs-target="#addNewLearnerModal">
                            <i class="bi bi-plus"></i>
                            <span> Add New Student </span>
                        </button>
                    </div> -->

                    <div class="table-responsive">
                        <?php

                        // Tables

                        require_once 'components/tables/activeStudentTable.php';

                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="reviewFormModal" tabindex="-1" aria-labelledby="reviewFormModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content">
            <form id="reviewForm">
                <div class="modal-header">
                    <h5 class="modal-title" id="reviewFormModalLabel">Review Learners Personal Information Sheet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="learnerID" name="learnerID">

                    <section class="form-group">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label for="firstName" class="form-label">First Name</label>
                                        <input type="text" id="firstName" class="form-control border-0 border-bottom" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="middleName" class="form-label">Middle Name</label>
                                        <input type="text" id="middleName" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="lastName" class="form-label">Last Name</label>
                                        <input type="text" id="lastName" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="sex" class="form-label">Sex</label>
                                        <input type="text" id="sex" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="birthday" class="form-label">Birthday</label>
                                        <input type="text" id="birthday" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="religion" class="form-label">Religion</label>
                                        <input type="text" id="religion" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="maritalStatus" class="form-label">Marital Status</label>
                                        <input type="text" id="maritalStatus" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row g-3 mt-3">
                                    <div class="col-md-6">
                                        <label for="occupation" class="form-label">Occupation</label>
                                        <input type="text" id="occupation" class="form-control" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="education" class="form-label">Educational Attainment</label>
                                        <input type="text" id="education" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <label for="personalStatement" class="form-label">Personal Statement</label>
                                    <textarea id="personalStatement" class="form-control" rows="3" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="mt-4">
                        <label for="personalStatus" class="form-label">Decision</label>
                        <select id="personalStatus" name="personalStatus" class="form-select">
                            <option value="enrolled">Accept (Enrolled)</option>
                            <option value="rejected">Reject</option>
                        </select>
                    </div>

                    <!-- Show if reject had been selected -->
                    <div class="mb-3" id="rejectionReasonContainer" class="d-none">
                        <label for="rejectionReason" class="form-label">Reason for Rejection</label>
                        <textarea id="rejectionReason" name="rejectionReason" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    class LearnerEnrollment {
        constructor() {
            this.init();
        }

        init() {
            this.bindReviewButtonClick();
            this.bindFormSubmission();
        }

        bindReviewButtonClick() {
            $(document).on('click', '.review-btn', (event) => {
                const learnerId = $(event.currentTarget).data('id');

                if (!learnerId) {
                    console.error('Invalid learner ID received.');
                    return;
                }

                $('#learnerID').val(learnerId);
                this.fetchLearnerDetails(learnerId);
            });
        }

        fetchLearnerDetails(learnerId) {
            $.ajax({
                type: "POST",
                url: "/ajax/showLearnerById",
                data: {
                    learnerID: learnerId
                },
                dataType: "json",
                success: (response) => {
                    if (response.success && response.data) {
                        this.populateLearnerDetails(response.data);
                    } else {
                        console.error('Failed to fetch learner details:', response.message || 'No response data.');
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('An error occurred while fetching learner details.');
                }
            });
        }

        populateLearnerDetails(learner) {
            if (!learner) {
                console.error('No learner data received.');
                return;
            }

            const birthDate = this.formatDate(learner.birthdate);
            $("#firstName").val(learner.first_name || '');
            $("#middleName").val(learner.middle_name || '');
            $("#lastName").val(learner.last_name || '');
            $("#sex").val(learner.sex || '');
            $("#birthday").val(birthDate);
            $("#address").val(learner.address || '');
            $("#religion").val(learner.religion || '');
            $("#maritalStatus").val(learner.marital_status || '');
            $("#occupation").val(learner.occupation || '');
            $("#education").val(learner.educational_attainment || '');
            $("#personalStatement").val(learner.personal_statement || '');
        }

        formatDate(dateString) {
            if (!dateString) return '';

            const date = new Date(dateString);
            if (isNaN(date)) {
                console.error("Invalid birthdate format:", dateString);
                return '';
            }

            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        bindFormSubmission() {
            $('#reviewForm').on('submit', (event) => {
                event.preventDefault();

                const learnerId = $('#learnerID').val();
                const personalStatus = $('#personalStatus').val();
                const rejectionReason = $('#rejectionReason').val().trim();

                if (!learnerId || !personalStatus) {
                    alert('Please select a learner and provide a status.');
                    return;
                }

                if (personalStatus === 'rejected' && !rejectionReason) {
                    alert('Please provide a rejection reason.');
                    return;
                }

                this.updateEnrollmentStatus(learnerId, personalStatus, rejectionReason);
            });

            $('#personalStatus').on('change', () => this.toggleRejectionReason());
            this.toggleRejectionReason();
        }

        toggleRejectionReason() {
            const personalStatus = $('#personalStatus').val();
            $('#rejectionReasonContainer').toggle(personalStatus === 'rejected');
        }

        updateEnrollmentStatus(learnerId, personalStatus, rejectionReason = null) {
            $.ajax({
                type: "POST",
                url: "/ajax/updatePersonalStatus",
                data: {
                    learnerID: learnerId,
                    personalStatus,
                    rejectionReason
                },
                dataType: "json",
                success: (response) => {
                    if (response.success) {
                        alert('Enrollment status updated successfully.');
                        location.reload();
                    } else {
                        alert('Failed to update enrollment status: ' + (response.message || 'Unknown error.'));
                    }
                },
                error: (jqXHR, textStatus, errorThrown) => {
                    console.error('AJAX Error:', textStatus, errorThrown);
                    alert('An error occurred while updating enrollment status.');
                }
            });
        }
    }

    $(document).ready(() => {
        new LearnerEnrollment();
    });
</script>
<?php $this->renderView('./pages/Admin/partials/admin-footer'); ?>