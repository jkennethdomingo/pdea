<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class AssetLocationController extends ResourceController
{
    use ResponseTrait;

    protected $departmentModel;
    protected $provincialOfficeModel;
    protected $regionalOfficeModel;

    public function __construct()
    {
        $this->departmentModel = Services::DepartmentModel();
        $this->provincialOfficeModel = Services::ProvincialOfficeModel();
        $this->regionalOfficeModel = Services::RegionalOfficeModel();
    }

    private function getValidationRules($type)
    {
        $rules = [
            'department' => [
                'department_name' => 'required|min_length[3]|max_length[255]',
                // Additional department rules...
            ],
            'provincial_office' => [
                'office_name' => 'required|min_length[3]|max_length[255]',
                'location' => 'required',
                // Additional provincial office rules...
            ],
            'regional_office' => [
                'regional_office_name' => 'required|min_length[3]|max_length[255]',
                // Additional regional office rules...
            ]
        ];

        return $rules[$type] ?? [];
    }

    private function insertEntity($model, $data, $entityName)
    {
        if ($model->insert($data)) {
            return $this->respondCreated("$entityName added successfully");
        } else {
            return $this->fail($model->errors(), 400);
        }
    }

    public function addEntity($type)
    {
        $json = $this->request->getJSON();
        $rules = $this->getValidationRules($type);

        if (!$this->validate($rules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $modelName = "{$type}Model";
        $entityName = str_replace('_', ' ', ucfirst($type));

        return $this->insertEntity($this->$modelName, (array)$json, $entityName);
    }

    
}



