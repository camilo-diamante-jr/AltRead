<?php
require_once 'partials/admin-header.php';
?>

<main class="app-main">
    <!-- App Content Header -->
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Dashboard</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- App Content -->
    <section class="app-content">
        <article class="container-fluid">
            <div class="row">
                <!-- Small Box Widgets -->
                <div class="col-lg-3 col-6 mb-3">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3><?= $data['totalModules']; ?></h3>
                            <p>Total Modules</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-book-fill small-box-icon" viewBox="0 0 16 16">
                            <path d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783" />
                        </svg>
                        <a href="/admin/modules" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6 mb-3">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3><?= $data['totalLessons']; ?></h3>
                            <p>Total Lessons</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-journal-bookmark-fill small-box-icon" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M6 1h6v7a.5.5 0 0 1-.757.429L9 7.083 6.757 8.43A.5.5 0 0 1 6 8z" />
                            <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2" />
                        </svg>
                        <a href="/admin/manage-lessons" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6 mb-3">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3><?= $data['totalStudents']; ?></h3>
                            <p>Total Students</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-mortarboard-fill small-box-icon" viewBox="0 0 16 16">
                            <path d="M8.211 2.047a.5.5 0 0 0-.422 0l-7.5 3.5a.5.5 0 0 0 .025.917l7.5 3a.5.5 0 0 0 .372 0L14 7.14V13a1 1 0 0 0-1 1v2h3v-2a1 1 0 0 0-1-1V6.739l.686-.275a.5.5 0 0 0 .025-.917z" />
                            <path d="M4.176 9.032a.5.5 0 0 0-.656.327l-.5 1.7a.5.5 0 0 0 .294.605l4.5 1.8a.5.5 0 0 0 .372 0l4.5-1.8a.5.5 0 0 0 .294-.605l-.5-1.7a.5.5 0 0 0-.656-.327L8 10.466z" />
                        </svg>
                        <a href="/admin/manage-users/learners" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                    </div>
                </div>

                <div class="col-lg-3 col-6 mb-3">
                    <div class="small-box text-bg-secondary">
                        <div class="inner">
                            <h3><?= $data['totalSubmissions']; ?></h3>
                            <p>Total Submissions</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-journal-check small-box-icon" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M10.854 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 8.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                        </svg>
                        <a href="#" class="small-box-footer">More info <i class="bi bi-link-45deg"></i></a>
                    </div>
                </div>
            </div>
        </article>

        <!-- Learner Progress Table -->
    </section>
</main>

<?php
require_once 'partials/admin-footer.php';
?>