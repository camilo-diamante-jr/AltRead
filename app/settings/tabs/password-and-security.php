<p>Change your password and manage your security settings.</p>
<form id="changePasswordSubmitForm" class="mt-2" method="POST">
    <div class="mb-3">
        <label for="current_password">Current password</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required />
    </div>
    <div class="mb-3">
        <label for="new_password">New password</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required />
    </div>
    <div class="mb-3">
        <label for="confirm_password">Confirm new password</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required />
    </div>
    <button type="submit" class="btn btn-primary">Save changes</button>
</form>