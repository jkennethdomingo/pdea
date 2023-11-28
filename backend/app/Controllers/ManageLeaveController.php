<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class ManageLeaveController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $leavetypeModel;
    protected $leaveBalanceModel;
    protected $employeeLeavesModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->leavetypeModel = Services::leavetypeModel();
        $this->leaveBalanceModel = Services::leaveBalanceModel();
        $this->employeeLeavesModel = Services::EmployeeLeavesModel();
    }

    public function getEmployeeOnLeave()
    {
        $builder = $this->employeeLeavesModel->builder();
        
        $builder->select('
            employee_leaves.id,
            employee_leaves.EmployeeID,
            employee_leaves.leave_type_id,
            employee_leaves.start_date,
            employee_leaves.end_date,
            employee_leaves.reason,
            employee_leaves.status,
            personal_information.surname,
            personal_information.first_name,
            leave_type.LeaveTypeName
        ');
        $builder->join('personal_information', 'employee_leaves.EmployeeID = personal_information.EmployeeID', 'inner');
        $builder->join('leave_type', 'employee_leaves.leave_type_id = leave_type.LeaveTypeID', 'inner');
        
        $query = $builder->get();
        
        $data = [
            'EmployeeOnLeave' => $query->getResult(),
        ];

        return $this->respond($data);
    }

    public function getAvailableLeave()
    {
        $employeeId = $this->request->getPost('EmployeeID');

        if (!$employeeId) {
            return $this->fail('Employee ID is required.', 400);
        }

        // Get the total leave balances for the employee, grouped by leave type
        $leaveBalances = $this->leaveBalanceModel
            ->select('leave_type.LeaveTypeName, leave_balance.LeaveTypeID, leave_balance.NumberOfLeaves as TotalLeave')
            ->join('leave_type', 'leave_balance.LeaveTypeID = leave_type.LeaveTypeID')
            ->where('leave_balance.EmployeeID', $employeeId)
            ->findAll();

        $availableLeavesPerType = [];

        foreach ($leaveBalances as $leaveBalance) {
            // Get the total leave taken by the employee for each leave type
            $leavesTaken = $this->employeeLeavesModel
                ->select('SUM(DATEDIFF(end_date, start_date) + 1) as LeavesTaken') // +1 to include both start and end dates
                ->where('EmployeeID', $employeeId)
                ->where('leave_type_id', $leaveBalance['LeaveTypeID'])
                ->where('status', 'approved')
                ->first();

            $leavesTakenCount = $leavesTaken['LeavesTaken'] ?? 0;

            // Calculate available leave for each type
            $availableLeave = $leaveBalance['TotalLeave'] - $leavesTakenCount;

            // Add to the result array
            $availableLeavesPerType[] = [
                'LeaveType' => $leaveBalance['LeaveTypeName'],
                'LeaveTypeID' => $leaveBalance['LeaveTypeID'], // Include LeaveTypeID in the result
                'AvailableLeave' => $availableLeave
            ];
        }

        return $this->respond(['availableLeavesPerType' => $availableLeavesPerType]);
    }

    public function getAllLeaveTypes()
    {
        $leaveTypeModel = $this->leavetypeModel; // Assuming you have already set this up in your constructor

        // Query the database for all leave types
        $leaveTypes = $leaveTypeModel->findAll();

        // Prepare the response array
        $response = [];
        foreach ($leaveTypes as $type) {
            $response[] = [
                'LeaveTypeID' => $type['LeaveTypeID'],
                'LeaveTypeName' => $type['LeaveTypeName']
            ];
        }

        // Return the response as JSON
        return $this->respond($response);
    }

    public function getAllEmployees()
    {
        $personalInformationModel = $this->personalInformationModel; // Assuming you have already set this up in your constructor

        // Query the database for all personal information
        $employees = $personalInformationModel->findAll();

        // Prepare the response array
        $response = [];
        foreach ($employees as $employee) {
            $response[] = [
                'EmployeeID' => $employee['EmployeeID'],
                'FirstName' => $employee['first_name'],
                'Surname' => $employee['surname'],
                'MiddleName' => $employee['middle_name'],
                'Photo' => $employee['photo'] // Make sure the photo field contains a path or a base64 encoded string
            ];
        }

        // Return the response as JSON
        return $this->respond($response);
    }

    public function requestLeave()
    {
        $employeeLeavesModel = $this->employeeLeavesModel;
        $leaveBalanceModel = $this->leaveBalanceModel; // Ensure this is set up in your constructor

        $data = $this->request->getJSON(true);

        // Basic validation for required fields
        if (!isset($data['EmployeeID'], $data['leave_type_id'], $data['start_date'], $data['end_date'], $data['reason'])) {
            return $this->fail('All fields are required.', 400);
        }

        // Additional validation such as date format, range, etc.
        // ...

        // Check if the employee has sufficient leave balance for the requested type
        $leaveBalance = $leaveBalanceModel->where('EmployeeID', $data['EmployeeID'])
                                        ->where('LeaveTypeID', $data['leave_type_id'])
                                        ->first();

        if (!$leaveBalance || $leaveBalance['NumberOfLeaves'] <= 0) {
            return $this->fail('No available leave balance for the requested type.', 400);
        }

        // Calculate the number of days requested
        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);
        $daysRequested = $endDate->diff($startDate)->days + 1; // +1 to include the start date

        // Validate if the employee has enough days left
        if ($daysRequested > $leaveBalance['NumberOfLeaves']) {
            return $this->fail('Insufficient leave balance for the requested dates.', 400);
        }

        // Prepare the data for insertion
        $leaveRequestData = [
            'EmployeeID' => $data['EmployeeID'],
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'status' => 'pending' // Default status is pending
        ];

        // Insert the leave request into the database
        $result = $employeeLeavesModel->insert($leaveRequestData);

        if ($result === false) {
            return $this->fail($employeeLeavesModel->errors(), 400);
        }

        // Return success response
        $response = [
            'status' => 201,
            'message' => 'Leave request submitted successfully.',
            'data' => $leaveRequestData
        ];

        return $this->respondCreated($response);
    }

    public function manualInputLeave()
    {
        $employeeLeavesModel = $this->employeeLeavesModel;
        $leaveBalanceModel = $this->leaveBalanceModel; // Ensure this is set up in your constructor

        $data = $this->request->getJSON(true);

        // Basic validation for required fields
        if (!isset($data['EmployeeID'], $data['leave_type_id'], $data['start_date'], $data['end_date'], $data['reason'])) {
            return $this->fail('All fields are required.', 400);
        }

        // Additional validation such as date format, range, etc.
        // ...

        // Check if the employee has sufficient leave balance for the requested type
        $leaveBalance = $leaveBalanceModel->where('EmployeeID', $data['EmployeeID'])
                                        ->where('LeaveTypeID', $data['leave_type_id'])
                                        ->first();

        // Calculate the number of days for the leave
        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);
        $daysRequested = $endDate->diff($startDate)->days + 1; // +1 to include the start date

        // No need to check for insufficient balance since it's an HR manual input, but you can log or notify if the balance goes negative.

        // Prepare the data for insertion
        $leaveRequestData = [
            'EmployeeID' => $data['EmployeeID'],
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'status' => 'approved' // Since it's HR input, we set the status to approved directly
        ];

        // Insert the approved leave into the database
        $result = $employeeLeavesModel->insert($leaveRequestData);

        if ($result === false) {
            return $this->fail($employeeLeavesModel->errors(), 400);
        }

        // Update the leave balance if necessary
        if ($leaveBalance && isset($leaveBalance['NumberOfLeaves']) && $leaveBalance['NumberOfLeaves'] > 0) {
            $newBalance = $leaveBalance['NumberOfLeaves'] - $daysRequested;
            $leaveBalanceModel->update($leaveBalance['LeaveBalanceID'], ['NumberOfLeaves' => $newBalance]);
        }

        // Return success response
        $response = [
            'status' => 201,
            'message' => 'Leave entry added successfully.',
            'data' => $leaveRequestData
        ];

        return $this->respondCreated($response);
    }

    public function getPendingLeavesWithDetails()
    {
        $employeeLeavesModel = $this->employeeLeavesModel;
        $leaveBalanceModel = $this->leaveBalanceModel; // Make sure this is set in your constructor
        $personalInformationModel = $this->personalInformationModel;
        $leaveTypeModel = $this->leavetypeModel;

        // Build the query using Query Builder
        $builder = $employeeLeavesModel->builder();
        $builder->select('
            employee_leaves.id,
            employee_leaves.EmployeeID,
            employee_leaves.leave_type_id,
            employee_leaves.start_date,
            employee_leaves.end_date,
            employee_leaves.reason,
            employee_leaves.status,
            personal_information.surname,
            personal_information.first_name,
            personal_information.middle_name,
            leave_type.LeaveTypeName,
            leave_balance.NumberOfLeaves as RemainingLeaveBalance
        ');
        $builder->join('personal_information', 'employee_leaves.EmployeeID = personal_information.EmployeeID', 'inner');
        $builder->join('leave_type', 'employee_leaves.leave_type_id = leave_type.LeaveTypeID', 'inner');
        $builder->join('leave_balance', 'employee_leaves.EmployeeID = leave_balance.EmployeeID AND employee_leaves.leave_type_id = leave_balance.LeaveTypeID', 'inner');
        $builder->where('employee_leaves.status', 'pending');

        $query = $builder->get();

        $data = [
            'pendingLeaves' => $query->getResult(),
        ];

        return $this->respond($data);
    }

    public function updateLeaveStatus()
    {
        $employeeLeavesModel = $this->employeeLeavesModel; // Ensure this is set in your constructor

        // Get the JSON data from the request body
        $data = $this->request->getJSON(true);

        // Basic validation for required fields
        if (!isset($data['id'], $data['action'])) {
            return $this->fail('Leave request ID and action are required.', 400);
        }

        $leaveRequestId = $data['id'];
        $action = $data['action']; // 'approve' or 'reject'

        // Fetch the leave request
        $leaveRequest = $employeeLeavesModel->find($leaveRequestId);
        if (!$leaveRequest) {
            return $this->failNotFound('Leave request not found.');
        }

        // Update the status based on the action
        $status = $action === 'approve' ? 'approved' : ($action === 'reject' ? 'rejected' : null);
        
        // If action is not 'approve' or 'reject', return an error
        if ($status === null) {
            return $this->fail('Invalid action. It must be either "approve" or "reject".', 400);
        }

        // Update the leave request status
        $updateResult = $employeeLeavesModel->update($leaveRequestId, ['status' => $status]);

        if (!$updateResult) {
            return $this->failServerError('Unable to update leave request status.');
        }

        // Return success response
        $responseMessage = $action === 'approve' ? 'Leave request approved successfully.' : 'Leave request rejected successfully.';
        return $this->respondUpdated(['message' => $responseMessage]);
    }




}
