<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

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

    public function getCombinedEvents()
    {
        // Fetch employee birthdays
        $birthdays = $this->personalInformationModel->getAllBirthdays();

        // Fetch training data
        $training = $this->trainingModel->findAll();

        // Fetch employee on leave data
        $builder = $this->employeeLeavesModel->builder();
        $builder->select('
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
        $builder->join('personal_information', 'employee_leaves.EmployeeID = personal_information.EmployeeID', 'inner');
        $builder->join('leave_type', 'employee_leaves.leave_type_id = leave_type.LeaveTypeID', 'inner');
        $employeeOnLeave = $builder->get()->getResult();

        // Combine the datasets
        $data = [
            'employeeBirthdays' => $birthdays,
            'training' => $training,
            'EmployeeOnLeave' => $employeeOnLeave,
        ];

        // Return the combined response
        return $this->respond($data);
    }


    public function getUpcomingEvents()
    {
        $today = date('Y-m-d');

        // Fetch employee birthdays
        $birthdays = $this->personalInformationModel->getUpcomingBirthdays($today);

        // Fetch training data including the employees involved
        $trainingQuery = $this->trainingModel->builder(); // Corrected line
        $trainingQuery->select('training.*, GROUP_CONCAT(DISTINCT personal_information.first_name, " ", personal_information.surname ORDER BY personal_information.first_name ASC) as participants');
        $trainingQuery->join('internal_employee_training', 'training.training_id = internal_employee_training.training_id', 'inner');
        $trainingQuery->join('personal_information', 'internal_employee_training.EmployeeID = personal_information.EmployeeID', 'inner');
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


}
