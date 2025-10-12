<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\AddSubjectModel;

class AddSubjectController
{
    private $AddSubjectModel;

    public function __construct()
    {
        $db = new DBConnection();
        $this->AddSubjectModel = new AddSubjectModel($db);
    }

    public function addsubject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $subject_code = $_POST['subject_code'] ?? '';
            $subject_name = $_POST['subject_name'] ?? '';
            $year_level = $_POST['year_level'] ?? '';
            $semester = $_POST['semester'] ?? '';
            $credit_units = $_POST['credit_units'] ?? '';

            if (empty($subject_code) || empty($subject_name) || empty($year_level) || empty($semester) || empty($credit_units)) {
                return ["success" => false, "message" => "All fields are required."];
            }
        }
        $result = $this->AddSubjectModel->addSubject($subject_code, $subject_name, $year_level, $semester, $credit_units);

        if ($result) {

            header("Location: /ViewSubjects");
            exit;
        }
        return "Error adding subject.";
    }


    // not fixed

    public function showSubjectForm($id)
    {
        $subjects = $this->AddSubjectModel->getSubjectById($id);
        echo $GLOBALS['templates']->render('Admin/UpdateSubjectView', ['subjects' => $subjects]);
    }

    public function readSubject()
    {
        $subjects = $this->AddSubjectModel->getAllSubject();
        echo $GLOBALS['templates']->render('Admin/ViewSubjects', ['subjects' => $subjects]);
    }




    // not

    public function updateSubject($id)
    {
        $subject_code = $_POST['subject_code'] ?? '';
        $subject_name = $_POST['subject_name'] ?? '';
        $year_level = $_POST['year_level'] ?? '';
        $semester = $_POST['semester'] ?? '';
        $credit_units = $_POST['credit_units'] ?? '';

        if (empty($subject_code) || empty($subject_name) || empty($year_level) || empty($semester) || empty($credit_units)) {
            return ["success" => false, "message" => "All fields are required."];
        }

        $result = $this->AddSubjectModel->updateSubject($id, $subject_code, $subject_name, $year_level, $semester, $credit_units);

        if ($result) {
            header("Location: /ViewSubjects");
            exit;
        }

        return "Error updating subject.";
    }

    // public function submitForVerification()
    // {
    //     $subjectId = $_GET['id'] ?? null;
    //     if ($subjectId) {
    //         $this->AddSubjectModel->addPendingSubject($subjectId);
    //     }

    //     header('Location: /ViewSubjects');
    //     exit;
    // }







    // Add your custom controllers below to handle business logic.
}
