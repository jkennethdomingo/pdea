<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class HumanResourceDashboardRemasteredController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $employeeLeavesModel;
    protected $internalEmployeeTrainingModel;
    protected $trainingModel;
    protected $leavetypeModel;
    protected $leaveBalanceModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->employeeLeavesModel = Services::EmployeeLeavesModel();
        $this->internalEmployeeTrainingModel = Services::InternalEmployeeTrainingModel();
        $this->trainingModel = Services::TrainingModel();
        $this->leavetypeModel = Services::LeavetypeModel(); // Corrected syntax
        $this->leaveBalanceModel = Services::LeaveBalanceModel(); // Corrected syntax
    }

    public function getTodayOnTrainingCount(): ResponseInterface
    {
        $count = $this->countTodayOnTraining(); // Renamed function for consistency
        return $this->respond(['todaysOnTrainingCount' => $count]);
    }

    private function countTodayOnTraining(): int // Renamed function for consistency
    {
        $currentDate = date('Y-m-d');
        $builder = $this->trainingModel->builder();
        $builder->select('COUNT(*) as NumberOfTrainingsToday');
        $builder->where('period_from <=', $currentDate);
        $builder->where('period_to >=', $currentDate);
        $query = $builder->get();
        $result = $query->getRowArray();
        return (int)$result['NumberOfTrainingsToday'];
    }

    public function getTodaysLeavesCount(): ResponseInterface
    {
        $count = $this->countTodaysLeaves();
        return $this->respond(['todaysLeavesCount' => $count]);
    }

    private function countTodaysLeaves(): int
    {
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

    public function fetchPendingLeaveCount(): ResponseInterface
    {
        $pendingLeavesCount = $this->employeeLeavesModel
            ->where('status', 'pending')
            ->countAllResults();

        return $this->respond(['pendingLeavesCount' => $pendingLeavesCount]);
    }

    public function fetchCountOfUpcomingTrainingsWithNoAssignedEmployees(): ResponseInterface
    {
        $today = date('Y-m-d'); // Get the current date in 'Y-m-d' format.

        $countOfUpcomingTrainingsWithNoEmployees = $this->trainingModel
            ->where('training.period_from >=', $today)
            ->groupBy('training.training_id') // Group by training ID to avoid duplicates.
            ->whereNotIn('training.training_id', function($builder) {
                return $builder->select('training_id')
                            ->from('internal_employee_training');
            })
            ->countAllResults(); // Use countAllResults() or equivalent method in your framework.

        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'error' => null,
            'data' => $countOfUpcomingTrainingsWithNoEmployees
        ]);
    }

    public function getActiveEmployeesCount()
    {
        $count = $this->countActiveEmployees();
        return $this->respond(['activeEmployeesCount' => $count]);
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
}
