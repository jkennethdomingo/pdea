<?php

namespace Config;

use CodeIgniter\Config\BaseService;
use App\Models\SectionModel;
use App\Models\DesignationModel;
use App\Models\PositionModel;
use App\Models\EmployeeAuthRoleModel;
use App\Models\EmployeePositionModel;
use App\Models\EmployeeDesignationModel;
use App\Models\EmployeeSectionModel;
use App\Models\LeavetypeModel;
use App\Models\LeaveBalanceModel;
use App\Models\FamilyBackgroundModel;
use App\Models\ChildrenModel;
use App\Models\EducationalBackgroundModel;
use App\Models\CivilServiceEligibilityModel;
use App\Models\WorkExperienceModel;
use App\Models\VoluntaryWorkModel;
use App\Models\TrainingProgramsModel;
use App\Models\OtherInformationModel;
use App\Models\PdSheetQuestionsModel;
use App\Models\ReferencesTblModel;
use App\Models\GovernmentIssuedIDsModel;
use App\Models\AddressModel;
use App\Models\EmployeeAddressModel;
use App\Models\AssetAuditModel;
use App\Models\AssetLocationModel;
use App\Models\AssetModel;
use App\Models\AssetStatusModel;
use App\Models\AssetTypeModel;
use App\Models\ProvincialOfficeModel;
use App\Models\RegionalOfficeModel;
use App\Models\DepartmentModel;
use App\Models\ProcurementModel;
use App\Models\ProcurementStatusModel;
use App\Models\EmployeeLeavesModel;
use App\Models\InternalEmployeeTrainingModel;
use App\Models\TrainingModel;
use App\Models\LeaveRequestNotesModel;
use App\Models\DivisionModel;
use App\Models\EmployeeDivisionModel;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends BaseService
{
    /*
     * public static function example($getShared = true)
     * {
     *     if ($getShared) {
     *         return static::getSharedInstance('example');
     *     }
     *
     *     return new \CodeIgniter\Example();
     * }
     */
    public static function personalInformationModel($getShared = true)
    {
        if ($getShared) {
            return static::getSharedInstance('personalInformationModel');
        }

        return new \App\Models\PersonalInformationModel();
    }

    public static function sectionModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('sectionModel');
        }

        return new SectionModel();
    }

    public static function designationModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('designationModel');
        }

        return new DesignationModel();
    }

    public static function positionModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('positionModel');
        }

        return new PositionModel();
    }
    
    public static function employeeAuthRoleModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('employeeAuthRoleModel');
        }

        return new EmployeeAuthRoleModel();
    }
    
    public static function employeePositionModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('employeePositionModel');
        }

        return new EmployeePositionModel();
    }

    public static function employeeDesignationModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('employeeDesignationModel');
        }

        return new EmployeeDesignationModel();
    }

    public static function employeeSectionModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('employeeSectionModel');
        }

        return new EmployeeSectionModel();
    }

    public static function leavetypeModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('leavetypeModel');
        }

        return new LeavetypeModel();
    }

    public static function leaveBalanceModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('leaveBalanceModel');
        }

        return new LeaveBalanceModel();
    }

    public static function FamilyBackgroundModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('FamilyBackgroundModel');
        }

        return new FamilyBackgroundModel();
    }

    public static function ChildrenModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('ChildrenModel');
        }

        return new ChildrenModel();
    }

    public static function EducationalBackgroundModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('EducationalBackgroundModel');
        }

        return new EducationalBackgroundModel();
    }

    public static function CivilServiceEligibilityModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('CivilServiceEligibilityModel');
        }

        return new CivilServiceEligibilityModel();
    }

    public static function WorkExperienceModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('WorkExperienceModel');
        }

        return new WorkExperienceModel();
    }

    public static function VoluntaryWorkModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('VoluntaryWorkModel');
        }

        return new VoluntaryWorkModel();
    }

    public static function TrainingProgramsModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('TrainingProgramsModel');
        }

        return new TrainingProgramsModel();
    }

    public static function OtherInformationModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('OtherInformationModel');
        }

        return new OtherInformationModel();
    }

    public static function PdSheetQuestionsModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('PdSheetQuestionsModel');
        }

        return new PdSheetQuestionsModel();
    }

    public static function ReferencesTblModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('ReferencesTblModel');
        }

        return new ReferencesTblModel();
    }

    public static function GovernmentIssuedIDsModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('GovernmentIssuedIDsModel');
        }

        return new GovernmentIssuedIDsModel();
    }

    public static function AddressModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('AddressModel');
        }

        return new AddressModel();
    }

    public static function AssetAuditModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('AssetAuditModel');
        }

        return new AssetAuditModel();
    }

    public static function AssetLocationModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('AssetLocationModel');
        }

        return new AssetLocationModel();
    }

    public static function AssetModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('AssetModel');
        }

        return new AssetModel();
    }

    public static function AssetStatusModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('AssetStatusModel');
        }

        return new AssetStatusModel();
    }

    public static function ProvincialOfficeModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('ProvincialOfficeModel');
        }

        return new ProvincialOfficeModel();
    }

    public static function EmployeeAddressModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('EmployeeAddressModel');
        }

        return new EmployeeAddressModel();
    }

    public static function DepartmentModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('DepartmentModel');
        }

        return new DepartmentModel();
    }

    public static function AssetTypeModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('AssetTypeModel');
        }

        return new AssetTypeModel();
    }

    public static function RegionalOfficeModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('RegionalOfficeModel');
        }

        return new RegionalOfficeModel();
    }

    public static function ProcurementModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('ProcurementModel');
        }

        return new ProcurementModel();
    }

    public static function ProcurementStatusModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('ProcurementStatusModel');
        }

        return new ProcurementStatusModel();
    }

    public static function TrainingModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('TrainingModel');
        }

        return new TrainingModel();
    }

    public static function InternalEmployeeTrainingModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('InternalEmployeeTrainingModel');
        }

        return new InternalEmployeeTrainingModel();
    }

    public static function EmployeeLeavesModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('EmployeeLeavesModel');
        }

        return new EmployeeLeavesModel();
    }
    
    public static function LeaveRequestNotesModel($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('LeaveRequestNotesModel');
        }

        return new LeaveRequestNotesModel();
    }
    
    public static function Division($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('Division');
        }

        return new Division();
    }
    
    public static function EmployeeDivision($getShared = true)
    {
        if ($getShared)
        {
            return static::getSharedInstance('EmployeeDivision');
        }

        return new EmployeeDivision();
    }

}
