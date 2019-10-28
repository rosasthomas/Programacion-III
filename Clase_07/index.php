<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once './vendor/autoload.php';
require_once './clases/verificadoraTxt.php';
require_once './clases/verificadora.php';
require_once './clases/usuario.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);



$app->put('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("PUT => Bienvenido!!! a SlimFramework");
    return $response;

});
$app->delete('[/]', function (Request $request, Response $response) {    
    $response->getBody()->write("DELETE => Bienvenido!!! a SlimFramework");
    return $response;

});

/*$uno = function(Request $request, Response $response, $next){
    $response->getBody()->write
};*/


$app->group('/credenciales/',function(){
    $this->get('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("GET grupo => Bienvenido!!! a SlimFramework");
        return $response;
    
    });
    
    $this->post('[/]', function (Request $request, Response $response) {   
        $datos = $request->getParsedBody(); 
        $nombre = $datos['nombre'];
        $response->getBody()->write("El nombre es $nombre </br>");
        
        return $response;
    
    });
})->add(function(Request $request, Response $response, $next){
    if($request->isGet()){
        $response->getBody()->write("Es por get </br>");
        $next($request, $response);
    }
    else if($request->isPost()){
        $datos = $request->getParsedBody();
        $tipo = $datos['tipo'];
        if($tipo == 'administrador'){
            $next($request, $response);
        }
        else{
            $response->getBody()->write("No tiene permisos </br>");
        }

    }
    else{
        $response->getBody()->write("Es por otro </br>");
    }
    
    return $response;
});

$app->group('/credenciales/poo/', function(){
    $this->get('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("GET grupo => Bienvenido!!! a SlimFramework");
        return $response;
    
    });
    
    $this->post('[/]', function (Request $request, Response $response) {   
        $datos = $request->getParsedBody(); 
        $nombre = $datos['nombre'];
        $response->getBody()->write("El nombre es $nombre </br>");
        
        return $response;
    
    });
})->add(\VerificadoraTxt::class . ':VerificarVerbo');


$app->group('/credenciales/bd/', function(){
    $this->post('[/]', \Usuario::class . ':AgregarUno')->add(\verificadora::class . ':VerificarVerbo');
    $this->get('[/]', function (Request $request, Response $response) {    
        $response->getBody()->write("GET grupo => Bienvenido!!! a SlimFramework");
        return $response;
    
    });

});



$app->run();