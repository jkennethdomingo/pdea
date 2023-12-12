<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Config\Services;

class Beta extends ResourceController
{
    use ResponseTrait;

    protected $personalInformationModel;

    public function __construct()
    {
        $this->personalInformationModel = Services::personalInformationModel();
    }

    public function doUpload()
    {
        $file = $this->request->getFile('file');

        // Check if the file is valid
        if ($file->isValid() && !$file->hasMoved()) {
            // Move the file to a writable directory
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads', $newName);

            // Get the employee ID from your session or request
            $employeeID = '48795'; // Replace with your logic to get the employee ID

            // Update the personal_information table with the file details
            $this->personalInformationModel->updatePhoto($employeeID, $newName);

            return json_encode(['status' => 'success', 'message' => 'File uploaded successfully']);
        } else {
            return json_encode(['status' => 'error', 'message' => $file->getErrorString()]);
        }
    }

}
