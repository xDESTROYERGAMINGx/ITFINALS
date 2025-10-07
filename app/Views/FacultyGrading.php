<?php
$this->layout('FacultyLayout', ['mainContent' => $this->fetch('FacultyLayout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->

<!-- Main Content -->
<main class="main-content">
    <div class=" mb-4">
        <h1 class="h2"><?= htmlspecialchars($subject['code']) ?></h1>
        <p class="text-light"><?= htmlspecialchars($subject['Description']) ?></p>
    </div>
    <!-- My Subjects (List Style) -->
    <div class="card-glass2 mb-4">
        <h5><i class="bi bi-journal-text"></i> STUDENTS</h5>
        <table class="table table-hover table-glass2 table-bordered">
            <thead>
                <tr>
                    <th class="text-white">Student ID</th>
                    <th class="text-white">Name</th>
                    <th class="text-white">Action</th>
                </tr>
            </thead>
            <?php foreach ($students as $student): ?>
                <tbody>
                    <td class="text-white"><?= htmlspecialchars($student['user_id']) ?></td>
                    <td class="text-white"><?= htmlspecialchars($student['name']) ?></td>
                    <td><a href="/faculty-grading/GradeStudent/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>/<?= $student['user_id'] ?>" class="btn btn-sm btn-outline-light px-3">
                            View Grade
                        </a>
                    </td>
                </tbody>
            <?php endforeach; ?>
        </table>
    </div>

    <!-- Student Applications -->
    <div class="card-glass2">
        <h5><i class="bi bi-person-check"></i> Student Applications</h5>
        <ul class="list-group list-group-flush mt-3" id="applicationsList"></ul>
    </div>
</main>

<?php
$this->stop();
?>