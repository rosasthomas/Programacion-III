<?php
    class MW{
        public function VerificarSeteo($request, $response, $next){
            $datos = $request->getParsedBody();
            $correo = isset($datos['correo']);
            $clave = isset($datos['clave']);
            if($correo == null && $clave == null){
                $retorno = $response->withJson('El correo y la clave no estan seteados', 409);
            }
            else if($correo == null){
                $retorno = $response->withJson('El correo no esta seteado', 409);
            }
            else if($clave == null){
                $retorno = $response->withJson('La clave no esta seteada', 409);
            }
            else{
                $retorno = $next($request, $response);
            }

            return $retorno;
        }   

        public static function VerificarVacio($request, $response, $next){
            $datos = $request->getParsedBody();
            $correo = $datos['correo'];
            $clave = $datos['clave'];
            if(empty($correo) && empty($clave)){
                $retorno = $response->withJson('El correo y la clave estan vacios', 409);
            }
            else if(empty($correo)){
                $retorno = $response->withJson('El correo esta vacio', 409);
            }
            else if(empty($clave)){
                $retorno = $response->withJson('La clave esta vacia', 409);
            }
            else{
                $retorno = $next($request, $response);
            }

            return $retorno;
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

        public function VerificarValidez($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];	
                    
            try {
                AutentificadorJWT::VerificarToken($token);
                $newresponse = $next($request, $response);
            } 
            catch (Exception $e) {
                $newresponse = $response->withJson('El token no es valido', 409);           
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