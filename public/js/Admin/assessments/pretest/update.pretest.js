export function updatePretest() {
  // Toggle choice input types
  $(document).on("change", ".choice-type", function () {
    let modal = $(this).closest(".modal");
    if ($(this).val() === "text") {
      modal.find(".text-choices").show();
      modal.find(".image-choices").hide();
    } else {
      modal.find(".text-choices").hide();
      modal.find(".image-choices").show();
    }
  });

  // Handle form submission via AJAX
  $(document).on("submit", "form[id^='editPretestSubmitForm']", function (e) {
    e.preventDefault();

    let form = $(this);
    let formData = new FormData(this);

    $.ajax({
      url: "/updatePretest", // Adjust this URL to your PHP handler
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function () {
        form
          .find("button[type='submit']")
          .prop("disabled", true)
          .text("Saving...");
      },
      success: function (response) {
        try {
          let res = JSON.parse(response);
          if (res.status === "success") {
            alert("Pretest updated successfully!");
            location.reload(); // Refresh the page or update UI dynamically
          } else {
            alert("Error: " + res.message);
          }
        } catch (e) {
          alert("Unexpected error. Please try again.");
        }
      },
      error: function () {
        alert("Error updating pretest. Please try again.");
      },
      complete: function () {
        form.find("button[type='submit']").prop("disabled", false).text("Save");
      },
    });
  });
}
