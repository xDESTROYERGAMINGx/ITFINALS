<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-blur fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <i class="bi bi-building"></i>
            Christ the King College
        </a>

        <!-- Mobile Sidebar Toggle -->
        <button class="btn btn-outline-light d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="ms-auto d-flex align-items-center gap-3">
            <span class="navbar-text d-none d-md-block">jatis@ckcgingoog.edu.ph</span>

            <!-- Notifications -->
            <div class="dropdown">
                <button class="btn btn-transparent position-relative dropdown-toggle p-0" type="button" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell fs-5 text-light"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notifBadge">1</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-lg p-2 mt-2" aria-labelledby="notifDropdown" style="min-width: 320px;">
                    <li class="dropdown-item d-flex justify-content-between align-items-start">
                        <div>
                            <small class="fw-bold">System</small><br>
                            <span>Your password was recently updated.</span>
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
    <a href="/faculty-profile/<?= $faculty['user_id'] ?>" class="active"><i class="bi bi-person-circle"></i> Profile</a>
    <a href="#"><i class="bi bi-gear"></i> Settings</a>
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
        <a href="/subjects_available" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-book"></i> Available Subjects</a>
        <a href="/my_subjects" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-lines-fill"></i> My Subjects</a>
        <a href="/profile" class="active px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-person-circle"></i> Profile</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-gear"></i> Settings</a>
        <a href="#" class="px-3 py-2 d-flex align-items-center gap-2"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<!-- Content -->
<main class="main-content text-center">

    <h2>Faculty Profile</h2>

    <!--Update Modal -->

    <div class="bg-primary-subtle">
        <div>
            <h1>Edit Profile Details</h1>
            <a href="/faculty-profile/<?= $faculty['user_id'] ?>"></a>
        </div>
        <form method="POST" action="/faculty-profile/<?= $profile['id_number'] ?>/ChangePassword">
            <div class="modal-body row">
                <div class="mb-3">
                    <label for="password">Enter Current Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter new password" name="currentPassword">
                </div>
                <hr>
                <div class="mb-3">
                    <label for="password">New Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter new password" name="newPassword">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword">Retype New Password</label>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" name="passwordConfirmation">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>


</main>

<script>
    const passbtn = document.getElementById('toggleButton');
    passbtn.addEventListener('click', function() {
        passbtn.style.display = 'none';
    });
</script>
<?php
$this->stop();
?>