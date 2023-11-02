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
        $user = $this->model->where('email', $email)->first();
        
        if (!$user || !password_verify($password, $user['Password'])) {
            throw new \Exception('Invalid login');
        }

        return $user;
    }

}