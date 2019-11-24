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
            $path = $destino.date('d-m-y').".".$extension[0];
            $archivos['foto']->moveTo($path);

            return $path;
        }

        #region Consultas
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
        #endregion

        #region Api
        public function CargarUno($request, $response, $args){
            $objDelaRespuesta= new stdclass();
        
            $ArrayDeParametros = $request->getParsedBody();
            $nombre= $ArrayDeParametros['nombre'];
            $apellido= $ArrayDeParametros['apellido'];
            $correo= $ArrayDeParametros['correo'];
            $clave= $ArrayDeParametros['clave'];
            $perfil= $ArrayDeParametros['perfil'];

            $usu = new Usuario();
            $path = Usuario::SubirFoto($request);
            $usu->nombre=$nombre;
            $usu->apellido=$apellido;
            $usu->correo=$correo;
            $usu->clave=$clave;
            $usu->perfil=$perfil;
            $usu->foto=$path;

            if($usu->InsertarUsuario()){
                $objDelaRespuesta->respuesta="Se guardo el usuario.";   
            }  
            else{
                $objDelaRespuesta->respuesta="Se no guardo el usuario.";   
            }

            return $response->withJson($objDelaRespuesta, 200);
        }

        public function TraerTodos($request, $response, $args) {
            $listado = Usuario::TraerTodosLosUsuarios();
            $newresponse = $response->withJson($listado, 200);  
            return $newresponse;
        }
        #endregion

        public function GenerarJWTCorreoYClave($request, $response, $args){
            $datos =$objDelaRespuesta= new stdclass();
        
            $ArrayDeParametros = $request->getParsedBody();
            /*$datos->correo= $ArrayDeParametros['correo'];
            $datos->clave= $ArrayDeParametros['clave'];*/

            $token = AutentificadorJWT::CrearToken($ArrayDeParametros);

            $newresponse = $response->withJson($token, 200);  
            return $newresponse;
        }

        public static function VerificarToken($request, $response, $args){
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];	
                    
            try {
                AutentificadorJWT::VerificarToken($token);
                $newresponse = $response->withJson("El token es valido", 200);  
            } 
            catch (Exception $e) {
                $newresponse = $response->withJson($e->getMessage(), 409);           
            }

            return $newresponse;
        }

        public function Listado($request, $response, $args){
            $listado = Usuario::TraerTodosLosUsuarios();
            $tabla = '';
            $tabla.= "<table border=1> <thead> <tr>";
            $tabla.= "<td>Nombre</td> <td>Apellido</td> <td>Correo</td> <td>Perfil</td> <td>Foto</td>";
            $tabla.= "</tr> </thead>";
            foreach($listado as $usu){
                $tabla.= "<tr><td> $usu->nombre  </td>";
                $tabla.= "<td> $usu->apellido </td>";
                $tabla.= "<td> $usu->correo </td>";
                $tabla.= "<td> $usu->perfil</td>";
                $tabla.="<td>";
                $tabla.="<img src='./fotos/" . $usu->foto . "' height=60 width=60>";
                $tabla.="</td></tr>";
            }
            $tabla.="</table>";


            return $tabla;
        }      
    }