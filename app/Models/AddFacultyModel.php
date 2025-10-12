<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class AddFacultyModel
{
    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }

    // Method to insert a new faculty record
    public function insertFaculty($firstName, $lastName, $password, $mobile_number, $gender, $email, $idNumber)
    {
        $stmt = $this->db->prepare(
            "INSERT INTO faculty (first_name, last_name, password, phone_number, gender, email, id_number) 
             VALUES (:first_name, :last_name, :password, :mobile_number,:gender, :email, :id_number)"
        );
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':mobile_number', $mobile_number, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id_number', $idNumber, PDO::PARAM_STR);
        return $stmt->execute();
    }




    // Method to fetch all faculties
    public function getAllFaculty()
    {
        $stmt = $this->db->query("SELECT * FROM faculty ORDER BY id_number DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to get faculty by ID
    public function getFacultyById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM faculty WHERE id_number = :id_number");
        $stmt->bindParam(':id_number', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }




    // Method to update faculty details
    public function updateFaculty($id, $firstName, $lastName, $password, $mobile_number, $gender, $email, $idNumber)
    {
        $stmt = $this->db->prepare(
            "UPDATE faculty 
             SET first_name = :first_name, 
                 last_name = :last_name, 
                 password = :password, 
                 phone_number = :mobile_number,
                 gender = :gender, 
                 email = :email, 
                 id_number = :id_number 
             WHERE faculty_id = :id"
        );

        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':mobile_number', $mobile_number, PDO::PARAM_STR);
        $stmt->bindParam(':gender', $gender, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id_number', $idNumber, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }


    public function getTotalFaculty()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM faculty");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getTotalSubjects()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM subject");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
}
