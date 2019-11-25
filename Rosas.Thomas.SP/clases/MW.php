<?php
    class MW{
        public function TokenValido($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];	
            $flag = false;
            try {
                AutentificadorJWT::VerificarToken($token);
                $flag = true;
            } 
            catch (Exception $e) {
                $newresponse = $response->withJson("El token no es valido: ".$e->getMessage(), 403);           
            }

            if($flag){
                $newresponse = $next($request, $response);
            }
            return $newresponse;
        }

        public static function VerificarPropietario($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos[0]->perfil == 'propietario' ){
                $newresponse = $next($request, $response);
            }
            else{
                $newresponse = $response->withJson('No es encargado ni propietario', 409);
            }

            return $newresponse;
        }

        public function VerificarEncargado($request, $response, $next){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos[0]->perfil == 'propietario' || $datos[0]->perfil == 'encargado'){
                $newresponse = $next($request, $response);
            }
            else{
                $newresponse = $response->withJson('No es encargado ni propietario', 409);
            }

            return $newresponse;
        }
    }