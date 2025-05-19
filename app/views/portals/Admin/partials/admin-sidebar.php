<aside class="app-sidebar bg-primary-subtle" data-bs-theme="dark">
    <div class="sidebar-brand">
        <a href="/dashboard" class="brand-link">
            <img src="/assets/images/logo/AltRead-Logo.jpg" alt="AltRead-Logo"
                class="brand-image rounded-circle opacity-75 shadow">
            <span class="brand-text fw-light"><?= $brandText ?></span>
        </a>
    </div>

    <div class="sidebar-wrapper p-0">
        <nav class="mt-2">
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="/admin/dashboard" class="nav-link">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>


                <!-- Assessments -->
                <li class="border"></li>
                <li class="nav-header">Assessments</li>

                <li class="nav-item">
                    <a href="/admin/assessment/pretest" class="nav-link">
                        <i class="nav-icon bi bi-book"></i>
                        <p>Pretest</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="/admin/assessment/quiz" class="nav-link">
                        <i class="nav-icon bi bi-pencil-square"></i>
                        <p>Quizzes</p>
                    </a>
                </li>


                <li class="border"></li>
                <li class="nav-header">Management</li>

                <!-- Archive -->
                <!-- <li class="nav-item">
                    <a href="/admin/archives" class="nav-link">
                        <i class="nav-icon bi bi-archive"></i>
                        <p>Archive</p>
                    </a>
                </li> -->

                <!-- Answer Keys -->
                <li class="nav-item">
                    <a href="/admin/management/answerkeys" class="nav-link">
                        <i class="nav-icon bi bi-key"></i>
                        <p>Answer Keys</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="/admin/management/users" class="nav-link">
                        <i class="nav-icon bi bi-people"></i>
                        <p>Users Account</p>
                    </a>
                </li>

                <li class="border"></li>
                <li class="nav-header">Registries</li>

                <!-- Contents -->
                <li class="nav-item">
                    <a href="/admin/registry/contents" class="nav-link">
                        <i class="nav-icon bi bi-folder"></i>
                        <p>Contents</p>
                    </a>
                </li>
                <!-- Materials -->
                <li class="nav-item">
                    <a href="/admin/registry/materials" class="nav-link">
                        <i class="nav-icon bi bi-folder"></i>
                        <p>Materials</p>
                    </a>
                </li>

                <!-- Students -->
                <li class="nav-item">
                    <a href="/admin/registry/students" class="nav-link">
                        <i class="nav-icon bi bi-person-fill"></i>
                        <p>Students</p>
                    </a>
                </li>

                <!-- Teachers -->
                <li class="nav-item">
                    <a href="/admin/registry/teachers" class="nav-link">
                        <i class="nav-icon bi bi-person-fill-check"></i>
                        <p>Teachers</p>
                    </a>
                </li>



                <li class="border"></li>
                <li class="nav-header">Reports</li>

                <!-- Submissions -->
                <li class="nav-item">
                    <a href="/admin/report/submissions" class="nav-link">
                        <i class="nav-icon bi bi-journal-check"></i>
                        <p>Submissions</p>
                    </a>
                </li>

                <!-- Progress -->
                <li class="nav-item">
                    <a href="/admin/report/progress" class="nav-link">
                        <i class="nav-icon bi bi-award"></i>
                        <p>Progress</p>
                    </a>
                </li>

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