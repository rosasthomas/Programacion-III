<?php
    require_once "AccesoDatos.php";
    require_once "IParte2.php";
    require_once "IParte3.php";
    class Televisor implements IParte2, IParte3{
        public $tipo;
        public $precio;
        public $paisOrigen;
        public $path;

        public function __construct($tipo = null, $precio = null, $paisOrigen = null, $path = null){
            $this->tipo = $tipo; 
            $this->precio = $precio;
            $this->paisOrigen = $paisOrigen;
            $this->path = $path;
        }

        public function ToJSON(){
            return '{"tipo": "'. $this->tipo . '", "precio": "'. $this->precio . '", "paisOrigen": "'. $this->paisOrigen . '", "path": "'. $this->path . '"}';
        }

        public function Agregar(){
            $objetoDatos = AccesoDatos::DameUnObjetoAcceso();
            if($this->path != null){
                $consulta = $objetoDatos->RetornarConsulta("INSERT INTO televisores (tipo,precio,pais,foto) VALUES (:tipo, :precio, :pais, :foto)");
                $consulta->bindValue(':foto', $this->path, PDO::PARAM_STR);
            }
            else{
                $consulta = $objetoDatos->RetornarConsulta("INSERT INTO televisores (tipo,precio,pais) VALUES (:tipo, :precio, :pais)");    
            }
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);
            $flag = $consulta->execute();
            return $flag;
        }

        public function Traer(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais as paisOrigen, foto as 'path' FROM televisores");        
            
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);    

            return $consulta; 
        }

        public function CalcularIVA(){
            return $this->precio * 1.21;
        }

        public function Modificar($id,$tipo,$precio,$pais,$path){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE televisores SET tipo=:tipo,precio=:precio,pais=:pais,foto=:foto WHERE id=:id");
            
            $consulta->bindValue(':tipo', $tipo, PDO::PARAM_STR);
            $consulta->bindValue(':precio', $precio, PDO::PARAM_INT);
            $consulta->bindValue(':pais', $pais, PDO::PARAM_STR);
            $consulta->bindValue(':foto', $path, PDO::PARAM_STR);
            $consulta->bindValue(':id',$id,PDO::PARAM_INT);
            $consulta->execute();
            $flag = false;
            if($consulta->rowCount() > 0) 
            {
                $flag = true;
            }
             return $flag;
        }

        public function Eliminar(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta = $objetoAccesoDato->RetornarConsulta("DELETE FROM televisores WHERE tipo=:tipo");
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->execute();
            $flag = false;
            if($consulta->rowCount() > 0){  
                $flag = true;
            }
            return $flag;
        }

        public function Existe(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais as paisOrigen, foto as 'path' FROM televisores WHERE tipo=:tipo");
            $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            $consulta->execute();
            $flag = false;
            if($consulta->rowCount() > 0){  
                $flag = true;
            }
            return $flag;
        }

        public function Filtrar(){
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            var_dump($this);

            if($this->tipo != null && $this->paisOrigen == null){
                $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais as paisOrigen, foto as 'path' FROM televisores WHERE tipo=:tipo");
                $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
            }
            else if($this->tipo == null && $this->paisOrigen != null){
                $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais as paisOrigen, foto as 'path' FROM televisores WHERE pais=:pais");
                $consulta->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);
            }
            else if($this->tipo != null && $this->paisOrigen != null){
                $consulta =$objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais as paisOrigen, foto as 'path' FROM televisores WHERE (tipo=:tipo AND pais=:pais )");
                $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
                $consulta->bindValue(':pais', $this->paisOrigen, PDO::PARAM_STR);
            }
            else{
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT tipo, precio, pais as paisOrigen, foto as 'path' FROM televisores");
            }

            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_INTO, new Televisor);    

             return $consulta;
        }
    }