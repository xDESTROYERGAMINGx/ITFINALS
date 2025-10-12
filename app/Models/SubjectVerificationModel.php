<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class SubjectVerificationModel
{
    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }

    // Get all pending subjects
    public function getPendingSubjects()
    {
        $query = "
            SELECT 
                sa.id,
                CONCAT(f.first_name, ' ', f.last_name) AS faculty_name,
                s.subject_code,
                s.subject_name,
                s.year_level,
                s.semester
            FROM subject_allocations sa
            LEFT JOIN faculty f ON sa.faculty_id = f.faculty_id
            LEFT JOIN subject s ON sa.subject_id = s.subject_id
            WHERE sa.status = 'Pending'
        ";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🟢 Get all verified (Approved or Rejected) subjects
    public function getVerifiedSubjects()
    {
        $query = "
            SELECT 
                sa.id,
                CONCAT(f.first_name, ' ', f.last_name) AS faculty_name,
                s.subject_code,
                s.subject_name,
                s.year_level,
                s.semester,
                sa.status
            FROM subject_allocations sa
            LEFT JOIN faculty f ON sa.faculty_id = f.faculty_id
            LEFT JOIN subject s ON sa.subject_id = s.subject_id
            WHERE sa.status IN ('Approved', 'Rejected')
        ";

        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ✅ Approve subject allocation
    public function approveSubject($id)
    {
        $stmt = $this->db->prepare("UPDATE subject_allocations SET status = 'Approved' WHERE id = ?");
        $stmt->execute([$id]);
    }

    // ❌ Reject subject allocation
    public function rejectSubject($id)
    {
        $stmt = $this->db->prepare("UPDATE subject_allocations SET status = 'Rejected' WHERE id = ?");
        $stmt->execute([$id]);
    }

    // 🧪 Temporary: Add a pending subject manually (for testing)
    public function addPendingSubject($subjectId, $facultyId = 1)
    {
        // Check if already exists to prevent duplicates
        $check = $this->db->prepare("
            SELECT * FROM subject_allocations 
            WHERE subject_id = ? AND faculty_id = ?
        ");
        $check->execute([$subjectId, $facultyId]);

        if ($check->rowCount() === 0) {
            $stmt = $this->db->prepare("
                INSERT INTO subject_allocations (faculty_id, subject_id, status)
                VALUES (?, ?, 'Pending')
            ");
            $stmt->execute([$facultyId, $subjectId]);
        }
    }
}
