export function initializeUploadingAnswerKeys() {
  const answerkeyTable = new DataTable("#answerKeysTable");
  initializeImportingAnswerKeys();
  return answerkeyTable;
}

function initializeImportingAnswerKeys() {
  setupDragAndDrop();
  setupSubmitUploadedFile();
  setupRemoveUploadedFile();
  setupUpdateUploadedFile();
  setupArchiveUploadedFile(); // Reserved for future use
}

// Status: OK
function setupDragAndDrop() {
  const dragArea = $(".file_drag");

  dragArea.on("dragover", function () {
    $(this).addClass("file_drag_over");
    return false;
  });

  dragArea.on("dragleave", function () {
    $(this).removeClass("file_drag_over");
    return false;
  });

  dragArea.on("drop", function (e) {
    e.preventDefault();
    $(this).removeClass("file_drag_over");

    const files = e.originalEvent.dataTransfer.files;
    const validFiles = [];

    // Filter only PDF files
    for (let i = 0; i < files.length; i++) {
      if (files[i].type === "application/pdf") {
        validFiles.push(files[i]);
      }
    }

    // Store files in DOM for later submission
    this.dropFiles = validFiles;

    previewUploadedFiles(validFiles); // Preview files right after drag and drop

    const formData = new FormData();
    validFiles.forEach((file) => {
      formData.append("file[]", file);
    });

    uploadAnswerKeyFiles(formData, validFiles);
  });
}

// Function to preview files before uploading
function previewUploadedFiles(files) {
  const previewContainer = $("#uploaded_file");
  previewContainer.empty(); // Clear any existing previews

  files.forEach((file, index) => {
    const fileCard = `
      <div class="col-md-4 mb-3 uploaded-card">
        <div class="card p-2 position-relative">
          <p class="mb-0">${file.name}</p>
          <button class="btn btn-sm btn-danger btn-remove-file position-absolute top-0 end-0 m-2" data-index="${index}">&times;</button>
        </div>
      </div>
    `;
    previewContainer.append(fileCard);
  });
}

// Status: Ok
function uploadAnswerKeyFiles(formData, validFiles) {
  $.ajax({
    type: "POST",
    url: "/answerkeysFilePreview", // The URL to upload the file
    data: formData,
    contentType: false,
    cache: false,
    processData: false,
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {
        console.log(response.message);
      } else {
        // Use SweetAlert2 to show error message
        Swal.fire({
          icon: "error",
          title: "Upload Failed",
          text: "There was an error uploading the files. Please try again.",
        });
      }
    },
    error: function () {
      // Use SweetAlert2 to show error message
      Swal.fire({
        icon: "error",
        title: "Error",
        text: "An error occurred while uploading the files.",
      });
    },
  });
}

// Status: Ok
function setupRemoveUploadedFile() {
  $("#uploaded_file").on("click", ".btn-remove-file", function (e) {
    e.preventDefault();
    const index = $(this).data("index");

    // Remove file visually from preview area
    $(this).closest(".uploaded-card").remove();

    // Also remove from the stored dropFiles array
    const dropArea = $(".file_drag")[0];
    if (dropArea.dropFiles) {
      dropArea.dropFiles.splice(index, 1);
    }
  });
}

// Status: Finalized with inline data rendering
function setupSubmitUploadedFile() {
  $("#uploadAnswerKeysForm").on("submit", function (e) {
    e.preventDefault();

    const dropArea = $(".file_drag")[0];
    const files = dropArea.dropFiles || [];

    if (!files.length) {
      Swal.fire({
        icon: "warning",
        title: "No Files Selected",
        text: "Please upload at least one PDF file.",
      });
      return;
    }

    const formData = new FormData();
    files.forEach((file) => {
      formData.append("file[]", file);
    });

    $.ajax({
      type: "POST",
      url: "/uploadAnswerKeys",
      data: formData,
      contentType: false,
      cache: false,
      processData: false,
      dataType: "json",
      success: function (response) {
        if (response.status === "success") {
          Swal.fire({
            icon: "success",
            title: "Upload Successful",
            text: "The file/s were uploaded successfully.",
          }).then(() => {
            $("#answerKeysModal").modal("hide");
            $("#uploaded_file").empty();
            $(".file_drag")[0].dropFiles = [];

            // Directly use response.uploaded instead of making another request
            renderUploadedFiles(response.uploaded);
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Upload Failed",
            text: `Upload failed: ${response.message}`,
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Upload Error",
          text: "An error occurred while uploading the files.",
        });
      },
    });
  });
}

function renderUploadedFiles(uploadedFiles) {
  const table = $("#answerKeysTable").DataTable();

  uploadedFiles.forEach((file) => {
    const formattedDate = new Date(file.uploaded_at).toLocaleDateString(
      "en-US",
      {
        year: "numeric",
        month: "long",
        day: "numeric",
      }
    );

    // Add row without clearing existing table
    table.row.add([
      file.original_name,
      formattedDate,
      `
        <div class="text-center">
          <a data-fancybox data-type="iframe" data-src="/files/uploads/answer_keys/${file.original_name}" href="javascript:;" class="text-secondary me-2" title="View">
            <i class="bi bi-eye-fill"></i>
          </a>
          <a href="#" class="text-warning me-2 update-file" data-id="${file.id}" title="Update">
            <i class="bi bi-pencil-fill"></i>
          </a>
          <a href="#" class="text-danger remove-file" data-id="${file.id}" title="Remove">
            <i class="bi bi-trash-fill"></i>
          </a>
        </div>
      `,
    ]);
  });

  table.draw(false); // 'false' keeps current pagination
}

function setupUpdateUploadedFile() {
  $(document).on("click", ".update-file", function (e) {
    e.preventDefault();
    const id = $(this).data("id");
    const $row = $(this).closest("tr");

    Swal.fire({
      title: "Update File",
      text: "Please choose a new PDF file.",
      input: "file",
      inputAttributes: {
        accept: "application/pdf",
      },
      showCancelButton: true,
      confirmButtonText: "Upload <i class='bi bi-upload'></i>",
      cancelButtonText: "Cancel <i class='bi bi-x'></i>",
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-danger",
      },
      inputValidator: (file) => {
        if (!file) {
          return "Please select a file to upload!";
        }
        if (file.type !== "application/pdf") {
          return "Only PDF files are allowed!";
        }
      },
    }).then((result) => {
      if (result.isConfirmed && result.value instanceof File) {
        const formData = new FormData();
        formData.append("answerkey_id", id);
        formData.append("new_file", result.value);

        $.ajax({
          type: "POST",
          url: "/updateAnswerKeys",
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              const updated = response.updated_file;
              const formattedDate = new Date(
                updated.uploaded_at
              ).toLocaleDateString("en-US", {
                year: "numeric",
                month: "long",
                day: "numeric",
              });

              const table = $("#answerKeysTable").DataTable();
              table
                .row($row)
                .data([
                  updated.original_name,
                  formattedDate,
                  `
                  <div class="text-center">
                    <a data-fancybox data-type="iframe" data-src="/files/uploads/answer_keys/${updated.original_name}" href="javascript:;" class="text-secondary me-2" title="View">
                      <i class="bi bi-eye-fill"></i>
                    </a>
                    <a href="#" class="text-warning me-2 update-file" data-id="${updated.id}" title="Update">
                      <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="#" class="text-danger remove-file" data-id="${updated.id}" title="Remove">
                      <i class="bi bi-trash-fill"></i>
                    </a>
                  </div>
                `,
                ])
                .draw(false);

              Swal.fire({
                icon: "success",
                title: "File Updated",
                text: "The file was successfully updated.",
                showConfirmButton: false,
                timer: 1500,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Update Failed",
                text:
                  response.message || "There was an error updating the file.",
              });
            }
          },
          error: function (xhr, status, error) {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "An error occurred while updating the file.",
            });
            console.error("AJAX error:", status, error);
          },
        });
      }
    });
  });
}

function setupArchiveUploadedFile() {
  $(document).on("click", ".remove-file", function () {
    const id = $(this).data("id");
    const $row = $(this).closest("tr"); // Ensure this targets the correct row in the table

    Swal.fire({
      title: "Are you sure?",
      text: "This file will be archived.",
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#d33",
      cancelButtonColor: "#6c757d",
      confirmButtonText: "Yes, archive it!",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          type: "POST",
          url: "/removeAnswerKeys", // Ensure your route is correctly mapped
          data: { answerkey_id: id },
          dataType: "json",
          success: function (response) {
            if (response.status === "success") {
              const table = $("#answerKeysTable").DataTable();
              table.row($row).remove().draw(false); // Remove row without resetting pagination

              Swal.fire({
                icon: "success",
                title: "Archived!",
                text: "The file was archived successfully.",
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Archiving Failed",
                text: `Archiving failed: ${response.message}`,
              });
            }
          },
          error: function () {
            Swal.fire({
              icon: "error",
              title: "Archive Error",
              text: "An error occurred while archiving the file.",
            });
          },
        });
      }
    });
  });
}
