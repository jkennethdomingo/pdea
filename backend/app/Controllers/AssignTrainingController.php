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
            'employees' => 'permit_empty' // 'employees' can be empty but if present, must be an array
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
            'employees' => 'permit_empty' // 'employees' can be empty but if present, must be an array
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
        // Start building the query
        $builder = $this->trainingModel->builder();
        
        // Specify the columns you want to select
        $builder->select('
            training.*,
            GROUP_CONCAT(DISTINCT personal_information.first_name ORDER BY personal_information.first_name) as first_names,
            GROUP_CONCAT(DISTINCT personal_information.surname ORDER BY personal_information.surname) as surnames,
            GROUP_CONCAT(DISTINCT personal_information.photo ORDER BY personal_information.EmployeeID) as photos,
            GROUP_CONCAT(DISTINCT internal_employee_training.EmployeeID ORDER BY internal_employee_training.EmployeeID) as employee_ids
        ', false);
        
        // Join with the internal_employee_training table and personal_information table
        $builder->join('internal_employee_training', 'training.training_id = internal_employee_training.training_id', 'left');
        $builder->join('personal_information', 'internal_employee_training.EmployeeID = personal_information.EmployeeID', 'left');
        
        // Add a where clause for the title
        $builder->where('training.title', $title);
        
        // Add a group by clause to consolidate the results by training ID
        $builder->groupBy('training.training_id');
        
        // Execute the query and get the result
        $query = $builder->get();
        $trainingData = $query->getResultArray();
    
        // Process each training record to convert photos and employee_ids into arrays
        foreach ($trainingData as &$training) {
            // Split the concatenated string of photos and employee IDs into arrays
            $training['first_names'] = array_filter(explode(',', $training['first_names']));
            $training['surnames'] = array_filter(explode(',', $training['surnames']));
            $training['photos'] = array_filter(explode(',', $training['photos']));
            $training['employee_ids'] = array_filter(explode(',', $training['employee_ids']));
        }
        unset($training); // Break the reference with the last element
    
        // Prepare the data for the response
        $data = [
            'training' => $trainingData,
        ];
    
        return $this->respond($data);
    }

    public function getTrainingbyID($id)
    {
        // Start building the query
        $builder = $this->trainingModel->builder();
        
        // Specify the columns you want to select
        $builder->select('
            training.*,
            GROUP_CONCAT(DISTINCT personal_information.first_name ORDER BY personal_information.first_name) as first_names,
            GROUP_CONCAT(DISTINCT personal_information.surname ORDER BY personal_information.surname) as surnames,
            GROUP_CONCAT(DISTINCT personal_information.photo ORDER BY personal_information.EmployeeID) as photos,
            GROUP_CONCAT(DISTINCT internal_employee_training.EmployeeID ORDER BY internal_employee_training.EmployeeID) as employee_ids
        ', false);
        
        // Join with the internal_employee_training table and personal_information table
        $builder->join('internal_employee_training', 'training.training_id = internal_employee_training.training_id', 'left');
        $builder->join('personal_information', 'internal_employee_training.EmployeeID = personal_information.EmployeeID', 'left');
        
        // Add a where clause for the title
        $builder->where('training.training_id', $id);
        
        // Add a group by clause to consolidate the results by training ID
        $builder->groupBy('training.training_id');
        
        // Execute the query and get the result
        $query = $builder->get();
        $trainingData = $query->getResultArray();
    
        // Process each training record to convert photos and employee_ids into arrays
        foreach ($trainingData as &$training) {
            // Split the concatenated string of photos and employee IDs into arrays
            $training['first_names'] = array_filter(explode(',', $training['first_names']));
            $training['surnames'] = array_filter(explode(',', $training['surnames']));
            $training['photos'] = array_filter(explode(',', $training['photos']));
            $training['employee_ids'] = array_filter(explode(',', $training['employee_ids']));
        }
        unset($training); // Break the reference with the last element
    
        // Prepare the data for the response
        $data = [
            'training' => $trainingData,
        ];
    
        return $this->respond($data);
    }
    


    public function getEmployeeInfo()
    {
        $data = $this->personalInformationModel->select('EmployeeID, first_name, surname, photo, DateOfEntry, IPCR')->findAll();
        // Return the data as a JSON response.
        return $this->response->setJSON($data);
    }

    public function fetchUpcomingTrainingsWithoutEmployees() {
        // Get the current date
        $currentDate = date('Y-m-d');
    
        // Build the query
        $query = $this->trainingModel
            ->select('training.*')
            ->join('internal_employee_training', 'training.training_id = internal_employee_training.training_id AND internal_employee_training.EmployeeID IS NULL', 'left')
            ->where('training.period_from >=', $currentDate) // Only fetch training that hasn't passed
            ->groupBy('training.training_id') // Group by to avoid duplicate trainings
            ->orderBy('training.period_from', 'ASC'); // Order by upcoming dates
    
        // Execute the query and return the result
        $upcomingTrainingsWithoutEmployees = $query->findAll();
    
        // Prepare the response
        $response = [
            'trainings' => $upcomingTrainingsWithoutEmployees
        ];
    
        // Return the response as JSON
        return $this->response->setJSON($response);
    }

    public function fetchSortedTrainingSessions()
    {
        // Fetch and sort unassigned or pending training sessions
        $unassignedOrPendingTrainings = $this->buildTrainingQuery('pending')->findAll();

        // Fetch and sort upcoming training sessions
        $upcomingTrainings = $this->buildTrainingQuery('upcoming')->findAll();

        // Fetch and sort finished training sessions
        $finishedTrainings = $this->buildTrainingQuery('finished')->findAll();

        // Prepare the response
        $response = [
            'unassigned_or_pending' => $this->prepareTrainingResponse($unassignedOrPendingTrainings),
            'upcoming' => $this->prepareTrainingResponse($upcomingTrainings),
            'finished' => $this->prepareTrainingResponse($finishedTrainings)
        ];

        // Return the response as JSON
        return $this->response->setJSON($response);
    }

    private function buildTrainingQuery($status)
{
    $today = date('Y-m-d');
    $query = $this->trainingModel
        ->select('
            training.training_id as TrainingID,
            training.title,
            training.period_from,
            training.period_to,
            training.number_of_hours,
            training.conducted_by,
            training.created_at,
            training.updated_at'
        );

    if ($status === 'pending') {
        // Unassigned or pending trainings that have not started yet
        $query = $query
            ->join('internal_employee_training', 'training.training_id = internal_employee_training.training_id', 'left')
            ->where('internal_employee_training.internal_training_id IS NULL') // No associated internal_employee_training record means unassigned
            ->where('training.period_from >', $today); // Excludes past training sessions
    } elseif ($status === 'upcoming') {
        // Upcoming trainings that have not finished
        $query = $query
            ->where('training.period_to >=', $today)
            ->orderBy('training.period_from', 'ASC');
    } elseif ($status === 'finished') {
        // Finished trainings
        $query = $query
            ->where('training.period_to <', $today)
            ->orderBy('training.period_to', 'DESC');
    }

    return $query;
}


    private function prepareTrainingResponse($trainings)
    {
        return array_map(function ($training) {
            return [
                'TrainingID' => $training['TrainingID'] ?? 'N/A',
                'Title' => $training['title'] ?? 'Not Specified',
                'StartTime' => $training['period_from'] ?? 'N/A',
                'EndTime' => $training['period_to'] ?? 'N/A',
                'Hours' => $training['number_of_hours'] ?? 'N/A',
                'ConductedBy' => $training['conducted_by'] ?? 'N/A',
                'CreatedAt' => $training['created_at'] ?? 'N/A',
                'UpdatedAt' => $training['updated_at'] ?? 'N/A',
                // Include more fields as needed
            ];
        }, $trainings);
    }

    
    

}
