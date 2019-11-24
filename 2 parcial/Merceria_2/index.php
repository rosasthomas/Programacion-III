<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './clases/media.php';
require_once './clases/usuario.php';
require_once './clases/MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/', \Media::class . ':CargarUno');
$app->get('/medias[/]', \Media::class . ':TraerTodos');

$app->post('/usuarios[/]', \Usuario::class . ':CargarUno');
$app->get('/', \Usuario::class . ':TraerTodos');

$app->group('/login', function(){
    $this->post('[/]', \Usuario::class . ':GenerarJWTCorreoYClave')->add(\MW::class . ':VerificarSeteo')->add(\MW::class . '::VerificarVacio')->add(\MW::class . ':VerificarBD');
    $this->get('[/]', \Usuario::class . '::VerificarToken');
});

$app->delete('/', \Media::class . ':BorrarUno')->add(\MW::class . ':VerificarValidez')->add(\MW::class . '::VerificarPropietario');
$app->put('/', \Media::class . ':ModificarUno')->add(\MW::class . ':VerificarValidez')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarEncargado');

$app->group('/listado', function(){
    $this->get('[/]', \Media::class . ':TraerTodasLasMedias("SELECT color,marca,precio,talle FROM medias")')->add(\MW::class . ':VerificarEncargado');
    $this->get('/colores[/]', function($request, $response){
        $medias = Media::TraerTodasLasMedias('SELECT color FROM medias');
        $coloresTemp = array();
        foreach ($medias as $media) {
            array_push($coloresTemp, $media->color);
        }
        $colores = array_unique($coloresTemp);
        $cantidad = sizeof($colores);
        $newResponse = $response->withJson($cantidad, 200);  
        return $newResponse;
    })->add(\MW::class . ':VerificarEncargado');
    $this->get('/id[/{dato}]', function($request, $response, $args){
        $id = isset($args['dato']);
        if($id != null){
            $listado = Media::TraerTodasLasMedias("SELECT * FROM medias WHERE id=$id");
        }
        else{
            $listado = Media::TraerTodasLasMedias();
        }
        $newResponse = $response->withJson($listado, 200);
        return $newResponse;
    })->add(\MW::class . ':VerificarPropietario');
});

$app->run();