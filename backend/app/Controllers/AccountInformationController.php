<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class AccountInformationController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $employeeAuthRoleModel;
    protected $employeeDesignationModel;
    protected $employeeSectionModel;
    protected $employeePositionModel;
    protected $leavetypeModel;
    protected $leaveBalanceModel;
    protected $FamilyBackgroundModel;
    protected $ChildrenModel;
    protected $EducationalBackgroundModel;
    protected $CivilServiceEligibilityModel;
    protected $WorkExperienceModel;
    protected $VoluntaryWorkModel;
    protected $TrainingProgramsModel;
    protected $OtherInformationModel;
    protected $PdSheetQuestionsModel;
    protected $ReferencesTblModel;
    protected $GovernmentIssuedIDsModel;
    protected $AddressModel;
    protected $EmployeeAddressModel;
    protected $sectionModel;
    protected $designationModel;
    protected $positionModel;
    protected $authRoleModel;
    protected $DivisionModel;
    protected $EmployeeDivisionModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->employeeAuthRoleModel = Services::employeeAuthRoleModel();
        $this->employeeDesignationModel = Services::employeeDesignationModel();
        $this->employeeSectionModel = Services::employeeSectionModel();
        $this->employeePositionModel = Services::employeePositionModel();
        $this->leavetypeModel = Services::leavetypeModel();
        $this->leaveBalanceModel = Services::leaveBalanceModel();
        $this->FamilyBackgroundModel = Services::FamilyBackgroundModel();
        $this->ChildrenModel = Services::ChildrenModel();
        $this->EducationalBackgroundModel = Services::EducationalBackgroundModel();
        $this->CivilServiceEligibilityModel = Services::CivilServiceEligibilityModel();
        $this->WorkExperienceModel = Services::WorkExperienceModel();
        $this->VoluntaryWorkModel = Services::VoluntaryWorkModel();
        $this->TrainingProgramsModel = Services::TrainingProgramsModel();
        $this->OtherInformationModel = Services::OtherInformationModel();
        $this->PdSheetQuestionsModel = Services::PdSheetQuestionsModel();
        $this->ReferencesTblModel = Services::ReferencesTblModel();
        $this->GovernmentIssuedIDsModel = Services::GovernmentIssuedIDsModel();
        $this->AddressModel = Services::AddressModel();
        $this->EmployeeAddressModel = Services::EmployeeAddressModel();
        $this->sectionModel = Services::SectionModel();
        $this->designationModel = Services::DesignationModel();
        $this->positionModel = Services::PositionModel();
        $this->authRoleModel = Services::AuthRoleModel();
        $this->DivisionModel = Services::DivisionModel();
        $this->EmployeeDivisionModel = Services::EmployeeDivisionModel();
    }

    private function hashPassword($password)
    {
        $pepper = getenv('PASSWORD_PEPPER');
        $pepperedPassword = hash_hmac('sha256', $password, $pepper);
        return password_hash($pepperedPassword, PASSWORD_ARGON2ID);
    }
    // This function is responsible for inserting data into the personal_information table
    private function insertPersonalInformation($jsonData, $hashedPassword) {
        // Extract information from $jsonData and prepare the array for insertion
        $personalInfoData = [
            'EmployeeID' => $jsonData->EmployeeID,
            'surname' => $jsonData->surname,
            'first_name' => $jsonData->first_name,
            'name_extension' => $jsonData->name_extension ?? null,
            'middle_name' => $jsonData->middle_name ?? null,
            'date_of_birth' => $jsonData->date_of_birth,
            'place_of_birth' => $jsonData->place_of_birth,
            'sex' => $jsonData->sex,
            'civil_status' => $jsonData->civil_status,
            'height' => $jsonData->height ?? null,
            'weight' => $jsonData->weight ?? null,
            'blood_type' => $jsonData->blood_type ?? null,
            'gsis_id_no' => $jsonData->gsis_id_no ?? null,
            'pag_ibig_id_no' => $jsonData->pag_ibig_id_no ?? null,
            'philhealth_no' => $jsonData->philhealth_no ?? null,
            'sss_no' => $jsonData->sss_no ?? null,
            'tin_no' => $jsonData->tin_no ?? null,
            'agency_employee_no' => $jsonData->agency_employee_no ?? null,
            'citizenship' => $jsonData->citizenship,
            'dual_citizenship_type' => $jsonData->dual_citizenship_type ?? null,
            'country' => $jsonData->country, 
            'telephone_no' => $jsonData->telephone_no ?? null,
            'mobile_no' => $jsonData->mobile_no,
            'Email' => $jsonData->Email ?? null,
            'Password' => $hashedPassword,
            'DateOfEntry' => $jsonData->DateOfEntry ?? date("Y-m-d"),
            'IPCR' => $jsonData->IPCR,
        ];
    
        // Insert the data and check for success
        if (!$this->personalInformationModel->insert($personalInfoData)) {
            // If the insert failed, throw an exception
            throw new \Exception('Failed to insert personal information');
        }
    
        // If the insert was successful, return the cs_id_no
        return $jsonData->EmployeeID;
    }

    public function uploadEmployeePhoto()
    {
        $employeeID = $this->request->getPost('EmployeeID');
        $file = $this->request->getFile('file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Generate a unique filename (or any other method you prefer)
            $newName = $file->getRandomName();
            
            // Move the file to the desired directory
            $file->move(ROOTPATH . 'public/uploads', $newName);

            // Use your model's function to update the photo in the database
            $this->personalInformationModel->updatePhoto($employeeID, $newName);

            // Return a success response
            return $this->response->setJSON(['status' => 'success', 'message' => 'File uploaded successfully', 'fileName' => $newName]);
        }

        return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to upload file']);
    }


    private function insertAddress($json) {
    
        $addressData = [
            'province' => $json->province,
            'city_municipality' => $json->municipality,
            'barangay' => $json->barangay,
            'subdivision_village' => $json->subdivision_village ?? null,
            'street' => $json->street ?? null,
            'house_block_lot' => $json->house_block_lot_no ?? null,
            'zip_code' => $json->zip_code
        ];
    
        // Insert the address data and check for success
        $addressID = $this->AddressModel->insert($addressData);
        if (!$addressID) {
            // If the insert failed, throw an exception
            throw new \Exception('Failed to insert address information');
        }
        
        // If the insert was successful, return the address ID
        return $addressID;
    }
    

    private function insertFamilyBackground($jsonData, $employeeId) {
        // Extract information from $jsonData and prepare the array for insertion
        $familyBackgroundData = [
            'EmployeeID' => $employeeId,
            'spouse_surname' => $jsonData->spouse_surname ?? null,
            'spouse_first_name' => $jsonData->spouse_first_name ?? null,
            'spouse_middle_name' => $jsonData->spouse_middle_name ?? null,
            'spouse_name_extension' => $jsonData->spouse_name_extension ?? null,
            'spouse_occupation' => $jsonData->spouse_occupation ?? null,
            'spouse_employer_business_name' => $jsonData->spouse_employer_business_name ?? null,
            'spouse_business_address' => $jsonData->spouse_business_address ?? null,
            'spouse_telephone_no' => $jsonData->spouse_telephone_no ?? null,
            'father_surname' => $jsonData->father_surname ?? null,
            'father_first_name' => $jsonData->father_first_name ?? null,
            'father_middle_name' => $jsonData->father_middle_name ?? null,
            'father_name_extension' => $jsonData->father_name_extension ?? null,
            'mother_maiden_name' => $jsonData->mother_maiden_name ?? null,
            'mother_surname' => $jsonData->mother_surname ?? null,
            'mother_first_name' => $jsonData->mother_first_name ?? null,
            'mother_middle_name' => $jsonData->mother_middle_name ?? null,
            // ... include other fields as necessary
        ];

        $familyBackgroundID = $this->FamilyBackgroundModel->insert($familyBackgroundData);
    
        // Insert the data and check for success
        if(!$familyBackgroundID) {
            // If the insert failed, throw an exception
            throw new \Exception('Failed to insert family background information');
        }
    
        // If the insert was successful, return true
        return $familyBackgroundID;
    }

    private function insertChildrenInformation($childJson, $EmployeeID, $familyId) {
        // Prepare the array for insertion
        $childData = [
            'family_id' => $familyId, // assuming family_id is the same as EmployeeID in this context
            'full_name' => $childJson->full_name,
            'date_of_birth' => $childJson->date_of_birth,
            // ... include other fields as necessary
        ];
    
        // Insert the data and check for success
        if (!$this->ChildrenModel->insert($childData)) {
            // If the insert failed, throw an exception
            throw new \Exception('Failed to insert child information');
        }
    }

    private function insertEducationalBackground($json, $EmployeeID) {
        // Define the educational levels
        $educationLevels = ['Elementary', 'Secondary', 'Vocational', 'College', 'GraduateStudies'];
    
        // Loop through each educational level
        foreach ($educationLevels as $level) {
            // Check if educational data for the level is provided
            if (isset($json->$level)) {
                $educationJson = $json->$level;
    
                // Prepare the education data array
                $educationData = [
                    'EmployeeID' => $EmployeeID,
                    'level' => $level,
                    'name_of_school' => $educationJson->name_of_school,
                    'degree_course' => $educationJson->degree_course ?? null,
                    'period_of_attendance_from' => $educationJson->period_of_attendance_from,
                    'period_of_attendance_to' => $educationJson->period_of_attendance_to,
                    'highest_level_units_earned' => $educationJson->highest_level_units_earned ?? null,
                    'year_graduated' => $educationJson->year_graduated ?? null,
                    'scholarship_academic_honors_received' => $educationJson->scholarship_academic_honors_received ?? null,
                    // ... include other fields as necessary
                ];
    
                // Insert the data and check for success
                if (!$this->EducationalBackgroundModel->insert($educationData)) {
                    // If the insert failed, throw an exception
                    throw new \Exception('Failed to insert educational background information for ' . $level);
                }
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }
    

    private function insertCivilServiceEligibility($json, $EmployeeID) {
        // Check if CivilService data is provided
        if (!isset($json->CivilService)) {
            // Optionally handle the lack of CivilService data
            return $this->response->setStatusCode(400) // Bad Request
                                  ->setJSON(['error' => 'No Civil Service eligibility information provided.']);
        }
    
        try {
            // Assuming $json->CivilService contains an array of civil service eligibility entries
            foreach ($json->CivilService as $eligibilityJson) {
                $eligibilityData = [
                    'EmployeeID' => $EmployeeID,
                    'career_service' => $eligibilityJson->career_service,
                    'rating' => $eligibilityJson->rating,
                    'date_of_examination' => $eligibilityJson->date_of_examination,
                    'place_of_examination' => $eligibilityJson->place_of_examination,
                    'license_number' => $eligibilityJson->license_number ?? null,
                    'license_date_of_validity' => $eligibilityJson->license_date_of_validity ?? null,
                    // ... include other fields as necessary
                ];
    
                if (!$this->CivilServiceEligibilityModel->insert($eligibilityData)) {
                    // If the insert failed, gather the errors
                    $errors = $this->CivilServiceEligibilityModel->errors();
                    error_log(print_r($errors, true));
                    // Return a 500 Internal Server Error response
                    return $this->response->setStatusCode(500)
                                          ->setJSON(['error' => 'Failed to insert Civil Service eligibility information', 'details' => $errors]);
                }
            }
    
            // If all inserts were successful, return a 201 Created response
            return $this->response->setStatusCode(201)
                                  ->setJSON(['message' => 'Civil Service eligibility information successfully inserted']);
        } catch (\Exception $e) {
            // Handle any other exceptions and return a 500 Internal Server Error response
            return $this->response->setStatusCode(500)
                                  ->setJSON(['error' => 'An error occurred while inserting Civil Service eligibility information', 'details' => $e->getMessage()]);
        }
    }
    

    private function insertWorkExperience($json, $EmployeeID) {
        // Check if work experience data is provided
        if (!isset($json->WorkExperience)) {
            // Optionally handle the lack of work experience data
            throw new \Exception('No work experience information provided.');
        }
    
        // Assuming $json->work_experience contains an array of work experience entries
        foreach ($json->WorkExperience as $experienceJson) {
            $experienceData = [
                'EmployeeID' => $EmployeeID,
                'inclusive_dates_from' => $experienceJson->inclusive_dates_from,
                'inclusive_dates_to' => $experienceJson->inclusive_dates_to,
                'position_title' => $experienceJson->position_title,
                'department_agency_office_company' => $experienceJson->department_agency_office_company,
                'monthly_salary' => $experienceJson->monthly_salary,
                'salary_grade_step_increment' => $experienceJson->salary_grade_step_increment ?? null,
                'status_of_appointment' => $experienceJson->status_of_appointment,
                'govt_service' => $experienceJson->govt_service ?? null,
                // ... include other fields as necessary
            ];
    
            // Insert the data and check for success
            if (!$this->WorkExperienceModel->insert($experienceData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert work experience information');
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }
    
    private function insertVoluntaryWork($json, $EmployeeID) {
        // Check if voluntary work data is provided
        if (!isset($json->VoluntaryWork)) {
            // Optionally handle the lack of voluntary work data
            throw new \Exception('No voluntary work information provided.');
        }
    
        // Assuming $json->voluntary_work contains an array of voluntary work entries
        foreach ($json->VoluntaryWork as $voluntaryWorkJson) {
            $voluntaryWorkData = [
                'EmployeeID' => $EmployeeID,
                'organization_name' => $voluntaryWorkJson->organization_name,
                'position' => $voluntaryWorkJson->position,
                'period_from' => $voluntaryWorkJson->period_from,
                'period_to' => $voluntaryWorkJson->period_to,
                'number_of_hours' => $voluntaryWorkJson->number_of_hours,
                // ... include other fields as necessary
            ];
    
            // Insert the data and check for success
            if (!$this->VoluntaryWorkModel->insert($voluntaryWorkData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert voluntary work information');
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }

    private function insertTrainingPrograms($json, $EmployeeID) {
        // Check if training programs data is provided
        if (!isset($json->LearningDevelopment)) {
            // Optionally handle the lack of training programs data
            throw new \Exception('No training programs information provided.');
        }
    
        // Assuming $json->training_programs contains an array of training program entries
        foreach ($json->LearningDevelopment as $trainingJson) {
            $trainingData = [
                'EmployeeID' => $EmployeeID,
                'title' => $trainingJson->title,
                'period_from' => $trainingJson->period_from,
                'period_to' => $trainingJson->period_to,
                'number_of_hours' => $trainingJson->number_of_hours,
                'conducted_by' => $trainingJson->conducted_by,
                // ... include other fields as necessary
            ];
    
            // Insert the data and check for success
            if (!$this->TrainingProgramsModel->insert($trainingData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert training programs information');
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }
    
    private function insertOtherInformation($json, $EmployeeID) {
        // Check if voluntary work data is provided
        if (!isset($json->OtherInformation)) {
            // Optionally handle the lack of voluntary work data
            throw new \Exception('No voluntary work information provided.');
        }
    
        // Assuming $json->voluntary_work contains an array of voluntary work entries
        foreach ($json->OtherInformation as $otherInformationJson) {
            $otherInformationData = [
                'EmployeeID' => $EmployeeID,
                'special_skills_hobbies' => $otherInformationJson->special_skills_hobbies ?? null,
                'non_academic_distinctions_recognition' => $otherInformationJson->non_academic_distinctions_recognition ?? null,
                'membership_association_organization' => $otherInformationJson->membership_association_organization ?? null,
                // ... include other fields as necessary
            ];
        
            // Insert the data and check for success
            if (!$this->OtherInformationModel->insert($otherInformationData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert other information');
            }
        }        
        // If all inserts were successful, return true
        return true;
    }

    private function insertPDSheetQuestions($json, $EmployeeID) {
        // Check if PDSheet questions data is provided
        if (!isset($json->pd_sheet_questions)) {
            // Optionally handle the lack of PDSheet questions data
            throw new \Exception('No PDSheet questions information provided.');
        }
    
        // Assuming $json->pd_sheet_questions contains an array of PDSheet questions entries
        foreach ($json->pd_sheet_questions as $pdSheetQuestionJson) {
            $pdSheetQuestionData = [
                'EmployeeID' => $EmployeeID,
                'question_text' => $pdSheetQuestionJson->question_text,
                'question_code' => $pdSheetQuestionJson->question_code,
                'answer' => $pdSheetQuestionJson->answer,
                'details' => $pdSheetQuestionJson->details ?? null,
                'date_of_event' => $pdSheetQuestionJson->date_of_event ?? null,
                'status_or_remarks' => $pdSheetQuestionJson->status_or_remarks ?? null,
                // ... include other fields as necessary
            ];
    
            // Insert the data and check for success
            if (!$this->PdSheetQuestionsModel->insert($pdSheetQuestionData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert PDSheet questions information');
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }

    private function insertReferences($json, $EmployeeID) {
        // Check if reference data is provided
        if (!isset($json->references)) {
            // Optionally handle the lack of reference data
            throw new \Exception('No references information provided.');
        }
    
        // Assuming $json->references contains an array of reference entries
        foreach ($json->references as $referenceJson) {
            $referenceData = [
                'EmployeeID' => $EmployeeID,
                'name' => $referenceJson->name,
                'address' => $referenceJson->address,
                'telephone_no' => $referenceJson->telephone_no,
                // ... include other fields as necessary
            ];
    
            // Insert the data and check for success
            if (!$this->ReferencesTblModel->insert($referenceData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert reference information');
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }

    private function insertGovernmentIssuedIDs($json, $EmployeeID) {
        // Check if government-issued ID data is provided
        if (!isset($json->government_issued_ids)) {
            // Optionally handle the lack of government-issued ID data
            throw new \Exception('No government-issued ID information provided.');
        }
    
        // Assuming $json->government_issued_ids contains an array of government-issued ID entries
        foreach ($json->government_issued_ids as $govIdJson) {
            $govIdData = [
                'EmployeeID' => $EmployeeID,
                'id_type' => $govIdJson->id_type,
                'id_number' => $govIdJson->id_number,
                'date_of_issue' => $govIdJson->date_of_issue ?? null,
                'place_of_issue' => $govIdJson->place_of_issue ?? null,
                // ... include other fields as necessary
            ];
    
            // Insert the data and check for success
            if (!$this->GovernmentIssuedIDsModel->insert($govIdData)) {
                // If the insert failed, throw an exception
                throw new \Exception('Failed to insert government-issued ID information');
            }
        }
    
        // If all inserts were successful, return true
        return true;
    }
    
    private function insertDataAndRollbackOnFailure($model, $data, $rollbackModel)
    {
        if (!$model->insert($data)) {
            $rollbackModel->transRollback();
            return $this->fail($model->errors(), 400);
        }

        return true;
    }

    private function linkEmployeeToAddress($EmployeeID, $AddressID, $AddressType) {
        $linkData = [
            'EmployeeID' => $EmployeeID,
            'address_id' => $AddressID,
            'address_type' => $AddressType
        ];
    
        // Insert the link data and check for success
        if (!$this->EmployeeAddressModel->insert($linkData)) {
            // If the insert failed, throw an exception
            throw new \Exception('Failed to link employee to address');
        }
        
        // If the insert was successful, return true
        return true;
    }

    // Main function to handle the create operation
    public function create() {

        $json = $this->request->getJSON();
        

            // Validate all incoming data first
        $validationRules = $this->getValidationRules();

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        // Hash the password after validation
        $hashedPassword = $this->hashPassword($json->Password);
        
        if ($this->personalInformationModel->find($json->EmployeeID)) {
            return $this->fail('EmployeeID already exists.', 400);
        }

        // Start transaction
        $this->personalInformationModel->transStart();

        try {
            // Insert personal information and get cs_id_no
        $EmployeeID = $this->insertPersonalInformation($json, $hashedPassword);

        // Extract residential address data
        $jsonResidential = $json->residentialForm;

        // Insert the residential address and get its ID
        $residentialAddressID = $this->insertAddress($jsonResidential);

        $this->linkEmployeeToAddress($EmployeeID, $residentialAddressID, 'Residential');

        // Extract residential address data
        $jsonPermanent = $json->permanentForm;

        // Insert the residential address and get its ID
        $permanentAddressID = $this->insertAddress($jsonPermanent);

        $this->linkEmployeeToAddress($EmployeeID, $permanentAddressID , 'Permanent');

        $familyId = $this->insertFamilyBackground($json, $EmployeeID);

        if (isset($json->children) && is_array($json->children)) {
            // Insert children information
            foreach ($json->children as $childJson) {
                $this->insertChildrenInformation($childJson, $EmployeeID, $familyId);
            }
        }

        $this->insertEducationalBackground($json, $EmployeeID);

        $this->insertCivilServiceEligibility($json, $EmployeeID);

        $this->insertWorkExperience($json, $EmployeeID);

        $this->insertVoluntaryWork($json, $EmployeeID);

        $this->insertTrainingPrograms($json, $EmployeeID);
        
        $this->insertOtherInformation($json, $EmployeeID);

        // $this->insertPDSheetQuestions($json, $EmployeeID);

        // $this->insertReferences($json, $EmployeeID);

        // $this->insertGovernmentIssuedIDs($json, $EmployeeID);

        $authRoleData = [
            'EmployeeID' => $EmployeeID,
            'AuthRoleID' => '3',
        ];

        $this->insertDataAndRollbackOnFailure(
            $this->employeeAuthRoleModel,
            $authRoleData,
            $this->personalInformationModel
        );

        // Insert data into employee_designation table
        $designationData = [
            'EmployeeID' => $EmployeeID,
            'DesignationID' => $json->designation,
        ];

        $this->insertDataAndRollbackOnFailure(
            $this->employeeDesignationModel,
            $designationData,
            $this->personalInformationModel
        );

        // Insert data into employee_section table
        $sectionData = [
            'EmployeeID' => $EmployeeID,
            'SectionID' => $json->section,
        ];

        $this->insertDataAndRollbackOnFailure(
            $this->employeeSectionModel,
            $sectionData,
            $this->personalInformationModel
        );

        // Insert data into employee_position table
        $positionData = [
            'EmployeeID' => $EmployeeID,
            'PositionID' => $json->position,
        ];

        $this->insertDataAndRollbackOnFailure(
            $this->employeePositionModel,
            $positionData,
            $this->personalInformationModel
        );
        // Insert data into employee_division table
        $divisionData = [
            'EmployeeID' => $EmployeeID,
            'DivisionID' => $json->division,
        ];

        $this->insertDataAndRollbackOnFailure(
            $this->EmployeeDivisionModel,
            $divisionData,
            $this->personalInformationModel
        );

        // Initialize leave balance
        $leaveTypes = $this->leavetypeModel->findAll();

        foreach ($leaveTypes as $leaveType) {
            $leaveBalanceData = [
                'EmployeeID' => $EmployeeID,
                'LeaveTypeID' => $leaveType['LeaveTypeID'],
                'NumberOfLeaves' => $leaveType['DefaultLeaveCount']
            ];
        
            if (!$this->leaveBalanceModel->insert($leaveBalanceData)) {
                $this->personalInformationModel->transRollback();
                return $this->fail($this->leaveBalanceModel->errors(), 400);
            }
        }

        // Commit transaction
        $this->personalInformationModel->transComplete();

        if ($this->personalInformationModel->transStatus() === false) {
            return $this->fail('Transaction failed', 400);
        }

        return $this->respondCreated(['message' => 'Employee created successfully.'], 201);

        }

        catch (\Exception $e) {
            // Handle the exception, log it, etc.
            // You might also want to rollback the transaction on exception
            $this->personalInformationModel->transRollback();
    
            return $this->fail($e->getMessage(), 500);
        }

    }

    private function getValidationRules() 
    {
        return [
            'EmployeeID' => [
                'rules' => 'required|alpha_numeric_space|is_unique[personal_information.EmployeeID]',
                'errors' => [
                    'required' => 'Employee ID is required.',
                    'alpha_numeric_space' => 'Employee ID must be alphanumeric and may contain spaces.',
                    'is_unique' => 'This Employee ID already exists.'
                ]
            ],
        ];
    }

    public function getDropdownData()
    {
        $data = [
            'sections' => $this->sectionModel->findAll(),
            'designations' => $this->designationModel->findAll(),
            'positions' => $this->positionModel->findAll(),
        ];

        return $this->respond($data);
    }

    public function getEmployeeInformation() {
        // Retrieve JSON data from the request
        $json = $this->request->getJSON();
    
        // Decode JSON to get the Employee ID
        $employeeID = $json->employeeID ?? null;
    
        // Check if Employee ID is provided
        if ($employeeID) {
            // Fetch the specific employee's information using the model
            $employeeInfo = $this->personalInformationModel->find($employeeID);
    
            // Check if employee exists
            if ($employeeInfo) {
                $response = [
                    'status' => 'success',
                    'employee' => $employeeInfo,
                ];
            } else {
                $response = [
                    'status' => 'fail',
                    'message' => 'Employee not found',
                ];
            }
        } else {
            $response = [
                'status' => 'fail',
                'message' => 'No Employee ID provided',
            ];
        }
    
        // Return the data as JSON
        return $this->response->setJSON($response);
    }
    


}
