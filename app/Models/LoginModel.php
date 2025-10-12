<?php

namespace app\Models;

use config\DBConnection;
use PDO;

class LoginModel
{
    private $db;

    public function __construct(DBConnection $db)
    {
        $this->db = $db->getConnection();
    }

    /**
     * Check if admin exists with the provided credentials
     */
    public function checkAdmin($username, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM admin WHERE username = :username AND password = :password");
        $stmt->execute(['username' => $username, 'password' => $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
