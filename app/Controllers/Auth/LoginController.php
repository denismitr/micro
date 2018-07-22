<?php


namespace App\Controllers\Auth;


use App\Auth\JwtAuthInterface;
use App\Controllers\Controller;
use Psr\Http\Message\{
    RequestInterface as Request,
    ResponseInterface as Response
};

class LoginController extends Controller
{
    /**
     * @var JwtAuthInterface
     */
    private $auth;

    /**
     * LoginController constructor.
     * @param JwtAuthInterface $auth
     */
    public function __construct(JwtAuthInterface $auth)
    {
        $this->auth = $auth;
    }

    public function login(Request $request, Response $response)
    {
        if ( !$token = $this->retrieveToken($request)) {
            return $response->withJson([
                'message' => 'Authentication failed.',
            ], 401);
        }

        return $response->withJson([
            'token' => $token,
        ]);
    }

    protected function retrieveToken(Request $request): ?string
    {
        return $this->auth->attempt(
            $request->getParam('username'),
            $request->getParam('password')
        );
    }
}