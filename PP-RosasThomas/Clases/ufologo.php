<?php
    class Ufologo{
        private $pais;
        private $legajo;
        private $clave;

        public function __construct($pais, $legajo, $clave){
            $this->pais = $pais;
            $this->legajo = $legajo;
            $this->clave = $clave;
        }

        public function ToJSON(){
            return '{"pais": "'. $this->pais . '", "legajo": "'. $this->legajo . '", "clave": "'. $this->clave . '"}';
        }

        public function GuardarEnArchivo(){
            $json = json_decode('{"exito": "", "mensaje": ""}');
            $json->exito = false;
            try{
                $archivo = fopen("./archivos/ufologos.json", "a");
                $cad = fwrite($archivo, $this->ToJSON()."\r\n");
                if($cad > 0 ){
                    $json->exito = true;
                    $json->mensaje = "Se ha podido guardar el usuario";
                }
                else{
                    $json->mensaje = "No se ha podido guardar el usuario";
                }
            }
            catch(exception $e){
                echo $json->mensaje = "Error:" . $e->getMessage();
            }
            fclose($archivo);
            
            return $json;
        }

        public static function TraerTodos(){
            $lista = array();
            $archivo = fopen("./archivos/ufologos.json", "r");
            while(!feof($archivo)){
                $line = trim(fgets($archivo));
                if($line != null){
                    $ufologo = json_decode($line);
                    array_push($lista, new Ufologo($ufologo->pais, $ufologo->legajo,$ufologo->clave));    
                }
            }
            fclose($archivo);

            return $lista;
        }

        public static function VerificarExistencia($ufologo){
            $json = json_decode('{"exito": "", "mensaje": ""}');
            $json->exito = false;
            $json->mensaje = "No existe el ufologo";
            $lista = Ufologo::TraerTodos();
            foreach($lista as $aux){
                if($aux->legajo == $ufologo->legajo && $aux->clave == $ufologo->clave){
                    $json->exito = true;
                    $json->mensaje = "Existe el ufologo";
                    break;
                }
            }

            return $json;
        }

    }