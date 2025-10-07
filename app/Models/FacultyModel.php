<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class FacultyModel
{
    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }

    //Faculty Information Model
    public function getFacultyInfo($faculty_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $faculty_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getFacultyProfile($facultyId)
    {
        $stmt = $this->db->prepare("SELECT * FROM faculty WHERE id_number = :id_number");
        $stmt->bindParam(':id_number', $facultyId, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function editFacultyProfile($facultyId, $firstName, $lastName, $phoneNumber)
    {
        $stmt = $this->db->prepare("UPDATE faculty SET first_name = :first_name, last_name = :last_name, phone_number = :phone_number WHERE id_number = :id_number");
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':phone_number', $phoneNumber, PDO::PARAM_STR);
        $stmt->bindParam(':id_number', $facultyId, PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function changePassword($facultyId, $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE faculty SET password = :password WHERE id_number = :id_number");
        $stmt->bindParam(':password', $newPassword, PDO::PARAM_STR);
        $stmt->bindParam(':id_number', $facultyId, PDO::PARAM_STR);
        return $stmt->execute();
    }   

    //Student Information Model
    public function getStudentInfo($studenId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->bindValue(':user_id', $studenId, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // single row
    }

    //Subject Information Model
    public function getSubjectInfo($code)
    {
        $stmt = $this->db->prepare("SELECT * FROM subject WHERE code = :code");
        $stmt->bindValue(':code', $code, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // single row
    }

    // Login models
    public function login($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = :username AND password = :password");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //dashboard models
    public function countFacultySubjects($faculty_id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS subject_count
        FROM faculty_subject
        WHERE faculty_id = :faculty_id AND status = 1
    ");
        $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['subject_count'];
    }
    public function countFacultySubjectsPendingApplication($faculty_id)
    {
        $stmt = $this->db->prepare("
        SELECT COUNT(*) AS subject_count
        FROM faculty_subject
        WHERE faculty_id = :faculty_id AND status = 0
    ");
        $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['subject_count'];
    }

    //available subjects model
    public function getAvailableSubjects()
    {
        $stmt = $this->db->prepare("
        SELECT *
        FROM subject s
        WHERE s.code NOT IN (
            SELECT fs.subject_id
            FROM faculty_subject fs
        )
    ");

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //faculty subjects model
    public function getFacultySubjects($faculty_id)
    {
        $stmt = $this->db->prepare("SELECT s.*, fs.faculty_id
        FROM subject s
        JOIN faculty_subject fs ON s.code = fs.subject_id
        WHERE fs.faculty_id = :faculty_id AND fs.status = 1;
        ");
        $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function postFacultySubjectApplication($facultyId, $code)
    {
        $sem = "First Semester";
        $stmt = $this->db->prepare("INSERT INTO faculty_subject(faculty_id, subject_id, semester, status) VALUES(:faculty_id, :subject_id, :semester, 0)");
        $stmt->bindParam(':faculty_id', $facultyId, PDO::PARAM_STR);
        $stmt->bindParam(':subject_id', $code, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $sem, PDO::PARAM_STR);
        return $stmt->execute();
    }
    public function getFacultySubjectsPendingApplication($faculty_id)
    {
        $stmt = $this->db->prepare("SELECT s.*, fs.faculty_id
        FROM subject s
        JOIN faculty_subject fs ON s.code = fs.subject_id
        WHERE fs.faculty_id = :faculty_id AND fs.status = 0;
        ");
        $stmt->bindParam(':faculty_id', $faculty_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //subject grading model
    public function getFacultyGradingStudents($code)
    {
        $stmt = $this->db->prepare("SELECT u.*
        FROM users u
        JOIN student_subject ss ON u.user_id = ss.student_id
        WHERE ss.subject_id = :subject_code
        ");
        $stmt->bindParam(':subject_code', $code, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getRecordedStudentGrade($student_id, $subject_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM Grading WHERE student_id = :student_id AND subject_id = :subject_id");
        $stmt->bindParam(':student_id', $student_id, PDO::PARAM_STR);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //subject grading model - ADD
    public function add($studentId, $code, $prelimGrade, $midtermGrade, $finalsGrade)
    {
        $stmt = $this->db->prepare("INSERT INTO grading (subject_id, student_id, prelim, midterm, finals) VALUES (:subject_id, :student_id, :prelim, :midterm, :finals)");
        $stmt->bindParam(':subject_id', $code, PDO::PARAM_STR);
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_STR);
        $stmt->bindParam(':prelim', $prelimGrade, PDO::PARAM_STR);
        $stmt->bindParam(':midterm', $midtermGrade, PDO::PARAM_STR);
        $stmt->bindParam(':finals', $finalsGrade, PDO::PARAM_STR);
        return $stmt->execute();
    }

    //subject grading model - EDIT
    public function edit($id, $code, $prelim, $midterm, $finals)
    {
        $stmt = $this->db->prepare("UPDATE grading SET prelim = :prelim, midterm = :midterm, finals = :finals WHERE student_id = :student_id AND subject_id = :subject_id");
        $stmt->bindParam(':prelim', $prelim, PDO::PARAM_STR);
        $stmt->bindParam(':midterm', $midterm, PDO::PARAM_STR);
        $stmt->bindParam(':finals', $finals, PDO::PARAM_STR);
        $stmt->bindParam(':student_id', $id, PDO::PARAM_STR);
        $stmt->bindParam(':subject_id', $code, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
