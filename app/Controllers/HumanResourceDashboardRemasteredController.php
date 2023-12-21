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

    public function getUpcomingEvents()
    {
        $today = date('Y-m-d');

        // Fetch employee birthdays
        $birthdays = $this->personalInformationModel->getUpcomingBirthdays($today);

        // Fetch training data including the employees involved
        $trainingQuery = $this->trainingModel->builder(); // Corrected line
        $trainingQuery->select('training.*, GROUP_CONCAT(DISTINCT personal_information.first_name, " ", personal_information.surname ORDER BY personal_information.first_name ASC) as participants');
        $trainingQuery->join('internal_employee_training', 'training.training_id = internal_employee_training.training_id', 'left');
        $trainingQuery->join('personal_information', 'internal_employee_training.EmployeeID = personal_information.EmployeeID', 'left');
        $trainingQuery->where('training.period_from >=', $today); // Only get training starting today or in the future
        $trainingQuery->groupBy('training.training_id');
        $training = $trainingQuery->get()->getResult();

        // Fetch employee on leave data
        $leaveQuery = $this->employeeLeavesModel->builder(); // Corrected line
        $leaveQuery->select('
            employee_leaves.id,
            employee_leaves.EmployeeID,
            employee_leaves.leave_type_id,
            employee_leaves.start_date,
            employee_leaves.end_date,
            employee_leaves.reason,
            employee_leaves.status,
            personal_information.surname,
            personal_information.first_name,
            leave_type.LeaveTypeName
        ');
        $leaveQuery->join('personal_information', 'employee_leaves.EmployeeID = personal_information.EmployeeID', 'inner');
        $leaveQuery->join('leave_type', 'employee_leaves.leave_type_id = leave_type.LeaveTypeID', 'inner');
        $leaveQuery->where('employee_leaves.start_date >=', $today); // Only get leaves starting today or in the future
        $leaveQuery->where('employee_leaves.status', 'approved'); // Only get leaves with 'approved' status
        $employeeOnLeave = $leaveQuery->get()->getResult();

        // Combine the datasets
        $data = [
            'upcomingEmployeeBirthdays' => $birthdays,
            'upcomingTraining' => $training,
            'upcomingEmployeeOnLeave' => $employeeOnLeave,
        ];

        // Return the combined response
        return $this->respond($data);
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

    public function getTodayTrainingCount()
    {
        $count = $this->countTodayTraining();
        return $this->respond(['todaysTrainingCount' => $count]);
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

    public function fetchRecentlyApprovedLeaves(): ResponseInterface
    {
        $approvedLeaves = $this->employeeLeavesModel
            ->select('personal_information.first_name, personal_information.middle_name, personal_information.surname, personal_information.photo, personal_information.Email, leave_type.LeaveTypeName, employee_leaves.*')
            ->join('personal_information', 'personal_information.EmployeeID = employee_leaves.EmployeeID')
            ->join('leave_type', 'leave_type.LeaveTypeID = employee_leaves.leave_type_id')
            ->where('employee_leaves.status', 'approved')
            ->orderBy('employee_leaves.updated_at', 'DESC')
            ->findAll();

        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'error' => null,
            'data' => $approvedLeaves
        ]);
    }

    public function fetchUpcomingTrainingsWithNoAssignedEmployees(): ResponseInterface
    {
        $today = date('Y-m-d'); // Get the current date in 'Y-m-d' format.

        $upcomingTrainingsWithNoEmployees = $this->trainingModel
            ->select('training.*')
            ->where('training.period_from >=', $today)
            ->groupBy('training.training_id') // Group by training ID to avoid duplicates.
            ->whereNotIn('training.training_id', function($builder) {
                return $builder->select('training_id')
                               ->from('internal_employee_training');
            })
            ->orderBy('training.period_from', 'ASC') // Order by date, closest first.
            ->findAll();

        return $this->respond([
            'status' => ResponseInterface::HTTP_OK,
            'error' => null,
            'data' => $upcomingTrainingsWithNoEmployees
        ]);
    }
    
}
