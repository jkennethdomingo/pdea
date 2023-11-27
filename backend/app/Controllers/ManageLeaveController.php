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





}
