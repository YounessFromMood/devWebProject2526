<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//routes when a user clicks on the website link
$routes->get('/', 'Home::index');

$routes->get('/login', 'Authentificator::loginPage');
$routes->get('/login/(:num)', 'Authentificator::toLogInAndRedirect\$1');
$routes->post('/login', 'Authentificator::toLogIn');
$routes->get('/register', 'Authentificator::registerPage');
$routes->post('/register', 'Authentificator::toRegister');

$routes->get('/formations', 'Formation::index');
$routes->get('/formations/search', 'Formation::search');
$routes->get('/formations/(:num)', 'Formation::details/$1');

$routes->get('/logout', 'Authentificator::logout');
//routes for logged in user who needs it's dashboard depending on it's role
$routes->get('/dashboard/(:num)', 'Dashboard::index/$1');
$routes->get('student/dashboard/(:num)', 'Student\Dashboard::index/$1');
$routes->get('admin/dashboard/(:num)', 'Admin\Dashboard::index/$1');
$routes->get('teacher/dashboard/(:num)', 'Teacher\Dashboard::index/$1');
//routes for logged in user who needs it's history depending on if it's a teach or a student
$routes->get('/history/(:num)', 'History::index/$1');
$routes->get('student/history/(:num)', 'Student\History::index/$1');
$routes->get('teacher/history/(:num)', 'Teacher\History::index/$1');
//routes for a student to subscribe to a session
$routes->get('/session/registration/(:num)', 'Session::registerPage/$1');
$routes->post('/session/registration/(:num)', 'Session::toRegister/$1');
$routes->post('/session/unsubscribe/(:num)', 'Session::unsubscribe/$1');
//students payment pages
$routes->get('/payment/(:num)', 'Student\Payment::paymentPage/$1');
$routes->post('/payment/(:num)', 'Student\Payment::confirmPayment/$1');
//admin actions
$routes->get('/admin/student', 'Admin\Student::studentAdmin');
$routes->post('/admin/student/create', 'Admin\Student::createStudent');
$routes->post('/admin/student/update', 'Admin\Student::updateStudent');
$routes->post('/admin/student/delete', 'Admin\Student::deleteStudent');

$routes->get('/admin/session', 'Admin\Session::sessionAdmin');
$routes->post('/admin/session/create', 'Admin\Session::createSession');
$routes->post('/admin/session/update', 'Admin\Session::updateSession');
$routes->post('/admin/session/delete', 'Admin\Session::deleteSession');

$routes->get('/admin/teacher', 'Admin\Teacher::teacherAdmin');
$routes->post('/admin/teacher/create', 'Admin\Teacher::createTeacher');
$routes->post('/admin/teacher/update', 'Admin\Teacher::updateTeacher');
$routes->post('/admin/teacher/delete', 'Admin\Teacher::deleteTeacher');

$routes->get('/admin/formation', 'Admin\Formation::formationAdmin');
$routes->post('/admin/formation/create', 'Admin\Formation::createFormation');
$routes->post('/admin/formation/update', 'Admin\Formation::updateFormation');
$routes->post('/admin/formation/delete', 'Admin\Formation::deleteFormation');

$routes->get('/admin/payment', 'Admin\Payment::paymentAdmin');
$routes->post('/admin/payment/confirmPayment', 'Admin\Payment::confirmPayment');
$routes->post('/admin/payment/confirmRefund', 'Admin\Payment::confirmRefund');
//routes for grades
$routes->get('/my-grades', 'Student\Grades::index');
$routes->get('/my-grades/(:num)','Student\Grades::getGrade/$1');
$routes->post('/grades/create/(:num)/(:num)', 'Teacher\Grades::createGrade/$1/$2');
$routes->post('/grades/update/(:num)/(:num)', 'Teacher\Grades::updateGrade/$1/$2');
$routes->post('/grades/delete/(:num)/(:num)', 'Teacher\Grades::deleteGrade/$1/$2');
//routes for session links to give
$routes->post('/session/link/add-link/(:any)','Teacher\Session::createLink');
$routes->post('/session/link/modify-link/(:any)','Teacher\Session::updateLink');
$routes->post('/session/link/delete-link/(:any)','Teacher\Session::deleteLink');