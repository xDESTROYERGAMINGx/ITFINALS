<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\LoginModel;

class LoginController
{
    private $LoginModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $db = new DBConnection();
        $this->LoginModel = new LoginModel($db);
    }

    public function index()
    {
        $data = [
            'error' => '',
            'parentError' => '',
            'keepParentOpen' => false,
            'showSecurityQuestion' => false,
            'security_question' => '',
            'digit2' => '',
            'digit3' => '',
            'digit5' => '',
            'digit6' => '',
            'digit7' => '',
            'digit8' => '',
            'email' => '',
            'recaptchaSiteKey' => $_ENV['RECAPTCHA_SITE_KEY_V3'] ?? ''
        ];

        echo $GLOBALS['templates']->render('Login', $data);
    }

    public function getSecurityQuestion()
    {
        header('Content-Type: application/json');
        $parent_id = $_GET['parent_id'] ?? '';

        if (preg_match('/^C\d{2}-\d{4}$/', $parent_id)) {
            $result = $this->LoginModel->getSecurityQuestion($parent_id);

            if ($result) {
                echo json_encode(['success' => true, 'question' => $result['security_question']]);
            } else {
                echo json_encode(['success' => false, 'message' => 'ID number hasn\'t been registered.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid ID format']);
        }
        exit;
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /login");
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';

        if (empty($email) || empty($password)) {
            $this->renderWithError("Please provide both email and password.");
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->renderWithError("Please enter a valid email.", $email);
            return;
        }

        if (empty($recaptchaToken)) {
            $this->renderWithError("reCAPTCHA verification failed. Please try again.", $email);
            return;
        }

        $recaptchaResponse = $this->verifyRecaptchaV3($recaptchaToken, $_ENV['RECAPTCHA_SECRET_KEY_V3'] ?? '');
        if (!$recaptchaResponse || !$recaptchaResponse['success'] || $recaptchaResponse['score'] < 0.5) {
            $this->renderWithError("reCAPTCHA verification failed. Please try again.", $email);
            return;
        }

        $faculty = $this->LoginModel->getFacultyByEmail($email);

        if ($faculty) {
            if (!password_verify($password, $faculty['password'])) {
                $this->renderWithError("Invalid email or password.", $email);
                return;
            }

            session_regenerate_id(true);
            $_SESSION['faculty_id'] = $faculty['faculty_id'];
            $_SESSION['id_number'] = $faculty['id_number'];
            $_SESSION['name'] = $faculty['first_name'] . ' ' . $faculty['last_name']; // assuming faculty table has 'name'
            $_SESSION['email'] = $faculty['email'];

            header("Location: /faculty-dashboard");
            exit;
        }
        
        $admin = $this->LoginModel->getAdminByEmail($email);

        if ($admin) {
            if (!password_verify($password, $admin['password'])) {
                $this->renderWithError("Invalid email or password.", $email);
                return;
            }
            header("Location: /admin-dashboard");
            exit;
        }


        $user = $this->LoginModel->getUserByEmail($email);

        if (!$user || !password_verify($password, $user['password'])) {
            $this->renderWithError("Invalid email or password.", $email);
            return;
        }

        session_regenerate_id(true);
        $_SESSION['student_id'] = $user['student_id'];
        $_SESSION['id_number'] = $user['id_number'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['student_name'] = $user['first_name'].' '.$user['last_name'];


        header("Location: /student-dashboard");
        exit;
    }

    public function parentLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /login");
            exit;
        }

        $digit2 = $_POST['digit2'] ?? '';
        $digit3 = $_POST['digit3'] ?? '';
        $digit5 = $_POST['digit5'] ?? '';
        $digit6 = $_POST['digit6'] ?? '';
        $digit7 = $_POST['digit7'] ?? '';
        $digit8 = $_POST['digit8'] ?? '';

        $digits = [$digit2, $digit3, $digit5, $digit6, $digit7, $digit8];

        foreach ($digits as $d) {
            if (!preg_match('/^\d$/', $d)) {
                $this->renderWithParentError("Please enter valid digits in your ID.", true, $digit2, $digit3, $digit5, $digit6, $digit7, $digit8);
                return;
            }
        }

        $parent_id = "C{$digit2}{$digit3}-{$digit5}{$digit6}{$digit7}{$digit8}";
        $parent_answer = trim($_POST['parent_security_answer'] ?? '');

        if (empty($parent_answer)) {
            $this->renderWithParentError("Please enter your answer to the security question.", true, $digit2, $digit3, $digit5, $digit6, $digit7, $digit8);
            return;
        }

        $lockStatus = $this->checkAndIncrementParentAttempts($parent_id);

        if ($lockStatus['locked']) {
            $minutes = ceil($lockStatus['seconds_locked'] / 60);
            $this->renderWithParentError("Too many failed attempts. Please try again after $minutes minute(s).", true, $digit2, $digit3, $digit5, $digit6, $digit7, $digit8);
            return;
        }

        $user = $this->LoginModel->getUserByUsername($parent_id);

        if (!$user) {
            $this->renderWithParentError("", true, $digit2, $digit3, $digit5, $digit6, $digit7, $digit8);
            return;
        }

        if (!password_verify($parent_answer, $user['security_answer'])) {
            $this->renderWithParentError("Incorrect answer. Please try again.", true, $digit2, $digit3, $digit5, $digit6, $digit7, $digit8);
            return;
        }

        $this->LoginModel->resetParentAttempts($parent_id);

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];

        header("Location: /parents-dashboard");
        exit;
    }

    private function checkAndIncrementParentAttempts($id_number)
    {
        $result = $this->LoginModel->getParentAttempts($id_number);

        if (!$result) {
            $this->LoginModel->createParentAttempt($id_number);
            return ['locked' => false, 'remaining' => 5];
        }

        $attempts = $result['attempts'];
        $last_attempt_ts = strtotime($result['last_attempt']);
        $now = time();

        if ($attempts >= 5 && ($now - $last_attempt_ts) < 300) {
            $seconds_locked = 300 - ($now - $last_attempt_ts);
            return ['locked' => true, 'remaining' => 0, 'seconds_locked' => $seconds_locked];
        } elseif (($now - $last_attempt_ts) >= 300) {
            $this->LoginModel->updateParentAttempts($id_number, 1);
            return ['locked' => false, 'remaining' => 4];
        } else {
            $this->LoginModel->updateParentAttempts($id_number, $attempts + 1);
            return ['locked' => false, 'remaining' => 5 - ($attempts + 1)];
        }
    }

    private function verifyRecaptchaV3($token, $secret)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = ['secret' => $secret, 'response' => $token];
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ],
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) return false;
        return json_decode($result, true);
    }

    private function renderWithError($error, $email = '')
    {
        $data = [
            'error' => $error,
            'parentError' => '',
            'keepParentOpen' => false,
            'showSecurityQuestion' => false,
            'security_question' => '',
            'digit2' => '',
            'digit3' => '',
            'digit5' => '',
            'digit6' => '',
            'digit7' => '',
            'digit8' => '',
            'email' => $email,
            'recaptchaSiteKey' => $_ENV['RECAPTCHA_SITE_KEY_V3'] ?? ''
        ];
        echo $GLOBALS['templates']->render('Login', $data);
    }

    private function renderWithParentError($error, $keepOpen = false, $d2 = '', $d3 = '', $d5 = '', $d6 = '', $d7 = '', $d8 = '')
    {
        $security_question = '';
        $showSecurityQuestion = false;

        if ($d2 && $d3 && $d5 && $d6 && $d7 && $d8) {
            $parent_id = "C{$d2}{$d3}-{$d5}{$d6}{$d7}{$d8}";
            $result = $this->LoginModel->getSecurityQuestion($parent_id);
            if ($result) {
                $security_question = $result['security_question'];
                $showSecurityQuestion = true;
            }
        }

        $data = [
            'error' => '',
            'parentError' => $error,
            'keepParentOpen' => $keepOpen,
            'showSecurityQuestion' => $showSecurityQuestion,
            'security_question' => $security_question,
            'digit2' => $d2,
            'digit3' => $d3,
            'digit5' => $d5,
            'digit6' => $d6,
            'digit7' => $d7,
            'digit8' => $d8,
            'email' => '',
            'recaptchaSiteKey' => $_ENV['RECAPTCHA_SITE_KEY_V3'] ?? ''
        ];
        echo $GLOBALS['templates']->render('Login', $data);
    }
}
