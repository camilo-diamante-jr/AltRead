export function createQuestion() {
  $("#questionsTable").DataTable();

  setupQuestionType();
  setupFormSubmission();
  setupSubContent();
  setupImageUpload();
}

const maxChoices = 4;

function setupQuestionType() {
  const questionType = $("select[name='question_type']");

  if (questionType.val() === "multiple_choice") {
    showMultipleChoiceFields();
  }

  questionType.on("change", function () {
    if ($(this).val() === "multiple_choice") {
      showMultipleChoiceFields();
    } else {
      hideMultipleChoiceFields();
    }
  });
}

function showMultipleChoiceFields() {
  const multipleChoiceContainer = $("#multiple-choice-container");
  multipleChoiceContainer.empty();
  $(".multiple-choice-main-container").removeClass("d-none");

  for (let i = 1; i <= maxChoices; i++) {
    const choiceInput = $(`
      <div class="row align-items-center mb-2 choice-item">
        <div class="col-auto">
          <input type="checkbox" name="correct_choice[]" value="${i}" class="form-check-input mt-1" />
        </div>
        <div class="col">
          <input type="text" class="form-control" name="multiple_choice_option[]" placeholder="Choice ${i}" />
        </div>
      </div>
    `);
    multipleChoiceContainer.append(choiceInput);
  }
}

function hideMultipleChoiceFields() {
  $("#multiple-choice-container").empty();
  $(".multiple-choice-main-container").addClass("d-none");
}

function setupSubContent() {
  let subContentCount = $("#sub-content-container .sub-content-item").length;

  $("#addSubContentBtn").on("click", function () {
    if (subContentCount < 4) {
      subContentCount++;
      const subContent = $(`
        <div class="row mt-2 sub-content-item">
          <div class="col-md-10">
            <input type="text" class="form-control" name="sub_content[]" placeholder="Sub Content ${subContentCount}" />
          </div>
          <div class="col-md-2">
            <button type="button" class="btn btn-danger remove-sub-content">Remove</button>
          </div>
        </div>
      `);
      $("#sub-content-container").append(subContent);
    } else {
      Swal.fire(
        "Limit Reached",
        "You can only add up to 4 sub-contents.",
        "warning"
      );
    }
  });

  $("#sub-content-container").on("click", ".remove-sub-content", function () {
    $(this).closest(".sub-content-item").remove();
    subContentCount = $("#sub-content-container .sub-content-item").length;
  });
}

function setupFormSubmission() {
  $("#insertQuestionForm").on("submit", (e) => {
    e.preventDefault();
    const formData = new FormData(e.currentTarget);
    const questionType = $("select[name='question_type']").val();

    if (questionType === "multiple_choice") {
      let choices = [];
      let correctAnswers = [];

      $("input[name='multiple_choice_option[]']").each(function (index) {
        const choiceText = $(this).val().trim();
        if (choiceText !== "") {
          choices.push(choiceText);
          const isChecked = $("input[name='correct_choice[]']")
            .eq(index)
            .prop("checked");

          if (isChecked) {
            correctAnswers.push(index + 1); // Store index as 1-based
          }
        }
      });

      if (choices.length < 2) {
        Swal.fire(
          "Error!",
          "Please provide at least two choices for the question.",
          "error"
        );
        return;
      }

      if (correctAnswers.length === 0) {
        Swal.fire(
          "Error!",
          "Please select at least one correct answer.",
          "error"
        );
        return;
      }

      formData.delete("multiple_choice_option[]");
      choices.forEach((choice) => {
        formData.append("multiple_choice_option[]", choice);
      });

      formData.delete("correct_choice[]");
      correctAnswers.forEach((correct) => {
        formData.append("correct_choice[]", correct);
      });
    }

    // Append image file as 'content_img' for PHP
    const imageFile = document.getElementById("content_image").files[0];
    if (imageFile) {
      formData.append("content_image", imageFile); // <== THIS IS THE FIX
    }

    // console.log(imageFile);

    // Debugging output
    for (let pair of formData.entries()) {
      console.log(pair[0] + ": " + pair[1]);
    }

    acceptSubmission(formData);
  });
}

function acceptSubmission(formData) {
  $.ajax({
    url: "/admin/createQuestion",
    type: "POST",
    data: formData,
    processData: false, // Required for FormData
    contentType: false, // Required for FormData
    dataType: "json",
    success: handleSuccess,
    error: (xhr, textStatus, errorThrown) => {
      console.error("AJAX Error:", textStatus, errorThrown);
      console.error("Response Text:", xhr.responseText);

      try {
        const response = JSON.parse(xhr.responseText);
        Swal.fire(
          "Error!",
          response.message || "An unknown error occurred.",
          "error"
        );
      } catch (e) {
        Swal.fire(
          "Error!",
          "There was an error submitting your question. Please try again.",
          "error"
        );
        console.log(e);
      }
    },
  });
}

function handleSuccess(response) {
  if (response.status === "success") {
    Swal.fire({
      title: "Success!",
      text: response.message,
      icon: "success",
      confirmButtonText: "OK",
    }).then(() => {
      $("#insertQuestionForm")[0].reset();
      $("#insertNewQuestionModal").modal("hide");
      hideMultipleChoiceFields();
      $("#sub-content-container").empty();
      $("#imagePreview").addClass("d-none");
      $("#removeImageFileBtn").addClass("d-none");
    });
  } else {
    Swal.fire(
      "Error!",
      response.message || "An unknown error occurred.",
      "error"
    );
  }
}

function setupImageUpload() {
  $("#content_image").on("change", function () {
    const file = this.files[0];

    if (file) {
      const reader = new FileReader();

      $("#imagePreview").addClass("d-none");
      $("#loader").removeClass("d-none");

      reader.onload = function (e) {
        $("#loader").addClass("d-none");
        $("#imagePreview").attr("src", e.target.result).removeClass("d-none");
        $("#removeImageFileBtn").removeClass("d-none");
      };

      reader.readAsDataURL(file);
    }
  });

  $("#removeImageFileBtn").click(function () {
    $("#content_image").val("");
    $("#imagePreview").addClass("d-none").attr("src", "");
    $(this).addClass("d-none");
  });
}
