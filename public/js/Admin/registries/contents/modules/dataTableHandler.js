export function initDataTable() {
  const tableSelector = "#moduleTable";

  if (!$.fn.DataTable.isDataTable(tableSelector)) {
    window.moduleTable = $(tableSelector).DataTable({
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

  loadModules();
}

// ✅ Fetch Data & Populate Table
export function loadModules() {
  $.ajax({
    url: "/ajax/getModules",
    type: "GET",
    dataType: "json",
    success: function (response) {
      console.log("✅ Server Response:", response);

      if (response.success && Array.isArray(response.data)) {
        window.moduleTable.clear();
        updateTable(response.data);
      } else {
        console.warn("⚠️ No modules found or invalid response.");
      }
    },
    error: function (xhr, status, error) {
      console.error("❌ AJAX Error:", status, error);
    },
  });
}

// ✅ Function to update DataTable dynamically
export function updateTable(modules) {
  modules.forEach((module) => {
    window.moduleTable.row.add([
      module.module_name,
      module.module_description,
      `
      <button class="btn btn-sm btn-primary editModuleBtn" 
          data-bs-toggle="modal" 
          data-bs-target="#editModuleModal_${module.module_id}" 
          data-module-id="${module.module_id}">
          <i class="fa fa-pencil"></i>
      </button>
      <button class="btn btn-sm btn-danger removeModuleBtn" 
          data-module-id="${module.module_id}">
          <i class="fa fa-trash"></i>
      </button>
      `,
    ]);
  });

  window.moduleTable.draw();
}
