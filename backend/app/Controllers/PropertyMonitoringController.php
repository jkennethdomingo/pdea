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
            'item_status' => $formData->status,
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
            // Add other location details as needed
        ];
        $this->assetLocationModel->insert($assetLocationData);

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


    public function getAssetType()
    {
        $data = [
            'asset_type' => $this->assetTypeModel->findAll(),
        ];

        return $this->respond($data);
    }

}
