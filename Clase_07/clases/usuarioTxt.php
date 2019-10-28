<?php
    class UsuarioTxt{
        public $nombre;
        public $tipo;
        public $clave;

        public function __construct($nombre, $tipo, $clave){
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->clave = $clave;
        }

        public static function Leer(){
            $usuarios = array();
            $aux = array();
            $archivo = fopen("./clases/listado.txt", 'r');
            while(!feof($archivo)){
                $datos = trim(fgets($archivo));
                $aux = explode(",",$datos);
                array_push($usuarios, new UsuarioTxt($aux[0], $aux[1], $aux[2]));
            }

            fclose($archivo);
            return $usuarios;
        }
    }