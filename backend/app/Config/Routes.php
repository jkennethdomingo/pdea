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
        $routes->post('getEmployeeInformation', 'AccountInformationController::getEmployeeInformation');
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

    $routes->group('manageLeave', function($routes) {
        $routes->post('getEmployeeOnLeave', 'ManageLeaveController::getEmployeeOnLeave');
        $routes->post('getAvailableLeave', 'ManageLeaveController::getAvailableLeave');
        $routes->post('getAllLeaveTypes', 'ManageLeaveController::getAllLeaveTypes');
        $routes->post('getAllEmployees', 'ManageLeaveController::getAllEmployees');
        $routes->post('requestLeave', 'ManageLeaveController::requestLeave');
        $routes->post('manualInputLeave', 'ManageLeaveController::manualInputLeave');
        $routes->post('getPendingLeavesWithDetails', 'ManageLeaveController::getPendingLeavesWithDetails');
        $routes->post('updateLeaveStatus', 'ManageLeaveController::updateLeaveStatus');
        $routes->post('validateAndDeductLeave', 'ManageLeaveController::validateAndDeductLeave');
        $routes->post('getEmployeeLeaveTypesWithBalance', 'ManageLeaveController::getEmployeeLeaveTypesWithBalance');
        $routes->post('fetchPendingLeaveRequests', 'ManageLeaveController::fetchPendingLeaveRequests');
    });

    // For Beta Testing
    $routes->group('beta', function($routes) {
        $routes->post('doUpload', 'Beta::doUpload');
    });

    $routes->group('database', function($routes) {
        $routes->get('backup', 'BackupDatabaseController::backup');
        $routes->get('restore', 'RestoreDatabaseController::restore');
    });

    $routes->group('hrDashboard', function($routes) {
        $routes->post('getTodaysLeavesCount', 'HumanResourceDashboardController::getTodaysLeavesCount');
        $routes->post('getTodayTrainingCount', 'HumanResourceDashboardController::getTodayTrainingCount');
        $routes->post('getTodayOnTrainingCount', 'HumanResourceDashboardController::getTodayOnTrainingCount');
        $routes->post('getActiveEmployeesCount', 'HumanResourceDashboardController::getActiveEmployeesCount');
        $routes->post('getEmployeeStatusPercentages', 'HumanResourceDashboardController::getEmployeeStatusPercentages');
        $routes->post('getTrainingCountsForLast13Days', 'HumanResourceDashboardController::getTrainingCountsForLast13Days');
        $routes->post('getActiveEmployeesCountForLast13Days', 'HumanResourceDashboardController::getActiveEmployeesCountForLast13Days');
        $routes->post('getCombinedEvents', 'HumanResourceDashboardController::getCombinedEvents');
        $routes->post('getUpcomingEvents', 'HumanResourceDashboardController::getUpcomingEvents');
        $routes->post('fetchRecentlyApprovedLeaves', 'HumanResourceDashboardController::fetchRecentlyApprovedLeaves');
        $routes->post('fetchUpcomingTrainingsWithNoAssignedEmployees', 'HumanResourceDashboardController::fetchUpcomingTrainingsWithNoAssignedEmployees');
        $routes->post('fetchCountOfUpcomingTrainingsWithNoAssignedEmployees', 'HumanResourceDashboardController::fetchCountOfUpcomingTrainingsWithNoAssignedEmployees');
    });


    $routes->post('insert', 'TestArea::create');

});

