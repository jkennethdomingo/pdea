<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController extends ResourceController  
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $employeeAuthRoleModel;
    protected $authRoleModel;

    public function __construct()
    {
        $this->personalInformationModel = new \App\Models\PersonalInformationModel();
        $this->employeeAuthRoleModel = new \App\Models\EmployeeAuthRoleModel();
        $this->authRoleModel = new \App\Models\AuthRoleModel();
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
            'iss' => 'pdeabackend.com', // Issuer
            'sub' => $user['EmployeeID'], // Subject, typically the user ID
            'role' => $user['Role'], // User's role
            'exp' => time() + 60*60, // Expiration time (e.g., 60 minutes)
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
        $user = $this->personalInformationModel->where('Email', $email)->first();
        
        if (!$user) {
            throw new \Exception('Invalid login');
        }

        // Retrieve the pepper from your secure storage (e.g., environment variable).
        $pepper = getenv('PASSWORD_PEPPER');
        // Pepper the input password before verification.
        $pepperedPassword = hash_hmac('sha256', $password, $pepper);

        // Now verify the peppered password against the hashed password from the database.
        if (!password_verify($pepperedPassword, $user['Password'])) {
            throw new \Exception('Invalid login');
        }

        // Get the AuthRoleID from EmployeeAuthRole where EmployeeID matches
        $empAuth = $this->employeeAuthRoleModel->where('EmployeeID', $user['EmployeeID'])->first();
        if (!$empAuth) {
            throw new \Exception('User has no role assigned');
        }

        // Get the role name from AuthRole based on AuthRoleID
        $role = $this->authRoleModel->find($empAuth['AuthRoleID']);
        if (!$role) {
            throw new \Exception('Role does not exist');
        }

        // Add the role name to the user array to be included in the JWT payload
        $user['Role'] = $role['AuthRoleName'];

        return $user;
    }


}