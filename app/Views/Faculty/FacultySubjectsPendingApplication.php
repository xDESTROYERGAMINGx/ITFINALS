<?php
$this->layout('Faculty/Layout', ['mainContent' => $this->fetch('Faculty/Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->

<!-- Main Content -->
<main class="main-content">
    <div class="mb-4">
        <h1 class="h2">My Subjects - Pending</h1>
        <p class="text-light">Subjects assigned to you by the admin.</p>
    </div>

    <!-- Subject Applications -->
    <div class="card-glass2">
        <h5><i class="bi bi-hourglass"></i> Pending Applications</h5>
        <hr>
        <table class="table table2 text-center" id="table">
            <thead>
                <tr>
                    <th class="text-white">Code</th>
                    <th class="text-white">Title</th>
                    <th class="text-white">Units</th>
                    <th class="text-white">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pendingSubjects as $subject): ?>
                    <tr>
                        <td class="text-white"><?= htmlspecialchars($subject['code']) ?></td>
                        <td class="text-white"><?= htmlspecialchars($subject['Description']) ?></td>
                        <td class="text-white"><?= htmlspecialchars($subject['Units']) ?></td>
                        <td>Waiting Admin Confirmation...</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="return mt-4">
        <a href="/faculty-subjects"><i class="bi bi-person-lines-fill"></i> View Subjects</a>
    </div>
</main>

<?php
$this->stop();
?>