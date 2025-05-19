<?php

function is_image($path)
{
    $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp'];
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    return in_array($ext, $image_extensions);
}

foreach ($pretests as $index => $pretest) : ?>
    <div class="modal fade" id="viewPretestModal<?= htmlspecialchars($pretest['pretest_id']) ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <header class="modal-header">
                    <h5 class="modal-title">All Pretest Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </header>

                <!-- Modal Body -->
                <div class="modal-body">
                    <div class="card shadow-lg border-0">
                        <div class="card-body">
                            <p><span class="fw-bold text-primary">Q<?= $index + 1 ?>:</span> <?= htmlspecialchars($pretest['question']) ?></p>
                            <p><span class="fw-bold">Type:</span> <?= htmlspecialchars($pretest['pretest_type']) ?></p>

                            <?php if (!empty($pretest['context'])) : ?>
                                <p class="text-muted"><span class="fw-bold">Main Context:</span> <?= nl2br(htmlspecialchars($pretest['context'])) ?></p>
                            <?php endif; ?>

                            <div>
                                <?php
                                $subContents = [
                                    'Sub Context 1' => $pretest['first_sub_context'],
                                    'Sub Context 2' => $pretest['second_sub_context'],
                                    'Sub Context 3' => $pretest['third_sub_context'],
                                    'Sub Context 4' => $pretest['fourth_sub_context']
                                ];
                                ?>

                                <?php foreach ($subContents as $label => $subContent) : ?>
                                    <?php if (!empty($subContent)) : ?>
                                        <p><span class="fw-bold text-success"> <?= $label ?>:</span> <?= htmlspecialchars($subContent) ?></p>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div>
                                <p class="fw-bold">Choices:</p>
                                <ul class="list-group">
                                    <?php foreach (['A' => 'choice_a', 'B' => 'choice_b', 'C' => 'choice_c', 'D' => 'choice_d'] as $key => $choice) : ?>
                                        <?php if (!empty($pretest[$choice])) : ?>
                                            <li class="list-group-item <?= ($pretest['correct_answer'] === $key) ? 'list-group-item-success' : '' ?>">
                                                <strong><?= $key ?>:</strong>
                                                <?php if (is_image($pretest[$choice])) : ?>
                                                    <img src="../files/uploads/pretest_choices/<?= $pretest[$choice] ?>" alt="Choice <?= $key ?>" class="img-fluid" style="max-width: 80px; height: auto;">
                                                <?php else : ?>
                                                    <?= htmlspecialchars($pretest[$choice]) ?>
                                                <?php endif; ?>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <footer class="modal-footer">
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">Close</button>
                </footer>
            </div>
        </div>
    </div>
<?php endforeach; ?>