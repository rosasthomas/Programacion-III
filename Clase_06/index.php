<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
�La primera l�nea es la m�s importante! A su vez en el modo de 
desarrollo para obtener informaci�n sobre los errores
 (sin �l, Slim por lo menos registrar los errores por lo que si est� utilizando
  el construido en PHP webserver, entonces usted ver� en la salida de la consola 
  que es �til).

  La segunda l�nea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera m�s predecible.
*/

$app = new \Slim\App(["settings" => $config]);


$app->get('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("GET => Bienvenido!!! a SlimFramework");
    return $response;

});

/*
COMPLETAR POST, PUT Y DELETE
*/
$app->post('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("POST => Bienvenido!!! a SlimFramework");
    return $response;

});
$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});
$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;

});

$app->get('/parametros/{nombre}[/{apellido}]', function (Request $request, Response $response, $args) {    
    $txt = isset($args['apellido']) ? "GET => El nombre es ".$args['nombre'].", ".$args['apellido']:"GET => El nombre es ".$args['nombre'];
    $response->getBody()->write($txt);
    return $response;

});

$app->group('/json/',function(){
    $this->post('', function (Request $request, Response $response) {   
        $nombre = $request->getParsedBody();

        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";
        $nombreAnterior=$archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior)  ;
        $extension=array_reverse($extension);
        $archivos['foto']->moveTo($destino.date('d-m-y').".".$extension[0]);

        var_dump($nombre);
        return $response;
    });

    $this->get('{nombre}/{apellido}', function (Request $request, Response $response, $args) {   
        $retorno = $response->WithJson($args, 200);
        return $retorno;
    });

    $this->delete('', function (Request $request, Response $response) {   
        $array = $request->getParsedBody();
        $json = json_decode($array['json']);

        $nombre = $json->nombre;
        $json->nombre = $json->apellido;
        $json->apellido = $nombre;
        $retorno = $response->withJson($json,200);
        return $retorno;
    });
});




$app->run();