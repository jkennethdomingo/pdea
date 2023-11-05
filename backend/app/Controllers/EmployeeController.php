<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;
use App\Models\AuthRoleModel;
use App\Models\EmployeeAuthRoleModel;
use App\Models\DesignationModel;
use App\Models\EmployeeDesignationModel;
use App\Models\SectionModel;
use App\Models\EmployeeSectionModel;
use App\Models\LeaveBalanceModel;
use App\Models\LeavetypeModel;

class EmployeeController extends ResourceController
{
    use ResponseTrait;

    protected $employeeModel;
    protected $authRoleModel;
    protected $employeeAuthRoleModel;
    protected $designationModel;
    protected $employeeDesignationModel;
    protected $sectionModel;
    protected $employeeSectionModel;
    protected $leaveBalanceModel;
    protected $leavetypeModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->authRoleModel = new AuthRoleModel();
        $this->employeeAuthRoleModel = new EmployeeAuthRoleModel();
        $this->designationModel = new DesignationModel();
        $this->employeeDesignationModel = new EmployeeDesignationModel();
        $this->sectionModel = new SectionModel();
        $this->employeeSectionModel = new EmployeeSectionModel();
        $this->leaveBalanceModel = new LeaveBalanceModel();
        $this->leavetypeModel = new LeavetypeModel();
    }

    public function create()
    {
        $json = $this->request->getJSON();

        // Prepare data for validation
        $data = [
            'EmployeeID' => esc($json->EmployeeID ?? ''),
            'Name' => esc($json->Name ?? ''),
            'Email' => filter_var($json->Email ?? '', FILTER_SANITIZE_EMAIL),
            'Password' => $json->Password ?? '',
            'PhoneNumber' => filter_var($json->PhoneNumber ?? '', FILTER_SANITIZE_NUMBER_INT),
            'Address' => esc($json->Address ?? ''),
            'DateOfBirth' => esc($json->DateOfBirth ?? ''),
            'DateOfEntry' => esc($json->DateOfEntry ?? date("Y-m-d")),
            'EducationalAttainment' => esc($json->EducationalAttainment ?? ''),
            'Eligibility' => esc($json->Eligibility ?? ''),
            'IPCR' => esc($json->IPCR ?? ''),
            'AuthRoleID' => esc($json->AuthRoleID ?? ''),
            'DesignationID' => esc($json->DesignationID ?? ''),
            'SectionID' => esc($json->SectionID ?? ''),
        ];
        
        // Validation rules
        $validationRules = $this->getValidationRules();

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        // Hash the password after validation
        $pepper = getenv('PASSWORD_PEPPER'); // Retrieve pepper from config or environment

        // Apply the pepper and hash the password
        $pepperedPassword = hash_hmac('sha256', $data['Password'], $pepper);
        $data['Password'] = password_hash($pepperedPassword, PASSWORD_ARGON2ID);

        // Start transaction
        $this->employeeModel->transStart();

        // Insert the employee data
        $employeeID = $this->employeeModel->insert($data, true);
        if (!$employeeID) {
            $this->employeeModel->transRollback();
            return $this->fail($this->employeeModel->errors(), 400);
        }

        // Insert data into employee_authrole table
        $authRoleData = [
            'EmployeeID' => $employeeID,
            'AuthRoleID' => $data['AuthRoleID'],
        ];

        if (!$this->employeeAuthRoleModel->insert($authRoleData)) {
            $this->employeeModel->transRollback();
            return $this->fail($this->employeeAuthRoleModel->errors(), 400);
        }

        // Insert data into employee_designation table
        $designationData = [
            'EmployeeID' => $employeeID,
            'DesignationID' => $data['DesignationID'],
        ];

        if (!$this->employeeDesignationModel->insert($designationData)) {
            $this->employeeModel->transRollback();
            return $this->fail($this->employeeDesignationModel->errors(), 400);
        }

        // Insert data into employee_section table
        $sectionData = [
            'EmployeeID' => $employeeID,
            'SectionID' => $data['SectionID'],
        ];

        if (!$this->employeeSectionModel->insert($sectionData)) {
            $this->employeeModel->transRollback();
            return $this->fail($this->employeeSectionModel->errors(), 400);
        }

        // Initialize leave balance
        $leaveTypes = $this->leavetypeModel->findAll();

        foreach ($leaveTypes as $leaveType) {
            $leaveBalanceData = [
                'EmployeeID' => $employeeID,
                'LeaveTypeID' => $leaveType['LeaveTypeID'],
                'NumberOfLeaves' => $leaveType['DefaultLeaveCount']
            ];
        
            if (!$this->leaveBalanceModel->insert($leaveBalanceData)) {
                $this->employeeModel->transRollback();
                return $this->fail($this->leaveBalanceModel->errors(), 400);
            }
        }

        // Commit transaction
        $this->employeeModel->transComplete();

        if ($this->employeeModel->transStatus() === false) {
            return $this->fail('Transaction failed', 400);
        }

        return $this->respondCreated(['message' => 'Employee created successfully.'], 201);
    }

    // Abstracted validation rules
    private function getValidationRules()
    {
        return [
            'EmployeeID' => [
                'rules' => 'required|alpha_numeric_space',
                'errors' => [
                    'required' => 'Employee ID is required.',
                    'alpha_numeric_space' => 'Employee ID must be alphanumeric and may contain spaces.'
                ]
            ],
            'Name' => [
                'rules' => 'required|alpha_space',
                'errors' => [
                    'required' => 'Name is required.',
                    'alpha_space' => 'Name can only contain alphabetic characters and spaces.'
                ]
            ],
            'Email' => [
                'rules' => 'required|valid_email',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Email address is not valid.'
                ]
            ],
            'Password' => [
                'rules'  => 'required|min_length[8]|regex_match[/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must be at least 8 characters long.',
                    'regex_match' => 'Password must include at least one uppercase letter, one lowercase letter, and one number.'
                ]
            ],
            'PhoneNumber' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => 'Phone number is required.',
                    'numeric' => 'Phone number must be numeric.'
                ]
            ],
            'Address' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Address is required.'
                ]
            ],
            'DateOfBirth' => [
                'rules' => 'required|valid_date',
                'errors' => [
                    'required' => 'Date of birth is required.',
                    'valid_date' => 'Date of birth is not a valid date.'
                ]
            ],
            'DateOfEntry' => [
                'rules' => 'valid_date',
                'errors' => [
                    'valid_date' => 'Date of entry is not a valid date.'
                ]
            ],            
            'EducationalAttainment' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Educational attainment is required.'
                ]
            ],
            'Eligibility' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Eligibility is required.'
                ]
            ],
            'IPCR' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'IPCR is required.'
                ]
            ],
            'AuthRoleID' => [
                'rules' => 'required|is_natural_no_zero|is_not_unique[auth_roles.id]',
                'errors' => [
                    'required' => 'Auth Role ID is required.',
                    'is_natural_no_zero' => 'Auth Role ID must be a natural number and not zero.',
                    'is_not_unique' => 'Invalid Auth Role ID provided.'
                ]
            ],
            'DesignationID' => [
                'rules' => 'required|is_natural_no_zero|is_not_unique[designations.id]',
                'errors' => [
                    'required' => 'Designation ID is required.',
                    'is_natural_no_zero' => 'Designation ID must be a natural number and not zero.',
                    'is_not_unique' => 'Invalid Designation ID provided.'
                ]
            ],
            'SectionID' => [
                'rules' => 'required|is_natural_no_zero|is_not_unique[sections.id]',
                'errors' => [
                    'required' => 'Section ID is required.',
                    'is_natural_no_zero' => 'Section ID must be a natural number and not zero.',
                    'is_not_unique' => 'Invalid Section ID provided.'
                ]
            ],
        ];
    }

}
