<div class="text-center">
    <img id="profile-photo" src="../files/uploads/avatars/default-avatar.jpg" class="img-fluid rounded-circle w-25 mb-3" alt="Profile Photo">
    <label class="upload-photo-label btn btn-outline-secondary" for="upload-photo">
        <i class="fa fa-camera"></i> <span>Change Profile Picture</span>
    </label>
    <input type="file" id="upload-photo" class="d-none" accept="image/*" onchange="previewPhoto(event)">
</div>
<hr>
<p class="text-muted">Update your general account settings below.</p>
<form>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control" id="username" value="<?= $user_account['username'] ?>" readonly>
    </div>
    <div class="mb-3">
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="fullname" value="<?= $user_account['name'] ?>" readonly>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" value="<?= $user_account['email'] ?>" readonly>
    </div>
    <div class="d-flex justify-content-center mt-4">
        <button type="button" id="edit-account" class="btn me-2 btn-warning">
            <i class="fa fa-edit"></i> Edit
        </button>
        <button type="reset" id="cancel-updating-account" class="me-2 btn btn-danger d-none">
            <i class="fa fa-close"></i> Cancel
        </button>
        <button type="button" id="save-account-changes" class="me-2 btn btn-primary disabled" disabled>
            <i class="fa fa-save"></i> Save changes
        </button>
    </div>
</form>