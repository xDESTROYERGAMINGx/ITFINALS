<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->

<!-- Main Content -->
<main class="main-content">
  <div class="row mb-3">
    <div class="col-md-6">
      <h1 class="h2">Available Subjects</h1>
      <p class="text-light ">Subjects created by admin that you can apply to teach.</p>
    </div>
  </div>

  <div class="card-glass2 mb-4">
    <h5><i class="bi bi-journal-text"></i> Available Subjects</h5>
    <hr>
    <table class="table table-hover text-center table2" id="table" >
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
          <td><a href="/faculty-subjectApplication/<?= $subject['code'] ?>" class="btn btn-warning btn-sm">Apply</a></td>
        </tbody>
      <?php endforeach; ?>
    </table>
  </div>

  </div>
</main>

<?php
$this->stop();
?>