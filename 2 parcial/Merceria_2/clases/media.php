<?php
    require_once './clases/AccesoDatos.php';
    class Media{

        public $color;
        public $marca;
        public $precio;
        public $talle;

        #region Consultas 
        public function InsertarMedia(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO medias (color, marca, precio, talle) VALUES(:color, :marca, :precio, :talle)");
            $consulta->bindValue(':color',  $this->color, PDO::PARAM_STR);
            $consulta->bindValue(':marca',  $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':talle',  $this->talle, PDO::PARAM_STR);
            return $consulta->execute();
        }

        public static function TraerTodasLasMedias($query = "SELECT * FROM medias"){
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta($query);
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Media");		
        }
        
        public function BorrarMedia(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM medias WHERE id=:id");	
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
			$consulta->execute();
			return $consulta->rowCount();
        }

        public function ModificarMedia(){

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE medias SET color=:color, marca=:marca, precio=:precio, talle=:talle WHERE id=:id");
            $consulta->bindValue(':id',     $this->id, PDO::PARAM_INT);		
            $consulta->bindValue(':color',  $this->color, PDO::PARAM_STR);
            $consulta->bindValue(':marca',  $this->marca, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':talle',  $this->talle, PDO::PARAM_STR);
            $consulta->execute();
			return $consulta->rowCount();
	    }
        #endregion

        #region api
        public function CargarUno($request, $response, $args) {
     	
            $objDelaRespuesta= new stdclass();
            
            $ArrayDeParametros = $request->getParsedBody();
            $color= $ArrayDeParametros['color'];
            $marca= $ArrayDeParametros['marca'];
            $precio= $ArrayDeParametros['precio'];
            $talle= $ArrayDeParametros['talle'];
            
            $media = new Media();
            $media->color=$color;
            $media->marca=$marca;
            $media->precio=$precio;
            $media->talle=$talle;

            if($media->InsertarMedia()){
                $objDelaRespuesta->respuesta="Se guardo la media.";   
            }
            else{
                $objDelaRespuesta->respuesta="Se no guardo la media.";   
            }
           
            return $response->withJson($objDelaRespuesta, 200);
        }

        public function TraerTodos($request, $response, $args) {
            $listado = Media::TraerTodasLasMedias();
            $newresponse = $response->withJson($listado, 200);  
            return $newresponse;
        }

        public function BorrarUno($request, $response, $args) {
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos->perfil == 'propietario'){
                $media= new Media();
                $media->id=$datos->id;
                $cantidadDeBorrados=$media->BorrarMedia();
                if($cantidadDeBorrados>0){
                    $newResponse = $response->withJson('Se pudo borrar', 200);  
                }
                else{
                    $newResponse = $response->withJson('No se pudo borrar', 409);  
                }
            }
            else{
                $newResponse = $response->withJson('No es propietario', 409);  
            }
      
            return $newResponse;
        }

        public function ModificarUno($request, $response, $args) {
            $arrayConToken = $request->getHeader('token');
            $token=$arrayConToken[0];
            $datos = AutentificadorJWT::ObtenerData($token);
            if($datos->perfil == 'propietario' || $datos->perfil == 'encargado'){
                $media= new Media();
                $media->id=$datos->id;
                $media->color=$datos->color;
                $media->marca=$datos->marca;
                $media->precio=$datos->precio;
                $media->talle=$datos->talle;

                $rowCount=$media->ModificarMedia();
                if($rowCount>0){
                    $newResponse = $response->withJson('Se pudo modificar', 200);  
                }
                else{
                    $newResponse = $response->withJson('No se pudo modificar', 409);  
                }
            }
            else{
                $newResponse = $response->withJson('No es propietario ni encargado', 409);  
            }
      
            return $newResponse;	
        }
        #endregion
    }