<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function($routes) 
{
    $routes->group('auth', function($routes) {
        $routes->post('login', 'AuthController::login');
    });

    $routes->group('employee', function($routes) {
        $routes->post('insert', 'EmployeeController::create', ['filter' => 'role:role=HR_ADMIN']);
        $routes->post('getDataforDropdown', 'EmployeeController::getDataForDropdowns', ['filter' => 'role:role=HR_ADMIN']);
    });

});

