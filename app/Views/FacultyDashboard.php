<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->


<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-blur fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <img src="/img/logo.png" alt="logo" class="logo">
            CKC information Technology
        </a>

        <!-- Toggle Button for Offcanvas -->
        <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#mobileSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">


            <!-- Notifications Dropdown -->
            <div class="dropdown">
                <a href="#" class="text-light position-relative" id="notifDropdown" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        id="notifBadge">2</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2" aria-labelledby="notifDropdown"
                    style="min-width: 320px;">
                    <li class="dropdown-item d-flex justify-content-between align-items-start">
                        <div>
                            <small class="fw-bold">Student Application</small><br>
                            <span>A student wants to join your subject.</span>
                        </div>
                        <div class="ms-2 d-flex gap-1">
                            <button class="btn btn-sm btn-success btn-confirm">Confirm</button>
                            <button class="btn btn-sm btn-danger btn-delete">Delete</button>
                        </div>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li class="dropdown-item d-flex justify-content-between align-items-start">
                        <div>
                            <small class="fw-bold">Admin Update</small><br>
                            <span>Admin confirmed you in the subject.</span>
                        </div>
                    </li>
                </ul>
            </div>

            <img src="/img/juswa.jpg" class="profile-pic" alt="Prof. Atis" />
        </div>
    </div>
</nav>

<!-- Sidebar (Desktop) -->
<nav class="sidebar d-none d-lg-flex flex-column">
    <li class="nav-item mb-2">
        <a href="Index.php" class="nav-link text-white">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
    </li>
    <li class="nav-item mb-2">
        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#teacherMenu" role="button" aria-expanded="false" aria-controls="teacherMenu">
            <span><i class="bi bi-person-badge me-2"></i>Faculty</span>
            <i class="bi bi-caret-down-fill small"></i>
        </a>

        <!-- Dropdown Items -->
        <div class="collapse ps-3" id="teacherMenu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="/faculty-subjects/<?= $faculty['user_id']?>" class="nav-link text-white-50">
                        <i class="bi bi-person-plus me-2"></i> My Subjects
                    </a>
                </li>
                <li class="nav-item">
                    <a href="Manage_Faculty.php" class="nav-link text-white-50">
                        <i class="bi bi-people me-2"></i> Manage Faculty
                    </a>
                </li>
            </ul>
        </div>
    </li>
    <li class="nav-item mb-2">
        <a class="nav-link text-white d-flex justify-content-between align-items-center" data-bs-toggle="collapse"
            href="#subjectMenu" role="button" aria-expanded="false" aria-controls="subjectMenu">
            <span><i class="bi bi-journal-text me-2"></i> Subject</span>
            <i class="bi bi-caret-down-fill small"></i>
        </a>

        <div class="collapse ps-3" id="subjectMenu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="addSubject.php" class="nav-link text-white-50">
                        <i class="bi bi-plus-circle me-2"></i> Add Subject
                    </a>
                </li>
                <li class="nav-item">
                    <a href="Manage_Subject.php" class="nav-link text-white-50">
                        <i class="bi bi-list-check me-2"></i> Manage Subject
                    </a>
                </li>
            </ul>
        </div>
    </li>

    <!-- Logout -->
    <li class="nav-item mt-3">
        <a href="logout.php" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </li>
</nav>
<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar"
    aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-0">
        <a href="/" class="active px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-house"></i> Dashboard</a>
        <a href="/subjects_available" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-book"></i>
            Available Subjects</a>
        <a href="/my_subjects" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill"></i>
            My Subjects</a>
        <a href="/profile" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-circle"></i>
            Profile</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-gear"></i> Settings</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<!-- Main Content -->
<main class="main-content">
    <h2>Faculty Dashboard</h2>
    <p class="text-light">Overview of your subjects, applications, and notifications.</p>

    <div class="row g-4 mb-4">
        <a href="/faculty-subjects/<?= $faculty['user_id'] ?>" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-journal-text metric-icon"></i>
                <div>
                    <div class="card-title">My Subjects</div>
                    <div class="card-value"><?= $acceptedCount ?: '—' ?></div>
                </div>
            </div>
        </a>
        <a href="/faculty-subjectsPendingApplication/<?= $faculty['user_id'] ?>" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-clock-history metric-icon"></i>
                <div>
                    <div class="card-title">Pending Subject Applications</div>
                    <div class="card-value"><?= $pendingCount ?: '—' ?></div>
                </div>
            </div>
        </a>

        <a href="#" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-bell metric-icon"></i>
                <div>
                    <div class="card-title">Pending Student Applications</div>
                    <div class="card-value"><span id="countNotifs">—</div>
                </div>
            </div>
        </a>
    </div>

    <div class="card-glass">
        <h5>Recent Activity</h5>
        <ul class="list-group list-group-flush activity-list mt-3" id="activityList"></ul>
    </div>
</main>

<?php
$this->stop();
?>