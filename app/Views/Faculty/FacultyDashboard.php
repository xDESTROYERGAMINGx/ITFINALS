<?php
$this->layout('Faculty/Layout', ['mainContent' => $this->fetch('Faculty/Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->


<!-- Main Content -->
<main class="main-content">
    <h2>Faculty Dashboard</h2>
    <p class="text-light">Overview of your subjects, applications, and notifications.</p>

    <div class="row g-4 mb-4">
        <a href="/faculty-subjects" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-journal-text metric-icon"></i>
                <div>
                    <div class="card-title">My Subjects</div>
                    <div class="card-value"><?= $acceptedCount ?: '—' ?></div>
                </div>
            </div>
        </a>
        <a href="/faculty-subject/PendingApplication" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-clock-history metric-icon"></i>
                <div>
                    <div class="card-title">Pending Subject Applications</div>
                    <div class="card-value"><?= $pendingCount ?: '—' ?></div>
                </div>
            </div>
        </a>

        <a href="/faculty-student/studentApplication" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-bell metric-icon"></i>
                <div>
                    <div class="card-title">Pending Student Applications</div>
                    <div class="card-value"><?= $studentPending ?: '—' ?></div>
                </div>
            </div>
        </a>
    </div>

    <div class="card-glass">
        <h5><i class="bi bi-journals me-1"></i> MY SUBJECTS</h5>
        <hr class="my-4">
        <div class="row text-center mt-4">
                <?php $subjects = $subjects ?? []; ?>
                <?php foreach ($subjects as $subject): ?>
                <div class="col-md-4 mb-3">
                    <a href="/faculty-dashboard/<?= $subject['code'] ?>">
                        <div class="rounded shadow-sm border border-secondary p-4 h-100">
                            <h5 class="fw-bold"><?= $subject['code'] ?></h5>
                            <h6 class="text-light"><?= $subject['Description'] ?></h6>
                            <h5>total of students</h5>
                            <h5>96</h5>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>

<?php
$this->stop();
?>