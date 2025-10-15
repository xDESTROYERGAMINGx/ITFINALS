<?php

namespace app\Controllers;

use config\DBConnection;
use app\Models\RegisterModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class RegisterController
{
    private $RegisterModel;
    private $allowedSuffixes = ['Jr.', 'Sr.', 'II', 'III', 'IV', ''];
    private $securityQuestions = [
        "What is your mother's maiden name?",
        "What is the name of your first pet?",
        "What was your first car?",
        "What elementary school did you attend?",
        "In what city were you born?"
    ];

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $db = new DBConnection();
        $this->RegisterModel = new RegisterModel($db);
    }

    public function index()
    {
        $data = [
            'error' => '',
            'success' => '',
            'allowedSuffixes' => $this->allowedSuffixes,
            'securityQuestions' => $this->securityQuestions,
            'formData' => [],
            'recaptchaSiteKey' => $_ENV['RECAPTCHA_SITE_KEY_V2'] ?? ''
        ];

        echo $GLOBALS['templates']->render('Register', $data);
    }

    public function sendCode()
    {
        header('Content-Type: application/json');

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Email is required']);
            exit;
        }

        if (!preg_match('/^[^@]+@ckcgingoog\.edu\.ph$/i', $email)) {
            echo json_encode(['success' => false, 'message' => "Email must be '@ckcgingoog.edu.ph' domain"]);
            exit;
        }

        if (!$this->domainHasMX($email)) {
            echo json_encode(['success' => false, 'message' => 'Email domain has no valid MX records']);
            exit;
        }

        if ($this->RegisterModel->checkEmailExists($email)) {
            echo json_encode(['success' => false, 'message' => "Email already registered. Please use a different email."]);
            exit;
        }

        $lastSent = $this->RegisterModel->getLastTempRegistration($email);

        if ($lastSent) {
            $last_sent_ts = strtotime($lastSent['created_at']);
            if (time() - $last_sent_ts < 300) {
                $remaining = 300 - (time() - $last_sent_ts);
                echo json_encode(['success' => false, 'message' => "Please wait $remaining seconds before resending."]);
                exit;
            }
        }

        $verification_code = rand(100000, 999999);

        $this->RegisterModel->deleteTempRegistration($email);
        $this->RegisterModel->createTempRegistration($email, $verification_code);

        $sendResult = $this->sendVerificationEmail($email, $verification_code);

        if ($sendResult === true) {
            echo json_encode(['success' => true, 'message' => 'Verification code sent to email']);
        } else {
            echo json_encode(['success' => false, 'message' => "Failed to send email: $sendResult"]);
        }
        exit;
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /register");
            exit;
        }

        $this->RegisterModel->cleanExpiredTempRegistrations();

        $formData = $_POST;
        $error = '';

        $recaptchaResponse = $_POST['g-recaptcha-response'] ?? '';
        if (empty($recaptchaResponse) || !$this->verifyRecaptcha($recaptchaResponse, $_ENV['RECAPTCHA_SECRET_KEY_V2'] ?? '')) {
            $error = "reCAPTCHA verification failed. Please try again.";
        }

        if (!$error) {
            $first_name = trim($_POST['first_name'] ?? '');
            $middle_name = trim($_POST['middle_name'] ?? '');
            $middle_name = $middle_name === '' ? null : $middle_name;
            $last_name = trim($_POST['last_name'] ?? '');
            $suffix = $_POST['suffix'] ?? '';
            $security_question = $_POST['security_question'] ?? '';
            $security_answer = trim($_POST['security_answer'] ?? '');

            if (!in_array($security_question, $this->securityQuestions)) {
                $error = "Invalid security question selected.";
            }
            if ($security_answer === '') {
                $error = "Please provide an answer to the security question.";
            }
            if (!in_array($suffix, $this->allowedSuffixes)) {
                $error = "Invalid suffix selected.";
            }

            $digit2 = trim($_POST['digit2'] ?? '');
            $digit3 = trim($_POST['digit3'] ?? '');
            $digit5 = trim($_POST['digit5'] ?? '');
            $digit6 = trim($_POST['digit6'] ?? '');
            $digit7 = trim($_POST['digit7'] ?? '');
            $digit8 = trim($_POST['digit8'] ?? '');

            $digits = [$digit2, $digit3, $digit5, $digit6, $digit7, $digit8];

            foreach ($digits as $d) {
                if (!preg_match('/^\d$/', $d)) {
                    $error = 'Each editable ID digit must be a single digit.';
                    break;
                }
            }

            $id_number = "C{$digit2}{$digit3}-{$digit5}{$digit6}{$digit7}{$digit8}";
            $email = trim($_POST['email'] ?? '');

            if ($this->RegisterModel->checkEmailExists($email)) {
                $error = "Email already registered. Please use a different email.";
            }

            $verification_code_input = '';
            for ($i = 1; $i <= 6; $i++) {
                $digit = trim($_POST["verify_digit$i"] ?? '');
                if (!preg_match('/^\d$/', $digit)) {
                    $error = "Please complete the 6-digit verification code.";
                    break;
                }
                $verification_code_input .= $digit;
            }

            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if ($password !== $confirm_password) {
                $error = "Passwords do not match.";
            }
            if ($email === '' || $first_name === '' || $last_name === '') {
                $error = "Please fill in all required fields.";
            }
            if (!preg_match('/^[^@]+@ckcgingoog\.edu\.ph$/i', $email)) {
                $error = "Email must be '@ckcgingoog.edu.ph'.";
            }
            if (!$error && !$this->domainHasMX($email)) {
                $error = "Email domain does not have valid MX records.";
            }

            if (!$error) {
                $result = $this->RegisterModel->verifyCode($email, $verification_code_input);

                if (!$result) {
                    $error = "Invalid verification code.";
                } else {
                    $created_ts = strtotime($result['created_at']);
                    if ($created_ts === false) {
                        $error = "Verification code data corrupted.";
                    } else if (time() - $created_ts > 300) {
                        $error = "Verification code expired.";
                    }
                }
            }

            if (!$error) {
                if ($this->RegisterModel->checkUserExists($email, $id_number)) {
                    $error = "Email or ID Number already registered.";
                }
            }

            if (!$error) {
                $userData = [
                    'first_name' => $first_name,
                    'middle_name' => $middle_name,
                    'last_name' => $last_name,
                    'suffix' => $suffix === '' ? null : $suffix,
                    'id_number' => $id_number,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'security_question' => $security_question,
                    'security_answer' => password_hash($security_answer, PASSWORD_DEFAULT),
                    'role' => 'student'
                ];

                if ($this->RegisterModel->createUser($userData)) {
                    $this->RegisterModel->deleteTempRegistration($email);
                    $_SESSION['message'] = "";
                    header("Location: /login");
                    exit;
                } else {
                    $error = "Database insert error.";
                }
            }
        }

        $data = [
            'error' => $error,
            'success' => '',
            'allowedSuffixes' => $this->allowedSuffixes,
            'securityQuestions' => $this->securityQuestions,
            'formData' => $formData,
            'recaptchaSiteKey' => $_ENV['RECAPTCHA_SITE_KEY_V2'] ?? ''
        ];

        echo $GLOBALS['templates']->render('Register', $data);
    }

    private function sendVerificationEmail($email, $verificationCode)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['SMTP_USERNAME'] ?? '';
            $mail->Password = $_ENV['SMTP_PASSWORD'] ?? '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'] ?? 587;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'] ?? '', $_ENV['SMTP_FROM_NAME'] ?? '');
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Your Email Verification Code';
            $mail->Body = "Your verification code is: <b>$verificationCode</b><br>Please enter this code on the verification page.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return $mail->ErrorInfo;
        }
    }

    private function verifyRecaptcha($token, $secret)
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = [
            'secret' => $secret,
            'response' => $token
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // For local development only
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // For local development only
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $result = curl_exec($ch);
        
        if (curl_errno($ch)) {
            error_log('cURL Error: ' . curl_error($ch));
            curl_close($ch);
            return false;
        }
        
        curl_close($ch);

        if ($result === false) {
            return false;
        }

        $json = json_decode($result, true);
        return ($json['success'] ?? false);
    }

    private function domainHasMX($email)
    {
        $parts = explode('@', $email);
        if (count($parts) != 2) return false;
        $domain = $parts[1];
        return checkdnsrr($domain, 'MX');
    }
}