<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\LoginModel;

class LoginController
{
    private $LoginModel;



    
    public function __construct()
    {
        $db = new DBConnection();
        $this->LoginModel = new LoginModel($db);
    }
    
    // Add your custom controllers below to handle business logic.
    public function showLogin()
    {
        \app\Router::render('LoginView');
    }

    /**
     * Handle login form submission
     */
    public function authenticate()
    {
        session_start();
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $admin = $this->LoginModel->checkAdmin($username, $password);

        if ($admin) {
            $_SESSION['admin'] = $admin['username'];
            header('Location: /DashboardView');
            exit;
        } else {
            $_SESSION['error'] = "Invalid username or password";
            header('Location: /LoginView');
            exit;
        }
    }

    /**
     * Logout and destroy session
     */
    public function logout()
    {
        session_start();
        session_destroy();
        header('Location: /LoginView');
        exit;
    }
}
