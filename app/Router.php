<?php

namespace app;

use app\Controllers\FacultyController;
use app\Models\FacultyModel;

class Router
{
    public static $routes = [];

    public static function init()
    {
        // ========================= LOGIN ROUTES =========================//
        Router::add('/', fn() => Router::render('pilotLogin'));
        Router::add('/login', fn() => (new FacultyController())->login(), 'POST');

        // ========================= FACULTY DASHBORAD ROUTES ========================= //
        Router::add('/faculty-dashboard', fn() => (new FacultyController())->facultyDashboard());
        Router::add('/faculty-subjectsAvailable', fn() => (new FacultyController())->availableSubjects());
        Router::add('/faculty-subjects', fn() => (new FacultyController())->facultySubjects());
        Router::add('/faculty-profile', fn() => (new FacultyController())->facultyProfile());

        // ========================= FACULTY PROFILE ROUTES ========================= //
        Router::add('/faculty-profile/EditProfile', fn() => (new FacultyController())->editFacultyProfile());
        Router::add('/faculty-profile/ChangePassword', fn() => (new FacultyController())->facultyProfileChangePassword());


        // ========================= SUBJECT APPLICATION ROUTES ========================= //
        Router::add('/faculty-subjectApplication/{code}', fn($data) => (new FacultyController())->facultySubjectApplication($data['code']));
        Router::add('/faculty-subject/PendingApplication', fn() => (new FacultyController())->facultySubjectsPendingApplication());

        // ========================= FACULTY GRADING ROUTES ========================= //
        Router::add('/faculty-grading/{code}', fn($data) => (new FacultyController())->facultyGradingStudents($data['code']));
        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}', fn($data) => (new FacultyController())->recordedStudentGrade(
            $data['code'],
            $data['studentId']
        ), 'GET');
        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}/edit', fn($data) => (new FacultyController())->edit(
            $data['code'],
            $data['studentId']
        ), 'POST');
        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}/add', fn($data) => (new FacultyController())->add(
            $data['code'],
            $data['studentId']
        ), 'POST');

        // ========================= FACULTY STUDENT ROUTES ========================= //
        Router::add('/faculty-students', fn() => (new FacultyController())->facultyStudents());
        Router::add('/faculty-student/studentInformation/{studentId}', fn($data) => (new FacultyController())->facultyStudentInformation($data['studentId']));
        Router::add('/faculty-student/studentApplication', fn() => (new FacultyController())->facultyStudentAppplication());
        Router::add('/faculty-student/studentApplication/{code}/{studentId}/confirm', fn($data) => (new FacultyController())->facultyStudentAppplicationConfirm($data['code'], $data['studentId']));
        Router::add('/faculty-student/studentApplication/{code}/{studentId}/reject', fn($data) => (new FacultyController())->facultyStudentAppplicationReject($data['code'], $data['studentId']));

        Router::run();
    }

    public static function add($path, $callback)
    {
        $path = str_replace(['{', '}'], ['(?P<', '>[^/]+)'], $path);

        Router::$routes[$path] = $callback;
    }

    public static function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes as $route => $callback) {
            if (preg_match("#^$route$#", $requestUri, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                echo call_user_func($callback, $params);

                return;
            }
        }
        echo template()->render('Errors/404');
    }

    public static function render($view, $data = [])
    {
        $viewPath = __DIR__ . "/Views/{$view}.php";

        if (file_exists($viewPath)) {
            $templates = new \League\Plates\Engine(__DIR__ . '/Views');
            echo $templates->render($view, $data);
        } else {
            echo template()->render('Errors/404');
        }
    }
}
