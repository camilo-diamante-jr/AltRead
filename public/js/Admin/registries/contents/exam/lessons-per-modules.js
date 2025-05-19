function loadModulesInitalization() {
	const modulesRow = $("#moduleSelectionRow");
	const lessonsRow = $("#lessonPerModule");
	const lessonGroups = $(".lesson-group");
	const backToModulesBtn = $(".back-to-modules-btn");

	// Handle "View Lessons" button click
	$(".view-lessons-btn").on("click", function () {
		const moduleId = $(this).data("module-id");
		lessonGroups.addClass("d-none");
		lessonGroups.filter(`[data-module-id="${moduleId}"]`).removeClass("d-none");

		modulesRow.fadeOut(300, function () {
			lessonsRow.fadeIn(300).removeClass("d-none");
		});
	});

	// Handle "Back to Modules" button click
	backToModulesBtn.on("click", function () {
		lessonsRow.fadeOut(300, function () {
			modulesRow.fadeIn(300);
		});
	});
}


$(document).ready(() => {
	loadModulesInitalization();
});