/*---------------------------
  Add User Handling
---------------------------*/
function handleAddUserForm() {
  $("#addUserForm").submit(function (event) {
    event.preventDefault();

    // Use FormData for handling file uploads
    const formData = new FormData(this);

    // Append default values if not set
    if (!formData.has("avatar") || !formData.get("avatar").name) {
      formData.set("avatar", "default-profile.png");
    }
    formData.append("status", "Inactive");

    $.ajax({
      type: "POST",
      url: "/ajax/addUser",
      data: formData,
      processData: false, // Important for file uploads
      contentType: false, // Important for file uploads
      dataType: "json",
      success: function (response) {
        handleAddUserResponse(response, formData);
      },
      error: handleAjaxError,
    });
  });
}

function handleAddUserResponse(data, formData) {
  if (data.success) {
    Swal.fire({
      icon: "success",
      title: "Success!",
      text: "User added successfully.",
      position: "top-end",
      showConfirmButton: false,
      timer: 1500,
    }).then(() => {
      $("#addUserModal").modal("hide");
      $("#addUserForm")[0].reset();
      $("#avatarPreviewImage").attr(
        "src",
        "../../files/uploads/avatars/default-profile.png"
      );

      const avatar = formData.get("avatar").name || "default-profile.png";
      const name = formData.get("name");
      const username = formData.get("username");
      const email = formData.get("email");
      const user_type = formData.get("userType");
      const status = formData.get("status");
      const formattedDate = new Date().toLocaleDateString();

      addNewRow(
        avatar,
        name,
        username,
        email,
        user_type,
        status,
        formattedDate
      );
    });
  } else {
    Swal.fire({
      icon: "error",
      title: "Error!",
      position: "top-end",
      text: data.message || "Failed to add user.",
    });
  }
}
