<?php

namespace app;

use app\Controllers\FacultyController;
use app\Models\FacultyModel;

class Router
{
    public static $routes = [];

    public static function init()
    {
        // login routes
        Router::add('/', fn() => Router::render('pilotLogin'));
        Router::add('/login', fn() => (new FacultyController())->login(), 'POST');

        //faculty dashboard
        Router::add('/faculty-dashboard/{facultyId}', fn($data) => (new FacultyController())->dashboard($data['facultyId']));
        Router::add('/faculty-subjectsAvailable/{facultyId}', fn($data) => (new FacultyController())->availableSubjects($data['facultyId']));
        Router::add('/faculty-subjects/{facultyId}', fn($data) => (new FacultyController())->facultySubjects($data['facultyId']));
        Router::add('/faculty-profile/{facultyId}', fn($data) => (new FacultyController())->facultyProfile($data['facultyId']));

        //faculty profile
        Router::add('/faculty-profile/{facultyId}/EditProfile', fn($data) => (new FacultyController())->editFacultyProfile($data['facultyId']));
        Router::add('faculty-profile/{facultyId}/ChangePassword', fn($data) => (new FacultyController())->facultyProfileChangePassword($data['facultyId']));

        //subject application
        Router::add('/faculty-subjectApplication/{facultyId}/{code}', fn($data) => (new FacultyController())->facultySubjectApplication($data['facultyId'], $data['code']));
        Router::add('/faculty-subjectsPendingApplication/{facultyId}', fn($data) => (new FacultyController())->facultySubjectsPendingApplication($data['facultyId']));

        //Grading Section
        Router::add('/faculty-grading/{facultyId}/{code}', fn($data) => (new FacultyController())->facultyGradingStudents($data['facultyId'], $data['code']));
        Router::add('/faculty-grading/GradeStudent/{facultyId}/{code}/{studentId}', fn($data) => (new FacultyController())->recordedStudentGrade(
            $data['facultyId'],
            $data['code'],
            $data['studentId']
        ), 'GET');
        Router::add('/faculty-grading/GradeStudent/{facultyId}/{code}/{studentId}/edit', fn($data) => (new FacultyController())->edit(
            $data['facultyId'],
            $data['code'],
            $data['studentId']
        ), 'POST');
        Router::add('/faculty-grading/GradeStudent/{facultyId}/{code}/{studentId}/add', fn($data) => (new FacultyController())->add(
            $data['facultyId'],
            $data['code'],
            $data['studentId']
        ), 'POST');


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
