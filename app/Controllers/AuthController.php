<?php 

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use \Firebase\JWT\ExpiredException;
use \Firebase\JWT\SignatureInvalidException;
use \Firebase\JWT\BeforeValidException;
use Config\Services;
use CodeIgniter\HTTP\ResponseInterface;

class AuthController extends ResourceController  
{
    use ResponseTrait;

    protected $personalInformationModel;
    protected $employeeAuthRoleModel;
    protected $authRoleModel;
    protected $jwtBlackListModel;

    public function __construct()
    {
        $this->personalInformationModel = new \App\Models\PersonalInformationModel();
        $this->employeeAuthRoleModel = new \App\Models\EmployeeAuthRoleModel();
        $this->authRoleModel = new \App\Models\AuthRoleModel();
        $this->jwtBlackListModel = Services::JwtBlackListModel();
    }

    public function login()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $remember = $this->request->getVar('remember'); // Get the 'remember' parameter from the request
    
        $user = $this->loginUser($email, $password);
    
        if (!$user) {
            return $this->failUnauthorized('Invalid credentials');
        }
    
        // Set the expiration time based on the 'remember' parameter
        $expirationTime = time() + ($remember ? (60 * 60 * 24 * 7) : (60 * 60 * 24)); // 1 week if remember is true, otherwise 1 day
    
        // JWT payload
        $payload = [
            'iss' => 'pdeabackend.com', // Issuer
            'sub' => $user['EmployeeID'], // Subject, typically the user ID
            'role' => $user['Role'], // User's role
            'exp' => $expirationTime, // Expiration time
            'iat' => time(), // Issued at
            'jti' => base64_encode(random_bytes(16)) // JWT ID
        ];
    
        // Generate JWT using HS256 (HMAC with SHA-256)
        $secretKey = getenv('JWT_SECRET'); // Get the secret key from your .env file or environment variable
        $token = JWT::encode($payload, $secretKey, 'HS256');
    
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

    public function getEmployeePhoto($employeeID)
    {
        // Select only the 'photo' field
        $this->personalInformationModel->select('photo');

        // Add a condition to fetch the photo of the specific employee
        $this->personalInformationModel->where('EmployeeID', $employeeID);

        // Perform the query
        $query = $this->personalInformationModel->first();

        // Return the photo if found, else return null
        $photo = $query ? $query['photo'] : null;
        return $this->respond(['photo' => $photo]);
    }
    
    public function logout()
    {
        try {
            $json = $this->request->getJSON();
            $token = $json->token ?? null;
    
            if (!$token) {
                return $this->failUnauthorized('No token provided');
            }
    
            // Decode the token
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            $jti = $decoded->jti;
    
            // Check if jti already exists in the blacklist
            $existingJti = $this->jwtBlackListModel->where('jti', $jti)->first();
    
            if (!$existingJti) {
                // Insert jti into the blacklist table only if it doesn't exist
                $this->jwtBlackListModel->insert([
                    'jti' => $jti,
                    'iat' => $decoded->iat,
                    'exp' => $decoded->exp
                ]);
            } else {
                // Optionally handle the case where the jti already exists
                // e.g., log this event or return a specific response
            }
    
            return $this->respond(['message' => 'Logout successful']);
    
        } catch (\Exception $e) {
            return $this->fail(new \Exception('An error occurred during logout: ' . $e->getMessage()));
        }
    }
    



    /*public function checkTokenBlacklist()
    {
        $token = $this->request->getHeaderLine('Authorization');
        if (!$token) {
            return $this->failUnauthorized('No token provided');
        }

        try {
            $decoded = JWT::decode($token, getenv('JWT_SECRET'), ['HS256']);
            $jti = $decoded->jti;

            // Check if the token's jti is in the blacklist
            $isBlacklisted = $this->jwtBlackListModel->where('jti', $jti)->first();
            if ($isBlacklisted) {
                return $this->respond(['message' => 'Token is blacklisted'], ResponseInterface::HTTP_OK);
            } else {
                return $this->respond(['message' => 'Token is valid'], ResponseInterface::HTTP_OK);
            }
        } catch (\Exception $e) {
            // Handle token decoding errors
            return $this->failUnauthorized('Invalid token: ' . $e->getMessage());
        }
    }*/ // With authorization header

    public function checkTokenBlacklist()
    {
        $json = $this->request->getJSON();
        $token = $json->token ?? null; // Get token from JSON
    
        if (!$token) {
            return $this->failUnauthorized('No token provided');
        }
    
        try {
            // Update here: Using Key class for decoding
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET'), 'HS256'));
            $jti = $decoded->jti;
    
            // Check if the token's jti is in the blacklist
            $isBlacklisted = $this->jwtBlackListModel->where('jti', $jti)->first();
            if ($isBlacklisted) {
                return $this->respond(['message' => 'Token is blacklisted'], ResponseInterface::HTTP_OK);
            } else {
                return $this->respond(['message' => 'Token is valid'], ResponseInterface::HTTP_OK);
            }
        } catch (\Exception $e) {
            // Handle token decoding errors
            return $this->failUnauthorized('Invalid token: ' . $e->getMessage());
        }
    }
    



    




}