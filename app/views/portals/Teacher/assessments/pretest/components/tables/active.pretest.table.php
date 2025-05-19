<table class="table table-bordered align-middle" id="pretestTable">
    <thead>
        <tr>
            <th>No.</th>
            <th>Question</th>
            <th class="no-sort">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($pretests as $index => $pretest): ?>
            <tr>
                <td><?= "Q" . ($index + 1) ?></td>
                <td><?= htmlspecialchars($pretest['question']) ?></td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a data-bs-toggle="modal" data-bs-target="#viewPretestModal<?= $pretest['pretest_id'] ?>"
                            class="btn btn-info btn-sm text-white" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        <button type="button" class="btn btn-primary btn-sm" data-bs-target="#editPretestModal_<?= $pretest['pretest_id'] ?>" data-bs-toggle="modal" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <a href="delete.php?id=<?= $pretest['pretest_id'] ?>" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this pretest?');">
                            <i class="fa fa-trash"></i>
                        </a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>