<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Navbar -->


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
          </div>

          <div class="text-end">
            <a href="#" class="btn btn-outline-primary btn-sm mb-2 text-light" data-bs-toggle="modal"
              data-bs-target="#updateProfileModal">
              Edit Profile
            </a>
            <br>
            <a type="button" class="text-decoration-underline" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              Change Password
            </a>
            <!-- <a href="/faculty-profile/<?= $profile['id_number'] ?>/ChangePassword" class="btn btn-link text-decoration-none text-light">Change Password</a> -->
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

<div class="modal fade text-start" id="changePasswordModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-primary-subtle">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Change Password</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" name="confirmPassword">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>


<?php $this->stop(); ?>