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
}
