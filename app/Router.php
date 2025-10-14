<?php

namespace app;

use app\Controllers\FacultyController;
use app\Controllers\AdminController;
use app\Controllers\StudentController;

class Router
{
    public static $routes = [];

    public static function init()
    {
        // ============================================== LOGIN ROUTES ==============================================//
        Router::add('/', fn() => Router::render('PilotLogin'));
        Router::add('/faculty', fn() => Router::render('Faculty/PilotLogin'));
        Router::add('/login', fn() => (new FacultyController())->login(), 'POST');

        // ============================================== FACULTY DASHBORAD ROUTES ============================================== //
        Router::add('/faculty-dashboard', fn() => (new FacultyController())->facultyDashboard());
        Router::add('/faculty-subjectsAvailable', fn() => (new FacultyController())->availableSubjects());
        Router::add('/faculty-subjects', fn() => (new FacultyController())->facultySubjects());
        Router::add('/faculty-profile', fn() => (new FacultyController())->facultyProfile());

        // ============================================== FACULTY PROFILE ROUTES ============================================== //
        Router::add('/faculty-profile/EditProfile', fn() => (new FacultyController())->editFacultyProfile());
        Router::add('/faculty-profile/ChangePassword', fn() => (new FacultyController())->facultyProfileChangePassword());

        // ============================================== SUBJECT APPLICATION ROUTES ============================================== //
        Router::add('/faculty-subjectApplication/{code}', fn($data) => (new FacultyController())->facultySubjectApplication($data['code']));
        Router::add('/faculty-subject/PendingApplication', fn() => (new FacultyController())->facultySubjectsPendingApplication());

        // ============================================== FACULTY GRADING ROUTES ============================================== //
        Router::add('/faculty-grading/{code}', fn($data) => (new FacultyController())->facultyGradingStudents($data['code']));
        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}', fn($data) => (new FacultyController())->recordedStudentGrade($data['code'], $data['studentId']), 'GET');
        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}/edit', fn($data) => (new FacultyController())->edit($data['code'], $data['studentId']), 'POST');
        Router::add('/faculty-grading/GradeStudent/{code}/{studentId}/publish', fn($data) => (new FacultyController())->publish($data['code'],$data['studentId']));

        // ============================================== FACULTY STUDENT ROUTES ============================================== //
        Router::add('/faculty-students', fn() => (new FacultyController())->facultyStudents());
        Router::add('/faculty-student/studentInformation/{studentId}', fn($data) => (new FacultyController())->facultyStudentInformation($data['studentId']));
        Router::add('/faculty-student/studentApplication', fn() => (new FacultyController())->facultyStudentAppplication());
        Router::add('/faculty-student/studentApplication/{code}/{studentId}/confirm', fn($data) => (new FacultyController())->facultyStudentAppplicationConfirm($data['code'], $data['studentId']));
        Router::add('/faculty-student/studentApplication/{code}/{studentId}/reject', fn($data) => (new FacultyController())->facultyStudentAppplicationReject($data['code'], $data['studentId']));


        Router::add('/faculty-gradeSummary', fn() => (new FacultyController())->facultyGradeSummary());
        Router::add('/faculty-gradeSummary/{code}', fn($data) => (new FacultyController())->facultyViewGradeSummary($data['code']));
        


        // ============================================== LOGOUT ROUTE ============================================== //
        Router::add('/logout', fn() => (new FacultyController())->logout());



        // admin

        Router::add('/login-admin', fn() => (new AdminController())->login(), 'POST'); // login form submit


        // ============================================ DASHBOARD ROUTE ============================================ //
        Router::add('/Admin-Dashboard', fn() => (new AdminController())->dashboard());

        // ============================================ FACULTY ROUTE ============================================ //
        Router::add('/ViewFaculty', fn() => (new AdminController())->readfaculty());
        Router::add('/AddFacultyView', fn() => Router::render('Admin/AddFacultyView')); // show add faculty page
        Router::add('/AddFacultySubmit', fn() => (new AdminController())->addFaculty(), 'POST'); // handle POST submit
        Router::add('/ViewFaculty/UpdateFaculty/{faculty}', fn($data) => (new AdminController())->showUpdateForm($data['faculty']), 'GET');
        Router::add('/ViewFaculty/UpdateFaculty/{faculty}/Update', fn($data) => (new AdminController())->updateFaculty($data['faculty']), 'POST');

        // ============================================ SUBJECTS ROUTE ============================================ //
        Router::add('/ViewSubjects', fn() => (new AdminController())->readSubject());
        Router::add('/AddSubjectView', fn() => Router::render('Admin/AddSubjectView'));
        Router::add('/AddSubjectSubmit', fn() => (new AdminController())->addSubject(), 'POST');
        Router::add('/ViewSubjects/UpdateSubjectView/{id}', fn($data) => (new AdminController())->showSubjectForm($data['id']), 'GET');
        Router::add('/ViewSubjects/UpdateSubjectView/{id}/Update', fn($data) => (new AdminController())->updateSubject($data['id']), 'POST');

        // ============================================ SUBJECT VERIFICATION ROUTE ============================================ //
        Router::add('/SubjectVerificationView', fn() => (new AdminController())->showPage());
        Router::add('/subject-verification/action', fn() => (new AdminController())->handleAction(), 'POST');
        Router::add('/subject-verification/submit', fn() => (new AdminController())->submitForVerification(), 'POST');




        // ============================================ STUDENT PAGE =============================================== //
        Router::add('/student', fn() => Router::render('Student/Login'));
        Router::add('/login-student', fn() => (new StudentController())->login());
        Router::add('/student-dashboard', fn() => (new StudentController())->studentDashboard());
        Router::add('/joinClassView', fn() => (new StudentController())->availableClass());
        Router::add('/joinClass/{subjectCode}', fn($data) => (new StudentController())->joinClass($data['subjectCode']));
        Router::add('/mysubjects', fn() => (new StudentController())->getStudentSubjects());
        Router::add('/viewgrade', fn() => (new StudentController())->getStudentGrades());
        Router::add('/subjectGrade/{subjectId}', fn($data) => (new StudentController())->getSubjectGrades($data['subjectId']));
        Router::add('/profile', fn() => (new StudentController())->getStudentInfo());
        Router::add('/parent-dashboard', fn() => (new StudentController())->getGradeSummary());

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
