$(document).ready(function () {
  handleAddUserForm();
});

function handleAddUserForm() {
  $("#registerNewUser").submit(function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    if (!formData.has("avatar") || !formData.get("avatar").name) {
      formData.set("avatar", "default-profile.png");
    }
    formData.append("status", "Inactive");

    $.ajax({
      type: "POST",
      url: "/ajax/addUser",
      data: formData,
      processData: false,
      contentType: false,
      dataType: "json",
      success: function (response) {
        handleAddUserResponse(response);
      },
      error: handleAjaxError,
    });
  });
}

function handleAddUserResponse(data) {
  if (data.success) {
    Swal.fire({
      position: "top-end",
      icon: "success",
      title: "Success!",
      text: "Registration successful!",
      showConfirmButton: false,
      timer: 1500,
    }).then(() => {
      resetForm();
      resetForm();
      window.location.href = "/login";
    });
  } else {
    Swal.fire({
      icon: "error",
      title: "Error!",
      text: data.message || "Failed to register.",
    });
  }
}

function resetForm() {
  $("#registerNewUser")[0].reset();
  $("#avatarPreviewImage").attr(
    "src",
    "../files/uploads/avatars/default-profile.png"
  );
}

function previewImageWithLoader(input, targetSelector) {
  const file = input.files[0];
  const targetImage = $(targetSelector);

  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      setTimeout(() => {
        targetImage.attr("src", e.target.result);
      }, 1000);
    };
    reader.readAsDataURL(file);
  } else {
    targetImage.attr("src", "../files/uploads/avatars/default-profile.png");
  }
}

function togglePassword() {
  let passwordInput = document.getElementById("password");
  let toggleIcon = document.getElementById("toggleIcon");
  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
  } else {
    passwordInput.type = "password";
    toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
  }
}

function handleAjaxError(xhr) {
  Swal.fire({
    icon: "error",
    title: "Error!",
    text: "An unexpected error occurred.",
  });
}
