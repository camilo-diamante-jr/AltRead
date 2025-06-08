<?php

$this->renderView('./portals/Admin/partials/admin-header', $data);

include_once 'components/user_modal.php';

?>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">User management</h3>
                    <p>Manage your organization members and their account permission</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="card users-account-card">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bolder">All Users </h5>
                        <button id="addUser" class="btn btn-sm btn-primary" data-bs-target="#addUserModal" data-bs-toggle="modal">
                            <i class="fa fa-plus"></i>
                            <span>Add New User</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="userAccountsTable" class="table table-hover table-striped">
                            <thead>
                                <th>Basic Info</th>
                                <th>Date Created</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                <?php foreach ($data['users'] as $index => $user): ?>
                                    <tr class="align-middle" data-id="<?= htmlspecialchars($user['user_id']) ?>"
                                        data-name="<?= htmlspecialchars($user['name']) ?>"
                                        data-email="<?= htmlspecialchars($user['email']) ?>"
                                        data-username="<?= htmlspecialchars($user['username']) ?>"
                                        data-user_type="<?= htmlspecialchars($user['user_type']) ?>"
                                        data-avatar="<?= $user['avatar'] ?? 'default-avatar.jpg' ?>">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="/files/uploads/avatars/<?= $user['avatar'] ?? 'default-avatar.jpg' ?>"
                                                    alt="Avatar"
                                                    class="rounded-circle shadow-lg me-3"
                                                    width="40"
                                                    height="40">
                                                <div>
                                                    <strong><?= htmlspecialchars($user['name']) ?></strong><br>
                                                    <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?= date('M d, Y', strtotime($user['date_created'])) ?></td>
                                        <td><?= htmlspecialchars($user['user_type']) ?></td>
                                        <td>
                                            <span class="status-label <?= $user['is_status'] === 'active' ? 'text-success' : 'text-danger' ?> d-flex align-items-center">
                                                <i class="fa fa-circle me-1 <?= $user['is_status'] === 'active' ? 'text-success' : 'text-danger' ?>"></i>
                                                <strong><?= $user['is_status'] === 'active' ? 'Active' : 'Inactive' ?></strong>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="">
                                                <a class="editUserBtn fs-5 text-warning">
                                                    <i class="fa fa-edit" title="Edit user"></i>
                                                </a>
                                                <a class="archiveBtn fs-5 text-danger">
                                                    <i class="fa fa-archive" title="Remove user"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>

<?php

$this->renderView('./portals/Admin/partials/admin-footer');

?>