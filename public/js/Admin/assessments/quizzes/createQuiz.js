export function initializeCreateQuizzes() {
  // Initialize the DataTable with row numbering (without the 'created_at' column)
  let quizzesTable = $("#quizzesTable").DataTable({
    columns: [
      { data: "index" }, // Adding an index column
      { data: "quiz_title" },
      { data: "quiz_question" },
      { data: "actions" }, // Removing 'created_at' column
    ],
    order: [[0, "asc"]], // Ensuring that rows are ordered by the index column
    createdRow: function (row, data, dataIndex) {
      // Automatically update the index on row creation
      $("td", row)
        .eq(0)
        .html(dataIndex + 1); // Update the index in the first column
    },
  });

  let addQuizSubContentCount = 0;
  let addQuizChoiceCount = 0;
  const maxSubContents = 6;
  const maxChoices = 6;

  // Add Sub Content
  $("#addQuizAddSubContentBtn").click(function () {
    if (addQuizSubContentCount < maxSubContents) {
      addQuizSubContentCount++;
      $("#addQuizSubContentsWrapper").append(`
        <div class="input-group mb-2" id="subContent_${addQuizSubContentCount}">
          <textarea class="form-control" name="sub_content_${addQuizSubContentCount}" placeholder="Sub Content ${addQuizSubContentCount}" rows="3"></textarea>
          <button type="button" class="btn btn-danger btn-sm" onclick="removeSubContent(${addQuizSubContentCount})">Remove</button>
        </div>
      `);
    } else {
      Swal.fire(
        "Limit reached",
        "You can only add up to 6 sub-contents.",
        "info"
      );
    }
  });

  // Remove Sub Content
  window.removeSubContent = function (subContentId) {
    $(`#subContent_${subContentId}`).remove();
  };

  // Add Choice
  $("#addQuizAddChoiceBtn").click(function () {
    if (addQuizChoiceCount < maxChoices) {
      addQuizChoiceCount++;
      $("#addQuizChoicesWrapper").append(`
        <div class="input-group mb-2" id="choice_${addQuizChoiceCount}">
          <input type="text" class="form-control" name="choices_${addQuizChoiceCount}" placeholder="Choice ${addQuizChoiceCount}">
          <button type="button" class="btn btn-danger btn-sm" onclick="removeChoice(${addQuizChoiceCount})">Remove</button>
        </div>
      `);
    } else {
      Swal.fire("Limit reached", "You can only add up to 6 choices.", "info");
    }
  });

  // Remove Choice
  window.removeChoice = function (choiceId) {
    $(`#choice_${choiceId}`).remove();
  };

  // Reset modal when opening
  $("#openAddQuizModalBtn").click(function () {
    $("#addQuizForm")[0].reset();
    $("#addQuizSubContentsWrapper").empty();
    $("#addQuizChoicesWrapper").empty();
    addQuizSubContentCount = 0;
    addQuizChoiceCount = 0;
    $("#addQuizModal").modal("show");
  });

  // Form submission (add quiz)
  $("#addQuizForm").submit(function (e) {
    e.preventDefault();

    $.ajax({
      url: "/createQuizzes", // Your server endpoint to create a quiz
      method: "POST",
      data: $(this).serialize(),
      dataType: "json",
      success: function (res) {
        if (res.success) {
          Swal.fire("Success!", "Quiz added successfully.", "success").then(
            () => {
              // Close the modal
              $("#addQuizModal").modal("hide");
              insertingNewRow(res.quizData); // Pass the newly added quiz data
            }
          );
        } else {
          Swal.fire("Error!", res.message || "Something went wrong.", "error");
        }
      },
      error: function (xhr, status, error) {
        console.error("AJAX error:", status, error);
        console.error("Response text:", xhr.responseText);
        Swal.fire("Oops!", "Server error occurred.", "error");
      },
    });
  });

  // Function to insert a new row into the DataTable (without 'created_at' column)
  function insertingNewRow(quizData) {
    // Get the current row count (which is also the next index to display)
    const newIndex = quizzesTable.rows().count() + 1;

    // Add the new quiz data to the table
    quizzesTable.row
      .add({
        index: newIndex, // Set the new row index dynamically
        quiz_title: quizData.quiz_title,
        quiz_question: quizData.quiz_question,
        actions: `
          <button type="button" class="btn btn-sm btn-warning me-2" title="Edit">
            <i class="fa fa-edit"></i>
          </button>
          <button type="button" class="btn btn-sm btn-danger" title="Remove">
            <i class="fa fa-archive"></i>
          </button>
        `,
      })
      .draw(false); // Append the row without reordering
  }
}
