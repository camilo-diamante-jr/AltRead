<div class="row g-4" id="materials-container">
    <?php if (!empty($materials)): ?>
        <?php foreach ($materials as $material): ?>
            <div class="col-md-4">
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">
                    <div class="card-body d-flex flex-column">
                        <h5 class="fw-bold text-primary">
                            <?= htmlspecialchars($material['materialTitle']) ?>:
                        </h5>
                        <p class="text-muted flex-grow-1">
                            <?= htmlspecialchars($material['materialSubtitle']) ?>
                        </p>
                    </div>
                    <div class="card-footer bg-light border-0 text-center py-3">
                        <a href="../../files/uploads/<?= htmlspecialchars($material['materialFiles']) ?>"
                            data-fancybox="pdf-gallery"
                            class="btn btn-primary btn-sm px-4 rounded-pill shadow-sm">
                            <i class="bi bi-file-earmark-text"></i> View Material
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-warning text-center fw-semibold shadow-sm rounded-4 p-3">
                <i class="bi bi-exclamation-circle-fill text-warning"></i> No materials available at the moment.
            </div>
        </div>
    <?php endif; ?>
</div>