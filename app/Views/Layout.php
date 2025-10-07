<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($_ENV['APP_DESCRIPTION'] ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($_ENV['APP_KEYWORDS'] ?? '') ?>">
    <meta name="author" content="<?= htmlspecialchars($_ENV['APP_AUTHOR'] ?? '') ?>">

    <link rel="shortcut icon" href="<?= htmlspecialchars($_ENV['APP_ICON'] ?? '') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/style.css">

    <title><?= isset($title) && !empty($title) ? $this->e($title) : htmlspecialchars($_ENV['APP_NAME'] ?? '') ?></title>
</head>

<body>
    <?php session_start(); ?>
    <nav class="navbar navbar-expand-lg navbar-blur fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center gap-2" href="#">
                <img src="/img/logo.png" alt="logo" class="logo">
                CKC information Technology
            </a>

            <!-- Mobile Sidebar Toggle -->
            <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileSidebar">
                <i class="bi bi-list fs-4"></i>
            </button>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="navbar-text d-none d-md-block"><?=$_SESSION['name']?></span>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn btn-transparent position-relative dropdown-toggle p-0" type="button" id="notifDropdown"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-bell fs-5 text-light"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="notifBadge">1</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2 mt-2" aria-labelledby="notifDropdown"
                        style="min-width: 320px;">
                        <li class="dropdown-item d-flex justify-content-between align-items-start">
                            <div>
                                <small class="fw-bold">System</small><br>
                                <span>Your password was recently updated.</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <img src="/img/juswa.jpg" class="profile-pic rounded-circle" alt="Prof. Atis"
                    style="width: 40px; height: 40px; object-fit: cover;" />
            </div>
        </div>
    </nav>

    <!-- Sidebar (Desktop) -->
    <nav class="sidebar d-none d-lg-flex flex-column">
        <a href="/faculty-dashboard/<?= $_SESSION['faculty_id'] ?>"><i class="bi bi-house"></i> Dashboard</a>
        <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample" class="d-flex justify-content-between align-items-center"><span><i class="bi bi-journals me-1"></i> Subjects </span> <i class="bi bi-caret-down-fill small"></i></a>
        <div class="collapse ms-3" id="collapseExample">
            <a href="/faculty-subjects/<?= $_SESSION['faculty_id'] ?>"><i class="bi bi-person-lines-fill"></i> My Subjects</a>
            <a href="/faculty-subjectsAvailable/<?= $_SESSION['faculty_id'] ?>"><i class="bi bi-book"></i> Available Subjects</a>
            <a href="/faculty-subjectsPendingApplication/<?= $_SESSION['faculty_id'] ?> "><i class="bi bi-clock-history"></i>Pending Subjects</a>

        </div>
        <a href="/faculty-profile/<?= $_SESSION['faculty_id'] ?>"><i class="bi bi-person-circle"></i> Profile</a>
        <a href="#"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>

    <!-- Offcanvas Sidebar (Mobile) -->
    <div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Menu</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column p-0">
            <a href="/" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-house"></i> Dashboard</a>
            <a href="/subjects_available" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-book"></i> Available
                Subjects</a>
            <a href="/my_subjects" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill"></i> My
                Subjects</a>
            <a href="/profile" class="active px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-circle"></i>
                Profile</a>
            <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-gear"></i> Settings</a>
            <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </div>
    </div>


    <main>
        <?= $this->section('mainContent') ?>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?= assets("js/Toasts.js") ?>"></script>

</body>

</html>