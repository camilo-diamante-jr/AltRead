/*---------------------------
  Add New Row to DataTable
---------------------------*/
function addNewRow(avatar, name, email, user_type, status, formattedDate) {
  const isActive = status.toLowerCase() === "inactive";

  window.userAccountsTable.row
    .add([
      `
			<div class="d-flex align-items-center">
				<img src="../files/uploads/avatars/${avatar}" 
					alt="Avatar"
					class="rounded-circle me-3"
					width="40"
					height="40">
				<div>
					<strong>${name}</strong><br>
					<small class="text-muted">${email}</small>
				</div>
			</div>`,

      formattedDate,
      user_type,
      `
			<span class="status-label ${
        isActive ? "text-success" : "text-danger"
      } d-flex align-items-center">
					<i class="fa fa-circle me-1 ${isActive ? "text-success" : "text-danger"}"></i>
			<strong>${isActive ? "Active" : "Inactive"}</strong>
			</span>`,
      `<div class="btn-group">
			<button type="button" class="btn editUserBtn btn-sm btn-primary">
				<i class="fa fa-edit"></i>
			</button>
			<button type="button" class="btn archiveBtn btn-sm btn-danger">
				<i class="fa fa-trash"></i>
			</button>
		</div>`,
    ])
    .draw(false);

  handleDeleteUser();
}
