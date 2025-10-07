<?php
$this->layout('Layout', ['mainContent' => $this->fetch('Layout')]);
$this->start('mainContent');
$this->insert('Errors/Toasts');
?>

<!-- Add your content here to be displayed in the browser -->
<!-- Top Navigation -->

<!-- Main Content -->
<main class="main-content">
    <div class="mb-4">
        <h1 class="h2"><?= htmlspecialchars($subject['code']) ?></h1>
        <p class="text-light"><?= htmlspecialchars($subject['Description']) ?></p>
    </div>

    <!-- My Subjects (List Style) -->
    <div class="card-glass2 mb-4">
        <h5><i class="bi bi-journal-text"></i> STUDENT GRADE</h5>
        <hr>
        <h6><?= htmlspecialchars($student['name']) ?></h6>  
        <table class="table table-hover table-glass2 table-bordered">
            <thead>
                <tr>
                    <th class="text-white">Prelim</th>
                    <th class="text-white">Midterm</th>
                    <th class="text-white">Finals</th>
                </tr>
            </thead>
            <tbody>
                <td class="text-white"><?= htmlspecialchars($grade['prelim'] ?: '—') ?></td>
                <td class="text-white"><?= htmlspecialchars($grade['midterm'] ?: '—') ?></td>
                <td class="text-white"><?= htmlspecialchars($grade['finals'] ?: '—') ?></td>
            </tbody>
        </table>
        <?php if (empty($grade['prelim']) && empty($grade['midterm']) && empty($grade['finals'])): ?>
            <!-- Show Add Grade if no grades exist -->
            <button type="button" class="btn btn-sm btn-outline-light px-3" data-bs-toggle="modal" data-bs-target="#addFormModal">
                Add Grade
            </button>
        <?php else: ?>
            <!-- Show Edit Grade if grades already exist -->
            
            <button type="button" class="btn btn-sm btn-outline-light px-3" data-bs-toggle="modal" data-bs-target="#editFormModal">
                Edit Grade
            </button>
        <?php endif; ?>



    </div>
    <div class="return">
        <a href="/faculty-grading/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>"><i class="bi bi-backspace-fill"></i> Return to Previous</a>
    </div>


    <!-- edit form modal -->
    <div class="modal fade" id="editFormModal" tabindex="-1" aria-labelledby="editFormLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-success-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editFormLabel">Edit Student Grade</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>    
                </div>
                <form method="POST" action="/faculty-grading/GradeStudent/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>/<?= $student['user_id'] ?>/edit">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Prelim</label>
                            <input type="text" name="prelim" class="form-control" value="<?= htmlspecialchars($grade['prelim']) ?? ' ' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Midterm</label>
                            <input type="text" name="midterm" class="form-control" value="<?= htmlspecialchars($grade['midterm']) ?? ' ' ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Finals</label>
                            <input type="text" name="finals" class="form-control" value="<?= htmlspecialchars($grade['finals']) ?? ' ' ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success">Edit Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add form modal -->
    <div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-success-subtle">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="/faculty-grading/GradeStudent/<?= $faculty['user_id'] ?>/<?= $subject['code'] ?>/<?= $student['user_id'] ?>/add">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Prelim</label>
                            <input type="text" name="prelim" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Midterm</label>
                            <input type="text" name="midterm" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Finals</label>
                            <input type="text" name="finals" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-light">Add Grade</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
$this->stop();
?>