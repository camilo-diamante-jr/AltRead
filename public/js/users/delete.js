function handleDeleteUser() {
	$("#userAccountsTable tbody").on("click", ".archiveBtn", function () {
		const table = $("#userAccountsTable").DataTable();
		const row = $(this).closest("tr"); // Get the clicked row
		const userId = row.data("id"); // User ID from data attribute
		const name = row.data("name"); // User's name

		// SweetAlert2 confirmation dialog
		Swal.fire({
			title: "Archive User?",
			html: `Are you sure you want to archive <strong style="color: #007bff;">${name}</strong>?<br>This action will deactivate their account.`,
			icon: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, archive",
			cancelButtonText: "No, cancel",
		}).then((result) => {
			if (result.isConfirmed) {
				table.row(row).remove().draw();
				$.ajax({
					url: "/ajax/archiveUser", // Replace with your PHP controller URL
					type: "POST",
					data: { userID: userId }, // Pass user ID
					dataType: "json",
					success: function (response) {
						if (response.success) {
							Swal.fire({
								title: "Archived",
								text: response.message,
								icon: "success",
								timer: 1500,
								showConfirmButton: false,
							});
						} else {
							Swal.fire({
								title: "Error",
								text: response.message,
								icon: "error",
							});
						}
					},
					error: function () {
						Swal.fire({
							title: "Error",
							text: "Something went wrong. Please try again.",
							icon: "error",
						});
					},
				});
			}
		});
	});
}
