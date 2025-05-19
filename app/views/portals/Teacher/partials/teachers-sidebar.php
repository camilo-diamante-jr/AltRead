<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/teacher" class="brand-link">
            <img src="../assets/images/logo/AR_LOGO400x200_2.png" alt="ALS-Logo"
                class="brand-img rounded-circle shadow" style="height:32px; width:32px">
            <span class="brand-text fw-light"><?= $brandText ?></span>
        </a>
    </div>

    <div class="sidebar-wrapper p-0">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/teacher" class="nav-link">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <!-- Assessments -->
                <li class="border"></li>
                <li class="nav-header">Assessments</li>

                <li class="nav-item">
                    <a href="/teacher/assessment/pretest" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Pretest</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/teacher/assessment/quizzes" class="nav-link">
                        <i class="nav-icon bi bi-pencil-square"></i>
                        <p>Quizzes</p>
                    </a>
                </li>


                <li class="border"></li>
                <li class="nav-header">Management</li>

                <!-- Archive -->
                <!-- <li class="nav-item">
                    <a href="/admin/archived" class="nav-link">
                        <i class="nav-icon bi bi-archive"></i>
                        <p>Archive</p>
                    </a>
                </li> -->

                <!-- Answer Keys -->
                <li class="nav-item">
                    <a href="/teacher/management/answerkeys" class="nav-link">
                        <i class="nav-icon bi bi-key"></i>
                        <p>Answer Keys</p>
                    </a>
                </li>

                <li class="border"></li>
                <li class="nav-header">Registries</li>

                <li class="nav-item">
                    <a href="/teacher/registry/contents" class="nav-link">
                        <i class="nav-icon bi bi-box"></i>
                        <p>Contents</p>
                    </a>
                </li>


                <!-- Materials -->
                <li class="nav-item">
                    <a href="/teacher/registry/materials" class="nav-link">
                        <i class="nav-icon bi bi-folder"></i>
                        <p>Materials</p>
                    </a>
                </li>

                <!-- Students -->
                <li class="nav-item">
                    <a href="/teacher/registry/student" class="nav-link">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>Students</p>
                    </a>
                </li>


                <li class="border"></li>
                <li class="nav-header">Reports</li>

                <!-- Submissions -->
                <li class="nav-item">
                    <a href="/teacher/report/submissions" class="nav-link">
                        <i class="nav-icon bi bi-journal-check"></i>
                        <p>Submissions</p>
                    </a>
                </li>

                <!-- Achievements -->
                <!-- <li class="nav-item">
                    <a href="/teacher/achievements" class="nav-link">
                        <i class="nav-icon bi bi-award"></i>
                        <p>Achievements</p>
                    </a>
                </li> -->

                <li class="border"></li>
                <li class="nav-header">Settings & Privacy</li>

                <!-- Account Settings -->
                <li class="nav-item">
                    <a href="/settings" class="nav-link">
                        <i class="nav-icon bi bi-gear"></i>
                        <p>General Settings</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>