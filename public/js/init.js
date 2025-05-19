$(document).ready(function () {
  ManageUsers();
  ManagePretest();
});

function ManageUsers() {
  initializeUsersDataTable();
  handleAvatarPreview();
  handleAddUserForm();
  handleUpdateUserForm();
  handleDeleteUser();
}

function ManagePretest() {
  // initializePretestDataTable();
}
