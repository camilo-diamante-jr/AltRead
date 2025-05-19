$(document).ready(function () {
	// Function to update the user count
	function updateUsersCount() {
		const usersCount = $("#userAccountsTable tbody tr:visible").length;
		$("#userCount").text(`(${usersCount})`);
	}

	// Initialize DataTable
	const userAccountsTable = $("#userAccountsTable").DataTable({
		paging: true,
		searching: true,
		ordering: true,
		columnDefs: [
			{ orderable: false, targets: [4] },
			{ targets: [0, 2], type: "string" },
		],
		language: {
			paginate: {
				next: '<i class="fa fa-chevron-right"></i>',
				previous: '<i class="fa fa-chevron-left"></i>',
			},
			search: '<i class="fa fa-search"></i>',
			searchPlaceholder: "Search users...",
		},
		drawCallback: function () {
			// Update the user count whenever the table is redrawn
			updateUsersCount();
		},
	});

	// Initial user count
	updateUsersCount();
});
