<?php
    class Usuario{
        private $email;
        private $clave;

        public function __construct($email, $clave){
            $email = str_replace(".", "_", $email);
            $this->email = $email;
            $this->clave = $clave;
        }

        public function ToJSON(){
            return '{"email": "'. $this->email . '", "clave": "'. $this->clave . '"}';
        }

        public function GuardarEnArchivo(){
            $json = json_decode('{"exito": "", "mensaje": ""}');
            $json->exito = false;
            try{
                $archivo = fopen("./archivos/usuarios.json", "a");
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
            $archivo = fopen("./archivos/usuarios.json", "r");
            while(!feof($archivo)){
                $line = trim(fgets($archivo));
                if($line != null){
                    $usuario = json_decode($line);
                    array_push($lista, new Usuario($usuario->email,$usuario->clave));    
                }
            }
            fclose($archivo);

            return $lista;
        }

        public static function VerificarExistencia($usuario){
            $flag = false;
            $lista = Usuario::TraerTodos();
            foreach($lista as $aux){
                if($aux->email == $usuario->email && $aux->clave == $usuario->clave){
                    $flag = true;
                }
            }

            return $flag;
        }
    }