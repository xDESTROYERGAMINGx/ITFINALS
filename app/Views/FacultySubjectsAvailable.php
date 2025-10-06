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
    position: relative;
    min-height: 100vh;
    z-index: 0;
  }

  body::before {
    content: "";
    position: fixed;
    top: 0; left: 0; right: 0; bottom: 0;
    background: url('/img/bg.jpg') no-repeat center center/cover;
    filter: blur(10px) brightness(0.6);
    z-index: -1;
  }

  .navbar {
    background: rgba(0, 44, 89, 0.85) !important;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(74, 200, 224, 0.15);
    z-index: 1100;
  }

  .navbar .navbar-brand {
    color: #4ac8e0;
    font-weight: 600;
  }

  .navbar .nav-link,
  .navbar .navbar-text {
    color: #cde9fb !important;
  }

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
    z-index: 1020;
    display: none;
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
    position: relative;
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

  .table-glass {
    background: rgba(74, 200, 224, 0.1);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(74, 200, 224, 0.3);
    border-radius: 12px;
    overflow: hidden;
  }

  .table-glass thead {
    background: rgba(4, 66, 121, 0.8);
  }

  .table-glass thead th {
    color: #cde9fb;
    border: none;
    font-weight: 600;
  }

  .table-glass tbody tr:hover {
    background-color: rgba(74, 200, 224, 0.2);
    color: #ffffff;
  }

  .table-glass tbody td {
    border-top: 1px solid rgba(74, 200, 224, 0.2);
    color: #e0f0ff;
  }

  .btn-primary {
    background-color: #4ac8e0;
    border-color: #4ac8e0;
  }

  .btn-primary:hover {
    background-color: #3a9fbf;
    border-color: #3a9fbf;
  }

  .modal-content {
    background: rgba(4, 66, 121, 0.85);
    color: #cce5ff;
    backdrop-filter: blur(10px);
    border-radius: 12px;
  }

  .form-control {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid #4ac8e0;
    color: #e0f0ff;
  }

  .form-control:focus {
    background: rgba(74, 200, 224, 0.1);
    border-color: #3a9fbf;
    color: #fff;
    box-shadow: 0 0 8px #3a9fbf;
  }

  .profile-pic {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #4ac8e0;
  }

  #notifBadge {
    font-size: 0.7rem;
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
    <a href="/available-subjects/<?= $faculty['user_id'] ?>" class="active"><i class="bi bi-book"></i> Available Subjects</a>
    <a href="/faculty-subjects/<?= $faculty['user_id'] ?>"><i class="bi bi-person-lines-fill"></i> My Subjects</a>
    <a href="/profile"><i class="bi bi-person-circle"></i> Profile</a>
    <a href="#"><i class="bi bi-gear"></i> Settings</a>
    <a href="#"><i class="bi bi-box-arrow-right"></i> Logout</a>
</nav>

<!-- Offcanvas Sidebar -->
<div class="offcanvas offcanvas-start text-bg-dark" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileSidebarLabel">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body d-flex flex-column p-0">
        <a href="/" class="active px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-house"></i> Dashboard</a>
        <a href="/faculty-subjectsAvailable/<?= $faculty['user_id'] ?>"><i class="bi bi-book"></i> Available Subjects</a>
        <a href="/my_subjects" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill"></i> My Subjects</a>
        <a href="/profile" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-circle"></i> Profile</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-gear"></i> Settings</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<!-- Main Content -->
<main class="main-content">
    <div class="row mb-3">
        <div class="col-md-6">
            <h1 class="h2">Available Subjects</h1>
            <p class="text-light ">Subjects created by admin that you can apply to teach.</p>
        </div>
        <div class="col-md-6 text-end">
            <input type="text" id="searchInput" class="form-control form-control-sm" placeholder="Search subject...">
        </div>
    </div>

    <div class="table-responsive">

        <table class="table table-hover table-glass table-bordered">
            <thead>
                <tr>
                    <th class="text-black">Code</th>
                    <th class="text-black">Title</th>
                    <th class="text-black">Units</th>
                    <th class="text-black">Action</th>
                </tr>
            </thead>
            <?php foreach ($subjects as $subject): ?>
                <tbody>
                    <td class="text-black"><?= htmlspecialchars($subject['code']) ?></td>
                    <td class="text-black"><?= htmlspecialchars($subject['Description']) ?></td>
                    <td class="text-black"><?= htmlspecialchars($subject['Units']) ?></td>
                    <td><a href="/faculty-subjectApplication/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>">Apply</a></td>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>
</main>

<?php
$this->stop();
?>