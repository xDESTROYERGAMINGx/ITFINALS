<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
?>

<style>
  body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #0d2a4e;
    color: #e0f0ff;
    overflow-x: hidden;
    min-height: 100vh;
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
    text-align: center;
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

  .form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(74, 200, 224, 0.3);
    color: #fff;
  }

  .form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: #4ac8e0;
    box-shadow: 0 0 0 0.25rem rgba(74, 200, 224, 0.25);
    color: #fff;
  }

  label {
    color: #b2d4ec;
    font-weight: 500;
  }

  .teacher-card {
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(74, 200, 224, 0.3);
    backdrop-filter: blur(18px);
    border-radius: 20px;
    padding: 30px;
    color: #fff;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    max-width: 800px;
    margin: 40px auto;
  }

  .teacher-card img {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 3px solid #4ac8e0;
    margin-bottom: 15px;
  }

  .info-title {
    color: #75e3a4;
    font-weight: 600;
  }

  .about-tab {
    font-weight: 600;
    color: #4ac8e0;
    text-transform: uppercase;
    margin-bottom: 20px;
  }
</style>
</head>

<body>

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
  <main class="main-content">

    <h2>Teacher Details</h2>
    <p class="text-light">Dashboard / Teacher Details</p>

    <div class="teacher-card">
      <img src="/img/juswa.jpg" alt="Teacher Photo">

      <h4><?= $profile['first_name'] ?> <?= $profile['last_name'] ?></h4>
      <div class="about-tab">About</div>

      <div class="row text-start">
        <div class="col-md-6">
          <p><span class="info-title">First Name:</span> <?= $profile['first_name']?></p>
          <p><span class="info-title">Last Name:</span> <?= $profile['last_name']?></p>
          <p><span class="info-title">Gender:</span> <?= $profile['gender']?></p>
          <p><span class="info-title">Email:</span> <?= $profile['email']?></p>
          <p><span class="info-title">Mobile Number:</span> <?= $profile['phone_number']?></p>
          <p><span class="info-title">ID Number:</span> <?= $profile['id_number']?></p>

        </div>

      </div>
    </div>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
      Edit Profile Details
    </button>


    <!--Update Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content bg-primary-subtle">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile Details</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form id="profileForm">
            <div class="modal-body">
              <div class="mb-3">
                <label for="fullName">First Name</label>
                <input type="text" class="form-control" id="fullName">
              </div>
              <div class="mb-3">
                <label for="fullName">Last Name</label>
                <input type="text" class="form-control" id="fullName">
              </div>
              <div class="mb-3">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email">
              </div>
              <hr>
              <div class="mb-3">
                <label for="password">New Password</label>
                <input type="password" class="form-control" id="password" placeholder="Enter new password">
              </div>
              <div class="mb-3">
                <label for="confirmPassword">Confirm Password</label>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password">
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>
  <?php
  $this->stop();
  ?>