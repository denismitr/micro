<?php


namespace App\Controllers\Auth;


use App\Auth\JwtAuthInterface;
use App\Controllers\Controller;
use App\Models\User;
use Psr\Http\Message\{
    RequestInterface as Request,
    ResponseInterface as Response
};

class RegisterController extends Controller
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

    public function register(Request $request, Response $response)
    {
        $password = $this->auth->hashPassword($request->getParam('password'));

        try {
            $user = User::create([
                'email' => $request->getParam('email'),
                'name' => $request->getParam('name'),
                'password' => $password,
            ]);
        } catch (\Throwable $t) {
            return $response->withJson([
                'message' => $t->getMessage(),
            ], 400);
        }

        return $response->withJson([
            'data' => $user->toArray(),
        ]);
    }
}