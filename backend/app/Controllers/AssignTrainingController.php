<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\TrainingModel;

class AssignTrainingController extends ResourceController
{
    use ResponseTrait;

    protected $trainingModel;

    public function __construct()
    {
        $this->trainingModel = new TrainingModel();
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
            // Add other rules as necessary
        ];

        if ($this->validate($validationRules)) {
            $data = [
                'title' => $json->title,
                'period_from' => $json->period_from,
                'period_to' => $json->period_to,
                'number_of_hours' => $json->number_of_hours,
                'conducted_by' => $json->conducted_by,
                // Add other fields as necessary
            ];

            // Insert training data into the database
            $trainingId = $this->trainingModel->insert($data);

            // Check if the training was successfully assigned
            if ($trainingId) {
                $response = [
                    'status'   => 201,
                    'error'    => null,
                    'messages' => [
                        'success' => 'Training successfully assigned'
                    ]
                ];
                return $this->respondCreated($response);
            } else {
                return $this->failServerError('Could not assign the training');
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

}
