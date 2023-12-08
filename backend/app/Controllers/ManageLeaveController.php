<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use DateTime;

class ManageLeaveController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $leavetypeModel;
    protected $leaveBalanceModel;
    protected $employeeLeavesModel;
    protected $leaveRequestNotesModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->leavetypeModel = Services::leavetypeModel();
        $this->leaveBalanceModel = Services::leaveBalanceModel();
        $this->employeeLeavesModel = Services::EmployeeLeavesModel();
        $this->leaveRequestNotesModel = Services::LeaveRequestNotesModel();
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
            ->select('leave_type.LeaveTypeName, leave_balance.LeaveTypeID, leave_balance.NumberofLeaves as TotalLeave')
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

        if (!$leaveBalance || $leaveBalance['NumberofLeaves'] <= 0) {
            return $this->fail('No available leave balance for the requested type.', 400);
        }

        // Calculate the number of days requested
        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);
        $daysRequested = $endDate->diff($startDate)->days + 1; // +1 to include the start date

        // Validate if the employee has enough days left
        if ($daysRequested > $leaveBalance['NumberofLeaves']) {
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
        $data = $this->request->getJSON(true);

        // Start a transaction using the employeeLeavesModel's database connection
        $this->employeeLeavesModel->db->transStart();

        if (!isset($data['EmployeeID'], $data['leave_type_id'], $data['start_date'], $data['end_date'], $data['reason'])) {
            $this->employeeLeavesModel->db->transComplete();
            return $this->fail('All fields are required.', 400);
        }

        $startDate = new \DateTime($data['start_date']);
        $endDate = new \DateTime($data['end_date']);

        if ($endDate < $startDate) {
            $this->employeeLeavesModel->db->transComplete();
            return $this->fail('End date must be after the start date.', 400);
        }

        $daysRequested = $endDate->diff($startDate)->days + 1;

        $leaveBalance = $this->leaveBalanceModel->where('EmployeeID', $data['EmployeeID'])
                                                ->where('LeaveTypeID', $data['leave_type_id'])
                                                ->first();

        if (!$leaveBalance) {
            $this->employeeLeavesModel->db->transComplete();
            return $this->fail('Employee does not have a leave balance record.', 400);
        }

        // Check if the employee has sufficient leave balance for the requested leave
        if ($leaveBalance['NumberofLeaves'] < $daysRequested) {
            $this->employeeLeavesModel->db->transComplete();
            return $this->fail('Employee does not have sufficient leave balance for the requested leave.', 400);
        }

        $leaveRequestData = [
            'EmployeeID' => $data['EmployeeID'],
            'leave_type_id' => $data['leave_type_id'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'status' => 'approved' // Assuming HR has approved this manually
        ];

        $result = $this->employeeLeavesModel->insert($leaveRequestData);

        if (!$result) {
            $this->employeeLeavesModel->db->transRollback();
            return $this->fail($this->employeeLeavesModel->errors(), 400);
        }

        // Deduct the requested days from the leave balance
        $newBalance = $leaveBalance['NumberofLeaves'] - $daysRequested;
        $leaveBalanceUpdateResult = $this->leaveBalanceModel->update($leaveBalance['LeaveBalanceID'], ['NumberofLeaves' => $newBalance]);

        if (!$leaveBalanceUpdateResult) {
            $this->employeeLeavesModel->db->transRollback();
            return $this->fail($this->leaveBalanceModel->errors(), 400);
        }

        if ($this->employeeLeavesModel->db->transStatus() === FALSE) {
            $this->employeeLeavesModel->db->transRollback();
            return $this->fail('Transaction failed: Unable to input leave and update balance.', 400);
        } else {
            $this->employeeLeavesModel->db->transComplete();
            $response = [
                'status' => 201,
                'message' => 'Leave entry added and balance updated successfully.',
                'data' => $leaveRequestData
            ];
            return $this->respondCreated($response);
        }
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
            leave_balance.NumberofLeaves as RemainingLeaveBalance
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

    public function validateAndDeductLeave($leaveRequestId)
    {
        $employeeLeavesModel = $this->employeeLeavesModel;
        $leaveBalanceModel = $this->leaveBalanceModel; // Ensure this is set up in your constructor

        // Fetch the leave request by ID
        $leaveRequest = $employeeLeavesModel->find($leaveRequestId);

        if (!$leaveRequest) {
            return $this->fail('Leave request not found.', 404);
        }

        // Check if the leave request is already processed
        if ($leaveRequest['status'] !== 'pending') {
            return $this->fail('Leave request is already processed.', 400);
        }

        // Fetch the leave balance
        $leaveBalance = $leaveBalanceModel->where('EmployeeID', $leaveRequest['EmployeeID'])
                                        ->where('LeaveTypeID', $leaveRequest['leave_type_id'])
                                        ->first();

        if (!$leaveBalance || $leaveBalance['NumberofLeaves'] <= 0) {
            return $this->fail('No available leave balance for the requested type.', 400);
        }

        // Calculate the number of days requested
        $startDate = new \DateTime($leaveRequest['start_date']);
        $endDate = new \DateTime($leaveRequest['end_date']);
        $daysRequested = $endDate->diff($startDate)->days + 1; // +1 to include the start date

        // Validate if the employee has enough days left
        if ($daysRequested > $leaveBalance['NumberofLeaves']) {
            return $this->fail('Insufficient leave balance for the requested dates.', 400);
        }

        // Start a transaction
        $employeeLeavesModel->db->transStart();

        // Deduct the requested days from the leave balance
        $newBalance = $leaveBalance['NumberofLeaves'] - $daysRequested;
        $leaveBalanceUpdateResult = $leaveBalanceModel->update($leaveBalance['LeaveBalanceID'], ['NumberofLeaves' => $newBalance]);

        if (!$leaveBalanceUpdateResult) {
            $employeeLeavesModel->db->transRollback();
            return $this->fail($leaveBalanceModel->errors(), 400);
        }

        // Update the status of the leave request to 'approved'
        $leaveRequestUpdateResult = $employeeLeavesModel->update($leaveRequestId, ['status' => 'approved']);

        if (!$leaveRequestUpdateResult) {
            $employeeLeavesModel->db->transRollback();
            return $this->fail($employeeLeavesModel->errors(), 400);
        }

        // Complete the transaction
        if ($employeeLeavesModel->db->transStatus() === FALSE) {
            $employeeLeavesModel->db->transRollback();
            return $this->fail('Transaction failed: Unable to approve leave and update balance.', 400);
        } else {
            $employeeLeavesModel->db->transComplete();
            $response = [
                'status' => 200,
                'message' => 'Leave approved and balance updated successfully.',
                'data' => [
                    'leaveRequestId' => $leaveRequestId,
                    'newBalance' => $newBalance
                ]
            ];
            return $this->respond($response);
        }
    }

    public function getEmployeeLeaveTypesWithBalance()
    {
        $leavetypeModel = $this->leavetypeModel; // Your leave type model
        $leaveBalanceModel = $this->leaveBalanceModel; // Your leave balance model

        $data = $this->request->getJSON(true);
        $employeeID = $data['EmployeeID'] ?? null; // Get the EmployeeID from the JSON payload

        if (!$employeeID) {
            return $this->fail('Employee ID is required.', 400);
        }

        // Query the database for all leave types
        $leaveTypes = $leavetypeModel->findAll();

        // Prepare the response array
        $response = [];
        foreach ($leaveTypes as $type) {
            // For each leave type, get the corresponding leave balance for the employee
            $balance = $leaveBalanceModel->where('EmployeeID', $employeeID)
                                        ->where('LeaveTypeID', $type['LeaveTypeID'])
                                        ->first();

            // If there's no balance record for the type, it could mean the employee has not been allocated that type of leave
            $numberofLeaves = $balance['NumberofLeaves'] ?? 0; // Default to 0 if no record found

            $response[] = [
                'LeaveTypeID' => $type['LeaveTypeID'],
                'LeaveTypeName' => $type['LeaveTypeName'],
                'RemainingBalance' => $numberofLeaves
            ];
        }

        // Return the response as JSON
        return $this->respond($response);
    }

    public function fetchPendingLeaveRequests()
    {
        $employeeLeavesModel = $this->employeeLeavesModel;
        $personalInformationModel = $this->personalInformationModel;
        $leavetypeModel = $this->leavetypeModel; // Your leave type model
        $leaveBalanceModel = $this->leaveBalanceModel; // Your leave balance model

        // Fetch pending leave requests along with employee and leave type information
        $pendingLeaves = $employeeLeavesModel
            ->select('employee_leaves.*, personal_information.first_name, personal_information.surname, personal_information.photo, leave_type.LeaveTypeName, leave_balance.NumberofLeaves')
            ->join('personal_information', 'personal_information.EmployeeID = employee_leaves.EmployeeID')
            ->join('leave_type', 'leave_type.LeaveTypeID = employee_leaves.leave_type_id')
            ->join('leave_balance', 'leave_balance.EmployeeID = employee_leaves.EmployeeID AND leave_balance.LeaveTypeID = employee_leaves.leave_type_id')
            ->where('employee_leaves.status', 'pending')
            ->findAll();

        // Prepare the response array
        $response = array_map(function ($leave) {
            return [
                'LeaveID' => $leave['id'], // Include the LeaveID from the employee_leaves table
                'EmployeeID' => $leave['EmployeeID'],
                'EmployeeName' => $leave['first_name'] . ' ' . $leave['surname'],
                'EmployeePhoto' => $leave['photo'], // Assuming the photo field contains the URL/path to the employee's photo
                'LeaveTypeName' => $leave['LeaveTypeName'],
                'RemainingBalance' => $leave['NumberofLeaves'], // Number of leaves remaining for this type
                'StartDate' => $leave['start_date'],
                'EndDate' => $leave['end_date'],
                'Reason' => $leave['reason'],
                'TimeRequested' => $leave['created_at'],
                // 'HRNote' field would be added here once you have that implemented
            ];
        }, $pendingLeaves);

        // Return the response as JSON
        return $this->respond($response);
    }


    



}
