<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class ManageInventoryController extends ResourceController
{
    use ResponseTrait;

    protected $procurementModel;
    protected $procurementStatusModel;

    public function __construct()
    {
        $this->procurementModel = Services::ProcurementModel();
        $this->procurementStatusModel = Services::ProcurementStatusModel();
    }

    public function addInventory()
    {
        $json = $this->request->getJSON();

        // Begin transaction
        $this->procurementModel->transStart();

        // Insert into procurement table
        $procurementData = [
            'project_particulars' => $json->project_particulars,
            'date_of_receipt_of_request' => $json->date_of_receipt_of_request,
            'purchase_work_job_request_no' => $json->purchase_work_job_request_no,
            'purchase_work_job_request_date' => $json->purchase_work_job_request_date,
            'philgeps_posting' => $json->philgeps_posting,
            'abstract_of_canvas_no' => $json->abstract_of_canvas_no,
            'abstract_of_canvas_date' => $json->abstract_of_canvas_date,
            'price_quotation_no' => $json->price_quotation_no,
            'price_quotation_date' => $json->price_quotation_date,
            'amount' => $json->amount,
            'supplier' => $json->supplier,
            'date_request_for_fund' => $json->date_request_for_fund,
            'ideal_no_of_days_to_complete' => $json->ideal_no_of_days_to_complete,
            'actual_days_to_complete' => $json->actual_days_to_complete,
            'difference' => $json->difference,
            'purchase_order' => $json->purchase_order,
            'delivery_status' => $json->delivery_status,
            'remarks' => $json->remarks,
            // ... other fields from the JSON data
        ];

        if (isset($json->endUserType)) {
            switch ($json->endUserType) {
                case 'personal':
                    $procurementData['EmployeeID'] = $json->endUser;
                    break;
                case 'department':
                    $procurementData['department_id'] = $json->endUser;
                    break;
                case 'province':
                    $procurementData['provincial_office_id'] = $json->endUser;
                    break;
                case 'region':
                    $procurementData['regional_office_id'] = $json->endUser;
                    break;
                // ... other cases
            }
        }
        // ... similar checks for department_id, provincial_office_id, regional_office_id
        $procurementData['item_status'] = 'Active';

        $this->procurementModel->insert($procurementData);

        // Get the ID of the inserted procurement record
        $procurementId = $this->procurementModel->getInsertID();

        // Insert into procurement_status table
        $procurementStatusData = [
            'procurement_id' => $procurementId,
            'status_name'    => $json->status_name,
            // ... other fields from the JSON data
        ];

        $this->procurementStatusModel->insert($procurementStatusData);

        // Complete the transaction
        $this->procurementModel->transComplete();

        // Check for transaction success
        if ($this->procurementModel->transStatus() === FALSE) {
            // Transaction failed, handle the error
            return $this->fail('Transaction failed');
        } else {
            // Transaction succeeded
            return $this->respondCreated($procurementData, 'Inventory added');
        }
    }

    public function archiveInventory($id)
    {
        // Begin transaction
        $this->procurementModel->transStart();

        // Update the item_status to 'Archived' where the procurement ID matches
        $this->procurementModel->update($id, ['item_status' => 'Archived']);

        // Complete the transaction
        $this->procurementModel->transComplete();

        // Check for transaction success
        if ($this->procurementModel->transStatus() === FALSE) {
            // Transaction failed, handle the error
            return $this->fail('Archiving failed');
        } else {
            // Transaction succeeded
            return $this->respondUpdated(null, 'Item archived');
        }
    }

    public function getInventoryData(){
        $data = [
            'procurement' => $this->procurementModel->findAll(),
        ];

        return $this->respond($data);
    }


}
