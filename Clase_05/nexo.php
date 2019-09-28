<?php
include_once ("AccesoDatos.php");
include_once ("usuario.php");
var_dump($_POST['op']);
    switch ($_POST['op']) {
        case 'existe':
            $usuario = json_decode($_POST["usuario"]);
            $retorno = new stdClass();
            $retorno->existe=Usuario::TraerPorCorreoYClave($usuario->correo, $usuario->clave);
            echo json_encode($retorno);
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
        default:
            echo ":c";
        break;
    };