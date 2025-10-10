<?php
$this->layout('Faculty/Layout', ['mainContent' => $this->fetch('Faculty/Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Main Content -->
<main class="main-content">
    <div class="mb-4 text-start">
        <h1 class="h2">Pending Student Application</h1>
        <p class="text-light"> My Students across classes.</p>
    </div>

    <!-- Subject Applications -->
    <div class="card-glass2">
        <h1 class="h4">Pending Student Application</h1>
        <hr>
        <div class="table-responsive">
            <table class="table table-glass2 table-hover text-center" id="table">
                <thead class="mt-5">
                    <tr>
                        <th class="text-white">Student ID</th>
                        <th class="text-white">Name</th>
                        <th class="text-white">Subject Code</th>
                        <th class="text-white">Subject Description</th>
                        <th class="text-white">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?= $result['student_id'] ?></td>
                            <td><?= $result['first_name'] ?> <?= $result['last_name'] ?></td>
                            <td><?= $result['code'] ?></td>
                            <td><?= $result['Description'] ?></td>
                            <td><a href="/faculty-student/studentApplication/<?= $result['code'] ?>/<?= $result['student_id'] ?>/confirm" class="btn btn-warning btn-sm me-2">Confirm</a> <a href="/faculty-student/studentApplication/<?= $result['code']?>/<?= $result['student_id']?>/reject" class="btn btn-danger btn-sm ms-2">Reject</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<?php
$this->stop();
?>