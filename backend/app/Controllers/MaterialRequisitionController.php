<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class MaterialRequisitionController extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $departmentModel;
    protected $assetAuditModel;
    protected $assetLocationModel;
    protected $assetModel;
    protected $assetStatusModel;
    protected $provincialOfficeModel;
    protected $assetTypeModel;
    protected $regionalOfficeModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
        $this->departmentModel = Services::DepartmentModel();
        $this->assetAuditModel = Services::AssetAuditModel();
        $this->assetLocationModel = Services::AssetLocationModel();
        $this->assetModel = Services::AssetModel();
        $this->assetStatusModel = Services::AssetStatusModel();
        $this->provincialOfficeModel = Services::ProvincialOfficeModel();
        $this->regionalOfficeModel = Services::RegionalOfficeModel();
        $this->assetTypeModel = Services::AssetTypeModel();
    }

    protected function validateAuthRoleId($value) {
        return $value != 2;
    }
    
    public function assignAsset()
    {
        
        $json = $this->request->getJSON();

        $validationRules = $this->getCreateValidationRules();

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        // Start transaction for all related operations
        $this->assetModel->transStart();

        try {
            // Insert asset
            $assetData = [
                'article' => $json->article,
                'description' => $json->description,
                'yr_acquired' => $json->yr_acquired,
                'serial_number' => $json->serial_number,
                'property_number' => $json->property_number,
                'unit_of_measure' => $json->unit_of_measure,
                'unit_value' => $json->unit_value,
                'asset_type_id' => $json->asset_type_id,
                'procurement_id' => $json->procurement_id,
            ];
            $assetId = $this->assetModel->insert($assetData);
            if (!$assetId) {
                throw new \Exception('Failed to assign asset');
            }

            // Insert asset status
            $assetStatusData = [
                'asset_id' => $assetId,
                'qty_per_property_card' => $json->qty_per_property_card,
                'physical_count' => $json->physical_count,
                'shortage_overage_value' => $json->shortage_overage_value,
                'status' => $json->status,
            ];
            $this->assetStatusModel->insert($assetStatusData);

            $currentTime = date('Y-m-d H:i:s'); 
            // Insert asset audit
            $assetAuditData = [
                'asset_id' => $assetId,
                'audit_date' => $currentTime,
                'auth_role_id' => $json->auth_role_id, 
            ];
            $this->assetAuditModel->insert($assetAuditData);

            $assetLocationData = [
                'asset_id' => $assetId,
                'remarks_whereabouts' => $json->remarks_whereabouts,
            ];
            
            // Check which IDs are present and add them to the $assetLocationData array
            if (!empty($json->EmployeeID)) {
                $assetLocationData['EmployeeID'] = $json->EmployeeID;
            }
            if (!empty($json->department_id)) {
                $assetLocationData['department_id'] = $json->department_id;
            }
            if (!empty($json->provincial_office_id)) {
                $assetLocationData['provincial_office_id'] = $json->provincial_office_id;
            }
            if (!empty($json->regional_office_id)) {
                $assetLocationData['regional_office_id'] = $json->regional_office_id;
            }
            
            // Insert the asset location data into the model
            $this->assetLocationModel->insert($assetLocationData);
            

            // Check for any errors after insert operations
            if ($this->assetModel->errors() || $this->assetLocationModel->errors() || $this->assetStatusModel->errors() || $this->assetAuditModel->errors()) {
                throw new \Exception('Failed to assign asset with associated details');
            }

            // If everything is fine, complete the transaction
            $this->assetModel->transComplete();
        } 
        catch (\Exception $e) {
            // This will catch any other general exceptions that might be thrown
            $this->assetModel->transRollback();
            log_message('error', $e->getMessage());
            return $this->fail('An error occurred.', 500);
        }

        // If the transaction is successful, send a success response
        if ($this->assetModel->transStatus() === FALSE) {
            return $this->fail('Transaction failed', 500);
        } else {
            return $this->respondCreated('Asset assigned successfully with all associated details');
        }
    }


    private function getCreateValidationRules() 
    {
        return [
            'asset_type_id' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Asset type ID is required.',
                ]
                ],
        ];
    }


    public function getAgentData()
    {
        $data = [
            'personal_information' => $this->personalInformationModel->getSelectedInfo(),
        ];

        return $this->respond($data);
    }

    public function getDepartmentData()
    {
        $data = [
            'department' => $this->departmentModel->findAll(),
        ];

        return $this->respond($data);
    }

    public function getProvinceData()
    {
        $data = [
            'provincial_office' => $this->provincialOfficeModel->findAll(),
        ];

        return $this->respond($data);
    }

    public function getRegionData()
    {
        $data = [
            'regional_office' => $this->regionalOfficeModel->findAll(),
        ];

        return $this->respond($data);
    }

    public function getDropdownData()
    {
        $data = [
            'personal_information' => $this->personalInformationModel->getSelectedInfo(),
            'asset_type' => $this->assetTypeModel->findAll(),
            'department' => $this->departmentModel->findAll(),
            'provincial_office' => $this->provincialOfficeModel->findAll(),
            'regional_office' => $this->regionalOfficeModel->findAll(),
        ];

        return $this->respond($data);
    }





    
}
