<?php if (empty($modules)) : ?>
    <div class="d-flex flex-column align-items-center justify-content-center py-5">
        <i class="fa fa-folder-open text-secondary display-3 mb-3"></i>
        <p class="text-muted fs-5">No modules available</p>
    </div>
<?php else : ?>
    <section id="moduleContainer" class="container">
        <div id="alertContainer"></div>

        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm border rounded-3 overflow-hidden">
                <thead class="bg-light">
                    <tr class="text-uppercase text-muted small">
                        <th scope="col" class="text-center">#</th>
                        <th scope="col" class="text-nowrap">
                            <i class="fa fa-book-open text-primary me-1"></i> Modules
                        </th>
                        <th scope="col" class="text-nowrap">
                            <i class="fa fa-align-left text-secondary me-1"></i> Description
                        </th>
                        <th scope="col" class="text-nowrap">
                            <i class="fa fa-chart-line text-success me-1"></i> Progress
                        </th>
                        <th scope="col" class="text-center text-nowrap">
                            <i class="fa fa-cogs text-warning me-1"></i> Actions
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($modules as $index => $module) :
                        $progress = rand(40, 90); // Dummy progress value
                    ?>
                        <tr class="module-row border-bottom" data-module-id="<?= htmlspecialchars($module['module_id']) ?>">
                            <td class="text-center fw-bold"><?= $index + 1 ?></td>
                            <td class="fw-semibold text-primary text-nowrap">
                                <i class="fa fa-folder-open me-2 text-warning"></i>
                                <?= htmlspecialchars($module['module_name']) ?>
                            </td>
                            <td class="text-muted small text-nowrap"><?= htmlspecialchars($module['module_description']) ?></td>
                            <td class="text-nowrap">
                                <div class="progress rounded-pill" style="height: 15px; min-width: 100px;">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info"
                                        role="progressbar" style="width: <?= $progress ?>%;"
                                        aria-valuenow="<?= $progress ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= $progress ?>%
                                    </div>
                                </div>
                            </td>
                            <td class="text-center text-nowrap">
                                <button class="btn btn-outline-primary btn-sm fw-semibold showLessonBtn"
                                    data-module-id="<?= htmlspecialchars($module['module_id']) ?>">
                                    <i class="fa fa-play me-1"></i> Start
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> <!-- End of .table-responsive -->
    </section>
<?php endif; ?>