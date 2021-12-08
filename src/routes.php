<?php

use Petrik\Loginapp\Token;
use Petrik\Loginapp\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;

return function(App $app){
    $app->get('/', function (Request $request, Response $response, $args) {
        $response->getBody()->write("Helloo!");
        return $response;
    });
    $app->post('/register', function (Request $request, Response $response, $args){
        $userData = json_decode($request->getBody(), true);
        $user = new User();
        $user->email = $userData['email'];
        $user->password = password_hash($userData['password'], PASSWORD_DEFAULT);
        $user->save();
        $response->getBody()->write($user->toJson());
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(201);
    });
    $app->post('/login', function (Request $request, Response $response, $args){
        $loginData = json_decode($request->getBody(), true);
        // $loginData VALIDÁLÁS HELYE
        $email = $loginData['email']; //email megfelel?
        $password = $loginData['password']; //jelszó megfelel?
        $user = User::where('email', $email)->firstOrFail(); // <--- ha ilyen user nincs, akkor nincs értelme továbbmenni a függvényben.
        if (password_verify($password, $user->password)){
            throw new Exception('Hibas email v. jelszo');
        }
        $token = new Token();
        $token->user_id = $user->id;
        $token->token = bin2hex(random_bytes(64));
    });
};