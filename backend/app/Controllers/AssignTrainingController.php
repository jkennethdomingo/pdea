<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TrainingModel;
use App\Models\InternalEmployeeTrainingModel;
use Config\Services;

class AssignTrainingController extends ResourceController
{
    use ResponseTrait;

    protected $trainingModel;
    protected $personalInformationModel;
    protected $internalEmployeeTrainingModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->trainingModel = new TrainingModel();
        $this->internalEmployeeTrainingModel = new InternalEmployeeTrainingModel();
    }

    public function insertTraining()
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON();

        // Validate the request data
        $validationRules = [
            'title' => 'required|is_unique[training.title]',
            'period_from' => 'required|valid_date',
            'period_to' => 'required|valid_date',
            'number_of_hours' => 'required|integer',
            'conducted_by' => 'required',
            'employees' => 'permit_empty|array' // 'employees' can be empty but if present, must be an array
            // Add other rules as necessary
        ];

        if ($this->validate($validationRules)) {
            $trainingData = [
                'title' => $json->title,
                'period_from' => $json->period_from,
                'period_to' => $json->period_to,
                'number_of_hours' => $json->number_of_hours,
                'conducted_by' => $json->conducted_by,
                // Add other fields as necessary
            ];

            // Insert training data into the database
            $trainingId = $this->trainingModel->insert($trainingData);

            // Check if the training was successfully inserted
            if ($trainingId) {
                // Check if there are employees to assign the training to
                if (!empty($json->employees) && is_array($json->employees)) {
                    foreach ($json->employees as $employeeId) {
                        $assignmentData = [
                            'EmployeeID' => $employeeId,
                            'training_id' => $trainingId,
                            // 'attendance_date' will be determined by backend logic if required
                        ];
                        // Insert into the junction table
                        $this->internalEmployeeTrainingModel->insert($assignmentData);
                    }
                }

                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Training successfully created' . (!empty($json->employees) ? ' and assigned' : '')
                    ]
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failServerError('Could not create the training');
            }
        }

        // Return validation errors if any
        return $this->fail($this->validator->getErrors());
    }

    public function editTraining()
    {
        // Get the JSON data from the request
        $json = $this->request->getJSON();

        // Validate the request data
        $validationRules = [
            'training_id' => 'required',
            'title' => 'required',
            'period_from' => 'required|valid_date',
            'period_to' => 'required|valid_date',
            'number_of_hours' => 'required|integer',
            'conducted_by' => 'required',
            'employees' => 'permit_empty|array' // 'employees' can be empty but if present, must be an array
            // Add other rules as necessary
        ];

        if ($this->validate($validationRules)) {
            $trainingId = $json->training_id;
            $trainingData = [
                'title' => $json->title,
                'period_from' => $json->period_from,
                'period_to' => $json->period_to,
                'number_of_hours' => $json->number_of_hours,
                'conducted_by' => $json->conducted_by,
                // Add other fields as necessary
            ];

            // Update training data in the database
            $updateResult = $this->trainingModel->update($trainingId, $trainingData);

            // Check if the training was successfully updated
            if ($updateResult) {
                // Check if there are employees to assign the training to
                if (!empty($json->employees) && is_array($json->employees)) {
                    // Assuming we clear previous assignments and reassign
                    $this->internalEmployeeTrainingModel->where('training_id', $trainingId)->delete();
                    
                    foreach ($json->employees as $employeeId) {
                        $assignmentData = [
                            'EmployeeID' => $employeeId,
                            'training_id' => $trainingId,
                            // 'attendance_date' will be determined by backend logic if required
                        ];
                        // Insert into the junction table
                        $this->internalEmployeeTrainingModel->insert($assignmentData);
                    }
                }

                $response = [
                    'status'   => 200,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Training successfully updated' . (!empty($json->employees) ? ' and employees assigned' : '')
                    ]
                ];
                return $this->response->setJSON($response);
            } else {
                return $this->failServerError('Could not update the training');
            }
        }

        // Return validation errors if any
        return $this->fail($this->validator->getErrors());
    }

    public function getTraining()
    {
        $data = [
            'training' => $this->trainingModel->findAll(),
        ];

        return $this->respond($data);
    }

    public function getTrainingbyTitle($title)
    {
            $training = $this->trainingModel->where('title', $title)->findAll();

        $data = [
            'training' => $training,
        ];

        return $this->respond($data);
    }

    public function getEmployeeInfo()
    {
        $data = $this->personalInformationModel->select('EmployeeID, first_name, surname, photo, IPCR')->findAll();
        // Return the data as a JSON response.
        return $this->response->setJSON($data);
    }

}
