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
        $routes->post('getAgentData', 'MaterialRequisitionController::getAgentData');
        $routes->post('getDropdownData', 'MaterialRequisitionController::getDropdownData');
        $routes->post('getDepartmentData', 'MaterialRequisitionController::getDepartmentData');
        $routes->post('getProvinceData', 'MaterialRequisitionController::getProvinceData');
        $routes->post('getRegionData', 'MaterialRequisitionController::getRegionData');
    });

    $routes->group('manageInventory', function($routes) {
        $routes->post('addInventory', 'ManageInventoryController::addInventory');
        $routes->post('getInventoryData', 'ManageInventoryController::getInventoryData');
        $routes->post('getArchivedInventoryData', 'ManageInventoryController::getArchivedInventoryData');
        $routes->post('getActiveInventoryData', 'ManageInventoryController::getActiveInventoryData');
        $routes->post('archiveInventory/(:num)', 'ManageInventoryController::archiveInventory/$1');
    });

    $routes->group('manageTraining', function($routes) {
        $routes->post('insertTraining', 'AssignTrainingController::insertTraining');
        $routes->post('getTraining', 'AssignTrainingController::getTraining');
        $routes->get('getTrainingByTitle/(:any)', 'AssignTrainingController::getTrainingbyTitle/$1');
        $routes->post('getEmployeeInfo', 'AssignTrainingController::getEmployeeInfo');
        $routes->post('editTraining', 'AssignTrainingController::editTraining');
    });

    // For Beta Testing
    $routes->group('beta', function($routes) {
        $routes->post('doUpload', 'Beta::doUpload');
    });

    $routes->post('insert', 'TestArea::create');

});

