<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\SubjectVerificationModel;

class SubjectVerificationController
{
    private $SubjectVerificationModel;

    public function __construct()
    {
        $db = new DBConnection();
        $this->SubjectVerificationModel = new SubjectVerificationModel($db);
    }

    // ✅ This method fixes your Router error and shows example data
    public function showPage()
    {
        // Try to get subjects from the model if methods exist
        if (method_exists($this->SubjectVerificationModel, 'getPendingSubjects') && method_exists($this->SubjectVerificationModel, 'getVerifiedSubjects')) {
            $pending = $this->SubjectVerificationModel->getPendingSubjects();
            $verified = $this->SubjectVerificationModel->getVerifiedSubjects();
        }

        // ✅ Render the view
        echo template()->render('Admin/SubjectVerificationView', [
            'pendingSubjects' => $pending,
            'verifiedSubjects' => $verified,
        ]);
    }

    // ✅ Handles approve/reject actions
    public function handleAction()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $action = $_POST['action'] ?? null;

            if ($id && $action) {
                if ($action === 'approve') {
                    $this->SubjectVerificationModel->approveSubject($id);
                } elseif ($action === 'reject') {
                    $this->SubjectVerificationModel->rejectSubject($id);
                }
            }
        }

        // Redirect back to main verification page
        header('Location: /SubjectVerificationView');
        exit;
    }

    public function submitForVerification()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subjectId = $_POST['subject_id'] ?? null;
            $facultyId = $_POST['faculty_id'] ?? 1; // test with static faculty if needed

            if ($subjectId) {
                $this->SubjectVerificationModel->addPendingSubject($subjectId, $facultyId);
            }
        }

        header('Location: /subject-verification');
        exit;
    }
}
