<?php
    class Usuario
    {
        public $id;
        public $nombre;
        public $apellido;
        public $perfil;
        public $estado;
        public $correo;
        private $clave;
    
        public function existeEnBD($correo, $clave):bool{
            $flag = false;
            $usuarios = Usuario::TraerTodosLosUsuario();
            foreach($usuarios as $us){
                if($us->correo == $correo && $us->clave == $clave){
                    $flag = true;
                    break;
                }
            }
            return $flag;
        }

        public function MostrarDatos()
        {
            return $this->id." - ".$this->nombre." - ".$this->apellido." - ".$this->perfil." - ".$this->estado." - ".$this->correo;
        }
        
        public static function TraerTodosLosUsuario()
        {    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM usuarios");        
            
            $consulta->execute();
            $consulta->setFetchMode(PDO::FETCH_INTO, new Usuario);     
            return $consulta; 
        }
        
        public function InsertarElUsuario()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("INSERT INTO usuarios (nombre,apellido,clave,perfil,estado,correo) 
                    VALUES(:nombre, :apellido, :clave, :perfil, :estado, :correo)");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);

            $consulta->execute();   
    
        }
        
        public static function ModificarUsuario($id, $nombre, $apellido, $perfil, $estado, $correo, $clave)
        {
    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("UPDATE usuarios SET nombre=:nombre, apellido=:apellido, clave=:clave, 
            perfil=:perfil, estado=:estado, correo=:correo WHERE id=:id");
            
            $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':perfil', $this->perfil, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $this->estado, PDO::PARAM_INT);
            $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':correo', $this->correo, PDO::PARAM_STR);
    
            return $consulta->execute();
    
        }
    
        public static function EliminarUsuario($usuario)
        {
    
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
            
            $consulta =$objetoAccesoDato->RetornarConsulta("DELETE FROM usuarios WHERE id = :id");
            
            $consulta->bindValue(':id', $usuario->id, PDO::PARAM_INT);
    
            return $consulta->execute();
    
        }
        
    }
