<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\EmployeeModel;
use App\Models\AuthRoleModel;
use App\Models\EmployeeAuthRoleModel;

class EmployeeController extends ResourceController
{
    use ResponseTrait;

    protected $employeeModel;
    protected $authRoleModel;
    protected $employeeAuthRoleModel;

    public function __construct()
    {
        $this->employeeModel = new EmployeeModel();
        $this->authRoleModel = new AuthRoleModel();
        $this->employeeAuthRoleModel = new EmployeeAuthRoleModel();
    }

    public function create()
    {
        $json = $this->request->getJSON();

        // Prepare data for validation
        $data = [
            'EmployeeID' => $json->EmployeeID ?? '',
            'Name' => $json->Name ?? '',
            'Email' => $json->Email ?? '',
            'Password' => $json->Password ?? '',
            'PhoneNumber' => $json->PhoneNumber ?? '',
            'Address' => $json->Address ?? '',
            'DateOfBirth' => $json->DateOfBirth ?? '',
            'EducationalAttainment' => $json->EducationalAttainment ?? '',
            'Eligibility' => $json->Eligibility ?? '',
            'IPCR' => $json->IPCR ?? '',
            'AuthRoleID' => $json->AuthRoleID ?? '', // Include role ID
        ];

        $validationRules = $this->getValidationRules();

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        // Check if the role exists in authentication_role
        if (!$this->authRoleModel->find($data['AuthRoleID'])) {
            return $this->fail('Invalid role ID.', 400);
        }

        // Hash the password after validation
        $data['Password'] = password_hash($data['Password'], PASSWORD_ARGON2I);

        // Add non-validated data
        $data['DateOfEntry'] = date("Y-m-d");

        // Start transaction
        $this->employeeModel->transStart();

        // Insert the data into employee table
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

        $this->employeeModel->transComplete();

        if ($this->employeeModel->transStatus() === false) {
            return $this->fail('Transaction failed', 400);
        }

        return $this->respondCreated(['message' => 'Employee created successfully with role assignment'], 201);
    }


    // Abstracted validation rules
    private function getValidationRules()
    {
        return [
            'EmployeeID' => 'required|alpha_numeric_space',
            'Name' => 'required|alpha_space',
            'Email' => 'required|valid_email',
            'Password' => 'required|min_length[8]',
            'PhoneNumber' => 'required|numeric',
            'Address' => 'required',
            'DateOfBirth' => 'required|valid_date',
            'EducationalAttainment' => 'required',
            'Eligibility' => 'required',
            'IPCR' => 'required',
            'AuthRoleID' => 'required|is_natural_no_zero', // assuming RoleID is a numeric ID and not zero
        ];
    }

}
