<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;


class PropertyMonitoringController extends ResourceController
{
    use ResponseTrait;

    protected $db;
    protected $assetModel;
    protected $assetLocationModel;
    protected $assetStatusModel;
    protected $assetAuditModel;
    protected $assetTypeModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect(); // Instantiate database connection
        $this->assetModel = Services::AssetModel();
        $this->assetLocationModel = Services::AssetLocationModel();
        $this->assetStatusModel = Services::AssetStatusModel();
        $this->assetAuditModel = Services::AssetAuditModel();
        $this->assetTypeModel = Services::AssetTypeModel();
    }

    public function insertAssetData()
    {
        // Assuming you are receiving JSON data
        $formData = $this->request->getJSON();
    
        $this->db->transStart();
    
        try {
            // Insert into `asset` table
            $assetData = [
                'article' => $formData->article,
                'asset_type_id' => $formData->asset_type_id,
                'description' => $formData->description,
                'yr_acquired' => $formData->yr_acquired,
                'serial_number' => $formData->serial_number,
                'property_number' => $formData->property_number,
                'unit_of_measure' => $formData->unit_of_measure,
                'unit_value' => $formData->unit_value,
            ];
            $this->assetModel->insert($assetData);
            $asset_id = $this->assetModel->getInsertID();
    
            // Insert into `asset_status` table
            $assetStatusData = [
                'asset_id' => $asset_id,
                'qty_per_property_card' => $formData->qty_per_property_card,
                'physical_count' => $formData->physical_count,
                'shortage_overage_qty' => $formData->shortage_overage_qty,
                'shortage_overage_value' => $formData->shortage_overage_value,
                'status' => $formData->status
            ];
            $this->assetStatusModel->insert($assetStatusData);
    
            // Insert into `asset_location` table
            $assetLocationData = [
                'asset_id' => $asset_id,
                'remarks_whereabouts' => $formData->remarks_whereabouts
            ];
            $this->assetLocationModel->insert($assetLocationData);
    
            // Check if the EmployeeID exists in the personal_information table
            $employeeExists = $this->db->table('personal_information')
                                       ->where('EmployeeID', $formData->employeeID)
                                       ->countAllResults() > 0;
    
            if (!$employeeExists) {
                // Rollback the transaction if the EmployeeID does not exist
                $this->db->transRollback();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => "EmployeeID {$formData->employeeID} does not exist in personal information."
                ]);
            }
    
            // Insert into `asset_audit` table
            $audit_date = date('Y-m-d H:i:s'); // Set audit_date to current date and time
            $assetAuditData = [
                'asset_id' => $asset_id,
                'EmployeeID' => $formData->employeeID,
                'audit_date' => $audit_date,
            ];
            $this->assetAuditModel->insert($assetAuditData);
    
            // Commit the transaction if everything went well
            $this->db->transComplete();
    
            if ($this->db->transStatus() === false) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Transaction failed: Could not insert asset data.'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Asset data inserted successfully.'
                ]);
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of an error
            $this->db->transRollback();
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Exception caught: ' . $e->getMessage()
            ]);
        }
    }

    public function getPropertyPlantAndEquipment()
{
    $this->db->transStart();
    try {
        $assets = $this->assetModel
            ->select('asset.*, asset_type.type_name as asset_type_name, asset_location.remarks_whereabouts, asset_audit.audit_date')
            ->join('asset_type', 'asset_type.asset_type_id = asset.asset_type_id', 'left')
            ->join('asset_location', 'asset_location.asset_id = asset.asset_id', 'left')
            ->join('asset_audit', 'asset_audit.asset_id = asset.asset_id', 'left')
            ->findAll();

        $categorizedData = [
            'active' => [],
            'archived' => []
        ];

        foreach ($assets as $asset) {
            $statusKey = strtolower($asset['item_status']);
            $typeKey = $asset['asset_type_name'];

            // Initialize the array if not already set
            if (!isset($categorizedData[$statusKey][$typeKey])) {
                $categorizedData[$statusKey][$typeKey] = [];
            }

            array_push($categorizedData[$statusKey][$typeKey], $asset);
        }

        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Could not retrieve inventory data.'
            ]);
        } else {
            return $this->response->setJSON([
                'success' => true,
                'data' => $categorizedData
            ]);
        }
    } catch (\Exception $e) {
        // Rollback the transaction in case of an error
        $this->db->transRollback();
        return $this->response->setJSON([
            'success' => false,
            'message' => 'Exception caught: ' . $e->getMessage()
        ]);
    }
}

    


    public function getAssetType()
    {
        $data = [
            'asset_type' => $this->assetTypeModel->findAll(),
        ];

        return $this->respond($data);
    }

    

}
