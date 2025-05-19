<div class="card" id="examinationReports">
    <div class="card-body">
        <!-- Tabbed Navigation for Modules -->
        <ul class="nav nav-tabs" id="moduleTabs" role="tablist">
            <?php
            $activeIndex = 0; // Set this to the index of the active tab (0 for the first tab, 1 for the second, etc.)
            foreach ($modules as $index => $module) : ?>
                <li class="nav-item" role="presentation">
                    <a class="nav-link <?= $index === $activeIndex ? 'active' : '' ?>"
                        id="module<?= $index + 1 ?>-tab"
                        data-bs-toggle="tab"
                        href="#module<?= $index + 1 ?>"
                        role="tab"
                        aria-controls="module<?= $index + 1 ?>"
                        aria-selected="<?= $index === $activeIndex ? 'true' : 'false' ?>">
                        Module <?= $index + 1 ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="moduleTabsContent">
            <!-- Module 1 -->
            <div class="tab-pane fade show active" id="module1" role="tabpanel" aria-labelledby="module1-tab">
                <table class="table table-bordered" id="module1Table">
                    <thead>
                        <tr>
                            <th colspan="6">
                                Student Name:
                            </th>
                        </tr>
                        <tr>
                            <th>Lesson</th>
                            <th>Part 1</th>
                            <th>Part 2</th>
                            <th>Part 3</th>
                            <th>Part 4</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <!-- <tfoot class="table-light">
                                <tr>
                                    <th>Total</th>
                                    <td>253</td>
                                    <td>266</td>
                                    <td>233</td>
                                    <td>270</td>
                                    <td>1022</td>
                                </tr>
                            </tfoot> -->
                </table>
            </div>

        </div>
    </div>
</div>