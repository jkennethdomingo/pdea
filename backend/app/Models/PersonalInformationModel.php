<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalInformationModel extends Model
{
    protected $table            = 'personal_information';
    protected $primaryKey       = 'EmployeeID';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['EmployeeID', 'surname', 'first_name', 'name_extension', 'middle_name', 'date_of_birth', 'place_of_birth', 'sex', 'civil_status', 'height', 'weight', 'blood_type', 'gsis_id_no', 'pag_ibig_id_no', 'philhealth_no', 'sss_no', 'tin_no', 'agency_employee_no', 'citizenship', 'dual_citizenship_type', 'country', 'telephone_no', 'mobile_no', 'Email', 'Password', 'DateOfEntry', 'IPCR', 'photo'];

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

    public function getSelectedInfo() {
        // Start the query by selecting the fields from the personal_information table.
        $this->select('personal_information.EmployeeID, personal_information.first_name, personal_information.surname, personal_information.agency_employee_no, personal_information.telephone_no, personal_information.mobile_no, personal_information.Email, personal_information.photo');
        
        // Join with the employee_position table to get the corresponding PositionID for each employee.
        $this->join('employee_position', 'personal_information.EmployeeID = employee_position.EmployeeID', 'left');
        
        // Join with the position table to get the PositionName.
        $this->join('position', 'employee_position.PositionID = position.PositionID', 'left');
        
        // Select the PositionName from the position table.
        $this->select('position.PositionName');
        
        // Finally, perform the query and return the results.
        return $this->findAll();
    }

    public function updatePhoto($employeeID, $photo)
    {
        $this->set('photo', $photo)
             ->where('EmployeeID', $employeeID)
             ->update();
    }

    public function getAllBirthdays() {
        // Select only the date_of_birth field along with EmployeeID for identification
        $this->select('personal_information.EmployeeID, personal_information.date_of_birth, personal_information.surname, personal_information.first_name');
        
        // Perform the query and return the results
        return $this->findAll();
    }
    
}
