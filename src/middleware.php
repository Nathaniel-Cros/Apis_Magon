<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);
use Firebase\JWT\JWT;


$valida_token = function($request, $response, $next){
    $token = $request->getHeader('Authorization');

    if(isset($token)) {

        //$jwt = JWT::decode($token,key_secret,'HS512');

        $response->getBody()->write(var_dump($token));
        //$response->getBody()->write('BEFORE');
        $response = $next($request, $response);

        return $response;
    }else {
        $response->getBody()->wirte('No es posible acceder a esta direccion');

        return $response;
    }
};