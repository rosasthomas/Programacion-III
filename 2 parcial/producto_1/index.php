<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \Firebase\JWT\JWT;

//APACHE_REQUEST_HEADERS();

require_once './vendor/autoload.php';
require_once './clases/AccesoDatos.php';
require_once './clases/AutentificadorJWT.php';
require_once './clases/empleado.php';
require_once './clases/producto.php';
require_once './clases/MW.php';

$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $config]);

$app->post('/', \Empleado::class . ':CargarUno')->add(\MW::class . ':VerificarLogueo');
$app->post('/email/clave/', \Empleado::class . ':Verificar')->add(\MW::class . ':VerificarLogueo');
$app->get('/', \Empleado::class . ':TraerTodos')->add(\MW::class . ':VerificarLogueo');

$app->post('/productos/', \Producto::class . ':CargarUno')->add(\MW::class . ':VerificarLogueo');
$app->get('/productos/', \Producto::class . ':TraerTodos')->add(\MW::class . ':VerificarLogueo');
$app->put('/productos/', \Producto::class . ':ModificarUno')->add(\MW::class . ':VerificarLogueo');
$app->delete('/productos/', \Producto::class . ':BorrarUno')->add(\MW::class . ':VerificarLogueo');

$app->post('/login/', \Empleado::class . ':VerificarJWT');

$app->run();




























//
?>