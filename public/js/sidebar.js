const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";

const Default = {
  scrollbarTheme: "os-theme-light",
  scrollbarAutoHide: "never", // Ensures the scrollbar is always visible
  scrollbarClickScroll: true,
};

const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

if (
  sidebarWrapper &&
  typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
) {
  OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
    scrollbars: {
      theme: Default.scrollbarTheme,
      autoHide: Default.scrollbarAutoHide,
      clickScroll: Default.scrollbarClickScroll,
    },
  });

  // Ensure the sidebar grows dynamically with content
  sidebarWrapper.style.overflow = "auto";
  sidebarWrapper.style.maxHeight = "auto"; // Ensures it doesn't exceed the viewport height
}
