<?php
    class Producto{
        public $id;
        public $nombre;
        public $precio;

        public function InsertarProducto(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO productos (nombre,precio) VALUES (:nombre,:precio)");
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio',  $this->precio, PDO::PARAM_INT);

            return $consulta->execute();
        }
        public static function TraerTodosLosProductos($query = "SELECT * FROM productos"){
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta($query);
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");		
        }
        public function ModificarProducto(){

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE productos SET nombre=:nombre, precio=:precio WHERE id=:id");
            $consulta->bindValue(':id',     $this->id, PDO::PARAM_INT);		
            $consulta->bindValue(':nombre',  $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->execute();
			return $consulta->rowCount();
	    }
        public function BorrarProducto(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM productos WHERE id=:id");	
			$consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
			$consulta->execute();
			return $consulta->rowCount();
        }

        #region api
        public function CargarUno($request, $response, $args){
            $objDelaRespuesta= new stdclass();
        
            $ArrayDeParametros = $request->getParsedBody();
            $nombre= $ArrayDeParametros['nombre'];
            $precio= $ArrayDeParametros['precio'];

            $prod = new Producto();
            $prod->nombre=$nombre;
            $prod->precio=$precio;

            if($prod->InsertarProducto()){
                $objDelaRespuesta->respuesta="Se guardo el producto.";   
            }  
            else{
                $objDelaRespuesta->respuesta="Se no guardo el producto.";   
            }

            return $response->withJson($objDelaRespuesta, 200);
        }

        public function TraerTodos($request, $response, $args) {
            $listado = Producto::TraerTodosLosProductos();
            $newresponse = $response->withJson($listado, 200);  
            return $newresponse;
        }

        public function ModificarUno($request, $response, $args) {
            $datos = $request->getParsedBody();
            $prod= new Producto();
            $prod->id=$datos['id'];
            $prod->nombre= isset($datos['nombre']) ? $datos['nombre'] : null;
            $prod->precio= isset($datos['precio']) ? $datos['precio'] : null;

            $rowCount=$prod->ModificarProducto();
            if($rowCount>0){
                $newResponse = $response->withJson('Se pudo modificar', 200);  
            }
            else{
                $newResponse = $response->withJson('No se pudo modificar', 409);  
            }
      
            return $newResponse;	
        }

        public function BorrarUno($request, $response, $args) {
            $datos = $request->getParsedBody();
            $prod= new Producto();
            $prod->id=$datos['id'];
            $cantidadDeBorrados=$prod->BorrarProducto();
            if($cantidadDeBorrados>0){
                $newResponse = $response->withJson('Se pudo borrar', 200);  
            }
            else{
                $newResponse = $response->withJson('No se pudo borrar', 409);  
            }           
      
            return $newResponse;
        }

        #endregion

    }