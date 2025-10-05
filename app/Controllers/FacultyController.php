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
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $faculty = $this->FacultyModel->login($username, $password); // only call once

            if ($faculty) {
                header("Location: /faculty-dashboard/" . urlencode($faculty['user_id']));
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
        header("Location: /faculty-subjects/$facultyId");
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
    public function facultyGradingStudents($facultyId, $code )
    {
        $students = $this->FacultyModel->getFacultyGradingStudents($code, $facultyId);
        $subject  = $this->FacultyModel->getSubjectInfo($code);
        $faculty  = $this->FacultyModel->getFacultyInfo($facultyId);

        echo $GLOBALS['templates']->render('FacultyGrading', [
            'students' => $students,
            'subject'  => $subject,
            'faculty'  => $faculty
        ]);
    }
    public function recordedStudentGrade($facultyId, $code, $studentId)
    {
        $grade = $this->FacultyModel->getRecordedStudentGrade($studentId, $code) ?: [];
        $student = $this->FacultyModel->getStudentInfo($studentId);
        $subject = $this->FacultyModel->getSubjectInfo($code);
        $faculty  = $this->FacultyModel->getFacultyInfo($facultyId);
        echo $GLOBALS['templates']->render('FacultyGradingViewStudent', [
            'grade' => $grade,
            'student' => $student,
            'subject' => $subject,
            'faculty' => $faculty
        ]);
    }

    // faculty grading - ADD
    public function addStudentGrade($facultyId, $code, $studentId)
    {
        $student = $this->FacultyModel->getStudentInfo($studentId);
        $subject = $this->FacultyModel->getSubjectInfo($code);
        $faculty = $this->FacultyModel->getFacultyInfo($facultyId);

        echo $GLOBALS['templates']->render('facultyGradingAddStudentGrade', [
            'student' => $student,
            'subject' => $subject,
            'faculty' => $faculty
        ]);
    }
    public function add($facultyId, $code, $studentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prelim  = $_POST['prelim']  ?? '';
            $midterm = $_POST['midterm'] ?? '';
            $finals  = $_POST['finals']  ?? '';

            $this->FacultyModel->add($studentId, $code, $prelim, $midterm, $finals);

            header("Location:/faculty-grading/ViewStudent/$facultyId/$code/$studentId");
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
        $faculty  = $this->FacultyModel->getFacultyInfo($facultyId);

        echo $GLOBALS['templates']->render('facultyGradingEditStudentGrade', [
            'student' => $student,
            'subject' => $subject,
            'grade' => $grade,
            'faculty'  => $faculty
        ]);
    }
    public function edit($facultyId, $code, $studentId)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $prelim  = $_POST['prelim']  ?? '';
            $midterm = $_POST['midterm'] ?? '';
            $finals  = $_POST['finals']  ?? '';

            $this->FacultyModel->edit($studentId, $code, $prelim, $midterm, $finals);

            header("Location:/faculty-grading/ViewStudent/$facultyId/$code/$studentId");
            exit;
        } else {
            header("Location: /");
            exit;
        }
    }
}
