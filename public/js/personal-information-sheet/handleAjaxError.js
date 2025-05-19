function handleAjaxError(xhr) {
  console.error(xhr.responseText);
  Swal.fire({
    icon: "error",
    title: "Error!",
    text: "An unexpected error occurred.",
  });
}
