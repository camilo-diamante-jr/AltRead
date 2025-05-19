<!-- Modal -->
<div class="modal fade" id="viewMoreTeachersInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUser Form">

                    <!-- Name Fields -->
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="firstname" class="form-label">First Name:</label>
                            <input type="text" id="firstname" class="form-control" required>
                        </div>
                        <div class="col-md-4">
                            <label for="middlename" class="form-label">Middle Name:</label>
                            <input type="text" id="middlename" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="lastname" class="form-label">Last Name:</label>
                            <input type="text" id="lastname" class="form-control" required>
                        </div>
                    </div>



                    <!-- Email and Guardian Fields -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" id="email" class="form-control" required>
                        </div>


                        <div class="col-md-6">
                            <label for="address" class="form-label">Address:</label>
                            <input type="text" id="address" class="form-control">
                        </div>
                    </div>

                    <!-- Username and Password Fields -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" id="username" class="form-control" required autocomplete="username">
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password:</label>
                            <input type="password" id="password" class="form-control" required>
                        </div>
                    </div>

                    <div class="m-0 p-0">
                        <input type="hidden" id="role_id" value="2" />
                    </div>

                    <button type="submit" class="btn btn-primary w-100 mt-3">Add User</button>
                </form>
            </div>
        </div>
    </div>
</div>