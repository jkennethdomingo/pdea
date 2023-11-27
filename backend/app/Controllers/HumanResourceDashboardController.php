<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class HumanResourceDashboardController extends ResourceController
{
    use ResponseTrait;

    protected $employeeLeavesModel;
    protected $internalEmployeeTrainingModel;
    protected $trainingModel;

    public function __construct()
    {
        $this->employeeLeavesModel = Services::EmployeeLeavesModel();
        $this->internalEmployeeTrainingModel = Services::InternalEmployeeTrainingModel();
        $this->trainingModel = Services::TrainingModel();
    }

    public function getTodaysLeavesCount()
    {
        $employeeLeavesModel = $this->employeeLeavesModel; // Ensure this is set up in your constructor
        $currentDate = date('Y-m-d'); // Get the current date

        // Build the query using Query Builder
        $builder = $employeeLeavesModel->builder();
        $builder->select('COUNT(*) as NumberOfEmployeesOnLeave');
        $builder->where('start_date <=', $currentDate);
        $builder->where('end_date >=', $currentDate);
        $builder->where('status', 'approved');

        $query = $builder->get();

        $result = $query->getRowArray(); // Assuming that you want to return an array

        // Return the count of employees on leave today
        return $this->respond(['todaysLeavesCount' => $result['NumberOfEmployeesOnLeave']]);
    }

    public function getTodayTrainingCount()
    {
        $currentDate = date('Y-m-d'); // Get the current date

        // Build the query using Query Builder
        // Assume $this->trainingModel is the model for the 'training' table
        $builder = $this->trainingModel->builder(); 
        $builder->select('COUNT(*) as NumberOfTrainingsToday');
        $builder->where('period_from <=', $currentDate);
        $builder->where('period_to >=', $currentDate);

        $query = $builder->get();

        $result = $query->getRowArray(); // Assuming that you want to return an array

        // Return the count of trainings happening today
        return $this->respond(['todaysOnTrainingCount' => $result['NumberOfTrainingsToday']]);
    }

    public function getTodayOnTrainingCount()
    {
        $currentDate = date('Y-m-d'); // Get the current date

        // Build the query using Query Builder
        $builder = $this->internalEmployeeTrainingModel->builder();
        $builder->select('COUNT(DISTINCT internal_employee_training.EmployeeID) as NumberOfEmployeesOnTraining');
        $builder->join('training', 'internal_employee_training.training_id = training.training_id', 'inner');
        $builder->where('training.period_from <=', $currentDate);
        $builder->where('training.period_to >=', $currentDate);

        $query = $builder->get();

        $result = $query->getRowArray(); // Assuming that you want to return an array

        // Return the count of employees on training today
        return $this->respond(['todaysOnTrainingCount' => $result['NumberOfEmployeesOnTraining']]);
    }



}
