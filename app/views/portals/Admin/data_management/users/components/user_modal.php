<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content shadow-lg">
            <form id="addUserForm" enctype="multipart/form-data" method="POST">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="text-center" id="addUserModalLabel">
                        <i class="bi bi-person-plus me-2"></i> Add New User
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row g-4">
                        <!-- Avatar Section -->
                        <div class="col-md-4 text-center">
                            <div class="card border-0 shadow">
                                <div class="card-body">
                                    <h6 class="mb-3">
                                        <i class="bi bi-image me-2"></i> Profile Picture
                                    </h6>
                                    <figure class="d-flex flex-column align-items-center">
                                        <img src="/files/uploads/avatars/default-profile.png" id="avatarPreviewImage"
                                            class="img-fluid avatar rounded-circle shadow mb-3" alt="Avatar Preview">
                                        <span id="avatarLoader" class="d-none avatar-loader"></span>
                                        <figcaption>
                                            <label for="Avatar" class="form-label mt-2 text-muted">Upload photo</label>
                                        </figcaption>
                                        <input type="file" class="form-control form-control-sm" id="avatar" name="avatar"
                                            accept="image/*" onchange="previewImageWithLoader(this, '#avatarPreviewImage')">
                                    </figure>
                                </div>
                            </div>
                        </div>

                        <!-- User Information Section -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-md-12 mb-3">
                                    <label for="name" class="form-label">
                                        Full Name
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-fill"></i>
                                        </span>
                                        <input type="text" class="form-control" id="name" name="name" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">
                                        Username
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                </div>
                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">
                                        Email
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="bi bi-envelope-fill"></i>
                                        </span>
                                        <input type="email" class="form-control" id="email" name="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">
                                        Password
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="bi bi-lock-fill"></i>
                                        </span>
                                        <input type="password" class="form-control" id="password" name="password" required>
                                    </div>
                                </div>
                                <!-- User Type -->
                                <div class="col-md-6 mb-3">
                                    <label for="userType" class="form-label">
                                        User Type
                                    </label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text">
                                            <i class="bi bi-people-fill"></i>
                                        </span>
                                        <select class="form-select form-select-sm" id="userType" name="userType" required>
                                            <option value="admin">Admin</option>
                                            <option value="teacher">Teacher</option>
                                            <option value="learner">Learner</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light justify-content-center">
                    <button type="submit" id="submitNewUser" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i> Save
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-octagon me-2"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="updateUserForm" enctype="multipart/form-data" method="POST">
                <!-- Modal Header -->
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="updateUserModalLabel">
                        <i class="bi bi-pencil-square me-2"></i>Edit User
                    </h5>
                    <!-- <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="row">
                        <!-- Avatar Section -->
                        <div class="col-md-4 text-center mb-4 mb-md-0">
                            <div class="card">
                                <div class="card-body avatar-card-body">
                                    <h6 class="mb-3 text-secondary">Profile Picture</h6>
                                    <!-- Loader -->

                                    <figure class="d-flex align-items-center justify-content-center">
                                        <div>
                                            <img src="/files/uploads/avatars/default-avatar.jpg" id="updateAvatarPreviewImage" class="img-fluid avatar rounded-circle shadow-lg mb-3" alt="Avatar Preview">
                                            <span id="updateAvatarLoader" class="d-none avatar-loader"></span>
                                            <figcaption>
                                                <label for="updateAvatar" class="form-label text-muted">Upload New Photo</label>
                                            </figcaption>
                                        </div>
                                    </figure>

                                    <!-- File Input -->
                                    <input type="file" class="form-control form-control-sm" id="updateAvatar" name="avatar" accept="image/*" onchange="previewImageWithLoader(this, '#updateAvatarPreviewImage')">
                                </div>
                            </div>

                        </div>

                        <!-- User Information Section -->
                        <div class="col-md-8">
                            <div class="row">
                                <!-- Full Name -->
                                <div class="col-md-12 mb-3">
                                    <label for="updateName" class="form-label fw-semibold">Full Name</label>
                                    <input type="hidden" id="userId" name="userID" />
                                    <input type="text" class="form-control" id="updateName" name="name" placeholder="Enter full name" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-6 mb-3">
                                    <label for="updateUsername" class="form-label fw-semibold">Username</label>
                                    <input type="text" class="form-control" id="updateUsername" name="username" placeholder="Enter username" required>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6 mb-3">
                                    <label for="updateEmail" class="form-label fw-semibold">Email Address</label>
                                    <input type="email" class="form-control" id="updateEmail" name="email" placeholder="Enter email address" required>
                                </div>
                            </div>

                            <div class="row">
                                <!-- User Type -->
                                <div class="col-md-12 mb-3">
                                    <label for="updateUserType" class="form-label fw-semibold">User Type</label>
                                    <select class="form-select" id="updateUserType" name="userType" required>
                                        <option value="" disabled selected>Choose user type</option>
                                        <option value="admin">Admin</option>
                                        <option value="teacher">Teacher</option>
                                        <option value="learner">Learner</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer bg-light justify-content-center">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>