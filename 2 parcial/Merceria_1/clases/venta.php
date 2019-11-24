<?php
    require_once './clases/AccesoDatos.php';
    class Venta{
        public function InsertarVenta($datos){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO ventas (id_usuario,id_media,cantidad) VALUES (:id_usuario,:id_media,:cantidad)");
            $consulta->bindValue(':id_usuario',  $datos->id_usuario, PDO::PARAM_INT);
            $consulta->bindValue(':id_media',  $datos->id_media, PDO::PARAM_INT);
            $consulta->bindValue(':cantidad', $datos->cantidad, PDO::PARAM_INT);

            return $consulta->execute();
        }

        public static function TraerTodosLasVentas(){
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM ventas");
			$consulta->execute();			
			return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");		
        }
        public function BorrarVenta($id_media, $id_usuario){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM ventas WHERE id_usuario=:id_usuario AND id_media=:id_media");	
            $consulta->bindValue(':id_usuario',$id_usuario, PDO::PARAM_INT);	
            $consulta->bindValue(':id_media',$id_media, PDO::PARAM_INT);			
			$consulta->execute();
			return $consulta->rowCount();
        }
        public function ModificarVenta($id, $cantidad){

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE ventas SET cantidad=:cantidad WHERE id=:id");
            $consulta->bindValue(':id',     $id, PDO::PARAM_INT);		
            $consulta->bindValue(':cantidad',  $cantidad, PDO::PARAM_STR);
            $consulta->execute();
			return $consulta->rowCount();
	    }

        public function Vender($request, $response, $args){
            $datos = $request->getParsedBody();
            $newresponse = new stdClass();
            $venta = new stdClass();
            $venta->id_usuario = $datos['id_usuario'];
            $venta->id_media = $datos['id_media'];
            $venta->cantidad = $datos['cantidad'];

            if(Venta::InsertarVenta($venta)){
                $newresponse = $response->withJson('Se pudo agregar', 200);
            }
            else{
                $newresponse = $response->withJson('No se pudo agregar', 504);
            }

            return $newresponse;
        }

        public function TraerTodos($request, $response, $args) {
            $listado = Venta::TraerTodosLasVentas();
            $newresponse = $response->withJson($listado, 200);  
            return $newresponse;
        }

        public function BorrarUno($request, $response, $args){
            $datos = $request->getParsedBody();
            $id_media = $datos['id_media'];
            $id_usuario = $datos['id_usuario'];
            $perfil = $datos['perfil'];
            if($perfil == 'empleado'){
                $cantidadDeBorrados= Venta::BorrarVenta($id_media, $id_usuario);
                if($cantidadDeBorrados>0){
                    $newResponse = $response->withJson('Se pudo borrar', 200);  
                }
                else{
                    $newResponse = $response->withJson('No se pudo borrar', 409);  
                }
            }
            else{
                $newResponse = $response->withJson('No es empleado', 409);  
            }
      
            return $newResponse;
        }

        public function ModificarUno($request, $response, $args) {
            $datos = $request->getParsedBody();
            $id = $datos['id'];
            $cant = $datos['cant'];
            $perfil = $datos['perfil'];
            
            if($perfil == 'empleado'){
                $rowCount= Venta::ModificarVenta($id, $cant);
                if($rowCount>0){
                    $newResponse = $response->withJson('Se pudo modificar', 200);  
                }
                else{
                    $newResponse = $response->withJson('No se pudo modificar', 409);  
                }
            }
            else{
                $newResponse = $response->withJson('No es empleado', 409);  
            }
      
            return $newResponse;	
        }
    }