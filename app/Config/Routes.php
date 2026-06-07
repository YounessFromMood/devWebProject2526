<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//routes when a user clicks on the website link
$routes->get('/', 'Home::index');

$routes->get('/login', 'Authentificator::loginPage');                        //controller: done
$routes->post('/login', 'Authentificator::toLogIn');                         //controller: done
$routes->get('/register', 'Authentificator::registerPage');                  //controller: done
$routes->post('/register', 'Authentificator::toRegister');                   //controller: done
$routes->get('/logout', 'Authentificator::logout');                          //controller: done

$routes->get('/formations', 'Formation::index');                             //controller: done
$routes->get('/formations/search', 'Formation::search');                     //controller: done
$routes->get('/formations/(:num)', 'Formation::details/$1');                 //controller: exception missing + sessions dates

$routes->get('/session/(:num)', 'Session::index/$1');
//routes for logged in user who needs it's dashboard depending on it's role
$routes->get('/dashboard', 'Dashboard::redirector');                              //controller: done
//routes for logged in user who needs it's history depending on if it's a teach or a student
$routes->get('/history', 'History::index');                                 //controller: missing
//routes for a student to subscribe to a session
$routes->get('/session/registration/(:num)', 'Session::registerPage/$1');    //controller: done
$routes->post('/session/registration/(:num)', 'Session::toRegister/$1');     //controller: done

//STUDENT
$routes->group('student', function($routes){
    //concerning dashboard
    $routes->get('dashboard', 'Student\Dashboard::index');                  //controller: done
    $routes->get('dashboard/planning', 'Student\Dashboard::planning');      //controller: done
    $routes->get('dashboard/my-course', 'Student\Dashboard::courses');      //controller: done
    //concerning history
    $routes->get('history', 'Student\History::index');                       //controller: done
    //concerning grades
    $routes->get('grades', 'Student\Grades::index');                         //controller: done
    //routes for student to check it's grades
    $routes->get('/my-grades', 'Student\Grades::index');                     //controller: done 
    //unsubscribe to a session
    $routes->post('/session/unsubscribe/(:num)', 'Session::unsubscribe/$1'); //controller: done
    //students payment pages
    $routes->get('/payment/(:num)', 'Student\Payment::paymentPage/$1');      //controller: done
    $routes->post('/payment/(:num)', 'Student\Payment::confirmPayment/$1');  //controller: done
});
//TEACHER
$routes->group('teacher', function($routes){
    $routes->get('dashboard', 'Teacher\Dashboard::index');
    $routes->get('history', 'Teacher\History::index');
    //CRUDs
    //grades
    $routes->post('/grades/create/(:num)/(:num)/(:any)', 'Teacher\Grades::createGrade/$1/$2/$3');
    $routes->post('/grades/update/(:num)/(:num)/(:any)', 'Teacher\Grades::updateGrade/$1/$2/$3');
    $routes->post('/grades/delete/(:num)/(:num)/(:any)', 'Teacher\Grades::deleteGrade/$1/$2/$3');
    //sessions
    $routes->post('/session/link/add-link/(:num)/(:any)/','Teacher\Session::createLink/$1/$2');
    $routes->post('/session/link/modify-link/(:num)/(:any)','Teacher\Session::updateLink/$1/$2');
    $routes->post('/session/link/delete-link/(:num)/(:any)','Teacher\Session::deleteLink/$1/$2');
});
//ADMIN
$routes->group('admin', function($routes){
    $routes->get('dashboard', 'Admin\Dashboard::index');
    //CRUDs
    //student
    $routes->get('student/index', 'Admin\Student::index');
    $routes->post('student/create', 'Admin\Student::createStudent');
    $routes->post('student/update', 'Admin\Student::updateStudent');
    $routes->post('student/delete', 'Admin\Student::deleteStudent');
    $routes->get('student/deleted', 'Admin\Student::getDeleted');
    $routes->post('student/restore', 'Admin\Student::restoreStudent');
    //teacher
    $routes->get('teacher/index', 'Admin\Teacher::index');
    $routes->post('teacher/create', 'Admin\Teacher::createTeacher');
    $routes->post('teacher/update', 'Admin\Teacher::updateTeacher');
    $routes->post('teacher/delete', 'Admin\Teacher::deleteTeacher');
    $routes->get('teacher/deleted', 'Admin\Teacher::getDeleted');
    $routes->post('teacher/restore', 'Admin\Teacher::restoreTeacher');
    //session
    $routes->get('session', 'Admin\Session::index');
    $routes->post('session/create', 'Admin\Session::createSession');
    $routes->post('session/update', 'Admin\Session::updateSession');
    $routes->post('session/delete', 'Admin\Session::deleteSession');
    $routes->get('session/deleted', 'Admin\Session::getDeleted');
    $routes->post('session/restore', 'Admin\Session::restoreSession');
    //formation
    $routes->get('formation/index', 'Admin\Formation::index');
    $routes->post('formation/create', 'Admin\Formation::createFormation');
    $routes->post('formation/update', 'Admin\Formation::updateFormation');
    $routes->post('formation/delete', 'Admin\Formation::deleteFormation');
    $routes->get('formation/deleted', 'Admin\Formation::getDeleted');
    $routes->post('formation/restore', 'Admin\Formation::restoreFormation');
    //payments management
    $routes->get('payment', 'Admin\Payment::index');
    $routes->post('payment/confirmPayment', 'Admin\Payment::confirmPayment');
});