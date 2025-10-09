<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Main Content -->
<main class="main-content">
    <div class="mb-4 text-start">
        <h1 class="h2">My Students</h1>
        <p class="text-light"> My Students across classes.</p>
    </div>

    <!-- Subject Applications -->
    <div class="card-glass2">
        <!-- <div class="select">
            <label for="filterYear" style="color:white;">Select Year Level : </label>
            <select id="filterYear">
                <option value="">All Levels</option>
                <option value="1st Year">1st Year</option>
                <option value="2nd Year">2nd Year</option>
                <option value="3rd Year">3rd Year</option>
                <option value="4th Year">4th Year</option>
            </select>
        </div> -->
        <h5>MY STUDENTS </h5>
        <div>
            <hr>
            <table class="table table-glass2 table-hover text-center" id="table">
                <thead class="mt-5">
                    <tr>
                        <th class="text-white">Student ID</th>
                        <th class="text-white">Name</th>
                        <th class="text-white">Year Level</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $result): ?>
                        <tr>
                            <td class="text-white"><a href="/faculty-student/studentInformation/<?= $result['student_id'] ?>" class="d-block"><?= $result['student_id'] ?> </a></td>
                            <td class="text-white"><a href="/faculty-student/studentInformation/<?= $result['student_id'] ?>" class="d-block"><?= $result['student_lastname'] ?>, <?= $result['student_firstname'] ?> </a> </td>
                            <td class="text-white"><a href="/faculty-student/studentInformation/<?= $result['student_id'] ?>" class="d-block"><?= $result['year_level'] ?> </a></td>
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