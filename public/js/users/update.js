/*---------------------------
  Update User Handling
---------------------------*/
function handleUpdateUserForm() {
  $(".editUserBtn").on("click", function () {
    // Reference the closest <tr> and extract its data attributes
    const $row = $(this).closest("tr");

    const userId = $row.data("id");
    const name = $row.data("name");
    const email = $row.data("email");
    const username = $row.data("username");
    const userType = $row.data("user_type");
    const avatar = $row.data("avatar");
    const status = $row.data("status");

    // Populate modal fields
    $("#userId").val(userId);
    $("#updateName").val(name);
    $("#updateEmail").val(email);
    $("#updateUsername").val(username);
    $("#updateUserType").val(userType.toLowerCase());

    const avatarPath = `../../files/uploads/avatars/${avatar}`;
    $("#updateAvatarPreviewImage").attr("src", avatarPath);

    // Show the modal
    $("#updateUserModal").modal("show");
  });

  $("#updateUserForm").submit(function (event) {
    event.preventDefault();

    // Use FormData for handling file uploads
    const updatedData = new FormData(this);

    $.ajax({
      type: "POST",
      url: "/ajax/updateUser",
      data: updatedData,
      processData: false, // Important for file uploads
      contentType: false, // Important for file uploads
      dataType: "json",
      success: function (response) {
        handleUpdateUserResponse(response, updatedData);
      },
      error: handleAjaxError,
    });
  });
}

function handleUpdateUserResponse(data, updatedData) {
  if (data.success) {
    Swal.fire({
      icon: "success",
      title: "Updated!",
      text: "User information updated successfully.",
      position: "top-end",
      showConfirmButton: false,
      timer: 1500,
    }).then(() => {
      $("#updateUserModal").modal("hide");
      $("#updateUserForm")[0].reset();
      $("#updateAvatarPreviewImage").attr(
        "src",
        "../../files/uploads/avatars/default-profile.png"
      );

      // Extract updated data
      const avatar = updatedData.get("avatar").name || "default-profile.png";
      const name = updateData.get("name");
      const username = updatedData.get("username");
      const email = updatedData.get("email");
      const user_type = updatedData.get("userType");
      const status = updatedData.get("status");
      const formattedDate = new Date().toLocaleDateString();

      // Update the DataTable row
      updateNewRow(
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
      text: data.message || "Failed to update user.",
    });
  }
}

/*---------------------------
  Error Handling
---------------------------*/
function handleAjaxError(xhr, status, error) {
  Swal.fire({
    icon: "error",
    title: "Ajax Error",
    text: `${status}: ${error}`,
  });
}
