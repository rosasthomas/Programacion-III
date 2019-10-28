<?php
require_once './clases/usuarioTxt.php';
    class VerificadoraTxt{
        public function VerificarVerbo($request, $response, $next){
            if($request->isGet()){
                $response->getBody()->write("Es por get </br>");
                $next($request, $response);
            }
            else if($request->isPost()){
                $datos = $request->getParsedBody();
                $usuario = new UsuarioTxt($datos['nombre'],$datos['tipo'],$datos['clave']);
                if($usuario->tipo == 'administrador'){
                    if(VerificadoraTxt::ExisteUsuario($usuario)){
                        $next($request, $response);
                    }
                }
                else{
                    $response->getBody()->write("No tiene permisos </br>");
                }
        
            }
            else{
                $response->getBody()->write("Es por otro </br>");
            }

            return $response;
        }

        public static function ExisteUsuario($obj){
            $listado = UsuarioTxt::Leer();
            $flag = false;

            foreach ($listado as $usuario) {
                if($usuario->nombre == $obj->nombre && $usuario->clave == $obj->clave){
                    $flag = true;
                    break;
                }
            }
            return $flag;
        }

        
    }