<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class RoleFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
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
                    ->setBody('Token not provided');
        }

        try {
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Check the user role based on the $arguments passed to the filter
            if (isset($arguments['role']) && (!isset($decoded->role) || $decoded->role !== $arguments['role'])) {
                return service('response')
                        ->setStatusCode(403)
                        ->setBody('Forbidden: Insufficient privileges');
            }

            // Pass the decoded token data to the controller, if needed
            $request->setGlobal('decoded_token', $decoded);

            // Continue with the request processing if the token is valid and the role is authorized
            return $request;

        } catch (\Exception $e) {
            return service('response')
                    ->setStatusCode(401)
                    ->setBody('Unauthorized: ' . $e->getMessage());
        }
    }



    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        //
    }
}
