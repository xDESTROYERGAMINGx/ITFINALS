<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Navbar -->


<!-- Main faculty Content -->
<main class="main-content p-4 mt-5">
  <h2 class="mt-3">Faculty Dashboard</h2>
  <p class="text-light">Overview of your subjects, applications, and notifications.</p>

  <div class=" card-glass2 p-4 mb-5">
    <div class="d-flex flex-column flex-md-row align-items-center gap-4">
      <img src="https://ui-avatars.com/api/?name=<?= $_SESSION['name'] ?>" alt="faculty Photo" class="rounded-circle"
        style="width: 100px; height: 100px; object-fit: cover;">

      <div class="flex-grow-1">
        <div class="d-flex justify-content-between align-items-start flex-wrap">
          <div>
            <h3 class="fw-bold mb-1"><?= $faculty['first_name'] ?> <?= $faculty['last_name'] ?></h3>
            <p class="text-light mb-0">Faculty ID: <?= $faculty['id_number'] ?></p>
            <p class="text-light mb-0">Email: <?= $faculty['email'] ?></p>
            <p class="text-light mb-0">Phone: <?= $faculty['phone_number'] ?></p>
          </div>

          <div class="text-end">
            <a href="#" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal"
              data-bs-target="#updatefacultyModal">
              Edit Profile
            </a>
            <br>
            <a type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
              Change Password
            </a>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-4">
    <h5><i class="bi bi-journals me-1"></i> MY SUBJECTS</h5>
    <div class="row text-center mt-4">
      <?php foreach ($subjects as $subject): ?>
        <div class="col-md-4 mb-3">
          <a href="/faculty-grading/<?= $subject['code']?>">
            <div class="rounded shadow-sm border border-secondary p-4 h-100">
              <h5 class="fw-bold"><?= $subject['code'] ?></h5>
              <h6 class="text-light"><?= $subject['Description'] ?></h6>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</main>

<!-- Edit faculty Modal -->
<div class="modal fade text-start" id="updatefacultyModal" tabindex="-1" aria-labelledby="editfacultyLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-primary-subtle">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editfacultyLabel">Edit faculty Details</h1>
        <a href="/faculty-profile" class="btn-close" aria-label="Close"></a>
      </div>
      <form method="POST" action="/faculty-profile/EditProfile">
        <div class="modal-body row">
          <div class="mb-3">
            <label>First Name</label>
            <input type="text" class="form-control" value="<?= $faculty['first_name'] ?>" name="firstName">
          </div>
          <div class="mb-3">
            <label>Last Name</label>
            <input type="text" class="form-control" value="<?= $faculty['last_name'] ?>" name="lastName">
          </div>
          <div class="mb-3">
            <label>Mobile Number</label>
            <input type="text" class="form-control" value="<?= $faculty['phone_number'] ?>" name="phoneNumber">
          </div>
        </div>
        <div class="modal-footer">
          <a href="/faculty-profile" class="btn btn-secondary">Close</a>
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
      <form method="POST" action="/faculty-profile/ChangePassword">
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