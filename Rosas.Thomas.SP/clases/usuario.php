<?php
    require_once './clases/AccesoDatos.php';
    require_once './clases/AutentificadorJWT.php';
    class Usuario{
        public $correo;
        public $clave;
        public $nombre;
        public $apellido;
        public $perfil;
        public $foto;

        public static function SubirFoto($request){
            $archivos = $request->getUploadedFiles();
            $destino="./fotos/";
            $nombreAnterior=$archivos['foto']->getClientFilename();
            $extension= explode(".", $nombreAnterior)  ;
            $extension=array_reverse($extension);
            $path = $destino.date('h-m-s').".".$extension[0];
            $archivos['foto']->moveTo($path);

            return $path;
        }

        #region consultas
            public function InsertarUsuario(){
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (correo,clave,nombre,apellido,perfil,foto) VALUES (:correo,:clave,:nombre,:apellido,:perfil,:foto)");
                $consulta->bindValue(':correo',  $this->correo, PDO::PARAM_STR);
                $consulta->bindValue(':clave',  $this->clave, PDO::PARAM_STR);
                $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':apellido',  $this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(':perfil',  $this->perfil, PDO::PARAM_STR);
                $consulta->bindValue(':apellido',  $this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(':foto', $this->foto);

                return $consulta->execute();
            }
            public static function TraerTodosLosUsuarios(){
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");
                $consulta->execute();			
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
            }
            public static function TraerUnUsuario($consulta = "SELECT * FROM usuarios"){
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta($consulta);
                $consulta->execute();			
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
            }
        #endregion

        #region api
            public function CargarUno($request, $response, $args){
                $objDelaRespuesta= new stdclass();
            
                $ArrayDeParametros = $request->getParsedBody();
                $datos = json_decode($ArrayDeParametros['json']);
               /* $nombre= $ArrayDeParametros['nombre'];
                $apellido= $ArrayDeParametros['apellido'];
                $correo= $ArrayDeParametros['correo'];
                $clave= $ArrayDeParametros['clave'];
                $perfil= $ArrayDeParametros['perfil'];*/

                $usu = new Usuario();
                $path = Usuario::SubirFoto($request);
                $usu->nombre=$datos->nombre;
                $usu->apellido=$datos->apellido;
                $usu->correo=$datos->correo;
                $usu->clave=$datos->clave;
                $usu->perfil=$datos->perfil;
                $usu->foto=$path;

                if($usu->InsertarUsuario()){
                    $objDelaRespuesta->exito = true;
                    $objDelaRespuesta->mensaje="Se guardo el usuario.";   
                    $newResponse = $response->withJson($objDelaRespuesta, 200);
                }  
                else{
                    $objDelaRespuesta->exito = false;
                    $objDelaRespuesta->mensaje="Se no guardo el usuario.";   
                    $newResponse = $response->withJson($objDelaRespuesta, 418);
                }

                return $newResponse;
            }
            public function Listado($request, $response, $args){
                $retorno = new stdClass();
                $listado = Usuario::TraerTodosLosUsuarios();
                $tabla = '';
                $tabla.= "<table border=1> <thead> <tr>";
                $tabla.= "<td>Nombre <td>Apellido <td>Correo <td>Perfil <td>Foto";
                //$tabla.= "</tr> </thead>";
                foreach($listado as $usu){
                    $tabla.= "<tr><td> $usu->nombre ";
                    $tabla.= "<td> $usu->apellido";
                    $tabla.= "<td> $usu->correo ";
                    $tabla.= "<td> $usu->perfil";
                    $tabla.="<td>";
                    $tabla.="<img src='" . $usu->foto . "' height=60 width=60>";
                    //$tabla.="</td></tr>";
                }
                //$tabla.="</table>";
                if($tabla != null){
                    $retorno->exito = true;
                    $retorno->mensaje = 'Se cargo el listado';
                    $retorno->tabla = $tabla;
                    $newResponse = $response->withJson($retorno, 200);
                    
                }
                else{
                    $retorno->exito = false;
                    $retorno->mensaje = 'No se cargo el listado';
                    $response->withJson($retorno, 424);
                }
                
                
                return $newResponse;
            } 
            public function GenerarJWTCorreoYClave($request, $response, $args){
                $datos =$objDelaRespuesta= new stdclass();
            
                $ArrayDeParametros = $request->getParsedBody();
                $datos= json_decode($ArrayDeParametros['json']);

                $usu = Usuario::TraerUnUsuario("SELECT * FROM usuarios WHERE correo='$datos->correo' AND clave='$datos->clave'");
                
                if($usu != null){
                    $token = AutentificadorJWT::CrearToken($usu);
                    $objDelaRespuesta->exito = true;
                    $objDelaRespuesta->jwt = $token;
                    $newresponse = $response->withJson($objDelaRespuesta, 200);  
                }
                else{
                    $objDelaRespuesta->exito = false;
                    $objDelaRespuesta->jwt = null;
                    $newresponse = $response->withJson($objDelaRespuesta, 403);  
                }
                
                return $newresponse;
            }
            public function VerificarToken($request, $response, $args){
                $arrayConToken = $request->getHeader('token');
                $token=$arrayConToken[0];	
                        
                try {
                    AutentificadorJWT::VerificarToken($token);
                    $newresponse = $response->withJson("El token es valido", 200);  
                } 
                catch (Exception $e) {
                    $newresponse = $response->withJson("El token no es valido: ".$e->getMessage(), 403);           
                }
    
                return $newresponse;
            }
        #endregion


    }