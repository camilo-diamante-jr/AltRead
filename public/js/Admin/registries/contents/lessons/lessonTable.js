export function lessonTable() {
  const tableSelector = "#lessonTable";

  if (!$.fn.DataTable.isDataTable(tableSelector)) {
    window.lessonTable = $(tableSelector).DataTable({
      responsive: true,
      autoWidth: false,
      lengthChange: true,
      paging: true,
      searching: true,
      ordering: true,
      info: true,
      destroy: true,
    });
  }
}
