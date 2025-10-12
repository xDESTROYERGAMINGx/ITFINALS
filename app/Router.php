<?php

namespace app;

use app\Controllers\FacultyController;
use app\Controllers\AddFacultyController;
use app\Controllers\LoginController;
use app\Controllers\AddSubjectController;
use app\Controllers\SubjectVerificationController;

class Router
{
    public static $routes = [];

    public static function init()
    {
        // ========================= LOGIN ROUTES =========================//
        Router::add('/', fn() => Router::render('Admin/LoginView'));
        Router::add('/faculty', fn() => Router::render('Faculty/PilotLogin'));
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

        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}/publish', fn($data) => (new FacultyController())->publish(
            $data['code'],
            $data['studentId']
        ));

        // ========================= FACULTY STUDENT ROUTES ========================= //
        Router::add('/faculty-students', fn() => (new FacultyController())->facultyStudents());
        Router::add('/faculty-student/studentInformation/{studentId}', fn($data) => (new FacultyController())->facultyStudentInformation($data['studentId']));
        Router::add('/faculty-student/studentApplication', fn() => (new FacultyController())->facultyStudentAppplication());
        Router::add('/faculty-student/studentApplication/{code}/{studentId}/confirm', fn($data) => (new FacultyController())->facultyStudentAppplicationConfirm($data['code'], $data['studentId']));
        Router::add('/faculty-student/studentApplication/{code}/{studentId}/reject', fn($data) => (new FacultyController())->facultyStudentAppplicationReject($data['code'], $data['studentId']));

        Router::add('/logout', fn() => (new FacultyController())->logout());



        // admin


        // Router::add('/', fn() => (new LoginController())->showLogin());
        Router::add('/LoginView', fn() => (new LoginController())->authenticate(), 'POST'); // login form submit

        // Add Faculty routes
        Router::add('/AddFacultyView', fn() => Router::render('Admin/AddFacultyView')); // show add faculty page
        Router::add('/AddFacultySubmit', fn() => (new AddFacultyController())->addFaculty(), 'POST'); // handle POST submit



        Router::add('/DashboardView', fn() => Router::render('Admin/DashboardView')); // show dashboard page
        Router::add('/DashboardView', fn() => (new AddFacultyController())->getcount()); // show dashboard page



        // Router::add('/AddSubjectView', fn() => (new AddSubjectController())->showSubjectForm());
        Router::add('/AddSubjectView', fn() => Router::render('Admin/AddSubjectView'));
        Router::add('/AddSubjectSubmit', fn() => (new AddSubjectController())->addSubject(), 'POST');
        Router::add('/ViewFaculty', fn() => (new AddFacultyController())->readfaculty());


        Router::add('/SubjectVerificationView', fn() => (new SubjectVerificationController())->showPage());
        Router::add('/subject-verification/action', fn() => (new SubjectVerificationController())->handleAction(), 'POST');
        Router::add('/subject-verification/submit', fn() => (new SubjectVerificationController())->submitForVerification(), 'POST');





        // Show Subject form
        Router::add('/ViewSubjects', fn() => (new AddSubjectController())->readSubject());
        Router::add('/ViewSubjects/UpdateSubjectView/{id}', fn($data) => (new AddSubjectController())->showSubjectForm($data['id']), 'GET');
        Router::add('/ViewSubjects/UpdateSubjectView/{id}/Update', fn($data) => (new AddSubjectController())->updateSubject($data['id']), 'POST');




        // Show update form (GET)
        // Show the update form (GET)
        Router::add(
            '/ViewFaculty/UpdateFaculty/{faculty}',
            fn($data) => (new AddFacultyController())->showUpdateForm($data['faculty']),
            'GET'
        );
        // Handle the form submit (POST)
        Router::add(
            '/ViewFaculty/UpdateFaculty/{faculty}/Update',
            fn($data) => (new AddFacultyController())->updateFaculty($data['faculty']),
            'POST'
        );
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
