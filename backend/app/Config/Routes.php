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
        $routes->post('insert', 'AccountInformationController::create');
        $routes->post('getDropdownData', 'AccountInformationController::getDropdownData');
    });

    $routes->group('materialRequisition', function($routes) {
        $routes->post('insert', 'MaterialRequisitionController::assignAsset');
        $routes->post('getData', 'MaterialRequisitionController::getData');
    });

    $routes->post('insert', 'TestArea::create');

});

