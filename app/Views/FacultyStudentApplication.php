<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
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
        <div class="m-3 table-responsive">
            <table class="table table-glass2 table-hover text-center" id="students">
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
                    <?php foreach($results as $result):?>
                        <tr>
                        <td><?= $result['student_id'] ?></td>
                        <td><?= $result['first_name'] ?> <?= $result['last_name'] ?></td>
                        <td><?= $result['code'] ?></td>
                        <td><?= $result['Description'] ?></td>
                        <td><a href="">Confirm</a> | <a href="">Reject</a></td>

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
