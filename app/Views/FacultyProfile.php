<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
?>

<!-- Navbar -->
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
      <span class="navbar-text d-none d-md-block">jatis@ckcgingoog.edu.ph</span>

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

<!-- Main Profile Content -->
<main class="main-content p-4 mt-5">
  <h2>Faculty Dashboard</h2>
  <p class="text-light">Overview of your subjects, applications, and notifications.</p>
  <div class="container card-glass2 p-4 mb-5">
    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
      <img src="/img/juswa.jpg" alt="Profile Photo" class="rounded-circle"
        style="width: 100px; height: 100px; object-fit: cover;">

      <div class="flex-grow-1">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
          <div>
            <h3 class="fw-bold mb-1"><?= $profile['first_name'] ?> <?= $profile['last_name'] ?></h3>
            <p class="text-light mb-0">Faculty ID: <?= $profile['id_number'] ?></p>
            <p class="text-light mb-0">Email: <?= $profile['email'] ?></p>
            <p class="text-light mb-0">Phone: <?= $profile['phone_number'] ?></p>
            <p class="text-light mb-0">Pass: <?= $profile['password'] ?></p>
          </div>

          <div class="text-end">
            <a href="#" class="btn btn-outline-primary btn-sm mb-2 text-light" data-bs-toggle="modal"
              data-bs-target="#updateProfileModal">
              Edit Profile
            </a>
            <br>
            <a href="#" class="btn btn-link text-decoration-none text-light" data-bs-toggle="modal"
              data-bs-target="#changePasswordModal">Change Password</a>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-4">

    <div class="row text-center">
      <div class="col-md-6 mb-3">
        <div class="bg-white rounded shadow-sm p-4 h-100">
          <h6 class="text-light">Department</h6>
          <h5 class="fw-bold">Faculty</h5>
        </div>
      </div>
      <div class="col-md-6 mb-3">
        <div class="bg-white rounded shadow-sm p-4 h-100">
          <h6 class="text-light">Gender</h6>
          <h5 class="fw-bold"><?= $profile['gender'] ?></h5>
        </div>
      </div>
    </div>
  </div>
</main>

<!-- Edit Profile Modal -->
<div class="modal fade text-start" id="updateProfileModal" tabindex="-1" aria-labelledby="editProfileLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-primary-subtle">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editProfileLabel">Edit Profile Details</h1>
        <a href="/faculty-profile/<?= $faculty['user_id'] ?>" class="btn-close" aria-label="Close"></a>
      </div>
      <form method="POST" action="/faculty-profile/<?= $profile['id_number'] ?>/EditProfile">
        <div class="modal-body row">
          <div class="mb-3">
            <label>First Name</label>
            <input type="text" class="form-control" value="<?= $profile['first_name'] ?>" name="firstName">
          </div>
          <div class="mb-3">
            <label>Last Name</label>
            <input type="text" class="form-control" value="<?= $profile['last_name'] ?>" name="lastName">
          </div>
          <div class="mb-3">
            <label>Mobile Number</label>
            <input type="text" class="form-control" value="<?= $profile['phone_number'] ?>" name="phoneNumber">
          </div>
        </div>
        <div class="modal-footer">
          <a href="/faculty-profile/<?= $faculty['user_id'] ?>" class="btn btn-secondary">Close</a>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade text-start" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-primary-subtle">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="changePasswordLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="/faculty-profile/<?= $profile['id_number'] ?>/ChangePassword">
        <div class="modal-body row">
          <div class="mb-3">
            <label for="currentPassword">Enter Password</label>
            <input type="password" class="form-control" id="currentPassword" name="password"
              placeholder="Enter current password">
          </div>
          <!-- <hr>
          <div class="mb-3">
            <label for="newPassword">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password">
          </div>
          <div class="mb-3">
            <label for="confirmPassword">Retype New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password">
          </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php $this->stop(); ?>