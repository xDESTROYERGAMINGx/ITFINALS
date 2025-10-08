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


    // ====================================== LOGIN ====================================== //
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $facultyId = $_POST['facultyId'] ?? '';
            $password = $_POST['password'] ?? '';

            $faculty = $this->FacultyModel->getFacultyProfile($facultyId);

            if ($faculty && password_verify($password, $faculty['password'])) {
                $_SESSION['faculty_id'] = $faculty['id_number'];
                $_SESSION['name'] = $faculty['first_name'] . " " . $faculty['last_name'];

                header("Location:/faculty-dashboard");
            } else {
                echo $GLOBALS['templates']->render('login', ['error' => 'Invalid username or password']);
            }
        }
    }

    //dashboard controller
    public function facultyDashboard()
    {
        $acceptedCount = $this->FacultyModel->countFacultySubjects($_SESSION['faculty_id']);
        $pendingCount = $this->FacultyModel->countFacultySubjectsPendingApplication($_SESSION['faculty_id']);
        echo $GLOBALS['templates']->render('FacultyDashboard', [
            'acceptedCount' => $acceptedCount,
            'pendingCount' => $pendingCount
        ]);
    }
    public function facultyProfile()
    {
        $faculty = $this->FacultyModel->getFacultyProfile($_SESSION['faculty_id']);
        $subjects = $this->FacultyModel->getFacultySubjects($_SESSION['faculty_id']);
        echo $GLOBALS['templates']->render('facultyProfile', ['faculty' => $faculty, 'subjects' => $subjects]);
    }

    //subjects controller
    public function availableSubjects()
    {
        $subjects = $this->FacultyModel->getAvailableSubjects();
        echo $GLOBALS['templates']->render('FacultySubjectsAvailable', [
            'subjects' => $subjects
        ]);
    }
    public function facultySubjects()
    {
        $subjects = $this->FacultyModel->getFacultySubjects($_SESSION['faculty_id']);
        echo $GLOBALS['templates']->render('FacultySubjects', [
            'subjects' => $subjects
        ]);
    }
    public function facultySubjectApplication($code)
    {

        $this->FacultyModel->postFacultySubjectApplication($_SESSION['faculty_id'], $code);
        header("Location: /faculty-subject/PendingApplication");
    }
    public function facultySubjectsPendingApplication()
    {
        $pendingSubjects = $this->FacultyModel->getFacultySubjectsPendingApplication($_SESSION['faculty_id']);
        echo $GLOBALS['templates']->render('FacultySubjectsPendingApplication', [
            'pendingSubjects' => $pendingSubjects
        ]);
    }



    //subject grading controller
    public function facultyGradingStudents($code)
    {
        $students = $this->FacultyModel->getFacultyGradingStudents($code, $_SESSION['faculty_id']);
        $pendingApplications = $this->FacultyModel->getFacultySubjectsPendingApplicationById($code);
        $subject = $this->FacultyModel->getSubjectInfo($code);

        echo $GLOBALS['templates']->render('FacultyGrading', [
            'students' => $students,
            'subject' => $subject,
            'pendingStudents' => $pendingApplications
        ]);
    }
    public function recordedStudentGrade( $code, $studentId)
    {
        $grade = $this->FacultyModel->getRecordedStudentGrade($studentId, $code) ?: [];
        $student = $this->FacultyModel->getStudentInfo($studentId);
        $subject = $this->FacultyModel->getSubjectInfo($code);
        echo $GLOBALS['templates']->render('FacultyGradingGradeStudent', [
            'grade' => $grade,
            'student' => $student,
            'subject' => $subject
        ]);
    }

    // faculty grading - ADD
    public function add( $code, $studentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prelim = $_POST['prelim'] ?: '—';
            $midterm = $_POST['midterm'] ?: '—';
            $finals = $_POST['finals'] ?: '—';

            $this->FacultyModel->add($studentId, $code, $prelim, $midterm, $finals);

            $_SESSION['success'][] = "Grade Added Successfully!";
            header("Location:/faculty-grading/GradeStudent/$code/$studentId");
            exit;
        } else {
            header("Location: /");
            exit;
        }
    }

    public function edit($code, $studentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prelim = $_POST['prelim'] ?? '';
            $midterm = $_POST['midterm'] ?? '';
            $finals = $_POST['finals'] ?? '';

            $this->FacultyModel->edit($studentId, $code, $prelim, $midterm, $finals);
            
            $_SESSION['success'][] = "Grade Added Successfully!";
            header("Location:/faculty-grading/GradeStudent/$code/$studentId");
            exit;
        } else {
            header("Location: /");
            exit;
        }
    }

    // faculty Profile controller
    public function editFacultyProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['firstName'];
            $lastName = $_POST['lastName'];
            $phoneNumber = $_POST['phoneNumber'];
            $this->FacultyModel->editFacultyProfile($_SESSION['faculty_id'], $firstName, $lastName, $phoneNumber);

            header("Location:/faculty-profile");
        }
    }

    public function facultyProfileChangePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPasswordInput = $_POST['currentPassword'] ?? '';
            $newPassword = $_POST['newPassword'] ?? '';
            $confirmPassword = $_POST['confirmPassword'] ?? '';
            $facultyId = $_SESSION['faculty_id'];

            $faculty = $this->FacultyModel->getFacultyProfile($facultyId);

            // Verify current password first
            if (!password_verify($currentPasswordInput, $faculty['password'])) {
                $_SESSION['danger'][] = "Incorrect Password. Please try again.";
                header("Location:/faculty-profile");
                exit;
            }

            // Check if new password is provided
            if (!empty($newPassword)) {
                if ($newPassword !== $confirmPassword) {
                    $_SESSION['danger'][] = "Password Don't Match! Please try again.";
                    header("Location:/faculty-profile");
                    exit;
                }
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $this->FacultyModel->changePassword($facultyId, $hashedPassword);
                $_SESSION['success'][] = "Successfully Changed Password.";
            }

            header("Location:/faculty-profile");
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
    public function facultyStudentAppplicationConfirm($code, $studentId)
    {
        $confirmStudent = $this->FacultyModel->setFacultyStudentApplicationConfirm($code, $studentId);
        if ($confirmStudent) {
            $_SESSION['success'][] = "Student Application Confirmed!";
        }
        header("Location:/faculty-student/studentApplication/$studentId");
    }
}
