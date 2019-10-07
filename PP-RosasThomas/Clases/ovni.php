<?php
    require_once "AccesoDatos.php";
    require_once "IParte2.php";

    class Ovni implements IParte2, IParte3{
        public $tipo;
        public $velocidad;
        public $planetaOrigen;
        public $pathFoto;

        public function __construct($tipo = null, $velocidad = null, $planetaOrigen = null, $pathFoto = null){
            $this->tipo = $tipo; 
            $this->velocidad = $velocidad;
            $this->planetaOrigen = $planetaOrigen;
            $this->pathFoto = $pathFoto;
        }

        public function ToJSON(){
            return '{"tipo": "'. $this->tipo . '", "velocidad": "'. $this->velocidad . '", "planetaOrigen": "'. $this->planetaOrigen . '", "pathFoto": "'. $this->pathFoto . '"}';
        }

        public function Agregar(){
            $objetoDatos = AccesoDatos::DameUnObjetoAcceso();
            if($this->pathFoto != null){
                $consulta = $objetoDatos->RetornarConsulta("INSERT INTO ovnis (tipo,velocidad,planeta,foto) VALUES (:tipo, :velocidad, :planeta, :foto)");
                $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            }
            else{
                $consulta = $objetoDatos->RetornarConsulta("INSERT INTO ovnis (tipo,velocidad,planeta) VALUES (:tipo, :velocidad, :planeta)");    
            }
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
            $consulta->bindValue(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
            $flag = $consulta->execute();
            return $flag;
        }

        public function Traer(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT tipo, velocidad, planeta as planetaOrigen, foto as pathFoto FROM ovnis");        
            
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_INTO, new Ovni);    

            return $consulta; 
        }

        public function ActivarVelocidadWarp(){
            return $this->velocidad * 10.45;
        }

        public function Existe($lista){
            $flag = false;

            foreach($lista as $obj){
                if($this->tipo == $obj->tipo && $this->velocidad == $obj->velocidad && $this->planetaOrigen == $obj->planetaOrigen ){
                    $flag = true;
                    break;
                }
            }

            return $flag;
        }

        public function Modificar($id){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE ovnis SET tipo=:tipo,velocidad=:velocidad,planeta=:planeta,foto=:foto WHERE id=:id");
            
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':velocidad', $this->velocidad, PDO::PARAM_INT);
            $consulta->bindValue(':planeta', $this->planetaOrigen, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $this->pathFoto, PDO::PARAM_STR);
            $consulta->bindValue(':id',$id,PDO::PARAM_INT);
            $flag = false;
            $consulta->execute();
            if($consulta->rowCount() > 0) 
            {
                $flag = true;
            }
           
             return $flag;
        }

        public function Eliminar($id){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM ovnis WHERE id=:id");
            $consulta->bindValue(':id', $id, PDO::PARAM_INT);
            $consulta->execute();
            $flag = false;
            if($consulta->rowCount() > 0){  
                $flag = true;
            }
            return $flag;
        }

        public function GuardarEnArchivo(){

        }

    }