<?php
$this->layout('FacultyLayout', ['mainContent' => $this->fetch('FacultyLayout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->


<!-- Main Content -->
<main class="main-content">
    <h2>Faculty Dashboard</h2>
    <p class="text-light">Overview of your subjects, applications, and notifications.</p>

    <div class="row g-4 mb-4">
        <a href="/faculty-subjects/<?= $faculty['user_id'] ?>" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-journal-text metric-icon"></i>
                <div>
                    <div class="card-title">My Subjects</div>
                    <div class="card-value"><?= $acceptedCount ?: '—' ?></div>
                </div>
            </div>
        </a>
        <a href="/faculty-subjectsPendingApplication/<?= $faculty['user_id'] ?>" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-clock-history metric-icon"></i>
                <div>
                    <div class="card-title">Pending Subject Applications</div>
                    <div class="card-value"><?= $pendingCount ?: '—' ?></div>
                </div>
            </div>
        </a>

        <a href="#" class="col-md-4">
            <div class="card-glass">
                <i class="bi bi-bell metric-icon"></i>
                <div>
                    <div class="card-title">Pending Student Applications</div>
                    <div class="card-value"><span id="countNotifs">—</div>
                </div>
            </div>
        </a>
    </div>

    <div class="card-glass">
        <h5>Recent Activity</h5>
        <ul class="list-group list-group-flush activity-list mt-3" id="activityList"></ul>
    </div>
</main>

<?php
$this->stop();
?>