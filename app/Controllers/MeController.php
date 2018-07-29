<?php
/**
 * Created by PhpStorm.
 * User: denismitr
 * Date: 30.07.2018
 * Time: 0:52
 */

namespace App\Controllers;


use Slim\Http\Request;
use Slim\Http\Response;

class MeController
{
    public function index(Request $request, Response $response)
    {
        return $response->withJson(['message' => 'This is me']);
    }
}