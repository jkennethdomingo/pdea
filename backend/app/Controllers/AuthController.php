<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends ResourceController  
{
    use ResponseTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new \App\Models\EmployeeModel();
    }

    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');

        $user = $this->loginUser($email, $password);

        if (!$user) {
            return $this->failUnauthorized('Invalid credentials');
        }

        $payload = [
            'iss' => 'example.com',
            'sub' => $user['id'],
            'exp' => time() + 60*60
        ];

        $token = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return $this->respond([
            'token' => $token
        ]);
    }

    public function loginUser($email, $password)
    {
        $user = $this->model->where('Email', $email)->first();
        
        if (!$user) {
            throw new \Exception('Invalid login');
        }

        if (!password_verify($password, $user['Password'])) {
            throw new \Exception('Invalid login');
        }

        return $user;
    }

    public function create()
    {
        $json = $this->request->getJSON();

        $data = [
            'EmployeeID' => $json->EmployeeID,
            'Name' => $json->Name,
            'Email' => $json->Email,
            'Password' => password_hash($json->Password, PASSWORD_DEFAULT), 
            'PhoneNumber' => $json->PhoneNumber,
            'Address' => $json->Address,
            'DateOfBirth' => $json->DateOfBirth,
            'Department' => $json->Department,
            'Role' => $json->Role,
            'LeaveBalance' => $json->LeaveBalance,
        ];

        // Set validation rules
        $validationRules = [
            'EmployeeID' => 'required|alpha_numeric',
            'Name' => 'required|alpha_space',
            'Email' => 'required|valid_email',
            'Password' => 'required', // Password validation can be added here if needed
            'PhoneNumber' => 'required|numeric',
            'Address' => 'required',
            'DateOfBirth' => 'required|valid_date',
            'Department' => 'required',
            'Role' => 'required',
            'LeaveBalance' => 'required|numeric',
        ];

        if (!$this->validate($validationRules)) {
            return $this->fail($this->validator->getErrors(), 400);
        }

        $this->model->insert($data);

        $response = ['message' => 'Data inserted successfully'];
        return $this->respondCreated($response, 201);
    }

}