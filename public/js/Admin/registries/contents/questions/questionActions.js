export function questionActions() {
  $(".view-question, .edit-question").on("click", function (e) {
    e.preventDefault();

    let questionId = $(this).data("id"); // Get question ID
    let isEdit = $(this).hasClass("edit-question"); // Check if it's Edit mode

    // Update modal title
    $("#questionModalTitle").text(isEdit ? "Edit Question" : "View Question");

    // Show loading text while fetching data
    $("#modalContent").html("<p class='text-center text-muted'>Loading...</p>");

    // Fetch question details via AJAX
    $.ajax({
      url: "/questions/getById",
      type: "POST",
      data: { question_id: questionId },
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          let q = response.data; // Store question data for easy access

          // Function to generate input fields (text for title, textarea for longer content)
          const generateInputField = (
            label,
            fieldName,
            value,
            isTextarea = false
          ) => {
            return `
                <div class="col-md-6 mb-3">
                  <label class="form-label">${label}</label>
                  ${
                    isTextarea
                      ? `<textarea class="form-control" id="edit_${fieldName}" rows="3">${
                          value || ""
                        }</textarea>`
                      : `<input type="text" class="form-control" id="edit_${fieldName}" value="${
                          value || ""
                        }">`
                  }
                </div>`;
          };

          // View Mode Layout
          let contentHtml = `
              <div class="custom-card mx-auto">
                <h5 class="custom-title">${q.content_title ?? "Untitled"}</h5>
                <p><strong>Directions:</strong> Read the following paragraph. Notice how the
                  paragraph is analyzed in order to identify the main idea and its supporting details.
                </p>
                ${
                  q.content_img
                    ? `<img src="assets/images/${q.content_img}" alt="Question Image" class="shadow custom-image">`
                    : ""
                }
                <p class="custom-text mt-3">${q.sub_content_1 ?? ""}</p>
              </div>`;

          // Edit Mode Layout
          if (isEdit) {
            contentHtml = `
                <div class="container">
                  <div class="row">
                    ${generateInputField(
                      "Question",
                      "question_text",
                      q.question_text,
                      true
                    )}
                    ${generateInputField(
                      "Content Title",
                      "content_title",
                      q.content_title
                    )}
                    ${generateInputField(
                      "Sub Content 1",
                      "sub_content_1",
                      q.sub_content_1,
                      true
                    )}
                    ${generateInputField(
                      "Sub Content 2",
                      "sub_content_2",
                      q.sub_content_2,
                      true
                    )}
                    ${generateInputField(
                      "Sub Content 3",
                      "sub_content_3",
                      q.sub_content_3,
                      true
                    )}
                    ${generateInputField(
                      "Sub Content 4",
                      "sub_content_4",
                      q.sub_content_4,
                      true
                    )}
                    ${generateInputField(
                      "Question Type",
                      "question_type",
                      q.question_type
                    )}
                  </div>
                  <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-success" id="saveEditQuestion">Save Changes</button>
                  </div>
                </div>`;
          }

          $("#modalContent").html(contentHtml);
        } else {
          $("#modalContent").html(
            `<p class="text-danger">${response.message}</p>`
          );
        }
      },
      error: function () {
        $("#modalContent").html(
          "<p class='text-danger'>Failed to fetch data. Please try again.</p>"
        );
      },
    });

    // Show the modal
    $("#questionModal").modal("show");
  });

  // Handle Save Changes in Edit Mode
  $(document).on("click", "#saveEditQuestion", function () {
    let updatedData = {
      question_id: questionId,
      question_text: $("#edit_question_text").val().trim(),
      content_title: $("#edit_content_title").val().trim(),
      sub_content_1: $("#edit_sub_content_1").val().trim(),
      sub_content_2: $("#edit_sub_content_2").val().trim(),
      sub_content_3: $("#edit_sub_content_3").val().trim(),
      sub_content_4: $("#edit_sub_content_4").val().trim(),
      question_type: $("#edit_question_type").val().trim(),
    };

    if (!updatedData.question_text) {
      alert("Question text cannot be empty!");
      return;
    }

    $.ajax({
      url: "/questions/update",
      type: "POST",
      data: updatedData,
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          alert("Question updated successfully!");
          $("#questionModal").modal("hide");
          location.reload(); // Refresh page to reflect changes
        } else {
          alert("Error updating question: " + response.message);
        }
      },
      error: function () {
        alert("Server error occurred while updating.");
      },
    });
  });
}
