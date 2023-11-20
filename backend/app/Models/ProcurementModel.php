<?php

namespace App\Models;

use CodeIgniter\Model;

class ProcurementModel extends Model
{
    protected $table            = 'procurement';
    protected $primaryKey       = 'procurement_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['project_particulars', 'date_of_receipt_of_request', 'purchase_work_job_request_no', 'purchase_work_job_request_date', 'philgeps_posting', 'abstract_of_canvas_no', 'abstract_of_canvas_date', 'price_quotation_no', 'price_quotation_date', 'amount', 'EmployeeID', 'department_id', 'provincial_office_id', 'regional_office_id', 'supplier', 'date_request_for_fund', 'ideal_no_of_days_to_complete', 'actual_days_to_complete', 'difference', 'purchase_order', 'delivery_status', 'remarks', 'item_status'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
