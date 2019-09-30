<?php
include_once ("AccesoDatos.php");
include_once ("usuario.php");
var_dump($_POST['op']);
    switch ($_POST['op']) {
        case 'existe':
            $usuario = json_decode($_POST["usuario"]);
            $retorno = new stdClass();
            $retorno=Usuario::TraerPorCorreoYClave($usuario->correo, $usuario->clave);
            var_dump($retorno);
            //echo json_encode($retorno);
        break;    
        case 'insertar':
            $aux = json_decode($_POST['usuario']);
            $usuario = new Usuario($aux);
            if($usuario->InsertarElUsuario()){
                echo "Se agrego";
            }
            else{
                echo "No se agrego";
            }
        break;  
        case 'mostrar':
        $usuarios = Usuario::TraerTodosLosUsuario();
        var_dump($usuarios);
        default:
            echo ":c";
        break;
    };