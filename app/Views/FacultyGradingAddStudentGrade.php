<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->

<style>
    body {
        margin: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: #0d2a4e;
        color: #e0f0ff;
        overflow-x: hidden;
        min-height: 100vh;
        z-index: 0;
    }

    body::before {
        content: "";
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('/img/bg.jpg') no-repeat center center/cover;
        filter: blur(10px) brightness(0.6);
        z-index: -1;
    }

    /* Navbar */
    .navbar-blur {
        background: rgba(0, 44, 89, 0.85);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(74, 200, 224, 0.15);
    }

    .navbar-blur .navbar-brand {
        color: #4ac8e0;
        font-weight: 600;
    }

    .navbar-blur .nav-link,
    .navbar-blur .navbar-text {
        color: #cde9fb;
    }

    .profile-pic {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #4ac8e0;
    }

    /* Sidebar */
    .sidebar {
        background: rgba(4, 66, 121, 0.75);
        backdrop-filter: blur(12px);
        height: 100vh;
        width: 240px;
        position: fixed;
        top: 56px;
        left: 0;
        padding-top: 1rem;
        border-right: 1px solid rgba(74, 200, 224, 0.15);
        display: flex;
        flex-direction: column;
    }

    .sidebar a {
        color: #a6d1f7;
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-weight: 500;
    }

    .sidebar a:hover,
    .sidebar a.active {
        background-color: rgba(74, 200, 224, 0.25);
        border-left: 4px solid #4ac8e0;
        padding-left: 16px;
        color: #d1f0ff;
    }

    .main-content {
        margin-left: 240px;
        padding: 90px 30px 30px;
        z-index: 1;
    }

    @media (max-width: 991.98px) {
        .sidebar {
            display: none !important;
        }

        .main-content {
            margin-left: 0;
            padding: 90px 15px 20px;
        }
    }

    .card-glass input,
    .card-glass button {
        background: rgba(31, 231, 111, 0.05);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #d8e5f1ff;
    }

    .card-glass tbody tr:hover {
        background-color: rgba(237, 196, 10, 0.84)
    }

    /* Glass Card */
    .card-glass {
        background: rgba(74, 200, 224, 0.15);
        border: 1px solid rgba(74, 200, 224, 0.3);
        backdrop-filter: blur(14px);
        border-radius: 20px;
        padding: 20px;
        color: #e0f0ff;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    }

    /* List Group Items */
    .list-group-item {
        background: transparent;
        border-color: rgba(74, 200, 224, 0.25);
        color: #e0f0ff;
    }

    /* return a */
    .return a {
        color: #d1f0ff;
        padding: 12px 20px;
        gap: 10px;
        text-decoration: none;
        font-weight: 500;
        background-color: rgba(74, 200, 224, 0.25);
        border: 1px solid rgba(74, 200, 224, 0.3);
        border-radius: 10px ;
    }
    .return a:hover {
        background-color: rgba(5, 175, 62, 0.1);
    }
</style>


<!-- Top Navigation -->
<nav class="navbar navbar-expand-lg navbar-blur fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="#">
            <i class="bi bi-building"></i>
            Christ the King College
        </a>

        <!-- Toggle Button for Offcanvas -->
        <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="navbar-text d-none d-md-block"><?= $faculty['name'] ?></span>

            <!-- Notifications Dropdown -->
            <div class="dropdown">
                <a href="#" class="text-light position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge">2</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2" aria-labelledby="notifDropdown" style="min-width: 320px;">
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
    <a href="/faculty-dashboard/<?= $faculty['user_id'] ?>"><i class="bi bi-house"></i> Dashboard</a>
    <a href="/faculty-subjectsAvailable/<?= $faculty['user_id'] ?>"><i class="bi bi-book"></i> Available Subjects</a>
    <a href="/faculty-subjects/<?= $faculty['user_id'] ?>"><i class="bi bi-person-lines-fill"></i> My Subjects</a>
    <a href="#" class="active"><i class="bi bi-book"></i> Add Grade</a>
    <hr>

</nav>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-0">
        <a href="/" class="active px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-house"></i> Dashboard</a>
        <a href="/subjects_available" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-book"></i> Available Subjects</a>
        <a href="/my_subjects" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill"></i> My Subjects</a>
        <a href="/profile" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-circle"></i> Profile</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-gear"></i> Settings</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<!-- Main Content -->
<main class="main-content">
    <div class="card-glass mb-4">
        <h1 class="h4"><?= htmlspecialchars($subject['code']) ?></h1>
        <p class="text-light"><?= htmlspecialchars($subject['Description']) ?></p>
    </div>

    <!-- My Subjects (List Style) -->
    <div class="card-glass mb-4">
        <h5><i class="bi bi-journal-text"></i> ADD GRADE</h5>
        <hr>
        <h6><?= htmlspecialchars($student['name']) ?></h6>
        <form action="/faculty-grading/AddStudentGrade/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>/<?= $student['user_id'] ?>/add" method="POST">
            <div class="row">
                <div class="col-3 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Prelim</label>
                    <input type="text" name="prelim" class="form-control">
                </div>
                <div class="col-3 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Midterm</label>
                    <input type="text" name="midterm" class="form-control">
                </div>
                <div class="col-3 mb-3">
                    <label for="exampleInputEmail1" class="form-label">Finals</label>
                    <input type="text" name="finals" class="form-control">
                </div>
                <div class="col-3 mb-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-light">Submit</button>
                </div>

            </div>
        </form>
    </div>
    <div class="return">
        <a href="/faculty-grading/ViewStudent/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>/<?= $student['user_id'] ?> "><i class="bi bi-backspace-fill"></i> Return to Previous</a>
    </div>
</main>

<?php
$this->stop();
?>