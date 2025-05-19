export function InitializeOverview() {
  const $submissionsTableCard = $("#submissionsTable, #reportCard");
  const $searchCommandList = $("#searchCommand, #searchList");
  const $searchInput = $("#search_input");

  $(document).on("click", ".student-name", loadSubmission);

  $searchInput.on("keydown", () => {
    $searchCommandList.removeClass("d-none");
    $submissionsTableCard.addClass("d-none");
  });

  function loadSubmission() {
    const learnerID = $(this).data("learner-id");

    $searchCommandList.addClass("d-none");
    $submissionsTableCard.addClass("d-none").find("tbody").empty();

    if (!learnerID) {
      Swal.fire({
        icon: "error",
        title: "Missing Student",
        text: "No learner ID found. Please try again.",
      });
      return;
    }

    Swal.fire({
      title: "Loading submissions...",
      allowOutsideClick: false,
      didOpen: Swal.showLoading,
    });

    $.ajax({
      url: "/get/submissions-by-learner-id",
      type: "POST",
      data: { learner_id: learnerID },
      dataType: "json",
      success(response) {
        Swal.close();

        if (
          Array.isArray(response.learnerSubmissions) &&
          response.learnerSubmissions.length > 0
        ) {
          renderSubmissions(response.learnerSubmissions);
          $searchCommandList.addClass("d-none");
          $submissionsTableCard.removeClass("d-none");
        } else {
          Swal.fire({
            icon: "info",
            title: "No Submissions",
            text:
              response.message || "This student has not submitted anything.",
          });
        }
      },
      error() {
        Swal.close();
        Swal.fire({
          icon: "error",
          title: "Network Error",
          text: "Failed to fetch student submissions.",
        });
      },
    });
  }

  function renderSubmissions(submissions) {
    // const $tbody = $submissionsTable.find("tbody").empty();
    // submissions.forEach((submission, index) => {
    //   const row = `
    //     <tr>
    //       <td></td>
    //       <td></td>
    //       <td></td>
    //       <td></td>
    //       <td></td>
    //       <td>
    //         <button type="button" class="btn btn-sm btn-primary rounded-pill">
    //             View answers
    //         </button>
    //       </td>
    //     </tr>
    //   `;
    //   $tbody.append(row);
    // });
  }
}
