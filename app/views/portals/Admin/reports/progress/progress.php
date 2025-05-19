<?php $this->renderView('./portals/Admin/partials/admin-header', $data); ?>

<main class="app-main mt-5">
    <!-- Page Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><?= htmlspecialchars($data['breadcrumb_title']) ?></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item">
                            <a href="#"><?= htmlspecialchars($data['breadcrumb_go_back_home_text']) ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <?= htmlspecialchars($data['breadcrumb_current_link_text']) ?>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-main-content">
        <div class="container-fluid">
            <div class="card rounded-0 shadow-sm">

                <div class="card-body">
                    <header class="heading border-bottom border-dark">
                        <figure class="deped-logo">
                            <img src="" alt="">
                        </figure>
                        <div class="header-texts text-center">
                            <h5> Republic of the Philippines </h5>
                            <h5> Region VI - Western Visayas </h5>
                            <h5> Department of Education </h5>
                            <h5> Schools District of Dumangas I</h5>
                            <h4 class="fw-bold"> Alternative Learning System</h4>
                        </div>
                        <figure class="department-logo">
                            <img src="" alt="">
                        </figure>
                    </header>

                    <section class="border-bottom border-dark py-3">
                        <h5 class="text-center fw-bold">PROGRESS REPORT CARD</h5>
                        <div class="row mb-3">
                            <div class="col-md-5">
                                <div class="d-flex align-items-center gap-4">
                                    <label for="">
                                        LRN:
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                        <input type="text" class="form-control form-control-sm rounded-0" />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-7">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="">Sex:</label>
                                    <select type="text" name="sex" id="sex" class="form-select rounded-0  form-select-sm">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="">Name:</label>
                                    <input type="text" class="form-control form-control-sm" />
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="d-flex align-items-center gap-2">
                                    <label for="">School Year:</label>
                                    <input type="year" class="form-control form-control-sm" value="2024-2025">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
</main>




<?php $this->renderView('./portals/Admin/partials/admin-footer'); ?>