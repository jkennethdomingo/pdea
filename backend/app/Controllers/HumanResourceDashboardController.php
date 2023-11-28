<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class HumanResourceDashboardController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $employeeLeavesModel;
    protected $internalEmployeeTrainingModel;
    protected $trainingModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->employeeLeavesModel = Services::EmployeeLeavesModel();
        $this->internalEmployeeTrainingModel = Services::InternalEmployeeTrainingModel();
        $this->trainingModel = Services::TrainingModel();
    }

    public function getTodaysLeavesCount()
    {
        $count = $this->countTodaysLeaves();
        return $this->respond(['todaysLeavesCount' => $count]);
    }

    public function getTodayTrainingCount()
    {
        $count = $this->countTodayTraining();
        return $this->respond(['todaysTrainingCount' => $count]);
    }

    public function getTodayOnTrainingCount()
    {
        $count = $this->countTodayOnTraining();
        return $this->respond(['todaysOnTrainingCount' => $count]);
    }

    public function getActiveEmployeesCount()
    {
        $count = $this->countActiveEmployees();
        return $this->respond(['activeEmployeesCount' => $count]);
    }


    public function getTrainingCountsForLast13Days()
    {
        $trainingCounts = []; // Array to store training counts for each day

        for ($i = 12; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days")); // Calculate the date for each day

            // Build the query using Query Builder
            $builder = $this->internalEmployeeTrainingModel->builder();
            $builder->select('COUNT(DISTINCT internal_employee_training.EmployeeID) as NumberOfEmployeesOnTraining');
            $builder->join('training', 'internal_employee_training.training_id = training.training_id', 'inner');
            $builder->where('training.period_from <=', $date);
            $builder->where('training.period_to >=', $date);

            $query = $builder->get();
            $result = $query->getRowArray();

            // Add the count for this date to the array
            $trainingCounts[] = [
                'date' => $date,
                'count' => $result['NumberOfEmployeesOnTraining'] ?? 0
            ];
        }

        // Return the counts for the last 13 days
        return $this->respond($trainingCounts);
    }

    public function getEmployeeStatusPercentages()
    {
        $totalEmployeesCount = $this->personalInformationModel->countAllResults();
        if ($totalEmployeesCount == 0) {
            return $this->respond([
                'activePercentage' => 0,
                'onTrainingPercentage' => 0,
                'onLeavePercentage' => 0
            ]);
        }

        $activeEmployeesCount = $this->countActiveEmployees();
        $onTrainingCount = $this->countTodayOnTraining();
        $onLeaveCount = $this->countTodaysLeaves();

        $activePercentage = ($activeEmployeesCount / $totalEmployeesCount) * 100;
        $onTrainingPercentage = ($onTrainingCount / $totalEmployeesCount) * 100;
        $onLeavePercentage = ($onLeaveCount / $totalEmployeesCount) * 100;

        return $this->respond([
            'activePercentage' => round($activePercentage, 2),
            'onTrainingPercentage' => round($onTrainingPercentage, 2),
            'onLeavePercentage' => round($onLeavePercentage, 2)
        ]);
    }


    private function countTodaysLeaves() {
        $currentDate = date('Y-m-d');
        $builder = $this->employeeLeavesModel->builder();
        $builder->select('COUNT(*) as NumberOfEmployeesOnLeave');
        $builder->where('start_date <=', $currentDate);
        $builder->where('end_date >=', $currentDate);
        $builder->where('status', 'approved');
        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['NumberOfEmployeesOnLeave'];
    }
    
    private function countTodayTraining() {
        $currentDate = date('Y-m-d');
        $builder = $this->trainingModel->builder();
        $builder->select('COUNT(*) as NumberOfTrainingsToday');
        $builder->where('period_from <=', $currentDate);
        $builder->where('period_to >=', $currentDate);
        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['NumberOfTrainingsToday'];
    }
    
    private function countTodayOnTraining() {
        $currentDate = date('Y-m-d');
        $builder = $this->internalEmployeeTrainingModel->builder();
        $builder->select('COUNT(DISTINCT EmployeeID) as NumberOfEmployeesOnTraining');
        $builder->join('training', 'internal_employee_training.training_id = training.training_id', 'inner');
        $builder->where('training.period_from <=', $currentDate);
        $builder->where('training.period_to >=', $currentDate);
        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['NumberOfEmployeesOnTraining'];
    }
    
    private function countActiveEmployees() {
        $currentDate = date('Y-m-d');
        $builder = $this->personalInformationModel->builder();
        $builder->select('COUNT(*) as NumberOfActiveEmployees');
        $builder->whereNotIn('EmployeeID', function($subQuery) use ($currentDate) {
            $subQuery->select('EmployeeID')
                     ->from('internal_employee_training')
                     ->join('training', 'internal_employee_training.training_id = training.training_id', 'inner')
                     ->where('training.period_from <=', $currentDate)
                     ->where('training.period_to >=', $currentDate);
        });
        $builder->whereNotIn('EmployeeID', function($subQuery) use ($currentDate) {
            $subQuery->select('EmployeeID')
                     ->from('employee_leaves')
                     ->where('start_date <=', $currentDate)
                     ->where('end_date >=', $currentDate)
                     ->where('status', 'approved');
        });
        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['NumberOfActiveEmployees'];
    }
    
    public function getActiveEmployeesCountForLast13Days()
    {
        $totalEmployeesCount = $this->personalInformationModel->countAllResults(); // Total number of employees
        $activeCounts = []; // Array to store active counts for each day
        $activePercentages = []; // Array to store active percentages for each day

        for ($i = 12; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i days")); // Calculate the date for each day
            $activeCount = $this->countActiveEmployeesForDate($date);

            // Calculate the percentage of active employees for the day
            $percentage = $totalEmployeesCount > 0 ? ($activeCount / $totalEmployeesCount) * 100 : 0;

            // Add the count and percentage for this date to the arrays
            $activeCounts[] = [
                'date' => $date,
                'activeCount' => $activeCount
            ];
            $activePercentages[] = [
                'date' => $date,
                'activePercentage' => round($percentage, 2)
            ];
        }

        // Return the counts and percentages for the last 14 days
        return $this->respond([
            'activeCounts' => $activeCounts,
            'activePercentages' => $activePercentages
        ]);
    }

    private function countActiveEmployeesForDate($date)
    {
        $builder = $this->personalInformationModel->builder();
        $builder->select('COUNT(*) as NumberOfActiveEmployees');
        
        // Exclude employees on leave
        $builder->whereNotIn('EmployeeID', function($subQuery) use ($date) {
            $subQuery->select('EmployeeID')
                     ->from('employee_leaves')
                     ->where('start_date <=', $date)
                     ->where('end_date >=', $date)
                     ->where('status', 'approved');
        });

        // Exclude employees in training
        $builder->whereNotIn('EmployeeID', function($subQuery) use ($date) {
            $subQuery->select('EmployeeID')
                     ->from('internal_employee_training')
                     ->join('training', 'internal_employee_training.training_id = training.training_id')
                     ->where('training.period_from <=', $date)
                     ->where('training.period_to >=', $date);
        });

        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['NumberOfActiveEmployees'];
    }





}
