async function loadModule(modulePath) {
  const timestamp = Date.now(); // More concise
  const moduleUrl = `${modulePath}?v=${timestamp}`;
  return import(moduleUrl);
}

$(document).ready(async () => {
  try {
    const { InitializeLearners } = await loadModule("./get-students.js");
    const { InitializeOverview } = await loadModule(
      "./get-submissions-overview.js"
    );
    const { InitializeByModule } = await loadModule(
      "./get-submissions-by-module.js"
    );

    InitializeLearners();
    InitializeOverview();
    InitializeByModule();
  } catch (error) {
    console.error("Error loading modules:", error);
    Swal.fire({
      icon: "error",
      title: "Module Load Error",
      text: "Failed to load one or more components. Please refresh and try again.",
    });
  }
});
