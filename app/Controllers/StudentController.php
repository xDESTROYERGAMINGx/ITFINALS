<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\StudentModel;

class StudentController
{
    private $StudentModel;

    public function __construct()
    {
        $db = new DBConnection();
        $this->StudentModel = new StudentModel($db);
    }

    // Add your custom controllers below to handle business logic.
    public function login()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $login_type = $_POST['login_type']; // new login type selector
            $studentId = trim($_POST['studentId']);

            $student = $this->StudentModel->login($studentId);

            if ($student) {
                $_SESSION['student_id'] = $student['student_id'];
                $_SESSION['student_name'] = $student['first_name'] . ' ' . $student['last_name'];
                $_SESSION['type'] = $login_type;
                // $_SESSION['student_email'] = $student['email'];

                if ($login_type === 'student') {
                    header("Location: /student-dashboard");
                    exit;
                } elseif ($login_type === 'parent') {
                    header("Location: /parent-dashboard");
                    exit;
                }
            }
        }
    }

    // ================================================ JOIN CLASS CONTROLLER ================================================ //
    public function availableClass()
    {
        $subjects = $this->StudentModel->getAvailableClass($_SESSION['student_id']);
        $pendingClass = $this->StudentModel->getPendingClass($_SESSION['student_id']);
        echo $GLOBALS['templates']->render('Student/JoinClass', ['subject' => $subjects, 'pending' => $pendingClass]);
    }
    public function joinClass($subjectCode)
    {
        $joinClass = $this->StudentModel->submitJoinClass($subjectCode, $_SESSION['student_id']);
        if ($joinClass) {
            $_SESSION['success'][] = "Successfully Applied for Class!";
            header("Location:/joinClassView");
            exit;
        } else {
            $_SESSION['danger'][] = "Application Unsuccessfull!";
        }
    }

    // ================================================ STUDENT SUBJECT CONTROLLER ================================================ //
    public function getStudentSubjects()
    {
        $mySubjects = $this->StudentModel->getStudentSubjectsById($_SESSION['student_id']);
        echo $GLOBALS['templates']->render('Student/MySubjects', ['subjects' => $mySubjects]);
    }

    // ================================================ STUDENT SUBJECT CONTROLLER ================================================ //
    public function getStudentGrades()
    {
        $grades = $this->StudentModel->getAllGrades($_SESSION['student_id']);
        echo $GLOBALS['templates']->render('Student/ViewGrade', ['grades' => $grades]);
    }
    public function getSubjectGrades($subjectCode)
    {
        $grades = $this->StudentModel->getGradeById($_SESSION['student_id'], $subjectCode);
        echo $GLOBALS['templates']->render('Student/ViewSubjectGrade', ['grade' => $grades]);
    }
    public function getGradeSummary()
    {
        $grades = $this->StudentModel->getAllGrades($_SESSION['student_id']);
        $student = $this->StudentModel->studentInfo($_SESSION['student_id']);
        echo $GLOBALS['templates']->render('ParentDashboard', ['grades' => $grades, 'student' => $student]);
    }

    // ================================================ STUDENT SUBJECT CONTROLLER ================================================ //
    public function getStudentInfo()
    {
        $student = $this->StudentModel->studentInfo($_SESSION['student_id']);
        echo $GLOBALS['templates']->render('Student/ManageAccount', ['student' => $student]);
    }
}
