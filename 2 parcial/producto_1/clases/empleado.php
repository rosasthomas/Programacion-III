<?php
    require_once './clases/AccesoDatos.php';
    class Empleado{
        public $id;
        public $nombre;
        public $apellido;
        public $email;
        public $foto;
        public $legajo;
        public $clave;
        public $perfil;

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
        public function InsertarEmpleado(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO empleados (nombre,apellido,email,foto,legajo,clave,perfil) VALUES (:nombre,:apellido,:email,:foto,:legajo,:clave,:perfil)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido',  $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':email',  $this->email, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->foto);
            $consulta->bindValue(':clave',  $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':perfil',  $this->perfil, PDO::PARAM_STR);
            $consulta->bindValue(':legajo',  $this->legajo, PDO::PARAM_INT);

            return $consulta->execute();
        }

        public static function TraerTodosLosEmpleados($query = "SELECT * FROM empleados"){
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta($query);
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Empleado");		
        }
        #endregion

        #region api
        public function CargarUno($request, $response, $args){
            $objDelaRespuesta= new stdclass();
        
            $ArrayDeParametros = $request->getParsedBody();
            $nombre= $ArrayDeParametros['nombre'];
            $apellido= $ArrayDeParametros['apellido'];
            $email= $ArrayDeParametros['email'];
            $clave= $ArrayDeParametros['clave'];
            $perfil= $ArrayDeParametros['perfil'];
            $legajo= $ArrayDeParametros['legajo'];


            $usu = new Empleado();
            $path = Empleado::SubirFoto($request);
            $usu->nombre=$nombre;
            $usu->apellido=$apellido;
            $usu->email=$email;
            $usu->clave=$clave;
            $usu->perfil=$perfil;
            $usu->foto=$path;
            $usu->legajo=$legajo;

            if($usu->InsertarEmpleado()){
                $objDelaRespuesta->respuesta="Se guardo el empleado.";   
            }  
            else{
                $objDelaRespuesta->respuesta="Se no guardo el empleado.";   
            }

            return $response->withJson($objDelaRespuesta, 200);
        }

        public function TraerTodos($request, $response, $args) {
            $listado = Empleado::TraerTodosLosEmpleados();
            $newresponse = $response->withJson($listado, 200);  
            return $newresponse;
        }

        public function Verificar($request, $response, $args){
            $ArrayDeParametros = $request->getParsedBody();
            $email= $ArrayDeParametros['email'];
            $clave= $ArrayDeParametros['clave'];

            $empleado = Empleado::TraerTodosLosEmpleados("SELECT * FROM empleados WHERE email='$email' AND clave='$clave'");

            $retorno = new stdClass();
            $retorno->valido = false;
           
            if(!is_null($empleado)){
                $retorno->valido = true;
                $retorno->usuario = $empleado;
            }

            return $response->withJson($retorno, 200);
        }

        public function VerificarJWT($request, $response, $args){
            $ArrayDeParametros = $request->getParsedBody();
            $email= $ArrayDeParametros['email'];
            $clave= $ArrayDeParametros['clave'];

            $empleado = Empleado::TraerTodosLosEmpleados("SELECT * FROM empleados WHERE email='$email' AND clave='$clave'");
            if(!is_null($empleado)){
                $JWT = AutentificadorJWT::CrearToken($empleado);
            }
            else{
                $JWT = 'Los datos no coinciden'; 
            }
           
            return $response->withJson($JWT, 200);
        }
        #endregion
    }