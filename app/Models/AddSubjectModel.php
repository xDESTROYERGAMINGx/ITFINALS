<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class AddSubjectModel
{
    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }



    public function addSubject($subject_code, $subject_name, $year_level, $semester, $credit_units)
    {
        $stmt = $this->db->prepare("INSERT INTO subject (subject_code, subject_name, year_level ,semester, credit_units) VALUES (:subject_code, :subject_name, :year_level, :semester, :credit_units)");
        $stmt->bindParam(':subject_code', $subject_code, PDO::PARAM_STR);
        $stmt->bindParam(':subject_name', $subject_name, PDO::PARAM_STR);
        $stmt->bindParam(':year_level', $year_level, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_STR);
        $stmt->bindParam(':credit_units', $credit_units, PDO::PARAM_INT);
        return $stmt->execute();
    }



    public function getAllSubject()
    {
        $stmt = $this->db->query("SELECT * FROM subject ORDER BY subject_code ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    // not fixed

    public function getSubjectById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM subject WHERE subject_id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateSubject($id, $subject_code, $subject_name, $year_level, $semester, $credit_units)
    {
        $stmt = $this->db->prepare("UPDATE subject SET subject_code = :subject_code, subject_name = :subject_name, year_level = :year_level ,semester = :semester, credit_units = :credit_units WHERE subject_id = :id");
        $stmt->bindParam(':subject_code', $subject_code, PDO::PARAM_STR);
        $stmt->bindParam(':subject_name', $subject_name, PDO::PARAM_STR);
        $stmt->bindParam(':year_level', $year_level, PDO::PARAM_STR);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_STR);
        $stmt->bindParam(':credit_units', $credit_units, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }


    






    // Add your custom methods below to interact with the database.
}
