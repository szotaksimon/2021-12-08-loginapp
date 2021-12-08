<?php

namespace Petrik\Loginapp\Middlewares;

use Exception;
use Petrik\Loginapp\Token;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthMiddleware {
    public function __invoke(Request $request, RequestHandler $handler):Response
    {
        $auth = $request->getHeader('Authorization');
        if (count($auth) !== 1){
            throw new Exception('Hibas Authorization header');
        }
        $authArr = mb_split(' ', $auth[0]);
        if ($authArr[0] !== 'Bearer'){
            throw new Exception('Nem tamogatott autentikacios modszer');
        }
        $tokenStr = $authArr[1];
        $token = Token::where('token', $tokenStr)->firstOrFail();

        // User kikeresése, eltárolása

        return $handler->handle($request);
    }

}