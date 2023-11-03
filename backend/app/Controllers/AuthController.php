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

        // JWT payload
        $payload = [
            'iss' => 'example.com', // Issuer
            'sub' => $user['id'], // Subject, typically the user ID
            'role' => $user['Role'], // User's role
            'exp' => time() + 60*15, // Shorter expiration time (e.g., 15 minutes)
            'iat' => time(), // Issued at
            'jti' => base64_encode(random_bytes(16)) // JWT ID
        ];

        // Generate JWT using HS256 (HMAC with SHA-256)
        $secretKey = getenv('JWT_SECRET'); // Get the secret key from your .env file or environment variable
        $token = JWT::encode($payload, $secretKey, 'HS256');

        // You can return the token in the response body or set it as a cookie
        // If setting as a cookie, ensure to use HttpOnly and Secure flags for production

        // Return success response (without sending the role in the payload)
        return $this->respond([
            'message' => 'Login successful',
            'token' => $token // Optionally send the token in the response
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