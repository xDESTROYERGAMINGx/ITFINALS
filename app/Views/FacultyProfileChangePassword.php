<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Content -->
<main class="main-content text-center">

    <h2>Faculty Profile</h2>

    <!--Update Modal -->

    <div class="bg-primary-subtle">
        <div>
            <h1>Change Password</h1>
            <a href="/faculty-profile/<?= $faculty['user_id'] ?>"></a>
        </div>
        <form method="POST" action="/faculty-profile/<?= $profile['id_number'] ?>/ChangePassword">
            <div class="row">
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
                <div>
                    <button type="button" class="btn btn-secondary">Back</button>
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