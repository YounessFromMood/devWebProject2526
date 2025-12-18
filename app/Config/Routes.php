<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('details', 'Home::details');
$routes->get('/', 'Home::index');
