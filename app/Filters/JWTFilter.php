<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTFilter implements FilterInterface {

    public function before(RequestInterface $request, $arguments = null)
    {
        $key = env('JWT_SECRET');

        $authHeader = $request->getHeaderLine('Authorization');
        $token = null;

        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (!$token) {
            return service('response')
                    ->setStatusCode(401)
                    ->setBody('Unauthorized');
        }

        try {
            JWT::decode($token, new Key($key, 'HS256'));
            
            // Optionally can check if user exists
            // $user = User::find($decoded->sub);

        } catch (\Exception $e) {
            return service('response')
                    ->setStatusCode(401)
                    ->setBody('Unauthorized');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    // 
    }

}