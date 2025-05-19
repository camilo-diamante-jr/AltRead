export function exportTeachers(table) {
  if (!table) {
    console.error("Table is undefined");
    return;
  }

  $("#exportTeachers").on("click", function () {
    const rows = [];

    table.rows({ search: "applied" }).every(function () {
      const data = this.data();
      rows.push([data[0], data[1], data[2], data[3]]);
    });

    let csv = "No.,Fullname,Address,Position\n";
    rows.forEach((row) => {
      csv += row.map((field) => `"${field}"`).join(",") + "\n";
    });

    const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.setAttribute("download", "teachers_export.csv");
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
  });
}
