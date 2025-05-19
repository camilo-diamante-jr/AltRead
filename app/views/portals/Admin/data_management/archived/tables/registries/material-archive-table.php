<div class="container mt-5">
    <div class="card">
        <header class="card-header">
            <h4 class="card-title">All Materials Archive</h4>
        </header>
        <div class="card-body">
            <table id="MaterialArchiveTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Date Archived</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($MaterialArchives as $matArchive) : ?>
                        <tr>
                            <td><?= htmlspecialchars($matArchive['materialTitle']); ?></td>
                            <td><?= htmlspecialchars($matArchive['materialSubtitle']); ?></td>
                            <td><?= htmlspecialchars($matArchive['materialCategory']); ?></td>
                            <td><?= htmlspecialchars($matArchive['dateArchived']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>