<?php

class Producto{
    private $nombre;
    public $cod_barra;
    public $path;

    public function __construct($n=null, $c=null, $p=null){
        if($n != null){
            $this->nombre = $n;
            $this->cod_barra = $c;
            $this->path = $p;
        }
    }

    public function ToString(){
        return $this->cod_barra." - ".$this->nombre;
    }

    public static function Guardar($obj){
        $flag = false;
        $archivo = fopen("./Archivos/productos.txt", "a");        
        $cad = fwrite($archivo, $obj->ToString()." - ".$obj->path."\r\n");
        fclose($archivo);
        if($cad > 0)
            $flag = true;
        return $flag;
    }

    public static function TraerTodosLosProductos(){
        $productos = array();
        $aux = array();
        $archivo = fopen("./Archivos/productos.txt", "r");
        while(!feof($archivo)){
            $datos = fgets($archivo);
            $aux = explode(" - ", $datos);
            if(isset($aux[0]) && isset($aux[1]) && isset($aux[2])){
                array_push($productos, new Producto($aux[1], $aux[0], $aux[2]));
            }
        }
        fclose($archivo);
        return $productos;
    }
}