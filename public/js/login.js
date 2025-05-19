$(document).ready(function () {
  // Load saved data from local storage if "Remember Me" was checked
  if (localStorage.getItem("rememberMe") === "true") {
    $("#username").val(localStorage.getItem("username"));
    $("#password").val(localStorage.getItem("password"));
    $("#flexCheckDefault").prop("checked", true);
  }

  // Handle form submission
  $("#loginForm").on("submit", function (event) {
    event.preventDefault();

    const rememberMe = $("#flexCheckDefault").is(":checked");
    const username = $("#username").val();
    const password = $("#password").val();

    if (rememberMe) {
      // Save username and password to local storage
      localStorage.setItem("rememberMe", "true");
      localStorage.setItem("username", username);
      localStorage.setItem("password", password); // Use only if passwords are hashed
    } else {
      // Clear saved data if "Remember Me" is not checked
      localStorage.removeItem("rememberMe");
      localStorage.removeItem("username");
      localStorage.removeItem("password");
    }

    // Proceed with AJAX or form submission
    $.ajax({
      url: "/login",
      type: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (response) {
        if (response.success) {
          console.log("Login successful for user type:", response.user_type); // Log user type on success

          const userType = response.user_type;

          redirect(userType);
        } else {
          const msg = response.message;

          handleAjaxFailure(msg);
        }
      },

      error: function (xhr) {
        $(".toast-body").text("An error occurred. Please try again.");
        new bootstrap.Toast(document.getElementById("loginToast")).show();
      },
    });
  });

  function handleAjaxFailure(msg) {
    console.warn("Login failed:", msg);

    $(".toast-body").text(msg || "Login failed.");

    const toast = new bootstrap.Toast(document.getElementById("loginToast"));

    toast.show();
  }

  $("#toggleBtn").click(function () {
    const passwordField = document.getElementById("userPass");
    const toggleIcon = document.getElementById("passToggleIcon");
    if (passwordField.type === "password") {
      passwordField.type = "text";
      toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
    } else {
      passwordField.type = "password";
      toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
    }
  });
});

// If success
function redirect(userType) {
  switch (userType) {
    case "Admin":
      window.location.href = "/admin/dashboard";
      break;
    case "Teacher":
      window.location.href = "/teacher/dashboard";
      break;
    case "Learner":
      window.location.href = "/student/dashboard";
      break;
    default:
      console.error("Unknown user type:", response.user_type);
  }
}

// Else failed
