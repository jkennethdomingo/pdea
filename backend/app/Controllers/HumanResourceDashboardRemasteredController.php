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

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->employeeLeavesModel = Services::EmployeeLeavesModel();
        $this->internalEmployeeTrainingModel = Services::InternalEmployeeTrainingModel();
        $this->trainingModel = Services::TrainingModel();
    }
}
