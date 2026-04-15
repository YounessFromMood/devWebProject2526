<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//routes when a user clicks on the website link
$routes->get('/', 'Home::index');
$routes->get('/login', 'Authentificator::loginPage');
$routes->post('/login', 'Authentificator::toLogIn');
$routes->get('/register', 'Authentificator::registerPage');
$routes->get('/register', 'Authentificator::toRegister');
//routes for logged in user who needs it's history depending on if it's a teach or a student
$routes->get('/dashboard', 'Dashboard::index');
$routes->get('/history', 'History::index');
//routes for a student to subscribe to a session
$routes->get('/session/registration', 'Session::registerPage');
$routes->post('/session/registration', 'Session::toRegister');
$routes->post('/session/unsubscribe', 'Session::unsubscribe');
//students payment pages
$routes->get('/payment/(:sessionId)', 'Payment::paymentPage/$sessionId');
$routes->post('/payment/(:sessionId)', 'Payment::confirmPayment/$sessionId');
