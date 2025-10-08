<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
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
        <hr>
        <table class="table table-hover table2 text-center">
            <thead>
                <tr>
                    <th class="text-white">Student ID</th>
                    <th class="text-white">Name</th>
                    <th class="text-white">Year Level</th>
                    <th class="text-white">Action</th>
                </tr>
            </thead>
            <?php foreach ($students as $student): ?>
                <tbody>
                    <td class="text-white"><?= htmlspecialchars($student['student_id']) ?></td>
                    <td class="text-white"><?= htmlspecialchars($student['first_name']) ?> <?= htmlspecialchars($student['last_name']) ?></td>
                    <td class="text-white"><?= htmlspecialchars($student['year_level']) ?></td>
                    <td class="text-center"><a href="/faculty-grading/GradeStudent/<?= $_SESSION['faculty_id'] ?>/<?= $subject['code'] ?>/<?= $student['student_id'] ?>" class=" btn btn-warning btn-sm">
                            Input Student Grade 
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