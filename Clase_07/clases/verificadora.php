<?php
require_once './clases/usuario.php';
    class verificadora{
        public static function VerificarVerbo($request, $response, $next){
            if($request->isPost()){
            $datos = $request->getParsedBody();
                if($datos['tipo'] == 'administrador'){                  
                    $next($request, $response);
                    $response->getBody()->write("Se agrego </br>");

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
    }