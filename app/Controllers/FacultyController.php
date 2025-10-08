<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\FacultyModel;

class FacultyController
{
    private $FacultyModel;

    public function __construct()
    {
        $db = new DBConnection();
        $this->FacultyModel = new FacultyModel($db);
    }


    // login controller
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $facultyId = $_POST['facultyId'] ?? '';
            $password = $_POST['password'] ?? '';

            $faculty = $this->FacultyModel->getFacultyProfile($facultyId);

            if ($faculty && password_verify($password, $faculty['password'])) {
                $_SESSION['faculty_id'] = $faculty['id_number'];
                $_SESSION['name'] = $faculty['first_name'] . " " . $faculty['last_name'];

                header("Location:/faculty-dashboard/$facultyId");
            } else {
                echo $GLOBALS['templates']->render('login', ['error' => 'Invalid username or password']);
            }
        }
    }

    //dashboard controller
    public function dashboard($facultyId)
    {
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);
        $acceptedCount = $this->FacultyModel->countFacultySubjects($facultyId);
        $pendingCount = $this->FacultyModel->countFacultySubjectsPendingApplication($facultyId);
        echo $GLOBALS['templates']->render('FacultyDashboard', [
            'faculty' => $faculty,
            'acceptedCount' => $acceptedCount,
            'pendingCount' => $pendingCount
        ]);
    }
    public function facultyProfile($facultyId)
    {
        $profile = $this->FacultyModel->getFacultyProfile($facultyId);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);
        echo $GLOBALS['templates']->render('facultyProfile', ['profile' => $profile, 'faculty' => $faculty]);
    }

    //subjects controller
    public function availableSubjects($facultyId)
    {
        $subjects = $this->FacultyModel->getAvailableSubjects();
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);
        echo $GLOBALS['templates']->render('FacultySubjectsAvailable', [
            'subjects' => $subjects,
            'faculty' => $faculty
        ]);
    }
    public function facultySubjects($facultyId)
    {
        $subjects = $this->FacultyModel->getFacultySubjects($facultyId);
        $pendingSubjects = $this->FacultyModel->getFacultySubjectsPendingApplication($facultyId);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);
        echo $GLOBALS['templates']->render('FacultySubjects', [
            'subjects' => $subjects,
            'faculty' => $faculty,
            'pendingSubjects' => $pendingSubjects
        ]);
    }
    public function facultySubjectApplication($facultyId, $code)
    {
        $this->FacultyModel->postFacultySubjectApplication($facultyId, $code);
        header("Location: /faculty-subjectsPendingApplication/$facultyId");
    }
    public function facultySubjectsPendingApplication($facultyId)
    {
        $pendingSubjects = $this->FacultyModel->getFacultySubjectsPendingApplication($facultyId);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);
        echo $GLOBALS['templates']->render('FacultySubjectsPendingApplication', [
            'faculty' => $faculty,
            'pendingSubjects' => $pendingSubjects
        ]);
    }



    //subject grading controller
    public function facultyGradingStudents($facultyId, $code)
    {
        $students = $this->FacultyModel->getFacultyGradingStudents($code, $facultyId);
        $subject = $this->FacultyModel->getSubjectInfo($code);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);

        echo $GLOBALS['templates']->render('FacultyGrading', [
            'students' => $students,
            'subject' => $subject,
            'faculty' => $faculty
        ]);
    }
    public function recordedStudentGrade($facultyId, $code, $studentId)
    {
        $grade = $this->FacultyModel->getRecordedStudentGrade($studentId, $code) ?: [];
        $student = $this->FacultyModel->getStudentInfo($studentId);
        $subject = $this->FacultyModel->getSubjectInfo($code);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);
        echo $GLOBALS['templates']->render('FacultyGradingGradeStudent', [
            'grade' => $grade,
            'student' => $student,
            'subject' => $subject,
            'faculty' => $faculty
        ]);
    }

    // faculty grading - ADD
    public function add($facultyId, $code, $studentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prelim = $_POST['prelim'] ?: '—';
            $midterm = $_POST['midterm'] ?: '—';
            $finals = $_POST['finals'] ?: '—';

            $this->FacultyModel->add($studentId, $code, $prelim, $midterm, $finals);

            header("Location:/faculty-grading/GradeStudent/$facultyId/$code/$studentId");
            exit;
        } else {
            header("Location: /");
            exit;
        }
    }

    //faculty grading - EDIT
    public function editStudentGrade($facultyId, $code, $studentId)
    {
        $grade = $this->FacultyModel->getRecordedStudentGrade($studentId, $code) ?: [];
        $student = $this->FacultyModel->getStudentInfo($studentId);
        $subject = $this->FacultyModel->getSubjectInfo($code);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);

        echo $GLOBALS['templates']->render('facultyGradingEditStudentGrade', [
            'student' => $student,
            'subject' => $subject,
            'grade' => $grade,
            'faculty' => $faculty
        ]);
    }
    public function edit($facultyId, $code, $studentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prelim = $_POST['prelim'] ?? '';
            $midterm = $_POST['midterm'] ?? '';
            $finals = $_POST['finals'] ?? '';

            $this->FacultyModel->edit($studentId, $code, $prelim, $midterm, $finals);

            header("Location:/faculty-grading/GradeStudent/$facultyId/$code/$studentId");
            exit;
        } else {
            header("Location: /");
            exit;
        }
    }

    // faculty Profile controller
    public function editFacultyProfile($facultyId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $phoneNumber = $_POST['phoneNumber'];
            $this->FacultyModel->editFacultyProfile($facultyId, $firstName, $lastName, $phoneNumber);

            header("Location:/faculty-profile/$facultyId");
        }
    }

    public function facultyProfileChangePassword($facultyId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPasswordInput = $_POST['currentPassword'] ?? '';
            $newPassword          = $_POST['newPassword'] ?? '';
            $confirmPassword      = $_POST['confirmPassword'] ?? '';

            $faculty = $this->FacultyModel->getFacultyProfile($facultyId);

            // Verify current password first
            if (!password_verify($currentPasswordInput, $faculty['password'])) {
                die("Current password is incorrect!");
            }

            // Check if new password is provided
            if (!empty($newPassword)) {
                if ($newPassword !== $confirmPassword) {
                    die("Passwords do not match!");
                }
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $this->FacultyModel->changePassword($facultyId, $hashedPassword);
            }

            header("Location:/faculty-profile/$facultyId");
            exit;
        }
    }

    // ========================= FACULTY STUDENTS CONTROLLER ========================= //
    public function facultyStudents($facultyId)
    {
        $result = $this->FacultyModel->getFacultyStudents($facultyId);
        echo $GLOBALS['templates']->render('FacultyStudent', ['result' => $result]);
    }
    public function facultyStudentInformation($studentId)
    {
        $student = $this->FacultyModel->getFacultyStudentInformation($studentId);
        $result = $this->FacultyModel->getFacultyStudentInformationSubject($studentId);
        echo $GLOBALS['templates']->render('FacultyStudentInformation', ['student' => $student, 'result' => $result]);
    }
    public function facultyStudentAppplication($facultyId)
    {
        $result = $this->FacultyModel->getFacultyStudentApplication($facultyId);
        echo $GLOBALS['templates']->render('FacultyStudentApplication', ['results' => $result]);
    }
}
