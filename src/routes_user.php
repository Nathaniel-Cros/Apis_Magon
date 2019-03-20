<?php

use Slim\Http\Request;
use Slim\Http\Response;
use Firebase\JWT\JWT;



$app->post('/user/login',function(Request $request, Response $response){

    $email = $request->getParam('email');
    $pass = md5($request->getParam('pass'));

    $sql = " SELECT * FROM usuario WHERE email = \"".$email."\" AND password = \"".$pass."\"";

    try{
        $db = new db();
        $db = $db->conexionDB();
        $result = $db->query($sql);

        if( $result->rowCount() > 0 ){
            $usuario = $result->fetchAll(PDO::FETCH_OBJ);
            $time = time();
            $token = array(
                'iat' => $time,
                'exp' => $time + (24*60*60)//(horas,segundos,milisegundos)
            );

            $jwt = JWT::encode($token, key_secret ,'HS512');

            $token = array(
              'token'=> $jwt
            );

            echo json_encode($token);
        }else{
            echo json_encode("Rectifica tus datos.");
        }
        //$db->closeCursor();
        $db = null;
        $result = null;

    }catch(PDOException $e){
        echo '{"error" : { "sql": "'.$sql.'","text": "'.$e->getMessage().'"}';
    }

});