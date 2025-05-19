$(document).ready(function () {
  // Toggle password visibility
  $(".toggle-password").on("click", function () {
    const $passwordField = $(this).prev("input");
    const type =
      $passwordField.attr("type") === "password" ? "text" : "password";
    $passwordField.attr("type", type);
    $(this).find("i").toggleClass("bi-eye bi-eye-slash");
  });

  generalAccountSettings();
  passwordSecuritySettings();
});

/* 
    
    This area is all scripts for
    General account settings. 
    
    */
function generalAccountSettings() {
  // Edit button for updating general account settings

  const editBtn = $("#edit-account");
  const cancelBtn = $("#cancel-updating-account");
  const saveBtn = $("#save-account");
  const usersMainInfo = $("#username, #email");

  editBtn.on("click", function () {
    $(this).addClass("d-none");
    cancelBtn.removeClass("d-none");
    usersMainInfo.removeAttr("readonly");
    saveBtn.removeAttr("disabled");
  });

  cancelBtn.on("click", function () {
    $(this).addClass("d-none");
    editBtn.removeClass("d-none");
    usersMainInfo.attr("readonly", true);
    saveBtn.attr("disabled", true);
  });

  saveBtn.on("click", function () {
    alert("Changes saved successfully!");
  });
}

// Password and security
function passwordSecuritySettings() {
  $("#changePasswordSubmitForm").on("submit", function (event) {
    event.preventDefault();

    $currentPassword = $("#changePasswordSubmitForm #current_password").val();
    $newPassword = $("#changePasswordSubmitForm #new_password").val();
    $confirmNewPassword = $(
      "#changePasswordSubmitForm #confirm_password"
    ).val();

    saveUpdatedPassword($currentPassword, $newPassword, $confirmNewPassword);
  });

  function saveUpdatedPassword(
    $currentPassword,
    $newPassword,
    $confirmNewPassword
  ) {
    $.ajax({
      type: "POST",
      url: "/ajax/change_password",
      data: {
        currentPass: $currentPassword,
        newPass: $newPassword,
        confirmNewPass: $confirmNewPassword,
      },
    });
  }

  // Preview profile photo
  function previewPhoto(event) {
    const reader = new FileReader();
    reader.onload = function () {
      const output = document.getElementById("profile-photo");
      output.src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
  }
}
