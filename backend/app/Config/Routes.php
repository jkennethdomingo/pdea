<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('api', function($routes) 
{
    $routes->post('login', 'AuthController::login');
    $routes->post('insert', 'AuthController::create');
});
