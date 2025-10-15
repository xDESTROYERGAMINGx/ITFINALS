<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class RegisterModel
{
    private $db;
    
    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }

    public function cleanExpiredTempRegistrations()
    {
        $stmt = $this->db->prepare("DELETE FROM temp_registrations WHERE created_at < NOW() - INTERVAL 5 MINUTE");
        return $stmt->execute();
    }

    public function checkEmailExists($email)
    {
        $stmt = $this->db->prepare("SELECT student_id FROM student WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function getLastTempRegistration($email)
    {
        $stmt = $this->db->prepare("SELECT created_at FROM temp_registrations WHERE email = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteTempRegistration($email)
    {
        $stmt = $this->db->prepare("DELETE FROM temp_registrations WHERE email = ?");
        return $stmt->execute([$email]);
    }

    public function createTempRegistration($email, $code)
    {
        $stmt = $this->db->prepare("INSERT INTO temp_registrations (email, verification_code, created_at) VALUES (?, ?, NOW())");
        return $stmt->execute([$email, $code]);
    }

    public function verifyCode($email, $code)
    {
        $stmt = $this->db->prepare("SELECT created_at FROM temp_registrations WHERE email = ? AND verification_code = ? ORDER BY created_at DESC LIMIT 1");
        $stmt->execute([$email, $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUserExists($email, $username)
    {
        $stmt = $this->db->prepare("SELECT student_id FROM student WHERE email = ? OR id_number = ?");
        $stmt->execute([$email, $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
    }

    public function createUser($data)
    {
        $stmt = $this->db->prepare("INSERT INTO student 
            (first_name, middle_name, last_name, suffix, id_number, email, password, security_question, security_answer, is_verified, created_at) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 1, NOW())");
        
        return $stmt->execute([
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['suffix'],
            $data['id_number'],
            $data['email'],
            $data['password'],
            $data['security_question'],
            $data['security_answer'],
        ]);
    }
}