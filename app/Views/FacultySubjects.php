<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>
<!-- Add your content here to be displayed in the browser -->

<!-- Main Content -->
<main class="main-content">
  <div class=" mb-4">
    <h1 class="h2">My Subjects</h1>
    <p class="text-light">Subjects assigned to you by the admin.</p>
  </div>

  <!-- My Subjects (List Style) -->
  <div class="card-glass2 mb-4">
    <h5><i class="bi bi-journal-text"></i> My Subjects</h5>
    <table class="table table-glass2 table-hover" id="students">
      <thead>
        <tr>
          <th class="text-white">Code</th>
          <th class="text-white">Title</th>
          <th class="text-white">Units</th>
          <th class="text-white">Action</th>
        </tr>
      </thead>
      <?php foreach ($subjects as $subject): ?>
        <tbody>
          <td class="text-white"><?= htmlspecialchars($subject['code']) ?></td>
          <td class="text-white"><?= htmlspecialchars($subject['Description']) ?></td>
          <td class="text-white"><?= htmlspecialchars($subject['Units']) ?></td>
          <td><a href="/faculty-grading/<?= $_SESSION['faculty_id'] ?>/<?= $subject['code'] ?>" class="btn btn-sm btn-outline-light px-3">View</a></td>
        </tbody>
      <?php endforeach; ?>
    </table>
  </div>

  <!-- Subject Applications -->
  <div class="return mt-4">
    <a href="/faculty-subjectsPendingApplication/<?= $_SESSION['faculty_id'] ?> "><i class="bi bi-clock-history"></i> View Pending Applications</a>
  </div>
</main>

<?php
$this->stop();
?>