<?php
    require_once './clases/AccesoDatos.php';
    class Auto{
        public $id;
        public $color;
        public $marca;
        public $precio;
        public $modelo;

         #region consultas
            public function InsertarAuto(){
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO autos (color,marca,precio,modelo) VALUES (:color,:marca,:precio,:modelo)");
                $consulta->bindValue(':color',  $this->color, PDO::PARAM_STR);
                $consulta->bindValue(':marca',  $this->marca, PDO::PARAM_STR);
                $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
                $consulta->bindValue(':modelo',  $this->modelo, PDO::PARAM_STR);

                return $consulta->execute();
            }
            public static function TraerTodosLosAutos(){
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("SELECT * FROM autos");
                $consulta->execute();			
                return $consulta->fetchAll(PDO::FETCH_CLASS, "Auto");		
            }
            public function BorrarAuto(){
                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM autos WHERE id=:id");	
                $consulta->bindValue(':id',$this->id, PDO::PARAM_INT);		
                $consulta->execute();
                return $consulta->rowCount();
            }
            public function ModificarAuto(){

                $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
                $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE autos SET color=:color, marca=:marca, precio=:precio, modelo=:modelo WHERE id=:id");
                $consulta->bindValue(':id',     $this->id, PDO::PARAM_INT);		
                $consulta->bindValue(':color',  $this->color, PDO::PARAM_STR);
                $consulta->bindValue(':marca',  $this->marca, PDO::PARAM_STR);
                $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
                $consulta->bindValue(':modelo',  $this->modelo, PDO::PARAM_STR);
                $consulta->execute();
                return $consulta->rowCount();
            }
    
        #endregion
        #region api
             public function CargarUno($request, $response, $args){
                $objDelaRespuesta= new stdclass();
            
                $ArrayDeParametros = $request->getParsedBody();
                $datos = json_decode($ArrayDeParametros['json']);

                $auto = new Auto();
                $auto->color=$datos->color;
                $auto->marca=$datos->marca;
                $auto->precio=$datos->precio;
                $auto->modelo=$datos->modelo;

                if($auto->InsertarAuto()){
                    $objDelaRespuesta->exito = true;
                    $objDelaRespuesta->mensaje="Se guardo el auto.";   
                    $newResponse = $response->withJson($objDelaRespuesta, 200);
                }  
                else{
                    $objDelaRespuesta->exito = false;
                    $objDelaRespuesta->mensaje="Se no guardo el auto.";   
                    $newResponse = $response->withJson($objDelaRespuesta, 418);
                }

                return $newResponse;
            }
            public function Listado($request, $response, $args){
                $retorno = new stdClass();
                $listado = Auto::TraerTodosLosAutos();
                $tabla = '';
                $tabla.= "<table border=1> <thead> <tr>";
                $tabla.= "<td>Color <td>Marca <td>Precio <td>Modelo";
                //$tabla.= "</tr> </thead>";
                foreach($listado as $auto){
                    $tabla.= "<tr><td> $auto->color  ";
                    $tabla.= "<td> $auto->marca ";
                    $tabla.= "<td> $auto->precio";
                    $tabla.= "<td> $auto->modelo";               
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
            public function BorrarUno($request, $response, $args) {
                $arrayConToken = $request->getHeader('token');
                $retorno = new stdClass();
                $arrayDatos = $request->getParsedBody();
                $id = $arrayDatos['id'];
                $token=$arrayConToken[0];
                $datos = AutentificadorJWT::ObtenerData($token);
                
                if($datos['0']->perfil == 'propietario'){
                    $auto= new Auto();
                    $auto->id=$id;
                    $cantidadDeBorrados=$auto->BorrarAuto();
                    if($cantidadDeBorrados>0){
                        $retorno->exito = true;
                        $retorno->mensaje = 'Se pudo borrar';
                        $newResponse = $response->withJson($retorno, 200);  
                    }
                    else{
                        $retorno->exito = false;
                        $retorno->mensaje = 'No se pudo borrar';
                        $newResponse = $response->withJson($retorno, 418);  
                    }
                }
                else{
                    $newResponse = $response->withJson("El usuario es ".$datos['0']->perfil, 409);  
                }
          
                return $newResponse;
            }
            public function ModificarUno($request, $response, $args) {
                $arrayDatos = $request->getParsedBody();
                $autoMod = json_decode($arrayDatos['json']);
                $arrayConToken = $request->getHeader('token');
                $token=$arrayConToken[0];
                $datos = AutentificadorJWT::ObtenerData($token);
                if($datos['0']->perfil == 'propietario' || $datos['0']->perfil == 'encargado'){
                    $auto= new Auto();
                    $auto->id=$autoMod->id;
                    $auto->color=$autoMod->color;
                    $auto->marca=$autoMod->marca;
                    $auto->precio=$autoMod->precio;
                    $auto->modelo=$autoMod->modelo;
    
                    $rowCount=$auto->ModificarAuto();
                    if($rowCount>0){
                        $newResponse = $response->withJson('Se pudo modificar', 200);  
                    }
                    else{
                        $newResponse = $response->withJson('No se pudo modificar', 418);  
                    }
                }
                else{
                    $newResponse = $response->withJson("El usuario es ".$datos['0']->perfil, 409);  
                }
          
                return $newResponse;	
            }
        #endregion

    }