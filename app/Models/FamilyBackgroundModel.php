<?php

namespace App\Models;

use CodeIgniter\Model;

class FamilyBackgroundModel extends Model
{
    protected $table            = 'family_background';
    protected $primaryKey       = 'family_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['EmployeeID', 'spouse_surname', 'spouse_first_name', 'spouse_name_extension', 'spouse_middle_name', 'spouse_occupation', 'spouse_employer_business_name', 'spouse_business_address', 'spouse_telephone_no', 'father_surname', 'father_middle_name', 'father_first_name', 'father_name_extension', 'mother_maiden_name', 'mother_surname', 'mother_first_name', 'mother_middle_name'];

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
