$(document).ready(function () {
	$(".lesson-card").on("click", function () {
		const moduleId = $(this).data("module-id");

		$.ajax({
			url: "/get_lessons",
			type: "GET",
			data: { module_id: moduleId },
			success: function (data) {
				if (data.trim() === "") {
					$("#noLessonsModal").modal("show");
				} else {
					$("#lessonsContainer").html(data); // Update modal content
					$("#lessonsModal").modal("show"); // Show modal
				}
			},
			error: function (xhr, status, error) {
				console.error("Error fetching lessons:", error);
				alert("Could not load lessons. Please try again.");
			},
		});
	});
});
