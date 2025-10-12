<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\AddFacultyModel;

class AddFacultyController
{
    private $AddFacultyModel;

    public function __construct()
    {
        $db = new DBConnection();
        $this->AddFacultyModel = new AddFacultyModel($db);
    }

    // Add new faculty
    public function addFaculty()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName  = $_POST['last_name'] ?? '';
            $password  = $_POST['password'] ?? '';
            $mobile_number  = $_POST['mobile_number'] ?? '';
            $gender    = $_POST['gender'] ?? '';
            $email     = $_POST['email'] ?? '';
            $idNumber  = $_POST['id_number'] ?? '';



            // Validate required fields
            if (empty($firstName) || empty($lastName) || empty($password) || empty($mobile_number) || empty($gender) || empty($email) || empty($idNumber)) {
                echo "All fields are required.";
                return;
            }

            // Secure password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert the faculty into the database
            $result = $this->AddFacultyModel->insertFaculty($firstName, $lastName, $hashedPassword, $mobile_number, $gender, $email, $idNumber);

            if ($result) {
                
                header("Location: /ViewFaculty");
                exit;
            }

            echo "Error adding faculty.";
        }
        
       
    }

    // Display list of all faculties
    public function readFaculty()
    {
        $faculties = $this->AddFacultyModel->getAllFaculty();
        echo $GLOBALS['templates']->render('Admin/ViewFaculty', ['faculties' => $faculties]);
    }






    // Update faculty information
    // Show update form
    public function showUpdateForm($id)
    {
        $faculty = $this->AddFacultyModel->getFacultyById($id);
        echo $GLOBALS['templates']->render('Admin/UpdateFacultyView', ['faculty' => $faculty]);
    }

    // Handle update POST
    public function updateFaculty($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstName = $_POST['first_name'] ?? '';
            $lastName  = $_POST['last_name'] ?? '';
            $password  = $_POST['password'] ?? '';
            $mobile_number  = $_POST['mobile_number'] ?? '';
            $gender    = $_POST['gender'] ?? '';
            $email     = $_POST['email'] ?? '';
            $idNumber  = $_POST['id_number'] ?? '';

            // Keep old password if blank
            $faculty = $this->AddFacultyModel->getFacultyById($id);
            $hashedPassword = !empty($password)
                ? password_hash($password, PASSWORD_DEFAULT)
                : $faculty['password'];

            $result = $this->AddFacultyModel->updateFaculty(
                $id,
                $firstName,
                $lastName,
                $hashedPassword,
                $mobile_number,
                $gender,
                $email,
                $idNumber
            );

            if ($result) {
                header("Location: /ViewFaculty");
                exit;
            }

            echo "Error updating faculty.";
        }
    }



    public function getcount()
    {
        $totalFaculty = $this->AddFacultyModel->getTotalFaculty();
        $totalSubjects = $this->AddFacultyModel->getTotalSubjects();

        echo $GLOBALS['templates']->render('Admin/DashboardView', ['totalFaculty' => $totalFaculty, 'totalSubjects' => $totalSubjects]);
    }
}
