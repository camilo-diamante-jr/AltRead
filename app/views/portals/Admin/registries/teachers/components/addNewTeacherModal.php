<!-- Modal -->
<div class="modal fade" id="addNewTeacherModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Teacher</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addTeacherForm">

                    <!-- Name Fields -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="first_name" class="form-label">First Name:</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="middle_name" class="form-label">Middle Name:</label>
                            <input type="text" id="middle_name" name="middle_name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="last_name" class="form-label">Last Name:</label>
                            <input type="text" id="last_name" name="last_name" class="form-control" required>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="contact_number" class="form-label">Contact Number:</label>
                            <input type="text" id="contact_number" name="contact_number" class="form-control">
                        </div>
                    </div>

                    <!-- Position -->
                    <div class="mb-3">
                        <label for="position" class="form-label">Position:</label>
                        <input type="text" id="position" name="position" class="form-control">
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea id="address" name="address" class="form-control" rows="2" required></textarea>
                    </div>

                    <!-- Date of Birth -->
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth:</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" class="form-control" required>
                    </div>

                    <!-- Hidden is_active (default to 1) -->
                    <input type="hidden" name="is_active" value="1">

                    <button type="submit" class="btn btn-primary w-100 mt-3">Add Teacher</button>
                </form>
            </div>
        </div>
    </div>
</div>