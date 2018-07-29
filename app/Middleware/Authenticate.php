<?php

namespace App\Middleware;


use App\Auth\JwtAuth;
use Slim\Http\Request;
use Slim\Http\Response;

class Authenticate
{
    /**
     * @var JwtAuth
     */
    protected $auth;

    /**
     * Authenticate constructor.
     * @param JwtAuth $auth
     */
    public function __construct(JwtAuth $auth)
    {
        $this->auth = $auth;
    }

    public function __invoke(Request $request, Response $response, $next)
    {
        if (!$token = $this->getAuthorizationHeader($request)) {
            return $response->withStatus(401);
        }

        try {
            $this->auth->authenticate($token);
        } catch (\Exception $e) {
            return $response->withJson([
                'message' => $e->getMessage(),
            ], 401);
        }

        return $next($request, $response);
    }

    protected function getAuthorizationHeader(Request $request)
    {
        [$header] = $request->getHeader('Authorization');

        if ($header) {
            return false;
        }

        return $header;
    }
}