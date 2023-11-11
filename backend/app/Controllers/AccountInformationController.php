<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\PersonalInformationModel;
use App\Models\EmployeeModel;


class AccountInformationController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $employeeModel;

    public function __construct()
    {
        $this->personalInformation = new PersonalInformationModel();
        $this->employeeModel = new EmployeeModel();
    }

    public function create()
    {
        $json = $this->request->getJSON();

        // Validate all data first
        $validationResult = $this->validateAll($json);
        if ($validationResult !== true) {
            return $this->fail($validationResult, 400);
        }

        // Hash password
        $hashedPassword = $this->hashPassword($json->Password);

        // Start transaction
        $this->personalInformation->transStart();

        try {
            // Insert personal information and get cs_id_no
            $cs_id_no = $this->insertPersonalInformation($json);

            // Insert employee data with cs_id_no
            $this->insertEmployee($json, $cs_id_no, $hashedPassword);

            // Insert address data
            $this->insertAddress($json, $cs_id_no);

            // Insert family background data
            $this->insertFamilyBackground($json, $cs_id_no);

            // ... repeat for other sections ...

            // If everything was fine, commit the transaction
            $this->personalInformation->transComplete();

        } catch (\Exception $e) {
            // If there was any error, rollback the transaction
            $this->personalInformation->transRollback();
            return $this->fail('Transaction failed: ' . $e->getMessage(), 400);
        }

        // Check if transaction was successful
        if ($this->personalInformation->transStatus() === false) {
            return $this->fail('Transaction failed', 400);
        }

        return $this->respondCreated(['message' => 'Employee created successfully.'], 201);
    }

    // Example of a method to insert personal information data and return cs_id_no
    private function insertPersonalInformation($jsonData)
    {
        // Insert logic for personal_information
        // ...

        // Return cs_id_no
    }

    // Example of a method to validate all incoming data
    private function validateAll($jsonData)
    {
        // Perform validation
        // Return true if valid, error details if not
    }

    // ... additional private methods for inserting data into other tables ...

}
