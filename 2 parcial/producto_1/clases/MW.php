<?php
    class MW{
        public function VerificarLogueo($request, $response, $next){
            if(MW::VerificarValidez($request,$response)){
                $arrayConToken = $request->getHeader('token');
                $token=$arrayConToken[0];    
                $datos = AutentificadorJWT::ObtenerData($token);
                if($datos[0]->perfil == 'admin'){
                    $newresponse = $next($request, $response);
                }
                else if($request->isGet() && $datos[0]->perfil == 'user'){
                    $newresponse = $next($request, $response);
                }
                else{
                    $newresponse = $response->withJson('No tiene acceso', 409);
                }
            }
            else{
                $newresponse = $response->withJson('No esta logueado', 409);     
            }

            return $newresponse;
        }

        public function VerificarBD($request, $response, $next){
            $datos = $request->getParsedBody();
            $correo = $datos['correo'];
            $clave = $datos['clave'];
            $listado = Usuario::TraerTodosLosUsuarios();
            $flag = false;
            foreach($listado as $usuario){
                if($usuario->correo == $correo && $usuario->clave == $clave){
                    $flag = true;
                    break;
                }
            }

            if(!$flag){
                $retorno = $next($request, $response);
            }
            else{
                $retorno = $response->withJson('Ya existe en la base de datos', 409);           
            }

            return $retorno;
        }

        public function VerificarValidez($request, $response){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];	
                    
            try {
                AutentificadorJWT::VerificarToken($token);
                $newresponse = true;
            } 
            catch (Exception $e) {
                $newresponse = false;           
            }

            return $newresponse;
        }

        public static function VerificarPropietario($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos->perfil == 'propietario'){
                $newresponse = $next($request, $response);
            }
            else{
                $newresponse = $response->withJson('No es propietario', 409);
            }

            return $newresponse;
        }

        public function VerificarEncargado($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos->perfil == 'encargado'){
                $newresponse = $next($request, $response);
            }
            else{
                $newresponse = $response->withJson('No es encargado', 409);
            }

            return $newresponse;
        }

        public function MostrarEncargado($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos->perfil == 'encargado'){
                $listado = Media::TraerTodasLasMedias("SELECT color,marca,precio,talle FROM medias");
                $newresponse = $response->withJson($listado, 200);
            }
            else{
                $listado = Media::TraerTodasLasMedias();
                $newresponse = $response->withJson($listado, 200);
            }

            return $newresponse;
        }

        //public static function MostrarColores


    }