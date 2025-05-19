export function manageTabs() {
  const tabContainer = $("#contentsTab");
  const contentContainer = $("#contentsContent");

  const lastActiveTab = localStorage.getItem("lastActiveTab");
  if (lastActiveTab) {
    tabContainer.find(".nav-link.active").removeClass("active");
    contentContainer.find(".tab-pane.show.active").removeClass("show active");

    tabContainer.find(`[data-bs-target="${lastActiveTab}"]`).addClass("active");
    contentContainer.find(lastActiveTab).addClass("show active");
  }

  tabContainer.on("click", ".nav-link", function () {
    localStorage.setItem("lastActiveTab", $(this).data("bs-target"));
  });
}
