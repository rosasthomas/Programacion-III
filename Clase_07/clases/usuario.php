<?php
require_once "AccesoDatos.php";
    class Usuario
    {
        public $id;
        public $nombre;
        public $apellido;
        public $perfil;
        public $estado;
        public $correo;
        public $foto;
        private $clave;

        public static function SubirFoto($request)
        {
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
        
        public function Validar($id, $clave){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios WHERE id= $id AND clave= '$clave' ");
            $consulta->execute();
            $json = new StdClass();
            $json->existe = false;
            if($consulta->rowCount() > 0){  
                $json->existe = true;
                $user = $consulta->fetchAll(PDO::FETCH_OBJ);
                $json->user = $user;
            }
            return $json;
        }

        public function MostrarDatos()
        {
            return $this->id." - ".$this->nombre." - ".$this->apellido." - ".$this->perfil." - ".$this->estado." - ".$this->correo;
        }
        
        public static function TraerUnUsuario($id) 
	    {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT id,nombre,apellido,clave,perfil,estado,correo,foto FROM usuarios WHERE id = $id");
			$consulta->execute();
			$usu= $consulta->fetchObject('Usuario');
			return $usu;				

        }
        public static function TraerTodosLosUsuarios()
        {    
            
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT id,nombre,apellido,clave,perfil,estado,correo,foto FROM usuarios");        
            
            $consulta->execute();
            
            $retorno = $consulta->fetchAll(PDO::FETCH_OBJ); 
            return $retorno; 
        }
        
        public function InsertarElUsuario()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre,apellido,clave,perfil,estado,correo,foto) 
                    VALUES(:nombre, :apellido, :clave, :perfil, :estado, :correo, :foto)");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_INT);
            $consulta->bindValue(':estado', 1, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->foto);

            $consulta->execute();

            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        }
        
        public function ModificarUsuario()
        {
    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, clave=:clave, 
            perfil=:perfil, estado=:estado, correo=:correo, foto=:foto WHERE id=:id");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->foto);

            return $consulta->execute();
    
        }
    
        public function EliminarUsuario()
        {
    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
            
            $consulta->bindValue(':id', $this->id, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->rowCount();
    
        }

        #endregion
        
        #region Metodos REST

        public function TraerUno($request, $response, $args) {
            $id=$args['id'];
            $usu=Usuario::TraerUnUsuario($id);
            $newResponse = $response->withJson($usu, 200);  
           return $newResponse;
        }

        public function TraerTodos($request, $response, $args) {
            $lista=Usuario::TraerTodosLosUsuarios();
            $newResponse = $response->withJson($lista, 200);  
            return $newResponse;
        }

        public function BorrarUno($request, $response, $args) {
            $ArrayDeParametros = $request->getParsedBody();
            $id=$ArrayDeParametros['id'];
            $usu= new Usuario();
            $usu->id=$id;
            $cantidadDeBorrados=$usu->EliminarUsuario();
   
            $objDelaRespuesta= new stdclass();
            $objDelaRespuesta->cantidad=$cantidadDeBorrados;
            if($cantidadDeBorrados>0)
            {
                $objDelaRespuesta->resultado="algo borro!!!";
            }
            else
            {
                $objDelaRespuesta->resultado="no Borro nada!!!";
            }
            $newResponse = $response->withJson($objDelaRespuesta, 200);  
            return $newResponse;
       }

     public function ModificarUno($request, $response, $args) {
		$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);    	
        $usu = new Usuario();
        $path = Usuario::SubirFoto($request);

	    $usu->id=$ArrayDeParametros['id'];
	    $usu->nombre=$ArrayDeParametros['nombre'];
	    $usu->apellido=$ArrayDeParametros['apellido'];
	    $usu->estado=$ArrayDeParametros['estado'];
        $usu->perfil=$ArrayDeParametros['perfil'];
        $usu->correo=$ArrayDeParametros['correo'];
        $usu->clave=$ArrayDeParametros['clave'];
	    $usu->foto=$path;

	   	$resultado =$usu->ModificarUsuario();
	   	$objDelaRespuesta= new stdclass();
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }

    public function AgregarUno($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();
        $usu = new Usuario();
        $path = Usuario::SubirFoto($request);

	    $usu->nombre=$ArrayDeParametros['nombre'];
	    $usu->apellido=$ArrayDeParametros['apellido'];
        $usu->perfil=$ArrayDeParametros['perfil'];
        $usu->correo=$ArrayDeParametros['correo'];
        $usu->clave=$ArrayDeParametros['clave'];
        $usu->foto=$path;
        
        $usu->InsertarElUsuario();
        return $response->withJson($usu, 200);
    }
        #endregion
    }
