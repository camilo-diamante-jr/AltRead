export function InitializeLearners() {
  StudentSearch();
}

function StudentSearch() {
  let searchInput, searchList;

  function init() {
    searchInput = $("#search_input");
    searchList = $("#searchList");

    setupListeners();
  }

  function setupListeners() {
    searchInput.on("keyup", function () {
      let value = $(this).val().toLowerCase();
      if (value.length > 0) {
        fetchStudents(value);
      } else {
        clearList();
      }
    });
  }

  function fetchStudents(query) {
    showLoading();

    $.ajax({
      url: "/get/students",
      type: "POST",
      data: { query: query },
      dataType: "json",
      success: function (response) {
        clearList();
        if (response.success && response.students.length > 0) {
          renderList(response.students);
        } else {
          renderError(response.message || "No students found");
        }
      },
      error: function () {
        clearList();
        renderError("Error fetching students");
      },
    });
  }

  function renderList(students) {
    students.forEach(function (student) {
      searchList.append(`
        <a class="list-group-item student-name w-100 list-group-item-action d-flex align-items-center gap-2" href="#" data-learner-id="${
          student.learner_id
        }">
          <i class="fa fa-user"></i> ${escapeHtml(student.full_name)}
        </a>
      `);
    });
  }

  function renderError(message) {
    searchList.append(`
      <div class="list-group-item disabled text-danger">
        ${escapeHtml(message)}
      </div>
    `);
  }

  function showLoading() {
    clearList();
    searchList.append(`
      <div class="list-group-item text-muted">
        Loading...
      </div>
    `);
  }

  function clearList() {
    searchList.empty();
  }

  function escapeHtml(text) {
    return $("<div>").text(text).html();
  }

  // ✅ Initialize the module
  init();
}
