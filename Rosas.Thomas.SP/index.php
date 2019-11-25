<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

require_once './vendor/autoload.php';
require_once './clases/usuario.php';
require_once './clases/auto.php';
require_once './clases/MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;
$app = new \Slim\App(["settings" => $config]);

$app->post('/usuarios[/]', \Usuario::class . ':CargarUno');
$app->get('/', \Usuario::class . ':Listado');    

$app->post('/', \Auto::class . ':CargarUno');
$app->get('/autos[/]', \Auto::class . ':Listado');    
$app->group('/login', function(){
    $this->post('/', \Usuario::class . ':GenerarJWTCorreoYClave');
    $this->get('/', \Usuario::class . ':VerificarToken');
});

$app->delete('/', \Auto::class . ':BorrarUno')->add(\MW::class . ':TokenValido')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarEncargado');
$app->put('/', \Auto::class . ':ModificarUno')->add(\MW::class . ':TokenValido')->add(\MW::class . '::VerificarPropietario')->add(\MW::class . ':VerificarEncargado');



$app->run();